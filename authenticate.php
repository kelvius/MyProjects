<?php
define('ADMIN_LOGIN', 'admin');

define('ADMIN_PASSWORD', 'admin');


session_start();
// Used to clear the session while logout is still in progress
// session_unset(); 
// session_destroy(); 
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
    echo ("Login Failed");
    exit;
  } else {
        $_SESSION['user_id'] = ($_POST['username']);
    $_SESSION['user_role'] = 'Admin';
    header('Location: create.php');
  }
}
}else{
  echo("Login Successful");
 // header("refresh:5;url=create.php");
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