<?php

/*******w******** 
Name: John Kelvin A. Valerio
Date: 03/13/23
Description: Project
****************/

require('connect.php');

if (
    $_POST && !empty($_POST['title']) && strlen($_POST['title']) >= 1 &&
    strlen($_POST['title']) <= 100 && !empty($_POST['content']) && strlen($_POST['content']) >= 1
) {
    if (isset($_POST['create'])) {
        //  Sanitize user input to escape HTML entities and filter out dangerous characters.
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRIPPED);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRIPPED);

        //  Build the parameterized SQL query and bind to the above sanitized values.
        $query = "INSERT INTO content_post (title, content) VALUES (:title, :content)";
        $statement = $db->prepare($query);

        //  Bind values to the parameters
        $statement->bindValue(":title", $title);
        $statement->bindValue(":content", $content);

        //  Execute the INSERT.
        //  execute() will check for possible SQL injection and remove if necessary
        if ($statement->execute()) {
            header("Location: index.php");
            exit;
        }
    } else if (isset($_POST['update'])) {
        //  Sanitize user input to escape HTML entities and filter out dangerous characters.
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRIPPED);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRIPPED);
        $id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);

        //  Build the parameterized SQL query and bind to the above sanitized values.
        //$query = "UPDATE content_post SET title=$title, content=$content WHERE id=$id";
        $query = "UPDATE content_post SET title = :title, content = :content WHERE post_id = :post_id";
        $statement = $db->prepare($query);

        //  Bind values to the parameters
        $statement->bindValue(":title", $title);
        $statement->bindValue(":content", $content);
        $statement->bindValue(":post_d", $post_id);

        //  Execute the UPDATE.
        //  execute() will check for possible SQL injection and remove if necessary
        if ($statement->execute()) {
            header("Location: index.php");
            exit;
        }

    } else if (isset($_POST['delete'])) {
        //  Sanitize user input to escape HTML entities and filter out dangerous characters.
        $id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
        
        //  Build the parameterized SQL query and bind to the above sanitized values.";
        $query = "DELETE FROM content_post WHERE post_id = :post_id";
        $statement = $db->prepare($query);

        //  Bind values to the parameters
        $statement->bindParam(":;post_id", $post_id);

        //  Execute the DELETE.
        //  execute() will check for possible SQL injection and remove if necessary
        if ($statement->execute()) {
            header("Location: index.php");
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