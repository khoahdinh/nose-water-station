<!-- Shift + Alt + F để canh lề -->
<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . '/app/controllers/topics.php');
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

    <title>Admin Section - Manager Topic</title>

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
                <a href="create.php" class="btn btn-big">Add Topic</a>
                <a href="index.php" class="btn btn-big">Manage Topics</a>
            </div>

            <div class="content">
                <h2 class="page-title">Manage Topics</h2>

                <!-- Message -->
                <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>
                <!-- // Message -->

                <table>
                    <thead>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Name Eng</th>
                        <th>Index</th>
                        <th colspan="2">Action</th>
                    </thead>
                    <tbody>
                        <?php foreach ($topics as $key => $topic): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $topic['name']; ?></td>
                                <td><?php echo $topic['name_eng']; ?></td>
                                <td><?php echo $topic['sort_order']; ?></td>
                                <td><a href="edit.php?id=<?php echo $topic['id']; ?>" class="edit">Edit</a></td>
                                <td><a href="index.php?del_id=<?php echo $topic['id']; ?>" class="delete">Delete</a></td>
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