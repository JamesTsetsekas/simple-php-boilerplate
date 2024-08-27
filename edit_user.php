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
  $userId = $_GET['id'];
  $stmt = $db->prepare("SELECT * FROM users WHERE uid = ?");
  $stmt->execute([$userId]);
  $user = $stmt->fetch(PDO::FETCH_OBJ);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $db->prepare("UPDATE users SET username = ?, password = ? WHERE uid = ?");
    $stmt->execute([$username, $password, $userId]);

    Redirect::to('admin.php');
  }
} else {
  Redirect::to('admin.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user->username); ?>" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Update User</button>
    </form>
</body>
</html>
