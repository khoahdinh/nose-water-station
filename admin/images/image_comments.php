<!-- Shift + Alt + F để canh lề -->
<?php include("../../path.php");
include(ROOT_PATH . "/app/controllers/images.php");
adminOnly();

$imageId = isset($_GET['image_id']) ? intval($_GET['image_id']) : null;

if (!$imageId) {
    die("Image ID not specified.");
}

// Lấy bình luận của ảnh được chọn
$comments = getImageComments($imageId);
// dd($comments);

// Lấy thông tin ảnh
$image = getImageById($imageId);
// dd($image);

if (!$image) {
    die("Image not found.");
}

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

    <title>Admin Section - Manage Image Comments</title>

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
                <a href="index.php" class="btn btn-big">Manage Images</a>
            </div>

            <div class="content">
                <h2 class="page-title">Manage Image Comments</h2>
                <?php include(ROOT_PATH . "/app/includes/messages.php") ?>

                <div class="selected-image">
                    <div class="image-card">
                        <img src="<?php echo BASE_URL . '/assets/images/' . htmlspecialchars($image['image_path']); ?>" alt="Selected Image">
                    </div>
                </div>


                <table>
                    <thead>
                        <th>SN</th>
                        <th>Author</th>
                        <th>Comment</th>
                        <th>Date</th>
                        <th>Action</th>
                    </thead>
                    <tbody>

                        <?php foreach ($comments as $key => $comment): ?>
                            <tr>
                                <td>
                                    <?php echo $key + 1; ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($comment['username']) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($comment['comment']) ?>
                                </td>
                                <td>
                                    <?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?>
                                </td>
                                <td>
                                    <a href="image_comments.php?image_id=<?php echo $imageId; ?>&delete_img_comment_id=<?php echo $comment['id']; ?>"
                                        class="delete">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>


                    </tbody>
                </table>

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