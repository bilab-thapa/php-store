<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "ecommerce";
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create or update the table schema to include a VARCHAR type for image paths
$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    subcategory VARCHAR(255) NOT NULL,
    quantity INT(6) NOT NULL,
    color VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    count INT(5) NOT NULL,
    image VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'products' updated successfully<br>";
} else {
    echo "Error updating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS cart_items (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    quantity INT(6) NOT NULL,
    price DECIMAL(10,2) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'cart_items' updated successfully<br>";
} else {
    echo "Error updating table: " . $conn->error;
}


$products = [
    ['Potato', 'Root Vegetables', 'Potato', 100, 'Brown', 5.50, 500, 'images/potato.jpg'],
    ['Beetroot', 'Root Vegetables', 'Beetroot', 100, 'Red', 8.00, 300, 'images/beetroot.jpg'],
    ['Tomato', 'Fruits', 'Tomato', 15, 'Red', 12.00, 300, 'images/tomato.jpg'],
    ['Pumpkin', 'Fruits', 'Pumpkin', 30, 'Orange', 10.00, 700, 'images/pumpkin.jpg'],
    ['Garlic', 'Allium Vegetables', 'Garlic', 60, 'White', 30.99, 200, 'images/garlic.jpg'],
    ['Ginger', 'Allium Vegetables', 'Ginger', 50, 'Beige', 200.00, 400, 'images/ginger.jpg'],
    ['Carrot', 'Root Vegetables', 'Carrot', 150, 'Orange', 3.00, 600, 'images/carrots.jpg'],
    ['Okra', 'Root Vegetables', 'Okra', 34, 'Green', 35.00, 800, 'images/okra.jpg'], 
    ['Capsicum', 'Fruits', 'Capsicum', 22, 'Green', 19.99, 900, 'images/capsicum.jpg'],
    ['Bell Pepper', 'Fruits', 'Bell Pepper', 22, 'Red', 15.99, 600, 'images/bellpepper.jpg'],
    ['Cucumber', 'Fruits', 'Cucumber', 75, 'Green', 4.20, 400, 'images/cucumber.jpg'],
    ['Beans', 'Legumes', 'Green Beans', 18, 'Green', 7.99, 1000, 'images/beans.jpg'],
    ['Zucchini', 'Fruits', 'Zucchini', 85, 'Green', 4.99, 1200, 'images/zucchini.jpg'],
    ['Onion', 'Allium Vegetables', 'Onion', 110, 'Yellow', 3.49, 1100, 'images/onion.jpg']
];

try {
    foreach ($products as $product) {
        $sql = $conn->prepare("INSERT INTO products (name, category, subcategory, quantity, color, price, count, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $sql->bind_param("sssisdss", $product[0], $product[1], $product[2], $product[3], $product[4], $product[5], $product[6], $product[7]);
        $sql->execute();
    }
    echo "Products inserted successfully.<br>";
} catch (mysqli_sql_exception $e) {
    echo "Error inserting product: " . $e->getMessage() . "<br>";
}


$conn->close();
