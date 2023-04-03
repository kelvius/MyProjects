<?php

/*******w******** 
Name: John Kelvin A. Valerio
Date: 03/13/23
Description: Project
****************/

require('connect.php');
session_start();
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
                <h2><a href="edit.php?id=<?= $blogData['post_id'] ?>"><?= $blogData['title'] ?></a></h2>
                    <p>
                        <small>
                        <?= date("F d, Y, h:ia", strtotime($blogData['created_at_date'])) ?>
                                        <a href="edit.php?id=<?= $blogData['post_id'] ?>">edit</a>
                        </small>
                    </p>
                    <div class='blog_content'>
                    <?= $blogData['content'] ?>
                    </div>
                </div>
            </div>

            <div id = "blog_comments">
            <form action="comment_post.php" method="post">
                <fieldset>
                    <legend>Comment post</legend>
                    <p>
                        <label for="name">Name</label>
                        <?php if(isset($_SESSION['user_name'])):?>
                            <input name="name" id="name" value="<?= $_SESSION['user_name']?>" >
                            <?php else:?>
                                <input name="name" id="name" >
                            <?php endif ?>
                    </p>
                    <p>
                        <label for="comment">Comment</label>
                        <textarea name="comment" id="comment"></textarea>
                    </p>
                    <p>
                        <input type="hidden" name="post_id" value="<?= $blogData['post_id']?>">
                        <input type="hidden" name="title" value="<?= $blogData['title']?>">
                        <input type="submit" name="submit" value="Comment">
                    </p>
                </fieldset>
            </form>

            
</div>
            <div id="footer">
                Copywrong 2023 - No Rights Reserved
            </div>
        </div>
    </body>

</html>