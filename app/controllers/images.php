<?php
include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validateImage.php");

$errors = array();
$table = 'images';
$images = getImages($table);


$id = "";
$author = "";
$date = "";
$caption = "";
$caption_eng = "";

if (isset($_GET['id'])) {
    $image = selectOne($table, ['id' => $_GET['id']]);

    $id = $image['id'];
    $author = $image['author'];
    $date = $image['date'];
    $caption = $image['caption'];
    $caption_eng = $image['caption_eng'];
    $image = $image['image_path'];
}

// if (isset($_GET['delete_id'])) {
//     adminOnly();
//     $count = delete($table, $_GET['delete_id']);
//     $_SESSION['message'] = "Image deleted successfully";
//     $_SESSION['type'] = "success";
//     header("location: " . BASE_URL . "/admin/images/index.php");
//     exit();
// }

if (isset($_GET['delete_id'])) {
    adminOnly();
    
    // Truy vấn để lấy thông tin ảnh từ cơ sở dữ liệu
    $image = selectOne($table, ['id' => $_GET['delete_id']]);
    
    if ($image) {
        // Lấy đường dẫn file ảnh
        $imagePath = ROOT_PATH . "/assets/images/" . $image['image_path']; // 'image_name' là tên cột chứa tên file ảnh
        
        // Xóa file ảnh nếu tồn tại
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        
        // Xóa thông tin ảnh trong cơ sở dữ liệu
        $count = delete($table, $_GET['delete_id']);
        $_SESSION['message'] = "Image deleted successfully";
        $_SESSION['type'] = "success";
    } else {
        $_SESSION['message'] = "Image not found!";
        $_SESSION['type'] = "error";
    }
    
    header("location: " . BASE_URL . "/admin/images/index.php");
    exit();
}


if (isset($_POST['add-image'])) {
    adminOnly();
    $errors = validateImage($_POST, $_FILES);
    if (count($errors) === 0) {

        if (!empty($_FILES['image']['name'])) {
            $image_name = time() . '_' . $_FILES['image']['name'];
            $destination = ROOT_PATH . "/assets/images/" . $image_name;
            $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
            if ($result) {
                $_POST['image_path'] = $image_name;
            } else {
                array_push($errors, "Failed to upload image");
            }
        }else{
            // edit không cần phải upload ảnh mới
        }

        unset($_POST['add-image']);

        $_POST['author'] = $_POST['author'];
        $_POST['date'] = $_POST['date'];
        $_POST['caption'] = ($_POST['caption']);
        $_POST['caption_eng'] = ($_POST['caption_eng']);

        $image_id = create($table, $_POST);

        $_SESSION['message'] = "Image created successfully";
        $_SESSION['type'] = "success";
        header("location: " . BASE_URL . "/admin/images/index.php");
        exit();
    } else {
        $author = $_POST['author'];
        $date = $_POST['date'];
        $caption = $_POST['caption'];
        $caption_eng = $_POST['caption_eng'];
    }
}

if (isset($_POST['update-image'])) {
    adminOnly();
    $id = $_POST['id'];
    $errors = validateImage($_POST, $_FILES);
    if (count($errors) === 0) {

        if (!empty($_FILES['image']['name'])) {
            $image_name = time() . '_' . $_FILES['image']['name'];
            $destination = ROOT_PATH . "/assets/images/" . $image_name;
            $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
            if ($result) {
                $_POST['image_path'] = $image_name;
            } else {
                array_push($errors, "Failed to upload image");
            }
        }
        unset($_POST['update-image'], $_POST['id']);

        $_POST['author'] = $_POST['author'];
        $_POST['date'] = $_POST['date'];
        $_POST['caption'] = ($_POST['caption']);
        $_POST['caption_eng'] = ($_POST['caption_eng']);

        $image_id = update($table, $id, $_POST);

        $_SESSION['message'] = "Image updated successfully";
        $_SESSION['type'] = "success";
        header("location: " . BASE_URL . "/admin/images/index.php");
        exit();
    } else {

        $author = $_POST['author'];
        $date = $_POST['date'];
        $caption = $_POST['caption'];
        $caption_eng = $_POST['caption_eng'];

        // Không upload ảnh mới => Lấy ảnh cũ từ database
        $currentImage = selectOne($table, ['id' => $id]);
        $image = $currentImage['image_path'];
    }
}

// XỬ LÝ COMMENT PHOTO.PHP(LIGHT BOX)

// lấy thông tin ảnh theo id 
function getImageById($imageId)
{
    global $conn;

    $sql = "SELECT * FROM images WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $imageId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    return $result->fetch_assoc();
}

// Lấy comment theo Id 
function getImageComments($imageId)
{
    global $conn;

    $sql = "SELECT img_comments.id, img_comments.comment, img_comments.created_at, users.username, images.image_path AS image_url
        FROM img_comments
        JOIN users ON img_comments.user_id = users.id
        JOIN images ON img_comments.image_id = images.id
        WHERE img_comments.image_id = ?
        ORDER BY img_comments.created_at DESC";


    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $imageId);
    $stmt->execute();
    $record = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $record;
}

// delete comment ảnh
if (isset($_GET['delete_img_comment_id'])) {
    adminOnly();

    // Lấy image_id từ URL
    $imageId = isset($_GET['image_id']) ? intval($_GET['image_id']) : null;

    if (!$imageId) {
        $_SESSION['message'] = "Image ID not specified.";
        $_SESSION['type'] = "error";
        header("location: " . BASE_URL . "/admin/images/index.php");
        exit();
    }

    // Xóa bình luận
    $count = delete('img_comments', $_GET['delete_img_comment_id']);
    $_SESSION['message'] = "Comment deleted successfully";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/admin/images/image_comments.php?image_id=" . $imageId);
    exit();
}

// thêm cmt cho ảnh trang photo.php
if (isset($_POST['submit-comment'])) {

    // Lấy dữ liệu từ form
    $comment = htmlspecialchars(trim($_POST['comment']));
    $user_id = $_SESSION['id']; // Lấy ID người dùng từ session
    $image_id = $_POST['image_id']; // ID ảnh từ form gửi

    // Kiểm tra tính hợp lệ của bình luận
    if (empty($comment)) {
        $_SESSION['message'] = "Bình luận không thể để trống!";
        $_SESSION['type'] = "error";
        header("Location: photo.php");
        exit();
    }

    // Thoát khỏi các ký tự đặc biệt để tránh SQL Injection
    $comment = htmlspecialchars($comment);

    // Dữ liệu cần chèn vào cơ sở dữ liệu
    unset($_POST['submit-comment']); // unset nút ko có trong db img_comments
    $data = [
        'user_id' => $user_id,
        'image_id' => $image_id,
        'comment' => $comment
    ];

    // Gọi hàm create để lưu bình luận vào cơ sở dữ liệu
    $comment_id = create('img_comments', $data);

    if ($comment_id) {
        header("Location: photo.php"); // Giả sử bạn chuyển hướng về trang ảnh
        exit;
    } else {
        echo "Lỗi khi lưu bình luận!";
    }
}
