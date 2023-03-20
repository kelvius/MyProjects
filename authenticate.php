<?php
define('ADMIN_LOGIN', 'wally');

define('ADMIN_PASSWORD', 'mypass');



// if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])

//     || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN)

//     || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)) {

//   header('HTTP/1.1 401 Unauthorized');

//   header('WWW-Authenticate: Basic realm="Drip Book"');

//   exit("Access Denied: Username and password required.");

// }
session_start();
$userIdSet = isset($_SESSION['user_id']);
$userRoleSet = isset($_SESSION['user_role']);

// Check if session is already set 
if(!$userIdSet && !$userRoleSet){
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Code to handle form submission
  if (
    !isset($_POST['username']) && !isset($_POST['password'])
    || (($_POST['username']) != ADMIN_LOGIN) || (($_POST['password']) != ADMIN_PASSWORD)
  ) {
    echo ("Access Denied");
    exit;
  } else {
        $_SESSION['user_id'] = ($_POST['username']);
    $_SESSION['user_role'] = 'Admin';
    header('Location: create.php');
  }
}
}else{
  echo($_SESSION['user_id']);
  header('Location: create.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="main.css">

  <title>Login Page</title>
</head>

<body>
  <h2>Login Form</h2>
  <form name="signup" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username"><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>

    <input type="submit" value="Submit">
  </form>
</body>

</html>