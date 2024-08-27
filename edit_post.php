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
  $stmt = $db->prepare("SELECT * FROM blog_posts WHERE id = ?");
  $stmt->execute([$postId]);
  $post = $stmt->fetch(PDO::FETCH_OBJ);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $db->prepare("UPDATE blog_posts SET title = ?, content = ? WHERE id = ?");
    $stmt->execute([$title, $content, $postId]);

    Redirect::to('admin.php');
  }
} else {
  Redirect::to('admin.php');
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Edit Blog Post</title>
</head>

<body>
  <h1>Edit Blog Post</h1>
  <form action="" method="post">
    <label for="title">Title:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($post->title); ?>" required>
    <br>
    <label for="content">Content:</label>
    <textarea name="content" required><?php echo htmlspecialchars($post->content); ?></textarea>
    <br>
    <button type="submit">Update Post</button>
  </form>
</body>

</html>
