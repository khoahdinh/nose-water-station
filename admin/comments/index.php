<!-- Shift + Alt + F để canh lề -->
<?php include("../../path.php");
// include(ROOT_PATH . "/app/database/db.php");
// include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/controllers/posts.php");
adminOnly();

$comments = getComments('comments');
$postsWithComments = getPostsWithComments();

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

    <title>Admin Section - Manage Comments</title>

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


            <div class="content">
                <h2 class="page-title">Manage Comments</h2>
                <?php include(ROOT_PATH . "/app/includes/messages.php") ?>
                <table>
                    <thead>
                        <th>SN</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Action</th>
                    </thead>
                    <tbody>

                        <?php foreach ($postsWithComments as $key => $post): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td>
                                    <a href="<?php echo BASE_URL . '/single.php?id=' . $post['post_id']; ?>" class="post-link">
                                        <?php echo $post['title']; ?>
                                    </a>
                                </td>
                                <td>
                                    <div class="image-card">
                                        <img src="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>" alt="">
                                    </div>
                                </td>
                                <td>
                                    <a href="edit.php?edit=<?php echo $post['post_id'] ?>" class="edit">Edit</a>
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