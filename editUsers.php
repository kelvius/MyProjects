<?php

/*******w******** 
Name: John Kelvin A. Valerio
Date: 03/13/23
Description: Project 
****************/

require('connect.php');
//require('authenticate.php');


$user_id = 0;
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
}

function filteredData()
{
    if (filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT) === 0) {
        return true;
    } else {
        return filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT);
    }
}

if (filteredData()) {
    // SQL is written as a String.
    $query = "SELECT * FROM users WHERE user_id = $user_id";

    // A PDO::Statement is prepared from the query.
    $statement = $db->prepare($query);

    // Execution on the DB server is delayed until we execute().
    $statement->execute();

    $userdata = $statement->fetch();
    echo($userdata['name']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Edit users!</title>
</head>

<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Kelvin's Blog- Edit Users</a></h1>
        </div>
        <ul class="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="create.php">New Post</a></li>
        </ul>
        <div id="all_users">
            <form action="user_post.php" method="post">
                <fieldset>
                    <legend>Edit Blog Post</legend>
                    <p>
                
                        <label for="name">Name</label>
                        <input name="name" id="name" value="<?= $userdata['name']?>" >
                    </p>
                    <p>
                        <label for="email">Email</label>
                        <input name="email" id="email" value="<?= $userdata['email']?>" >
                    </p>
                    <p>
                        <label for="userLvl">User Lvl</label>
                        <input name="userLvl" id="userLvl" value="<?= $userdata['user_lvl']?>" >
                    </p>
                    <p>
                        <input type="hidden" name="user_id" value=<?= $user_id?> >
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