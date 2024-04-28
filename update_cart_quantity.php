<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "ecommerce";
$conn = new mysqli($servername, $username, $password, $database);

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($conn === null) {
    die("Database connection is null");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];

    if ($quantity == 0) {
        $stmt = $conn->prepare("DELETE FROM cart_items WHERE name = ?");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("s", $name);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {
            $response = array("success" => true, "message" => "Item removed successfully");
        } else {
            $response = array("success" => false, "message" => "Error removing item");
        }
    } else {
        $stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE name = ?");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("ds", $quantity, $name);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {
            $response = array("success" => true, "message" => "Quantity updated successfully");
        } else {
            $response = array("success" => false, "message" => "Error updating quantity");
        }
    }
    $stmt->close();
    echo json_encode($response);
}

$conn->close();
?>