<?php

/*******w******** 
Name: John Kelvin A. Valerio
Date: 03/13/23
Description: Project
****************/


require('connect.php');
//require('authenticate.php');
session_start();

if(isset($_SESSION['alert_message'])) {
    $message = $_SESSION['alert_message'];
    //echo "<script>document.getElementById('error').style.visibility = 'visible';</script>"; 
    //echo "<p>('$message')</p>";
    echo "<script>alert('$message');</script>";
    unset($_SESSION['alert_message']);
    echo "<script>window.location.reload();</script>";
}
    
// SQL is written as a String.
$query = "SELECT * FROM categories ORDER BY categorie_id DESC";

// A PDO::Statement is prepared from the query.
$statement = $db->prepare($query);

// Execution on the DB server is delayed until we execute().
$statement->execute();

$tagList = array();
if ($statement->rowCount() > 0) {
    while ($row = $statement->fetch()) {
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
    <title>Edit this Post!</title>
    <script src='tinymce/tinymce.min.js'></script>
    <script>
        tinymce.init({
            selector: '#content',
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            autosave_ask_before_unload: true,
            autosave_interval: '30s',
            autosave_prefix: '{path}{query}-{id}-',
            autosave_restore_when_empty: false,
            autosave_retention: '2m',
            image_advtab: true,
            link_list: [
                { title: 'My page 1', value: 'https://www.codexworld.com' },
                { title: 'My page 2', value: 'http://www.codexqa.com' }
            ],
            image_list: [
                { title: 'My page 1', value: 'https://www.codexworld.com' },
                { title: 'My page 2', value: 'http://www.codexqa.com' }
            ],
            image_class_list: [
                { title: 'None', value: '' },
                { title: 'Some class', value: 'class-name' }
            ],
            importcss_append: true,
            file_picker_callback: (callback, value, meta) => {
                /* Provide file and text for the link dialog */
                if (meta.filetype === 'file') {
                    callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
                }

                /* Provide image and alt text for the image dialog */
                if (meta.filetype === 'image') {
                    callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
                }

                /* Provide alternative source and posted for the media dialog */
                if (meta.filetype === 'media') {
                    callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
                }
            },
            templates: [
                { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
                { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
                { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
            ],
            template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
            template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
            height: 400,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_class: 'mceNonEditable',
            toolbar_mode: 'sliding',
            contextmenu: 'link image table',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });
    </script>

</head>

<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Kelvin's Blog - New Blog Post</a></h1>
        </div>
        <ul class="menu">
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>
                <a href="authenticate.php" class="active">New Post</a>
            </li>
            <li>
                <a href="registration.php">Register User</a>
            </li>
            <?php if (isset($_SESSION['user_lvl']) && $_SESSION['user_lvl'] === 1): ?>
                <li>
                    <a href="userList.php">User list</a>
                </li>
            <?php endif ?>
        </ul>
        <div id="all_blogs">
            <form action="post.php" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Create Drip Post</legend>
                    <p>
                        <label for="title">Title</label>
                        <input name="title" id="title">
                    </p>
                    <p>
                        <label for="content">Content</label>
                        <textarea name="content" id="content"></textarea>
                    </p>

                    <p>
                        <input type="file" id="file" name="file[]" multiple>
                    </p>

                    <p>
                        <label for="tag">Select a tag:</label>
                        <select name="tag" id="tag">
                            <option value="">--Please chose a tag--</option>
                            <?php foreach ($tagList as $tag => $value): ?>
                                <option value="<?php echo $tag ?>"><?php echo $value ?></option>
                            <?php endforeach?>
                        </select>
                    </p>
                    <p>
                        <input type="hidden" name="id">
                        <input type="hidden" id="slug" name="slug" value="<?= isset($slug) ? $slug : '' ?>">
                        <input type="submit" name="create" value="Create">
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