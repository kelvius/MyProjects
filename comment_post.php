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
    if (isset($_POST['submit'])) {
        if (
            isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['comment']) && !empty($_POST['comment'])
        ) {

            //  Sanitize user input to escape HTML entities and filter out dangerous characters.
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRIPPED);
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
            } else {
                $user_id = 0;
            }
            $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRIPPED);
            $post_id = $_POST['post_id'];

            $visibility = 1;

            //  Build the parameterized SQL query and bind to the above sanitized values.
            $query = "INSERT INTO comments (user_id, post_id, comment,date_created,name, visibility) VALUES (:user_id, :post_id, :comment, NOW(),:name, :visibility)";
            $statement = $db->prepare($query);

            //  Bind values to the parameters
            $statement->bindValue(":user_id", $user_id);
            $statement->bindValue(":post_id", $post_id);
            $statement->bindValue(":comment", $comment);
            $statement->bindValue(":name", $name);
            $statement->bindValue(":visibility", $visibility);

            if ($statement->execute()) {
                header("Location: display.php?id=$post_id");
            }

        } else {
            echo ('Comment Failed please complete all the required fields.');
            exit;
        }
    } else if (isset($_POST['visibility'])) {
        $comment_id = $_POST['comment_id'];
        $post_id = $_POST['post_id'];
        $oldVisibility = $_POST['visibility_id'];
        echo("OV: $oldVisibility ");
        if($oldVisibility === '1'){
            echo("line58:");
            $newVisibility = 0;
        }else{
            $newVisibility = 1;
            echo("line62:");
        }

        //  Build the parameterized SQL query and bind to the above sanitized values.";
        $query = "DELETE FROM comments WHERE comment_id = :comment_id";
        $query = "UPDATE comments SET visibility = :visibility WHERE comment_id = :comment_id";
        $statement = $db->prepare($query);

        //  Bind values to the parameters
        $statement->bindParam(":visibility", $newVisibility);
        $statement->bindParam(":comment_id", $comment_id);

        //  Execute the DELETE.
        if ($statement->execute()) {
            header("Location: display.php?id=$post_id");
        }
    } else if (isset($_POST['delete'])) {
        echo ($_POST['comment_id']);
        $comment_id = $_POST['comment_id'];
        $post_id = $_POST['post_id'];

        echo ("Testing commentId: $comment_id");
        //  Build the parameterized SQL query and bind to the above sanitized values.";
        $query = "DELETE FROM comments WHERE comment_id = :comment_id";

        $statement = $db->prepare($query);

        //  Bind values to the parameters
        $statement->bindParam(":comment_id", $comment_id);

        //  Execute the DELETE.
        if ($statement->execute()) {
            header("Location: display.php?id=$post_id");
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