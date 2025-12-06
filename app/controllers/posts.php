<?php
include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validatePost.php");

$table = 'posts';

$topics = selectAll('topics');

$posts = get_posts_with_username($table);

$errors = array();

$id = "";
$title = "";
$title_eng = "";
$body = "";
$body_eng = "";
$topic_id = "";
$published = "";
$image = "";
$preview = "";
$preview_eng = "";
$slug = "";


if (isset($_GET['id'])) {
    // lấy dữ liệu -> edit page
    $post = selectOne($table, ['id' => $_GET['id']]);
    // dd($post);
    $id = $post['id'];
    $title = $post['title'];
    $title_eng = $post['title_eng'];
    $body = $post['body'];
    $body_eng = $post['body_eng'];
    $topic_id = $post['topic_id'];
    $published = $post['published'];
    $image = $post['image'];
    $preview = $post['preview'];
    $preview_eng = $post['preview_eng'];
    $slug = $post['slug'];
}

// if (isset($_GET['delete_id'])) {
//     adminOnly();
//     $count = delete($table, $_GET['delete_id']);
//     $_SESSION['message'] = "Post deleted successfully";
//     $_SESSION['type'] = "success";
//     header("location: " . BASE_URL . "/admin/posts/index.php");
//     exit();
// }

if (isset($_GET['delete_id'])) {
    adminOnly();

    // Truy vấn để lấy thông tin bài post
    $post = selectOne($table, ['id' => $_GET['delete_id']]);

    if ($post) {
        // Lấy đường dẫn ảnh
        $imagePath = ROOT_PATH . "/assets/images/" . $post['image'];

        // Xóa ảnh nếu tồn tại
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Xóa bài post trong cơ sở dữ liệu
        $count = delete($table, $_GET['delete_id']);
        $_SESSION['message'] = "Post deleted successfully";
        $_SESSION['type'] = "success";
    } else {
        $_SESSION['message'] = "Post not found!";
        $_SESSION['type'] = "error";
    }

    header("location: " . BASE_URL . "/admin/posts/index.php");
    exit();
}


if (isset($_GET['published']) && isset($_GET['p_id'])) {
    adminOnly();
    $published = $_GET['published'];
    $p_id = $_GET['p_id'];

    // update published
    $count = update($table, $p_id, ['published' => $published]);

    $_SESSION['message'] = "Post published state change";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/admin/posts/index.php");
    exit();
}

if (isset($_POST['add-post'])) {
    adminOnly();
    // dd($_FILES['image']['name']);
    $errors = validatePost($_POST);

    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . $_FILES['image']['name'];
        $destination = ROOT_PATH . "/assets/images/" . $image_name;
        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        if ($result) {
            $_POST['image'] = $image_name;
        } else {
            array_push($errors, "Failed to upload image");
        }
    } else {
        array_push($errors, "Post image required");
    }

    if (count($errors) === 0) {
        unset($_POST['add-post']);

        $_POST['user_id'] = $_SESSION['id']; //admin=true:1
        $_POST['published'] = isset($_POST['published']) ? 1 : 0;
        $_POST['body'] = htmlentities($_POST['body']);
        $_POST['preview'] = htmlentities($_POST['preview']);
        $_POST['title_eng'] = htmlentities($_POST['title_eng']);
        $_POST['body_eng'] = htmlentities($_POST['body_eng']);
        $_POST['preview_eng'] = htmlentities($_POST['preview_eng']);
        $_POST['slug'] = htmlentities($_POST['slug']);

        // Kiểm tra slug trùng lặp
        $existingSlug = selectOne($table, ['slug' => $_POST['slug']]);
        if ($existingSlug) {
            $_POST['slug'] .= '-' . time(); // Thêm timestamp nếu trùng
        }

        $post_id = create($table, $_POST);
        $_SESSION['message'] = "Post created successfully";
        $_SESSION['type'] = "success";
        header("location: " . BASE_URL . "/admin/posts/index.php");
        exit();
    } else {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $preview = $_POST['preview'];
        $topic_id = $_POST['topic_id'];
        $published = isset($_POST['published']) ? 1 : 0;
        $title_eng = $_POST['title_eng'];
        $body_eng = $_POST['body_eng'];
        $preview_eng = $_POST['preview_eng'];
        $slug = $_POST['slug'];
    }
}

