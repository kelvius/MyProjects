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
    if (isset($_POST['update'])) {
        //  Sanitize user input to escape HTML entities and filter out dangerous characters.
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRIPPED);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRIPPED);
        $user_lvl = filter_input(INPUT_POST, 'userLvl', FILTER_VALIDATE_INT);
        $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

        //  Build the parameterized SQL query and bind to the above sanitized values.
        //$query = "UPDATE content_post SET title=$title, content=$content WHERE id=$id";
        $query = "UPDATE users SET name = :name, email = :email, user_lvl = :user_lvl WHERE user_id = :user_id";
        $statement = $db->prepare($query);

        //  Bind values to the parameters
        $statement->bindValue(":name", $name);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":user_lvl", $user_lvl);
        $statement->bindValue(":user_id", $user_id);

        //  Execute the UPDATE.
        //  execute() will check for possible SQL injection and remove if necessary
        if ($statement->execute()) {
            header("Location: userList.php");
            exit;
        }

    } else if (isset($_POST['delete'])) {
        //  Sanitize user input to escape HTML entities and filter out dangerous characters.
        $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

        //  Build the parameterized SQL query and bind to the above sanitized values.";
        $query = "DELETE FROM users WHERE user_id = :user_id";
        $statement = $db->prepare($query);

        //  Bind values to the parameters
        $statement->bindParam(":user_id", $user_id);

        //  Execute the DELETE.
        //  execute() will check for possible SQL injection and remove if necessary
        if ($statement->execute()) {
            header("Location: userList.php");
            exit;
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