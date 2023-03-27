<?php
define('ADMIN_LOGIN', 'admin');

define('ADMIN_PASSWORD', 'admin');

require('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Code to handle form submission
    if (
        isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && !empty(($_POST['email']))
    ) {

    } else {

        echo ('Registration Failed please complete all the required fields.');
        exit;
    }
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
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Kelvin's Blog - New Blog Post</a></h1>
        </div>
        <ul class="menu">
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>
                <a href="authenticate.php">New Post</a>
            </li>
            <li>
                <a href="registration.php" class="active">Register User</a>
            </li>
        </ul>
        <div id="all_blogs">
            <form name="registration_form" action="register_post.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username"><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email"><br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password"><br><br>

                <label for="reenter_password">Reenter Password:</label>
                <input type="password" id="reenter_password" name="reenter_password"><br><br>

                <label for="remember">Remember me</label>
                <input type="checkbox" name="remember" value="Remember me ">

                <input type="submit" name="register" value="Register">
            </form>
        </div>
        <div id="footer">
            Copywrong 2023 - No Rights Reserved
        </div>
    </div>
</body>

</html>