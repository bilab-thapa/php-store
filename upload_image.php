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
$sql = "SELECT id, name, category, subcategory, quantity, color, price, image FROM products";
$result = $conn->query($sql);
$products = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (!empty($row['image'])) {
            $type = 'image/jpeg';
            $row['image'] = 'data:' . $type . ';base64,' . base64_encode($row['image']);
        }
        $products[] = $row;
    }
}
$conn->close();
header('Content-Type: application/json');
echo json_encode($products);
?>