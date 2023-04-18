<?php

/*******w******** 
Name: John Kelvin A. Valerio
Date: 03/13/23
Description: Project
****************/

require('connect.php');
session_start();

if (
    $_POST
) {
    if (isset($_POST['register'])) {
        $captcha_input = $_POST['captcha-input'];

        if ($_SESSION['captcha_text'] != $captcha_input) {
            echo ('Invalid captcha.');
        } else {
            if (
                isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['reenter_password']) && !empty($_POST['reenter_password']) &&
                filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && !empty(($_POST['email']) && $_POST['password'] == $_POST['reenter_password'])
            ) {

                //  Sanitize user input to escape HTML entities and filter out dangerous characters.
                $client_name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRIPPED);
                $client_email = $_POST['email'];
                $client_password = $_POST['password'];
                $client_lvl = '3';
                $hashed_password = password_hash($client_password, PASSWORD_DEFAULT);

                //  Build the parameterized SQL query and bind to the above sanitized values.
                $query = "INSERT INTO users (name, email, password,user_lvl) VALUES (:name, :email, :password, :user_lvl)";
                $statement = $db->prepare($query);

                //  Bind values to the parameters
                $statement->bindValue(":name", $client_name);
                $statement->bindValue(":email", $client_email);
                $statement->bindValue(":password", $hashed_password);
                $statement->bindValue(":user_lvl", $client_lvl);


                //  Execute the INSERT.
                //  execute() will check for possible SQL injection and remove if necessary
                if ($statement->execute()) {
                    // Check if remember me is selected  
                    $remember_is_selected = $_POST['remember'];
                    if ($remember_is_selected) {
                        // Set client to cookies
                        setcookie('client_name', $client_name, time() + (86400 * 30), '/');
                        setcookie('client_email', $client_email, time() + (86400 * 30), '/');
                        setcookie('client_lvl', $client_lvl, time() + (86400 * 30), '/');
                        // Set client to session 
                        echo ('Client Saved on session ');
                        // session_unset();
                        // session_destroy();

                        $query = "SELECT * FROM users WHERE email = :email";

                        // A PDO::Statement is prepared from the query.
                        $statementFetch = $db->prepare($query);
                        $statementFetch->bindParam(':email', $client_email);
                        // Execution on the DB server is delayed until we execute().
                        $statementFetch->execute();

                        $row = $statementFetch->fetch();

                        $_SESSION['user_name'] = $row['name'];
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['user_lvl'] = $row['user_lvl'];
                        $_SESSION['user_email'] = ($_POST['email']);

                        echo ($_SESSION['user_id']);

                        // $_SESSION['user_name'] = ($client_name);
                        // $_SESSION['user_email'] = ($client_email);
                        // $_SESSION['client_lvl'] = ($client_lvl);
                    }
                    header("Location: index.php");

                }
            } else {
                echo ('Registration Failed please complete all the required fields.');
                exit;
            }
        }
    }

} else {
    $errorMessage = "The tweet message or title is empty";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>My Drip Post!</title>
</head>

<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <?php if (!empty($errorMessage)): ?>
        <h1>
            <?= $errorMessage ?>
        </h1>
    <?php endif ?>
</body>

</html>