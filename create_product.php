<?php
require_once 'app/backend/core/Init.php';

// Initialize the database connection
try {
    $host = $GLOBALS['config']['mysql']['host'];
    $username = $GLOBALS['config']['mysql']['username'];
    $password = $GLOBALS['config']['mysql']['password'];
    $db_name = $GLOBALS['config']['mysql']['db_name'];
    $db = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

if (!$user->isLoggedIn() || !$user->hasPermission('admin')) {
    Redirect::to('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $stmt = $db->prepare("INSERT INTO products (name, description, price, stock) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $stock]);

    Redirect::to('admin.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Product</title>
</head>
<body>
    <h1>Create Product</h1>
    <form action="" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <br>
        <label for="description">Description:</label>
        <textarea name="description" required></textarea>
        <br>
        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" required>
        <br>
        <label for="stock">Stock:</label>
        <input type="number" name="stock" required>
        <br>
        <button type="submit">Create Product</button>
    </form>
</body>
</html>
