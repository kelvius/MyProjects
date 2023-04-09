<?php

/*******w******** 
Name: John Kelvin A. Valerio
Date: 03/13/23
Description: Project 
****************/

require('connect.php');
session_start();
// session_unset(); 
// session_destroy(); 

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
            <div id="user_header">
                <h1> Kelvin's Blog - Index </h1>
                <?php if (isset($_SESSION['user_id'])): ?>
                <form action="post.php" method="post">
                    <p>
                        <input type="submit" name="logout" value="logout"
                            onclick="return confirm('Are you sure you want to logout?')">
                    </p>
                </form>
                <?php endif?>
            </div>
            <ul class="menu">
                <li>
                    <a href="index.php" class="active">Home</a>
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
                    <a href="createCategories.php">Categories</a>
                </li>
                <?php endif ?>
                <?php if (isset($_SESSION['user_lvl']) && $_SESSION['user_lvl'] === 1): ?>
                    <li>
                        <a href="userList.php">User list</a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
        <!-- Add a form element to accept user's search query -->
<form method="GET" action="index.php">
  <input type="text" name="search" placeholder="Search...">
  <button type="submit">Search</button>
</form>

<!-- Display the search results -->
<div id="all_blogs">
  <?php if ($statement->rowCount() > 0): ?>
    <?php while ($row = $statement->fetch()): ?>
      <!-- Filter the results by the post's title -->
      <?php if (empty($_GET['search']) || strpos($row['title'], $_GET['search']) !== false): ?>
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
              $content = mb_substr($row['content'], 0, 200) . "<a href='display.php?id=" . $row['post_id'] . "'>Read Full Post</a>";
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
      <?php endif ?>
    <?php endwhile ?>
  <?php else: ?>
    <h2>No blogs found.</h2>
  <?php endif ?>
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
                                $content = mb_substr($row['content'], 0, 200) . "<a href='display.php?id=" . $row['post_id'] . "'>Read Full Post</a>";
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