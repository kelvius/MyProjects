<?php

require('connect.php');
session_start();

define('ADMIN_LOGIN', '1');
define('ADMIN_EMAIL', 'test2@mail.com');

define('ADMIN_PASSWORD', '1');

$userNameSet = isset($_SESSION['user_name']);
$userLvlSet = isset($_SESSION['user_lvl']);
$userEmailSet = isset($_SESSION['user_email']);

echo($_SESSION['user_name']);
echo($_SESSION['user_lvl']);
echo($_SESSION['user_email']);

// Used to clear the session while logout is still in progress
// session_unset(); 
// session_destroy(); 


// Check if session is already set 
if(!$userNameSet && !$userLvlSet && !$userEmailSet){
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Code to handle form submission
  if (
    !isset($_POST['email']) && !isset($_POST['password'])
  ) {
    echo ("Login Failed");
    exit;
  } else {
    // SQL is written as a String.
      // SQL is written as a String.
      $userMail = ($_POST['email']);

$query = "SELECT * FROM users WHERE email = :email" ;

// A PDO::Statement is prepared from the query.
$statement = $db->prepare($query);
$statement->bindParam(':email', $userMail);
// Execution on the DB server is delayed until we execute().
$statement->execute();

$row = $statement->fetch();

$_SESSION['user_name'] = $row['name'];
$_SESSION['user_id'] = $row['user_id'];
$_SESSION['user_lvl'] = $row['user_lvl'];
$_SESSION['user_email'] = ($_POST['email']);

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
    <label for="email">Email:</label>
    <input type="text" id="email" name="email"><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>

    <input type="submit" value="Submit">
  </form>
</body>

</html>