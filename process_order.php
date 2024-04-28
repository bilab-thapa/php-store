<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "ecommerce";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, quantity FROM cart_items";
$result = $conn->query($sql);

$allItemsAvailable = true;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $product_name = $row['name'];
        $requested_quantity = $row['quantity'];

        $sqlProduct = "SELECT quantity FROM products WHERE name = ?";
        $stmtProduct = $conn->prepare($sqlProduct);
        $stmtProduct->bind_param("s", $product_name);
        $stmtProduct->execute();
        $resultProduct = $stmtProduct->get_result();

        if ($resultProduct->num_rows > 0) {
            $rowProduct = $resultProduct->fetch_assoc();
            $available_quantity = $rowProduct['quantity'];

            if ($available_quantity < $requested_quantity) {
                $allItemsAvailable = false;
                break;
            }
        } else {
            $allItemsAvailable = false;
            break;
        }
    }
} else {
    echo '<script type="text/javascript">
    alert("No items in the cart. Please update your cart.");
    window.location.href = "index.php";
  </script>';
    exit;
}

if ($allItemsAvailable) {
    $sql = "DELETE FROM cart_items";
    if ($conn->query($sql) === TRUE) {
        echo '<script type="text/javascript">
        alert("Order placed successfully. Check your email for confirmation.");
        window.location.href = "index.php";
      </script>';
        exit;
    } else {
        echo '<script type="text/javascript">
            alert("No items in the cart. Please update your cart.");
            window.location.href = "index.php";
          </script>';
        exit;
    }
} else {
    echo '<script type="text/javascript">
            alert("Some items are not available. Please update your cart.");
            window.location.href = "cart.php";
          </script>';
    exit;
}

$conn->close();

?>