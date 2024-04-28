<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('display_errors', 0); // Turn off error reporting or handle errors properly
error_reporting(0);
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "ecommerce";
$conn = new mysqli($servername, $username, $password, $database);
$response = ['success' => false, 'data' => [], 'error' => ''];
if ($conn->connect_error) {
    $response['error'] = "Connection failed: " . $conn->connect_error;
    echo json_encode($response);
    exit;
}
$searchTerm = isset($_GET['query']) ? $_GET['query'] : '';
$sql = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ?"; // Ensure 'description' exists in your DB
$stmt = $conn->prepare($sql);
$searchTerm = '%' . $searchTerm . '%';
$stmt->bind_param("ss", $searchTerm, $searchTerm);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $response['success'] = true;
    $response['data'] = $products;
} else {
    $response['error'] = "Error in SQL execution: " . $stmt->error;
}
$stmt->close();
$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>