<?php
include("path.php");
include(ROOT_PATH . '/app/controllers/posts.php');
include(ROOT_PATH . '/app/includes/lang.php');
include(ROOT_PATH . '/app/includes/getLang.php');


// include(ROOT_PATH . '/app/controllers/comments.php');
// vấn đề include 2 controller


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
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Favicon -->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <title>Terms and Conditions | Nose Water Station</title>



</head>

<body>

    <!-- Header -->
    <?php include(ROOT_PATH . "/app/includes/header.php"); ?>
    <!-- // Header -->

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Post Slider -->
        <!-- // Post Slider -->

        <!-- Content -->


        <div class="content clearfix">
            <!-- Main Content Wrapper-->


            <div class="term-container">
                <h1>Điều khoản sử dụng</h1>
                <p>Chào mừng bạn đến với blog "Nose Water Station". Khi sử dụng blog này, bạn đồng ý tuân thủ các điều khoản và điều kiện sau:</p>

                <h2>1. Chấp nhận điều khoản</h2>
                <p>Khi sử dụng blog, bạn đồng ý tuân theo các điều khoản và điều kiện được liệt kê tại đây. Nếu bạn không đồng ý, vui lòng ngừng sử dụng blog.</p>

                <h2>2. Nội dung trên blog</h2>
                <ul>
                    <li>Nội dung trên blog thuộc quyền sở hữu của chúng tôi và được bảo vệ bởi bản quyền.</li>
                    <li>Không được sao chép, chỉnh sửa, hoặc phân phối lại nội dung mà không có sự đồng ý.</li>
                    <li>Chúng tôi không đảm bảo mọi thông tin trên blog là chính xác, đầy đủ, hoặc mới nhất.</li>
                </ul>

                <h2>3. Bình luận</h2>
                <ul>
                    <li>Bạn được phép bình luận, nhưng các bình luận phải tuân thủ:</li>
                    <ul>
                        <li>Không chứa ngôn ngữ xúc phạm, phân biệt đối xử, hoặc vi phạm pháp luật.</li>
                        <li>Không được spam, quảng cáo, hoặc chèn liên kết độc hại.</li>
                    </ul>
                    <li>Chúng tôi có quyền xóa hoặc chỉnh sửa bất kỳ bình luận nào mà không cần thông báo trước.</li>
                </ul>

                <h2>4. Quyền riêng tư</h2>
                <ul>
                    <li>Blog cam kết bảo vệ thông tin cá nhân của bạn. Vui lòng tham khảo <a href="privacy-policy">Chính sách bảo mật</a> để biết thêm chi tiết.</li>
                    <li>Bạn chịu trách nhiệm về các thông tin mình cung cấp khi bình luận hoặc đăng ký tài khoản.</li>
                </ul>

                <h2>5. Quy định về liên kết bên ngoài</h2>
                <p>Blog có thể chứa liên kết tới các trang web bên ngoài. Chúng tôi không chịu trách nhiệm về nội dung hoặc chính sách của các trang web này.</p>

                <h2>6. Trách nhiệm của người dùng</h2>
                <ul>
                    <li>Bạn chịu trách nhiệm về mọi hành động của mình trên blog.</li>
                    <li>Không được cố ý phá hoại, tấn công, hoặc làm gián đoạn hoạt động của blog.</li>
                </ul>

                <h2>7. Thay đổi điều khoản</h2>
                <p>Chúng tôi có quyền sửa đổi các điều khoản bất kỳ lúc nào. Những thay đổi sẽ có hiệu lực ngay sau khi được cập nhật.</p>

                <h2>8. Luật pháp áp dụng</h2>
                <p>Điều khoản này được điều chỉnh và giải thích theo luật pháp Việt Nam.</p>

                <p>Nếu có thắc mắc, vui lòng liên hệ với chúng tôi qua email: <a href="mailto:nosewater.station@gmail.com">nosewater.station@gmail.com</a></p>
            </div>





            <!-- // Main Content -->




            <!-- // Content -->



        </div>
        <!-- // Page Wrapper -->

        <!-- Footer -->
        <?php include(ROOT_PATH . "/app/includes/footer.php"); ?>
        <!-- // Footer -->

        <!-- JQuery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <!-- CKeditor -->
        <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

        <!-- Slick Carousel -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

        <!-- Custom Script -->
        <script src="assets/js/script.js"></script>



</body>

</html>