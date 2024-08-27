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
    $postId = $_GET['id'];
    $stmt = $db->prepare("DELETE FROM blog_posts WHERE id = ?");
    $stmt->execute([$postId]);
}

Redirect::to('admin.php');
?>
