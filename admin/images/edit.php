<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . '/app/controllers/images.php');

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

    <title>Admin Section - Edit Image</title>

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
                <a href="create.php" class="btn btn-big">Add Image</a>
                <a href="index.php" class="btn btn-big">Manage Images</a>
            </div>

            <div class="content">
                <h2 class="page-title">Edit Image</h2>
                <?php include(ROOT_PATH . '/app/helpers/formErrors.php'); ?>

                <form action="edit.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div>
                        <label>Curent Image</label>
                        <div class="current-image-container">
                            <img src="<?php echo BASE_URL . '/assets/images/' . $image; ?>" alt="Curent Image">
                        </div>
                    </div>
                    <div>
                        <label>Chọn ảnh</label>
                        <input type="file" name="image" id="image" class="text-input">
                    </div>
                    <div>
                        <label>Tác giả</label>
                        <input type="text" name="author" id="author" class="text-input" value="<?php echo $author; ?>">
                    </div>
                    <div>
                        <label>Date</label>
                        <input type="date" name="date" id="date" class="text-input" value="<?php echo $date; ?>">
                    </div>

                    <div>
                        <label>Caption</label>
                        <textarea name="caption" id="body" class="text-input"><?php echo $caption; ?></textarea>
                    </div>
                    <div>
                        <label>Caption Eng</label>
                        <textarea name="caption_eng" id="body_eng" class="text-input"><?php echo $caption_eng; ?></textarea>
                    </div>
                    <div>
                        <button type="submit" name="update-image" class="btn btn-big">Update Image</button>
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