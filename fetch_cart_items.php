<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "ecommerce";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, image, quantity, price FROM cart_items";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $cart_items = array();
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = array(
            'name' => $row['name'],
            'image' => $row['image'],
            'category' => $row['category'],
            'price' => $row['price'],
            'quantity' => $row['quantity']
        );
    }

    header('Content-Type: application/json');
    echo json_encode($cart_items);
} else {
    header('Content-Type: application/json');
    echo json_encode(array("message" => "No cart items found"));
}

$conn->close();

?>