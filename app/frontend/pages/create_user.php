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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $name = $_POST['name'];
  $joined = date('Y-m-d H:i:s'); // Set the joined field to the current date and time
  $groups = $_POST['groups'];

  $stmt = $db->prepare("INSERT INTO users (username, password, name, joined, `groups`) VALUES (:username, :password, :name, :joined, :groups)");
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':password', $password);
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':joined', $joined);
  $stmt->bindParam(':groups', $groups);
  $stmt->execute();

  Redirect::to('admin.php');
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Create User</title>
</head>

<body>
  <h1>Create User</h1>
  <form action="" method="post">
    <label for="name">Name:</label>
    <input type="text" name="name" required>
    <br>
    <label for="username">Username:</label>
    <input type="text" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    <br>
    <label for="groups">Group:</label>
    <select name="groups" required>
      <option value="1">User</option>
      <option value="2">Admin</option>
    </select>
    <br>
    <button type="submit">Create User</button>
  </form>
</body>

</html>
