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
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $db->prepare("INSERT INTO blog_posts (title, content) VALUES (?, ?)");
    $stmt->execute([$title, $content]);

    Redirect::to('admin.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Blog Post</title>
</head>
<body>
    <h1>Create Blog Post</h1>
    <form action="" method="post">
        <label for="title">Title:</label>
        <input type="text" name="title" required>
        <br>
        <label for="content">Content:</label>
        <textarea name="content" required></textarea>
        <br>
        <button type="submit">Create Post</button>
    </form>
</body>
</html>
