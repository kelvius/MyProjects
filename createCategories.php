<?php

/*******w******** 
Name: John Kelvin A. Valerio
Date: 03/13/23
Description: Project 
****************/

require('connect.php');
session_start();

// SQL is written as a String.
$query = "SELECT * FROM categories ORDER BY categorie_id DESC";

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
            <h1><a href="index.php">Kelvin's Blog - New Blog Post</a></h1>
        </div>
        <ul class="menu">
                <li>
                    <a href="index.php" >Home</a>
                </li>
                <li>
                    <a href="authenticate.php">New Post</a>
                </li>
                <li>
                    <a href="registration.php">Register User</a>
                </li>
                <? echo ("THIS IS SESSION LVL" + $_SESSION['user_lvl']) ?>
                <?php if (isset($_SESSION['user_lvl'])): ?>
                    <li>
                    <a href="createCategories.php" class="active">Categories</a>
                </li>
                <?php endif ?>
                <?php if (isset($_SESSION['user_lvl']) && $_SESSION['user_lvl'] === 1): ?>
                    <li>
                        <a href="userList.php">User list</a>
                    </li>
                <?php endif ?>
            </ul>
        <div id="all_blogs">
            <form action="categorie_post.php" method="post">
                <fieldset>
                    <legend>Create a categorie</legend>
                    <p>
                        <label for="categorie">Categorie</label>
                        <input name="categorie" id="categorie">
                    </p>
                    <p>
                        <input type="hidden" name="id">
                        <input type="submit" name="create" value="Create">
                    </p>
                </fieldset>
            </form>
        </div>

        <div id="all_categories">
            <h2>Categorie list:</h2>
            <?php if ($statement->rowCount() > 0): ?>
                <?php while ($row = $statement->fetch()): ?>
                    <form action="categorie_post.php" method="post">
                        <ul class="menu">
                            <li>
                                <div class="categories">
                                    <p>
                                        <input type="hidden" name="categorie_id" value="<?= $row['categorie_id'] ?>">
                                    <h3>
                                        <?= $row['categorie_name'] ?> <input type="submit" name="delete" value="Delete">
                                    </h3>
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </form>
                <?php endwhile ?>
            <?php else: ?>
                <h2>No user found.</h2>
            <?php endif ?>
        </div>
        <div id="footer">
            Copywrong 2023 - No Rights Reserved
        </div>
    </div>
</body>

</html>