<?php

/*******w******** 
Name: John Kelvin A. Valerio
Date: 03/13/23
Description: Project
****************/

// Required libraries for Gumlet Library
require 'ImageResize.php';
require 'ImageResizeException.php';

require('connect.php');
session_start();


function resize_images($file_type,$file_name,$file_path,$file_directory,$allowed_mime_types){
    if (in_array($file_type, $allowed_mime_types)) {

       $medium_file = $file_directory . pathinfo($file_name, PATHINFO_FILENAME) . '_medium.' . pathinfo($file_name, PATHINFO_EXTENSION);
       $thumbnail_file = $file_directory . pathinfo($file_name, PATHINFO_FILENAME) . '_thumbnail.' . pathinfo($file_name, PATHINFO_EXTENSION);

       // Resized Max Width 50px
       $image_thumbnail = new \Gumlet\ImageResize($file_path);
       $image_thumbnail->resizeToWidth(50);
       $image_thumbnail->save($thumbnail_file);

       // Resized Max Width 400px
       $image_medium = new \Gumlet\ImageResize($file_path);
       $image_medium->resizeToWidth(400);
       $image_medium->save($medium_file);
   }
}

if (
    $_POST && !empty($_POST['title']) && strlen($_POST['title']) >= 1 &&
    strlen($_POST['title']) <= 100 && !empty($_POST['content']) && strlen($_POST['content']) >= 1
) {
    if (isset($_POST['create'])) {
        //  Sanitize user input to escape HTML entities and filter out dangerous characters.
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRIPPED);

        $categorie_id = $_POST['tag'];

        $content = $_POST['content'];

        $user_id = $_SESSION['user_id'];

        $file_path = "";
        $file_path_medium = "";

        //$file = $_FILES['file'];

        if(isset($_FILES['file']) && isset($_POST['file'])){
            echo 'File is exisisting';
            $allowed_mime_types = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
            $file_directory = 'images/';
        
            // Create images directory if not existing
            if(!file_exists($file_directory)){
                mkdir("images");
            }
        
            for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
                echo 'Loop is running';
                $file_type = mime_content_type($_FILES['file']['tmp_name'][$i]);
                $file_name = $_FILES['file']['name'][$i];
                $file_path = $file_directory . $file_name;

                $pos = strrpos($file_path, "."); // Find the last occurrence of the "." character
                if ($pos !== false) {
                // If the "." character is found, insert "_medium" before it
                $file_path_medium = substr_replace($file_path, "_medium", $pos, 0);
                }
               
        
                if (!in_array($file_type, $allowed_mime_types)) {
                    $errorMessage = "File is type is invalid";
                    $_SESSION['alert_message'] = $errorMessage;
                     header("Location: authenticate.php");
                     exit;
                }
        
                if (file_exists($file_path)) {
                    $errorMessage = "File is already existing";
                    $_SESSION['alert_message'] = $errorMessage ;
                     header("Location: authenticate.php");
                     exit;
                }
        
                move_uploaded_file($_FILES['file']['tmp_name'][$i], $file_path);
        
                resize_images($file_type,$file_name,$file_path,$file_directory,$allowed_mime_types);
        }
    }

        $slug = trim($_POST['title']);
        $slug = strtolower($slug);
        $slug = preg_replace('/[^a-z0-9]+/', '/', $slug);
        $slug = trim($slug, '&');

        //  Build the parameterized SQL query and bind to the above sanitized values.
        $query = "INSERT INTO content_post (user_id,image_path, title, content, categorie_id, slug) VALUES (:user_id, :image_path, :title, :content, :categorie_id, :slug)";
        $statement = $db->prepare($query);

        //  Bind values to the parameters
        $statement->bindValue(":user_id", $user_id);
        $statement->bindValue(":image_path", $file_path_medium);
        $statement->bindValue(":title", $title);
        $statement->bindValue(":content", $content);
        $statement->bindValue(":categorie_id", $categorie_id);
        $statement->bindValue(":slug", $slug);

        //  Execute the INSERT.
        //  execute() will check for possible SQL injection and remove if necessary
        if ($statement->execute()) {
          header("Location: index.php");
           exit;
        }
    } else if (isset($_POST['update'])) {
        //  Sanitize user input to escape HTML entities and filter out dangerous characters.
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRIPPED);
        $content = $_POST['content'];
        $categorie_id = $_POST['tag'];
        $post_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        //  Build the parameterized SQL query and bind to the above sanitized values.
        //$query = "UPDATE content_post SET title=$title, content=$content WHERE id=$id";
        $query = "UPDATE content_post SET title = :title, content = :content, categorie_id = :categorie_id WHERE post_id = :post_id";
        $statement = $db->prepare($query);

        //  Bind values to the parameters
        $statement->bindValue(":title", $title);
        $statement->bindValue(":content", $content);
        $statement->bindValue(":post_id", $post_id);
        $statement->bindValue(":categorie_id", $categorie_id);

        //  Execute the UPDATE.
        //  execute() will check for possible SQL injection and remove if necessary
        if ($statement->execute()) {
            header("Location: index.php");
            exit;
        }

    } else if (isset($_POST['delete'])) {
        //  Sanitize user input to escape HTML entities and filter out dangerous characters.
        $post_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        //  Build the parameterized SQL query and bind to the above sanitized values.";
        $query = "DELETE FROM content_post WHERE post_id = :post_id";
        $statement = $db->prepare($query);

        //  Bind values to the parameters
        $statement->bindParam(":post_id", $post_id);

        //  Execute the DELETE.
        //  execute() will check for possible SQL injection and remove if necessary
        if ($statement->execute()) {
            header("Location: index.php");
            exit;
        }
    }

} else if ($_POST['logout']) {
    //Logout user fromt the system
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;

} else if ($_POST['login']) {
    //login user fromt the system
    header("Location: authenticate.php");
    exit;

}else {
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