<?php
include("path.php");
include(ROOT_PATH . '/app/controllers/posts.php');
include(ROOT_PATH . '/app/includes/lang.php');
include(ROOT_PATH . '/app/includes/getLang.php');


// Kiểm tra bài viết
if (isset($_GET['slug'])) {
    $post = selectOne('posts', ['slug' => $_GET['slug']]);
    if ($currentLang === 'en') {
        $post['title'] = $post['title_eng'];
        $post['body'] = $post['body_eng'];
    }
}

// dd(BASE_URL . '/assets/images/'. $post['image']);

// Lấy Comments cho bài viết
$post_id = $post['id']; // Lấy ID của bài viết từ URL trang
$comments = selectAllComment($post_id);
// $comments = getComments();


//Lấy Topic cho SideBar
$topics = selectAllTopics('topics');

// Lấy Popular Post
$sql = "UPDATE posts SET views = views + 1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $post_id);
$stmt->execute();
$stmt->close();

$popularPosts = getPopularPosts(lang: $currentLang);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Thẻ meta cho SEO -->
    <meta name="description" content="<?php echo htmlspecialchars($post['preview']); ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo BASE_URL . '/post/' . $post['slug']; ?>">
    <!-- Open Graph (hiển thị đẹp khi chia sẻ trên Facebook/Zalo) -->
    <meta property="og:title" content="<?php echo htmlspecialchars($post['title']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($post['preview']); ?>">
    <meta property="og:image" content="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>">
    <meta property="og:url" content="<?php echo BASE_URL . '/post/' . $post['slug']; ?>">
    <meta property="og:type" content="article">

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

    <title><?php echo $post['title']; ?> | Nose Water Station</title>

</head>

