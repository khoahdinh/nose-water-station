<!-- Shift + Alt + F để canh lề -->
<?php include("../../path.php"); ?>
<?php
include(ROOT_PATH . '/app/controllers/topics.php');
include(ROOT_PATH . '/app/includes/lang.php');
include(ROOT_PATH . '/app/includes/getLang.php');


adminOnly();

// Kiểm tra và cập nhật ngôn ngữ nếu người dùng submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedLang = $_POST['langData'] ?? [];
    $lang[$_SESSION['lang']] = $updatedLang;

    // Tạo nội dung file từ mảng $lang
    $content = "<?php\n\$lang = " . var_export($lang, true) . ";\n?>";

    // Thay đổi 'array(' thành '[' và ')' thành ']'
    $content = str_replace(['array (', ')'], ['[', ']'], $content);

    // Ghi nội dung đã format vào file
    file_put_contents(ROOT_PATH . '/app/includes/lang.php', $content);

    $_SESSION['message'] = 'Bạn đã cập nhật thành công';
    $_SESSION['type'] = 'success';
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

    <title>Admin Section - Manager Languages</title>

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
                <h2 class="page-title">Manage Languages</h2>

                <!-- Message -->
                <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>
                <!-- // Message -->

                <form action="index.php" method="post">
                    <table>

                        <thead>
                            <th>Key</th>
                            <th>Value</th>
                        </thead>

                        <tbody>

                            <?php foreach ($text as $key => $value): ?>
                                <tr>
                                    <td><?= htmlspecialchars($key) ?></td>
                                    <td>
                                        <textarea name="langData[<?= htmlspecialchars($key) ?>]" rows="2" cols="50"><?= htmlspecialchars($value) ?></textarea>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                    <button type="submit" class="btn submit">Update</button>
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