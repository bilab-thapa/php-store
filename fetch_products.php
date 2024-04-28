<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "ecommerce";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$category = isset($_GET['category']) ? $_GET['category'] : '';
$subcategory = isset($_GET['subcategory']) ? $_GET['subcategory'] : '';
$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';

$sql = "SELECT id, name, category, subcategory, quantity, color, price, image, count FROM products WHERE ";
$conditions = [];
$params = [];
$types = '';

if (!empty($category)) {
    $conditions[] = "category LIKE ?";
    $params[] = "%$category%";
    $types .= 's';
}

if (!empty($subcategory)) {
    $conditions[] = "subcategory LIKE ?";
    $params[] = "%$subcategory%";
    $types .= 's';
}

if (!empty($searchQuery)) {
    $conditions[] = "name LIKE ?";
    $params[] = "%$searchQuery%";
    $types .= 's';
}

if (!empty($searchQuery)) {
    $conditions[] = "(name LIKE ? OR category LIKE ? OR subcategory LIKE ?)";
    $params[] = "%$searchQuery%";
    $params[] = "%$searchQuery%";
    $params[] = "%$searchQuery%";
    $types .= 'sss';
}

if (count($conditions) > 0) {
    $sql .= implode(' AND ', $conditions);
} else {
    $sql .= "1";
}

$stmt = $conn->prepare($sql);
if (!empty($types)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$products = array();
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
$conn->close();
header('Content-Type: application/json');
echo json_encode($products);
?>