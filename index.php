<?php include("path.php");
include(ROOT_PATH . '/app/controllers/topics.php');
include(ROOT_PATH . '/app/includes/lang.php');
include(ROOT_PATH . '/app/includes/getLang.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);




// $text lấy từ getlang.php

//Lấy Topic cho SideBar
$topics = selectAllTopics('topics');

// Post
$posts = array();
$paginatedPosts = ['posts' => []];


$postsTitle = $text['recent_posts'];

if (isset($_GET['t_id']) && isset($_GET['search-term'])) {

    // Nếu có cả t_id và search-term, thực hiện tìm kiếm trong topic
    $postsTitle = $text['search_in_topic'] . " '"
        . htmlspecialchars($_GET['search-term'] ?? 'Unknown') . "' "
        . $text['within_topic'] . " '"
        . htmlspecialchars($_GET['name'] ?? 'Unknown') . "'";

    // Gọi hàm tìm kiếm trong topic với t_id và search-term
    $paginatedPosts = searchPostsInTopic($_GET['t_id'], $_GET['search-term'], 1, 3, $currentLang);
} elseif (isset($_GET['t_id'])) {
    // Nếu chỉ có t_id (không có search-term), hiển thị bài viết theo topic
    $postsTitle = $text['topic_guide'] . " '" . htmlspecialchars($_GET['name'] ?? 'Unknown') . "'";
    $paginatedPosts = getPostsByTopicID($_GET['t_id'], 1, 3, lang: $currentLang);
} elseif (isset($_GET['search-term'])) {
    // Nếu chỉ có search-term (không có t_id), tìm kiếm toàn bộ bài viết
    $postsTitle = $text['search_guide'] . " '" . htmlspecialchars($_GET['search-term'] ?? 'Unknown') . "'";
    $paginatedPosts = searchPosts($_GET['search-term'], 1, 3, $currentLang);
} else {
    // Nếu không có cả t_id và search-term, hiển thị tất cả bài viết
    $paginatedPosts = getPaginatedPosts(1, 3, $currentLang);
}

if (isset($_GET['page']) && isset($_GET['ajax'])) {
    $term = $_GET['search-term'] ?? '';
    $topic_id = isset($_GET['t_id']) ? $_GET['t_id'] : null;

    // Nếu có từ khóa tìm kiếm
    if ($term) {
        if ($topic_id) {
            $paginatedPosts = searchPostsInTopic($topic_id, $term, $_GET['page'], 3, $currentLang);
        } else {
            $paginatedPosts = searchPosts($term, $_GET['page'], 3, $currentLang);
        }
        // Nếu có topic mà không có từ khóa tìm kiếm
    } elseif ($topic_id) {
        $paginatedPosts = getPostsByTopicID($topic_id, $_GET['page'], 3, lang: $currentLang);
        // Nếu không có cả topic và từ khóa, lấy bài viết phân trang bình thường
    } else {
        $paginatedPosts = getPaginatedPosts($_GET['page'], 3, $currentLang);
    }


    echo json_encode($paginatedPosts, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);
    // echo json_encode($paginatedPosts);
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Blog chia sẻ những suy nghĩ về học hành, cuộc sống và những câu chuyện thú vị. Khám phá các bài viết đầy cảm hứng và thú vị ngay hôm nay!" />


    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/69714c34b3.js" crossorigin="anonymous"></script>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Candal&family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Varela+Round&display=swap" rel="stylesheet">
    <!-- Custom Styling -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Favicon -->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <title> Nose Water Station</title>

</head>

<body>
    <!-- Header -->
    <?php include(ROOT_PATH . "/app/includes/header.php"); ?>
    <!-- // Header -->

    <!-- Message -->
    <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>
    <!-- // Message -->

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Welcome Section -->

        <div class="container">
            <div class="content-section">
                <div class="title">
                    <h1><?php echo $text['hi_text']; ?></h1>
                </div>
                <div class="welcome_content">
                    <h3><?php echo $text['welcome_user']; ?></h3>
                    <p><?php echo $text['welcome_text']; ?></p>
                </div>
                <div class="random-post">
                    <button class="random-btn"><a href="<?php echo BASE_URL . '/' . get_random_post(); ?>"><?php echo $text['Random-post'] ?></a></button>
                </div>
            </div>
            <div class="image-section">
                <img src="<?php echo BASE_URL . '/assets/images/about_page/welcome_image.png' ?>" alt="">
                <!-- <iframe width="560" height="500" src="https://www.youtube.com/embed/rTHf5tPlIDk?si=i0EeIuiADKXzlb_v" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> -->
            </div>
        </div>

        <!-- //Welcome Section -->

        <!-- Content -->
        <div class="content clearfix">
            <!-- Main Content -->
            <div class="main-content">
                <div class="post-list">
                    <h1 class="recent-post-title">
                        <?php echo $postsTitle ?>
                    </h1>

                    <?php foreach ($paginatedPosts['posts'] as $post): ?>
                        <div class="post clearfix">
                            <img src="<?php echo $post['image']; ?>" alt="" class="post-image">
                            <div class="post-preview">
                                <h2><a href="<?php echo BASE_URL . '/' . $post['slug']; ?>">
                                        <?php echo $post['title']; ?>
                                    </a></h2>
                                <i class="far fa-user"> <span>
                                        <?php echo $post['username']; ?>
                                    </span></i>
                                &nbsp;
                                <i class="far fa-calendar"> <span>
                                        <?php echo $post['created_at']; ?>
                                    </span></i>
                                <p class="preview-text">

                                    <?php echo ($post['preview']); ?>

                                </p>
                                <!-- <a href="single.php?id=<?php echo $post['id']; ?>" class="btn read-more"><?php echo $text["read_more"]; ?></a> -->
                                <a href="<?php echo BASE_URL . '/' . $post['slug']; ?>" class="btn read-more"><?php echo $text["read_more"]; ?></a>

                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>


                </div>
                <div class="pagination-links" style="display: flex; justify-content: center;">
                    <button type="button" class="btn read-more load-more-btn"><?php echo $text["load_more"]; ?></button>
                </div>

            </div>
            <!-- // Main Content -->

            <!-- Sidebar -->
            <div class="sidebar">
                <div class="section search">
                    <h2 class="section-title"><?php echo $text['search']; ?></h2>
                    <form action="<?php echo BASE_URL; ?>" method="get">
                        <!-- <input type="text" name="search-term" class="text-input" placeholder="Search..."> -->
                        <input type="text" name="search-term" class="text-input" placeholder="Search..." value="<?php echo htmlspecialchars($_GET['search-term'] ?? ''); ?>">
                        <?php if (isset($_GET['t_id'])): ?>
                            <input type="hidden" name="t_id" value="<?php echo htmlspecialchars($_GET['t_id']); ?>">
                            <input type="hidden" name="name" value="<?php echo htmlspecialchars($_GET['name']); ?>">
                        <?php endif; ?>
                    </form>
                </div>

                <div class="section topics">
                    <h2 class="section-title"><?php echo $text['topics']; ?></h2>
                    <ul>
                        <?php foreach ($topics as $key => $topic):
                            $topic_name = ($currentLang === 'vi') ? $topic['name'] : $topic['name_eng'];
                        ?>
                            <li><a
                                    href="<?php echo BASE_URL . '/index.php?t_id=' . $topic['id'] . '&name=' . $topic_name; ?>">
                                    <?php echo $topic_name; ?>
                                </a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- <div class="section youtube">
                    <h2 class="section-title"><?php echo $text['topics']; ?></h2>
                </div> -->

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

    <!-- Slick Carousel -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <!-- Custom Script -->
    <script src="assets/js/script.js"></script>

    <!-- Load more button -->
    <script>
        const loadMoreBtn = document.querySelector('.load-more-btn');
        const postList = document.querySelector('.post-list');
        const paginationLinks = document.querySelector('.pagination-links');

        function displayPosts(posts) {
            posts.forEach(post => {
                let postHtmlString = `
                    <div class="post clearfix">
                            <img src="${post.image}" alt="" class="post-image">
                            <div class="post-preview">
                                <h2><a href="/blog/${post.slug}">
                                        ${post.title}
                                    </a></h2>
                                <i class="far fa-user"> <span>
                                        ${post.username}
                                    </span></i>
                                    &nbsp;
                                <i class="far fa-calendar"> <span>
                                        ${post.created_at}
                                    </span></i>
                                <p class="preview-text">
                                    ${post.preview}
                                </p>
                                <a href="/blog/${post.slug}" class="btn read-more"><?php echo $text["read_more"]; ?></a>
                            </div>
                        </div>
        `;
                const domParse = new DOMParser();
                const doc = domParse.parseFromString(postHtmlString, 'text/html');
                const postNode = doc.body.firstChild;
                postList.appendChild(postNode);
            });
        }

        let nextPage = 2;

        loadMoreBtn.addEventListener('click', async function(e) {
            loadMoreBtn.textContent = 'Loading...';

            const recordsPerPage = 3;

            const term = new URLSearchParams(window.location.search).get('search-term');
            const topicId = new URLSearchParams(window.location.search).get('t_id');
            const response = await fetch(`index.php?page=${nextPage}&ajax=1${term ? `&search-term=${term}` : ''}${topicId ? `&t_id=${topicId}` : ''}`);
            const data = await response.json();
            // const textData = await response.text();
            // console.log(textData); // Log response as text to see if there's an error message
            // const data = JSON.parse(textData);

            // console.log(data);  
            displayPosts(data.posts);
            nextPage = data.nextPage;
            if (!data.nextPage) {
                paginationLinks.innerHTML = '<div style="color:gray; "><?php echo $text["no_more_posts"]; ?></div>'
            } else {
                loadMoreBtn.textContent = '<?php echo $text["load_more"]; ?>';
            }

        });
    </script>
    <!-- <script>
        document.getElementById("no-idea-button").addEventListener("click", function(e) {
            e.preventDefault(); // Ngăn chặn hành động mặc định của thẻ <a>
            alert("Haha, no idea yet! But thanks for clicking!");
        });
    </script> -->
</body>

</html>