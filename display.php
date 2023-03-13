<?php

/*******w******** 
Name: John Kelvin A. Valerio
Date: 03/13/23
Description: Project
****************/

require('connect.php');

$id = 0;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

function filteredData()
{
    if (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) === 0) {
        return true;
    } else {
        return filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    }
}

if (filteredData()) {
    // SQL is written as a String.
    $query = "SELECT * FROM content_post WHERE post_id = $id";

    // A PDO::Statement is prepared from the query.
    $statement = $db->prepare($query);

    // Execution on the DB server is delayed until we execute().
    $statement->execute();

    $blogData = $statement->fetch();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Display this post!</title>
</head>

<body>
        <div id="wrapper">
            <div id="header">
            <h1><a href="index.php">Drip book - Display Full Blog Post</a></h1>
            </div>
            <ul id="menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="create.php">New Post</a></li>
            </ul>
            <div id="all_blogs">
                <div class="blog_post">
                <h2><a href="blogs.php?id=<?= $blogData['post_id'] ?>"><?= $blogData['title'] ?></a></h2>
                    <p>
                        <small>
                        <?= date("F d, Y, h:ia", strtotime($blogData['dateTime'])) ?>
                                        <a href="edit.php?id=<?= $blogData['post_id'] ?>">edit</a>
                        </small>
                    </p>
                    <div class='blog_content'>
                    <?= $blogData['content'] ?>
                    </div>
                </div>
            </div>
            <div id="footer">
                Copywrong 2023 - No Rights Reserved
            </div>
        </div>
    </body>

</html>