<body>

    <!-- Header -->
    <?php include(ROOT_PATH . "/app/includes/header.php"); ?>
    <!-- // Header -->

    <?php include(ROOT_PATH . '/app/includes/messages.php'); ?>

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Post Slider -->
        <!-- // Post Slider -->

        <!-- Content -->


        <div class="content clearfix">
            <!-- Main Content Wrapper-->
            <div class="main-content">

                <div class="single">

                    <!-- <h1 class="post-title"><?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?></h1> -->

                    <div class="post-content">
                        <?php echo html_entity_decode($post['body']); ?>
                    </div>
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(getCurrentUrl()); ?>" target="_blank" class="facebook-share-button">
                            <i class="fab fa-facebook-f"></i> Share
                        </a>
                    </div>
                </div>

                <div class="comment-section">
                    <div class="comment-form">

                        <?php if (isset($_SESSION['username'])): ?>
                            <form action="<?php echo BASE_URL . '/' .  $post['slug'] ?>" method="POST">
                                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                <textarea name="comment" placeholder="<?php echo $text['write_comment']; ?>"></textarea>
                                <button type="submit" name="submit-comment" class="btn btn-big button"><?php echo $text['send_comment']; ?></button>
                            </form>
                        <?php else: ?>
                            <p><?php echo $text['you_have']; ?>
                                <a href="<?php
                                            $currentUrl = $_SERVER['REQUEST_URI'];
                                            echo BASE_URL . '/login.php?redirect_to=' . urlencode($currentUrl);
                                            ?>">
                                    <?php echo $text['login']; ?>
                                </a>
                                <?php echo $text['to_comment']; ?>
                            </p>
                        <?php endif; ?>

                    </div>

                    <?php foreach (array_reverse($comments) as $comment):
                        $parentId = $comment['id']; // Lấy ID của comment cha
                        $childComments = selectAllChildComments($parentId); // Lấy comment con 
                    ?>
                        <div class="comment">
                            <p class="comment-author"><?php echo $comment['author']; ?></p>
                            <p><?php echo nl2br(html_entity_decode($comment['body'], ENT_QUOTES, 'UTF-8')); ?></p>
                            <small>Posted on: <?php echo $comment['created_at'] ?></small>

                            <!-- Nút Reply -->
                            <?php if (isset($_SESSION['username'])): ?>
                                <button class="reply-btn" onclick="toggleReplyForm(<?php echo $comment['id']; ?>)"><?php echo $text['reply']; ?></button>
                            <?php endif; ?>

                            <!-- Nút xổ xuống -->
                            <?php if (!empty($childComments)): ?>
                                <button class="toggle-reply-btn" data-parent-id="<?php echo $parentId; ?>">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            <?php endif; ?>

                            <!-- Form Reply Ẩn -->
                            <div class="reply-form" id="reply-form-<?php echo $comment['id']; ?>" style="display: none;">
                                <form action="single.php?id=<?php echo $post['id'] ?>" method="POST">
                                    <input type="hidden" name="parent_id" value="<?php echo $comment['id']; ?>">
                                    <input type="hidden" name="post_id" value="<?php echo $_GET['id']; ?>">
                                    <textarea name="comment" rows="3" placeholder="<?php echo $text['write_comment']; ?>"></textarea><br>
                                    <button type="submit" name="submit-comment" class="btn btn-big button"><?php echo $text['summit_reply']; ?></button>
                                </form>
                            </div>
                        </div>

                        <!-- Hiển thị comment con -->
                        <div class="child-comments" id="child-comments-<?php echo $parentId; ?>" style="display: none;">

                            <?php foreach ($childComments as $child): ?>
                                <div class="comment-son">
                                    <p class="comment-son-author"><?php echo $child['author']; ?></p>
                                    <p><?php echo html_entity_decode($child['body'], ENT_QUOTES, 'UTF-8') ?></p>
                                    <small>Posted on: <?php echo $child['created_at'] ?></small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>

                </div>

            </div>

            <!-- // Main Content -->

            <!-- Sidebar -->
            <div class="sidebar single">

                <div class="section popular">
                    <h2 class="section-title"><?php echo $text['popular_post']; ?></h2>
                    <?php foreach ($popularPosts as $p): ?>
                        <div class="post clearfix">
                            <img src="<?php echo BASE_URL . '/assets/images/' .  $p['image']; ?>" alt="">
                            <a href="<?php echo BASE_URL  .  '/' . $p['slug']; ?>" class="title">
                                <h4><?php echo $p['title']; ?></h4>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="section topics">
                    <h2 class="section-title"><?php echo $text['topics']; ?></h2>
                    <ul>
                        <?php foreach ($topics as $topic):
                            $topic_name = ($currentLang === 'vi') ? $topic['name'] : $topic['name_eng'];
                        ?>
                            <li><a href="<?php echo BASE_URL . '/?t_id=' . $topic['id'] . '&name=' .  $topic_name; ?>"><?php echo  $topic_name ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- // Sidebar -->

            </div>
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

        <!-- Favicon -->
        <link rel="icon" href="favicon.ico" type="image/x-icon">

        <script>
            // Reply comment
            function toggleReplyForm(commentId) {
                const form = document.getElementById(`reply-form-${commentId}`);
                if (form.style.display === "none") {
                    form.style.display = "block";
                } else {
                    form.style.display = "none";
                }
            }
            // Hide and show Reply comment
            // Rotate Hide/Show Button Comment Sub 


            document.addEventListener("DOMContentLoaded", function() {
                const toggleButtons = document.querySelectorAll(".toggle-reply-btn");

                toggleButtons.forEach(button => {
                    button.addEventListener("click", function() {
                        const parentId = this.dataset.parentId; // Lấy ID của comment cha
                        const childComments = document.getElementById(`child-comments-${parentId}`);
                        const icon = this.querySelector("i");

                        if (childComments) {
                            // Hiển thị hoặc ẩn phần comment con
                            if (childComments.style.display === "none" || childComments.style.display === "") {
                                childComments.style.display = "block"; // Hiển thị
                            } else {
                                childComments.style.display = "none"; // Ẩn
                            }
                            // Đổi trạng thái xoay cho nút
                            this.classList.toggle("active");
                        }
                    });
                });
            });
        </script>

</body>

</html>