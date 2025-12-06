<!-- Shift + Alt + F để canh lề -->
<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . '/app/controllers/posts.php');
adminOnly();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/69714c34b3.js" crossorigin="anonymous"></script>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Candal&family=Lora:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">

    <!-- Custom Styling -->
    <link rel="stylesheet" href="../../assets/css/style.css">

    <!-- Admin Styling -->
    <link rel="stylesheet" href="../../assets/css/admin.css">

    <!-- Favicon -->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <title>Admin Section - Add Post</title>

</head>

<body>

    <!-- Header -->
    <?php include(ROOT_PATH . "/app/includes/adminHeader.php"); ?>
    <!-- // Header -->

    <!-- Admin Page Wrapper -->
    <div class="admin-wrapper">

        <!-- Left Sidebar -->
        <?php include(ROOT_PATH . "/app/includes/adminSidebar.php"); ?>
        <!-- // Left Sidebar -->

        <!-- Admin Content -->
        <div class="admin-content">
            <div class="button-group">
                <a href="create.php" class="btn btn-big">Add Post</a>
                <a href="index.php" class="btn btn-big">Manage Posts</a>
            </div>

            <div class="content">
                <h2 class="page-title">Add Post</h2>
                <?php include(ROOT_PATH . '/app/helpers/formErrors.php'); ?>

                <form action="create.php" method="post" enctype="multipart/form-data">
                    <div>
                        <label>Title</label>
                        <input type="text" name="title" value="<?php echo $title; ?>" class="text-input">
                    </div>
                    <div>
                        <label>Title Eng</label>
                        <input type="text" name="title_eng" id="title_eng" value="<?php echo $title_eng ?? ''; ?>" class="text-input">
                    </div>
                    <div>
                        <label>Body</label>
                        <textarea name="body" id="body"><?php echo $body; ?></textarea>
                    </div>
                    <div>
                        <label>Body Eng</label>
                        <textarea name="body_eng" id="body_eng"><?php echo $body_eng ?? ''; ?></textarea>
                    </div>
                    <div>
                        <label>Preview</label>
                        <textarea id="preview" name="preview" class="text-input"><?php echo isset($preview) ? htmlspecialchars($preview) : ''; ?></textarea>
                    </div>
                    <div>
                        <label>Preview Eng</label>
                        <textarea name="preview_eng" id="preview_eng" class="text-input"><?php echo $preview_eng ?? ''; ?></textarea>
                    </div>
                    <div>
                        <label>Slug</label>
                        <textarea name="slug" id="slug" class="text-input"><?php echo $slug ?? ''; ?></textarea>
                    </div>
                    <div>
                        <label>Image</label>
                        <input type="file" name="image" class="text-input">
                    </div>
                    <div>
                        <label>Topic</label>
                        <select name="topic_id" class="text-input">
                            <option value=""></option>

                            <?php foreach ($topics as $key => $topic): ?>
                                <?php if (!empty($topic_id) &&   $topic_id == $topic['id']): ?>
                                    <option selected value="<?php echo $topic['id']; ?>"> <?php echo $topic['name']; ?></option>
                                <?php else: ?>
                                    <option value="<?php echo $topic['id']; ?>"> <?php echo $topic['name']; ?></option>
                                <?php endif; ?>


                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>

                        <?php if (empty($published)):  ?>
                            <label>
                                <input type="checkbox" name="published">
                                Publish
                            </label>
                        <?php else: ?>
                            <label>
                                <input type="checkbox" name="published" checked>
                                Publish
                            </label>
                        <?php endif; ?>
                    </div>

                    <div>
                        <button type="submit" name="add-post" class="btn btn-big">Add post</button>
                    </div>
                </form>

            </div>

        </div>
        <!-- // Admin Content -->

    </div>
    <!-- // Admin Page Wrapper -->

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- CKeditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

    <!-- Custom Script -->
    <script src="../../assets/js/script.js"></script>

</body>

</html>