if (isset($_POST['update-post'])) {
    adminOnly();
    $errors = validatePost($_POST);
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . $_FILES['image']['name'];
        $destination = ROOT_PATH . "/assets/images/" . $image_name;
        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        if ($result) {
            $_POST['image'] = $image_name;
        } else {
            array_push($errors, "Failed to upload image");
        }
    } else {
        // array_push($errors, "Post image required");
        // Không cần phải upload ảnh mới khi edit ảnh
    }
    if (count($errors) === 0) {
        $id = $_POST['id'];
        unset($_POST['update-post'], $_POST['id']);

        $_POST['user_id'] = $_SESSION['id']; //admin=true:1
        $_POST['published'] = isset($_POST['published']) ? 1 : 0;
        $_POST['body'] = htmlentities($_POST['body']);
        $_POST['preview'] = htmlentities($_POST['preview']);
        $_POST['title_eng'] = htmlentities($_POST['title_eng']);
        $_POST['body_eng'] = htmlentities($_POST['body_eng']);
        $_POST['preview_eng'] = htmlentities($_POST['preview_eng']);
        $_POST['slug'] = htmlentities($_POST['slug']);


        $post_id = update($table, $id, $_POST);
        $_SESSION['message'] = "Post updated successfully";
        $_SESSION['type'] = "success";
        header("location: " . BASE_URL . "/admin/posts/index.php");
    } else {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $preview = $_POST['preview'];
        $topic_id = $_POST['topic_id'];
        $published = isset($_POST['published']) ? 1 : 0;
        $title_eng = $_POST['title_eng'];
        $body_eng = $_POST['body_eng'];
        $preview_eng = $_POST['preview_eng'];
        $slug = $_POST['slug'];
    }
}

function getCurrentUrl()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $requestUri = $_SERVER['REQUEST_URI'];

    return $protocol . "://" . $host . $requestUri;
}

//  For Comment Logic

$spam_keywords = [
    "fuck",
    "shit",
    "bitch",
    "asshole",
    "damn",
    "bastard",
    "dick",
    "cocksucker",
    "motherfucker",
    "piss",
    "whore",
    "slut",
    "cock",
    "tits",
    "cunt",
    "pussy",
    "fag",
    "gay",
    "queer",
    "douchebag",
    "prick",
    "twat",
    "dildo",
    "bimbo",
    "cum",
    "semen",
    "orgasm",
    "rape",
    "molest",
    "sexist",
    "fuckhead",
    "fucking",
    "bastards",
    "cuntface"
];

// Hàm kiểm tra từ cấm
function is_spam_comment($comment, $spam_keywords)
{
    $words = preg_split('/\s+/', $comment); // Tách các từ trong bình luận
    foreach ($words as $word) {
        // Kiểm tra nếu từ có trong danh sách từ cấm
        if (in_array(strtolower($word), $spam_keywords)) {
            return true; // Nếu tìm thấy từ cấm, trả về true
        }
    }
    return false; // Nếu không có từ cấm, trả về false
}


if (isset($_POST['submit-comment'])) {

    // dd($_POST);
    $author = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
    $post_id = $_POST['post_id'];

    $comment_raw = $_POST['comment'];
    $comment_cleaned = strtolower($comment_raw); // Chuyển về chữ thường

    // $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');
    $parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : null; // Nếu có parent_id, đây là comment con

    // Kiểm tra nếu bình luận không rỗng
    if (!empty($comment_raw)) {

        if (is_spam_comment($comment_cleaned, $spam_keywords)) {
            $_SESSION['message'] = 'Bình luận của bạn chứa từ khóa spam. Vui lòng thử lại.';
            $_SESSION['type'] = 'error';
            header("Location: single.php?id=" . $post_id);
            exit;
        }

        // Nếu không chứa từ khóa spam, thêm bình luận vào cơ sở dữ liệu
        $comment = htmlspecialchars($comment_raw, ENT_QUOTES, 'UTF-8');
        unset($_POST['submit-comment']);
        $data = [
            'post_id' => $post_id,
            'author' => $author,
            'body' => $comment,
            'parent_id' => $parent_id
        ];

        $comment_id = create('comments', $data);

        // Sau khi thêm thành công, chuyển hướng lại về trang bài viết
        header("Location: single.php?id=" . $post_id);
        exit;
    } else {
        $_SESSION['message'] = 'Vui lòng nhập bình luận.';
        $_SESSION['type'] = 'error';
        header("Location: single.php?id=" . $post_id);
        exit;
    }
}


// Delete comment
if (isset($_GET['delete_comment_id'])) {
    $comment_id = $_GET['delete_comment_id'];

    // Bắt đầu một giao dịch để đảm bảo xóa đồng bộ cả bình luận cha và bình luận con
    $conn->begin_transaction();

    try {
        // Xóa bình luận cha
        $query = "DELETE FROM comments WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $comment_id);
        $stmt->execute();

        // Xóa tất cả các bình luận con của bình luận cha
        $query_children = "DELETE FROM comments WHERE parent_id = ?";
        $stmt_children = $conn->prepare($query_children);
        $stmt_children->bind_param("i", $comment_id);
        $stmt_children->execute();

        // Commit giao dịch
        $conn->commit();

        $_SESSION['message'] = 'Bình luận đã được xóa cùng với các bình luận con.';
        $_SESSION['type'] = 'success';
    } catch (Exception $e) {
        // Rollback nếu có lỗi
        $conn->rollback();
        $_SESSION['message'] = 'Không thể xóa bình luận. Lỗi: ' . $e->getMessage();
        $_SESSION['type'] = 'error';
    }

    header("location: " . BASE_URL . "/admin/comments/index.php");
    exit();
}
