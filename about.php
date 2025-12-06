<?php include("path.php"); ?>
<?php
include(ROOT_PATH . '/app/controllers/posts.php');
include(ROOT_PATH . '/app/includes/lang.php');
include(ROOT_PATH . '/app/includes/getLang.php');




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

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">

    <!-- Custom Styling -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Favicon -->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <title>About | Nose Water Station</title>

</head>

<body>

    <!-- Header -->
    <?php include(ROOT_PATH . "/app/includes/header.php"); ?>
    <!-- // Header -->

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Content -->
        <div class="content">
            <div class="content-about">
                <div class="item1 item">
                    <h1 class="text-center"><?php echo $text['title']; ?></h1> &nbsp;
                    
                    <p class="about-text"><?php echo $text['paragraph1']; ?></p>
                </div>
                <div class="item2 item">
                    <img src="<?php echo BASE_URL . '/assets/images/about_page/about_image_1.jpg' ?>" alt="">
                </div>
                <div class="item3 item">
                    <img src="<?php echo BASE_URL . '/assets/images/about_page/about_image_2.jpg' ?>" alt="">
                    <p class="about-text"><?php echo $text['paragraph2']; ?></p>
                </div>
                <div class="item4 item">
                    <img src="<?php echo BASE_URL . '/assets/images/about_page/about_image_3.png' ?>" alt="">
                </div>
                <div class="item5 item">
                    <h1 class="text-center"><?php echo $text['thank_you']; ?></h1>
                </div>
                <div class="item6 item">
                    <img src="<?php echo BASE_URL . '/assets/images/about_page/about_image_4.png' ?>" alt="">
                </div>
            </div>
        </div>

        <!-- // Content -->
        <!-- // Page Wrapper -->

        <!-- Footer -->
        <?php include(ROOT_PATH . "/app/includes/footer.php"); ?>
        <!-- // Footer -->

        <!-- JQuery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <!-- Slick Carousel -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

        <!-- Custom Script -->
        <script src="assets/js/script.js"></script>

</body>

</html>