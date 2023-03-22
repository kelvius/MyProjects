<?php

/*******w******** 
Name: John Kelvin A. Valerio
Date: 03/13/23
Description: Project 
****************/

require('connect.php');
//require('authenticate.php');


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
    <title>Edit this Post!</title>
</head>

<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Kelvin's Blog- Edit Post</a></h1>
        </div>
        <ul class="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="create.php">New Post</a></li>
        </ul>
        <div id="all_blogs">
            <form action="post.php" method="post">
                <fieldset>
                    <legend>Edit Blog Post</legend>
                    <p>
                        <label for="title">Title</label>
                        <input name="title" id="title" value="<?= $blogData['title']?>" >
                    </p>
                    <p>
                        <label for="content">Content</label>
                        <textarea name="content" id="content"><?= $blogData['content'] ?></textarea>
                    </p>
                    <p>
                        <input type="hidden" name="id" value=<?= $id ?> >
                        <input type="submit" name="update" value="Update" >
                        <input type="submit" name="delete" value="Delete"
                            onclick="return confirm('Are you sure you wish to delete this post?')" >
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