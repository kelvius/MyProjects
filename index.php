<?php

/*******w******** 
Name: John Kelvin A. Valerio
Date: 03/13/23
Description: Project 
****************/

require('connect.php');

// SQL is written as a String.
$query = "SELECT * FROM content_post ORDER BY post_id DESC LIMIT 5";

// A PDO::Statement is prepared from the query.
$statement = $db->prepare($query);

// Execution on the DB server is delayed until we execute().
$statement->execute();

$content = "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Drip Book</title>
</head>

<body>
     <!-- Remember that alternative syntax is good and html inside php is bad -->
     <div id="wrapper">
        <div id="header">
            <h1> Kelvin's Blog - Index </h1>
            <ul class="menu">
                <li>
                    <a href="index.php" class="active">Home</a>
                </li>
                <li>
                    <a href="authenticate.php">New Post</a>
                </li>
            </ul>
        </div>
        <div id="all_blogs">
            <?php if ($statement->rowCount() > 0): ?>
                <?php while ($row = $statement->fetch()): ?>
                    <ul class="menu">
                        <li>
                            <div class="blog_post">
                                <h2><a href="display.php?id=<?= $row['post_id'] ?>"><?= $row['title'] ?></a> </h2>
                                <p>
                                    <small>
                                        <?= date("F d, Y, h:ia", strtotime($row['created_at_date'])) ?>
                                        <a href="edit.php?id=<?= $row['post_id'] ?>">edit</a>
                                    </small>
                                </p>
                            </div>
                            <?php if (strlen($row['content']) >= 200): {
                                $content = mb_substr($row['content'], 0, 200) . "<a href='display.php?id=" . $row['pos_id'] . "'>Read Full Post</a>";
                            }
                            ?>
                            <?php else: ?>
                                <?php $content = $row['content'] ?>
                            <?php endif ?>
                            <div class='blog_content'>
                                <?= $content ?>
                            </div>
                        </li>
                    </ul>
                <?php endwhile ?>
            <?php else: ?>
                <h2>No blogs found.</h2>
            <?php endif ?>
        </div>
        <div id="footer">
            Copywrong 2023 - No Rights Reserved
        </div>
    </div>
</body>
</html>
