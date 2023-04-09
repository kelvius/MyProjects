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

// Get the current page number, or default to 1 if not set
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Define how many results to show per page
$resultsPerPage = 5;

// Calculate the offset based on the current page and number of results per page
$offset = ($page - 1) * $resultsPerPage;

// SQL query to retrieve the desired range of rows
$query = "SELECT * FROM content_post ORDER BY post_id DESC LIMIT $offset, $resultsPerPage";

// Prepare and execute the query
$statement = $db->prepare($query);
$statement->execute();

// Count the total number of rows in the table
$totalResults = $db->query("SELECT COUNT(*) FROM content_post")->fetchColumn();

// Calculate the total number of pages
$totalPages = ceil($totalResults / $resultsPerPage);

// Build the pagination links
$pagination = "";
if ($totalPages > 1) {
    for ($i = 1; $i <= $totalPages; $i++) {
        $pagination .= "<a href=\"index.php?page=$i\">$i</a> ";
    }
}

// SQL is written as a String.
$query2 = "SELECT * FROM categories ORDER BY categorie_id DESC";

// A PDO::Statement is prepared from the query.
$statement2 = $db->prepare($query2);

// Execution on the DB server is delayed until we execute().
$statement2->execute();

$tagList = array();
if ($statement2->rowCount() > 0) {
    while ($row = $statement2->fetch()) {
        $tagList[$row['categorie_id']] = $row['categorie_name'];
    }
}
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
                <?php else: ?>
                    <form action="post.php" method="post">
                        <p>
                            <input type="submit" name="login" value="login" />
                        </p>
                    </form>
                <?php endif ?>
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

            <label for="tag">Select a tag:</label>
            <select name="tag" id="tag">
                <option value="">--Please chose a tag--</option>
                <?php foreach ($tagList as $tag => $value): ?>
                    <option value="<?php echo $tag ?>"><?php echo $value ?></option>
                <?php endforeach ?>
            </select>
            <button type="submit">Search</button>
        </form>


        <!-- Display the search results -->
        <div id="all_blogs">
            <?php if ($statement->rowCount() > 0): ?>
                <?php while ($row = $statement->fetch()): ?>
                    <!-- Filter the results by the post's title -->

                    <?php if (empty($_GET['tag']) || $_GET['tag'] == $row['categorie_id'] || $_GET['tag'] == ""): ?>

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

                                    <div>
                                        <?php foreach ($tagList as $tag => $value): ?>
                                            <?php if ($row['categorie_id'] === $tag): ?>
                                                <input class="tagButton" type="submit" name="tag" value=<?php echo $value ?>>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </div>
                                </li>
                            </ul>
                        <?php endif ?>
                    <?php endif ?>
                <?php endwhile ?>

                <!-- Display the pagination links -->
                <?php if ($totalPages > 1): ?>
                    <div class="pagination">
                        <?= $pagination ?>
                    </div>
                <?php endif ?>
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