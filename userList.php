<?php

/*******w******** 
Name: John Kelvin A. Valerio
Date: 03/13/23
Description: Project 
****************/

require('connect.php');

// SQL is written as a String.
$query = "SELECT * FROM users ORDER BY user_id DESC LIMIT 10";

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
            <h1> Kelvin's Blog - User Ids </h1>
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
                <li>
                    <a href="userList.php" class="active">User list</a>
                </li>
            </ul>
        </div>
        <div id="all_user">
            <?php if ($statement->rowCount() > 0): ?>
                <?php while ($row = $statement->fetch()): ?>
                    <ul class="menu">
                        <li>
                            <div class="user">
                                <h2>User name: <?= $row['name'] ?></a> </h2>
                                <p>
                                    <small>  User email: 
                                        <?=($row['email']) ?>
                                        <h3>Role: <?= $row['user_lvl'] ?></h3>
                                    </small>
                                </p>
                            </div>
                        </li>
                    </ul>
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
