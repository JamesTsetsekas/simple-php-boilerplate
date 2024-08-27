<?php require_once 'start.php'; ?>
<?php require_once 'app\backend\auth\config.php'; // Include the configuration file
?>
<?php require_once FRONTEND_INCLUDE . 'header.php'; ?>
<?php require_once FRONTEND_INCLUDE . 'navbar.php'; ?>

<?php
// Use the configuration values to create a PDO connection
$host = $GLOBALS['config']['mysql']['host'];
$username = $GLOBALS['config']['mysql']['username'];
$password = $GLOBALS['config']['mysql']['password'];
$db_name = $GLOBALS['config']['mysql']['db_name'];

try {
  $db = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
  exit;
}
?>

<div class="container">
  <h1>Blog Posts</h1>
  <?php
  // Fetch blog posts from the database
  $posts = $db->query("SELECT * FROM blog_posts")->fetchAll(PDO::FETCH_OBJ);
  foreach ($posts as $post) {
    echo "<h2>{$post->title}</h2>";
    echo "<p>{$post->content}</p>";
  }
  ?>
</div>

<?php require_once FRONTEND_INCLUDE . 'footer.php'; ?>
