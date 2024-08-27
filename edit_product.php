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

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_OBJ);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];

        $stmt = $db->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $stock, $productId]);

        Redirect::to('admin.php');
    }
} else {
    Redirect::to('admin.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>
    <form action="" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product->name); ?>" required>
        <br>
        <label for="description">Description:</label>
        <textarea name="description" required><?php echo htmlspecialchars($product->description); ?></textarea>
        <br>
        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product->price); ?>" required>
        <br>
        <label for="stock">Stock:</label>
        <input type="number" name="stock" value="<?php echo htmlspecialchars($product->stock); ?>" required>
        <br>
        <button type="submit">Update Product</button>
    </form>
</body>
</html>
