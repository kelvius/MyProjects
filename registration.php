<?php
require('connect.php');
session_start();

$captcha_error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Code to handle form submission
        if (
            isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && 
            !empty($_POST['password']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && 
            !empty(($_POST['email'])) && empty($captcha_error)
        ) {
            // Registration is successful
        } if (strlen($_POST['password']) < 8) {
            echo ("Password must be at least 8 characters long");
            exit;
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
            <h1><a href="index.php">Kelvin's Blog - Register User</a></h1>
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
            <?php if (isset($_SESSION['user_lvl']) && $_SESSION['user_lvl'] === 1): ?>
                <li>
                    <a href="userList.php">User list</a>
                </li>
            <?php endif ?>
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

                <label for="captcha">Captcha:</label>
                <img src="captcha.php" alt="CAPTCHA Image" style="margin-bottom: 10px;">
                <label for="captcha-input">Enter the CAPTCHA:</label>
                <input type="text" id="captcha-input" name="captcha-input" required>

                <span class="error" id="captcha-error">
                    <?= $captcha_error ?>
                </span>

                <input type="submit" name="register" value="Register">
            </form>
        </div>
        <div id="footer">
            Copywrong 2023 - No Rights Reserved
        </div>
    </div>
</body>

</html>