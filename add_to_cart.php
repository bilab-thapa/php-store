<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "ecommerce";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve POST data
$name = $_POST['name'];
$image = $_POST['image'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];

// Check if the item already exists in the cart_items table
$check_stmt = $conn->prepare("SELECT * FROM cart_items WHERE name = ?");
$check_stmt->bind_param("s", $name);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    // Item exists, increment quantity
    $update_stmt = $conn->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE name = ?");
    $update_stmt->bind_param("ds", $quantity, $name);
    $update_stmt->execute();
    $update_stmt->close();

    $response = array("success" => true, "message" => "Quantity updated successfully");
} else {
    // Item does not exist, insert new row
    $stmt = $conn->prepare("INSERT INTO cart_items (name, image, price, quantity) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $image, $price, $quantity);
    $stmt->execute();

    if ($stmt->affected_rows === 1) {
        $response = array("success" => true, "message" => "Item added to cart successfully");
    } else {
        $response = array("success" => false, "message" => "Error adding item to cart: " . $stmt->error);
    }
    $stmt->close();
}

echo json_encode($response);

$conn->close();
?>