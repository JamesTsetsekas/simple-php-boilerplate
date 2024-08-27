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
  <h1>Admin Panel</h1>

  <!-- Users Section -->
  <h2>Users <a href="create_user.php">+</a></h2>
  <?php
  $users = $db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_OBJ);
  foreach ($users as $user) {
    $group = $user->groups == 2 ? 'Admin' : 'User';
    echo "<p>Username: {$user->username} ({$group})</p>";
    echo "<a href='edit_user.php?id={$user->uid}'>Edit</a> | ";
    echo "<a href='delete_user.php?id={$user->uid}'>Delete</a>";
  }
  ?>

  <!-- Blog Posts Section -->
  <h2>Blog Posts <a href="create_post.php">+</a></h2>
  <?php
  $posts = $db->query("SELECT * FROM blog_posts")->fetchAll(PDO::FETCH_OBJ);
  foreach ($posts as $post) {
    echo "<h3>{$post->title}</h3>";
    echo "<p>{$post->content}</p>";
    echo "<a href='edit_post.php?id={$post->id}'>Edit</a> | ";
    echo "<a href='delete_post.php?id={$post->id}'>Delete</a>";
  }
  ?>

  <!-- Products Section -->
  <h2>Products <a href="create_product.php">+</a></h2>
  <?php
  $products = $db->query("SELECT * FROM products")->fetchAll(PDO::FETCH_OBJ);
  foreach ($products as $product) {
    echo "<h3>{$product->name}</h3>";
    echo "<p>{$product->description}</p>";
    echo "<p>Price: \${$product->price}</p>";
    echo "<p>Stock: {$product->stock}</p>";
    echo "<a href='edit_product.php?id={$product->id}'>Edit</a> | ";
    echo "<a href='delete_product.php?id={$product->id}'>Delete</a>";
  }
  ?>
</div>

<?php require_once FRONTEND_INCLUDE . 'footer.php'; ?>
