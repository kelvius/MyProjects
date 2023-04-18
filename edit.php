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
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
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
            noneditable_class: 'mceNonEditaable',
            toolbar_mode: 'sliding',
            contextmenu: 'link image table',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });
    </script>
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
                        <input name="title" id="title" value="<?= $blogData['title'] ?>">
                    </p>
                    <p>
                        <label for="content">Content</label>
                        <textarea name="content" id="content"><?= $blogData['content'] ?></textarea>
                    </p>

                    <?php if (isset($blogPost['filename']) && !empty($blogPost['filename']) && $blogPost['filename'] !== null): ?>
                             <div id="existing-image-container"> 
                                <label>Existing Image:</label> 
                                <?php $img_src = '../Create/uploads/' . $blogPost['filename']; ?> 
                                <img src="<?= $img_src ?>" alt="<?= $blogPost['title'] ?>" style="width: 400px; height: auto;"> 
                                <div> <input type="checkbox" name="delete_image" value="1"> 
                                <label>Delete existing image</label> 
                            </div> 
                        </div> 
                        <?php endif; ?>


                    <p>
                        <input type="file" id="file" name="file[]" multiple>
                    </p>
                    <p>
                        <label for="tag">Select a tag:</label>
                        <select name="tag" id="tag">

                            <?php foreach ($tagList as $tag => $value): ?>
                                <?php if ($blogData['categorie_id'] === $tag): ?>
                                    <option value="<?php echo $tag ?>"><?php echo $value ?></option>
                                <?php endif ?>
                            <?php endforeach ?>

                            <?php foreach ($tagList as $tag => $value): ?>
                                <?php if ($tag != $blogData['categorie_id']): ?>
                                    <option value="<?php echo $tag ?>"><?php echo $value ?></option>
                                <?php endif ?>
                            <?php endforeach ?>

                        </select>
                    </p>
                    <p>
                        <input type="hidden" name="id" value=<?= $id ?>>
                        <input type="submit" name="update" value="Update">
                        <input type="submit" name="delete" value="Delete"
                            onclick="return confirm('Are you sure you wish to delete this post?')">
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