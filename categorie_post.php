<?php

/*******w******** 
Name: John Kelvin A. Valerio
Date: 03/13/23
Description: Project
****************/

require('connect.php');
session_start();

if (
    $_POST['categorie'] && !empty($_POST['categorie']) && strlen($_POST['categorie']) >= 1) {
    if (isset($_POST['categorie'])) {
        //  Sanitize user input to escape HTML entities and filter out dangerous characters.
        $categorie = filter_input(INPUT_POST, 'categorie', FILTER_SANITIZE_STRIPPED);

        //  Build the parameterized SQL query and bind to the above sanitized values.
        $query = "INSERT INTO categories (categorie_name) VALUES (:categorie_name)";
        $statement = $db->prepare($query);

        //  Bind values to the parameters
        $statement->bindValue(":categorie_name", $categorie);

        //  Execute the INSERT.
        //  execute() will check for possible SQL injection and remove if necessary
        if ($statement->execute()) {
            header("Location: createCategories.php");
            exit;
        }
    } 

} else if ($_POST['logout']) {
    //Logout user fromt the system
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;

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