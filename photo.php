<?php
include("path.php");
include(ROOT_PATH . '/app/controllers/images.php');
include(ROOT_PATH . '/app/includes/lang.php');
include(ROOT_PATH . '/app/includes/getLang.php');





$images = getImages(lang: $currentLang ); // lấy dữ liệu từ db -> truyền qua trang images/index.php

$image_comments = isset($_POST['image_id']) ? selectAll('img_comments', ['image_id' => $_POST['image_id']]) : [];

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
    <link rel="stylesheet" href="assets/css/photo.css">

    <!-- Favicon -->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <title>Story | Nose Water Station</title>

</head>

<body>

    <!-- Header -->
    <?php include(ROOT_PATH . "/app/includes/header.php"); ?>
    <!-- // Header -->

    <!-- Page Wrapper -->
    <div class="page-wrapper">
    <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>

        <div class="pin_container" style="display: none;">

            <?php foreach ($images as $image): ?>
                <div class="card" data-image-id="<?php echo $image['id']; ?>">
                    <img src="<?php echo BASE_URL . '/assets/images/' . htmlspecialchars($image['image_path']); ?>" alt="" class="thumbnail">
                    <div class="image-info">
                        <p class="author">by <?php echo htmlspecialchars($image['author']); ?></p>
                        <p class="date"><?php echo htmlspecialchars($image['date']); ?></p>
                        <p class="caption"><?php echo htmlspecialchars($image['caption'], ENT_NOQUOTES, 'UTF-8'); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

        <!-- Lightbox (ẩn mặc định) -->
        <div id="lightbox" class="lightbox">
            <span id="close-lightbox" class="close-lightbox">×</span>
            <div class="lightbox-content">
                <!-- Image -->
                <div class="lightbox-image">
                    <img id="lightbox-img" src="" alt="">
                </div>
                <!-- Info -->
                <div class="lightbox-description" id="lightbox-description">



                </div>
            </div>
        </div>

        <!-- // Page Wrapper -->

        <!-- Footer -->
        <?php include(ROOT_PATH . "/app/includes/footer.php"); ?>
        <!-- // Footer -->

        <!-- JQuery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <!-- Custom Script -->
        <script src="assets/js/script.js"></script>

        <!-- Phân loại ảnh -->
        <script>
            window.addEventListener('load', () => {
                const pinContainer = document.querySelector('.pin_container');
                const cards = document.querySelectorAll('.card');
                const assignClass = (img, card) => {
                    const {
                        width,
                        height
                    } = img;
                    const aspectRatio = width / height;

                    // Gán class dựa trên tỷ lệ và chiều cao
                    if (aspectRatio >= 0.9 && aspectRatio <= 1.1) {
                        // Hình gần như vuông -> card nhỏ
                        card.classList.add('card_small');
                    } else if (aspectRatio < 0.9) {
                        if (height < 1024) {
                            // Hình đứng với chiều cao trung bình -> card medium
                            card.classList.add('card_medium');
                        } else {
                            // Hình đứng với chiều cao lớn -> card large
                            card.classList.add('card_large');
                        }
                    } else if (aspectRatio > 1.1) {
                        // Hình ngang với chiều cao trung bình -> card medium
                        if (height < 1024) {
                            card.classList.add('card_medium');
                        } else {
                            card.classList.add('card_large');
                        }
                    }
                };

                cards.forEach(card => {
                    const img = card.querySelector('img');

                    // Kiểm tra kích thước ảnh định kỳ đến khi chiều rộng và chiều cao hợp lệ
                    const checkImageSize = setInterval(() => {
                        if (img.naturalWidth && img.naturalHeight) {
                            assignClass(img, card);
                            clearInterval(checkImageSize);
                        }
                    }, 100); // kiểm tra lại mỗi 100ms

                    // Xử lý trường hợp ảnh đã tải hoàn toàn từ cache
                    if (img.complete) {
                        assignClass(img, card);
                        clearInterval(checkImageSize);
                    }
                });

                // Hiển thị container sau khi tất cả ảnh đã được gán class
                pinContainer.style.display = 'grid';
            });

            // Hàm load bình luận qua AJAX
            function loadComments(imageId) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'load_comments.php', true); // Truyền đến file PHP xử lý bình luận
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Cập nhật phần bình luận trong lightbox
                        const commentSection = document.querySelector('.comment-image');
                        commentSection.innerHTML += xhr.responseText;
                    } else {
                        console.error('Không thể tải bình luận.');
                    }
                };

                // Gửi imageId qua AJAX
                xhr.send('image_id=' + imageId);
            }

            // Lightbox
            document.querySelectorAll('.thumbnail').forEach(img => {
                img.addEventListener('click', (e) => {
                    const imgSrc = e.target.src;
                    const parent = e.target.closest('.card');
                    const author = parent.querySelector('.author').textContent;
                    const date = parent.querySelector('.date').textContent;
                    const caption = parent.querySelector('.caption').textContent;

                    // Lấy imageId từ data-image-id của div.card
                    const imageId = parent.getAttribute('data-image-id');
                    console.log(imageId);

                    // Hiển thị lightbox
                    document.getElementById('lightbox').style.display = 'flex';

                    // Cập nhật ảnh trong lightbox
                    document.getElementById('lightbox-img').src = imgSrc;

                    // Cập nhật nội dung vào lightbox-description
                    const descriptionElement = document.getElementById('lightbox-description');
                    descriptionElement.innerHTML = ''; // Xóa nội dung cũ nếu có

                    descriptionElement.innerHTML += `
                        <div class="info-form">

                            <div class="image-info">
                                <p class="author">${author}</p>
                                <p class="date">${date}</p>
                                <p class="caption">${caption}</p>
                            </div>
                            
                            <div class="comment-list">
                                <div class="comment-image">
                                        
                                </div>     
                            </div>

                        </div>
                      
                    `;
                    loadComments(imageId);
                    // Kiểm tra trạng thái đăng nhập từ PHP
                    const isLoggedIn = <?php echo json_encode(isset($_SESSION['id'])); ?>;
                    if (isLoggedIn) {
                        descriptionElement.innerHTML += `
                        <form action="photo.php" method="POST" class="comment-form">

                            
                                
                                <div class="send-comment">

                                        <textarea name="comment" id="comment-box" placeholder="<?php echo $text['write_comment']; ?>"></textarea>
                                        <button type="submit" name="submit-comment" class="btn btn-big button"><i class="fa fa-arrow-up"></i></button>
                                        <input type="hidden" name="user_id" value="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?>"> 
                                        <input type="hidden" name="image_id" value="${imageId}">


                                </div>
                            
                        </form>
                        `;



                    } else {
                        descriptionElement.innerHTML += `
                            <div class="send-comment">

                                    <p><?php echo $text['you_have']; ?><a href="<?php $currentUrl = $_SERVER['REQUEST_URI']; echo BASE_URL . '/login.php?redirect_to=' . urlencode($currentUrl);?>"><?php echo $text['login']; ?></a><?php echo $text['to_comment']; ?></p>

                            </div>
                        `;


                    }
                });
            });

            // Đóng lightbox khi click vào dấu '×'
            document.getElementById('close-lightbox').addEventListener('click', () => {
                document.getElementById('lightbox').style.display = 'none';
            });

            // Đóng lightbox khi click ra ngoài khung (phía nền đen)
            document.getElementById('lightbox').addEventListener('click', (e) => {
                if (e.target === document.getElementById('lightbox')) {
                    console.log('Đóng lightbox');
                    document.getElementById('lightbox').style.display = 'none';
                }
            });
        </script>

</body>

</html>