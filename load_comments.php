<?php
include("path.php");
include(ROOT_PATH . "/app/database/db.php");

// Lấy bình luận cho ảnh
$image_id = $_POST['image_id'];

// Viết câu truy vấn SQL với JOIN
$sql = "SELECT img_comments.*, users.username FROM img_comments 
        JOIN users ON img_comments.user_id = users.id
        WHERE img_comments.image_id = ?
        ORDER BY created_at DESC";

// Thực thi câu truy vấn
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $image_id);  // Gán giá trị cho tham số image_id
$stmt->execute();
$result = $stmt->get_result();
$image_comments = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();  // Giải phóng statement sau khi hoàn tất

if ($image_comments):
    foreach ($image_comments as $comment):
        echo '<div class="comment-image">';
            echo '<p class="comment-text"><span class="comment-author">' . htmlspecialchars($comment['username']) . ':</span> ' . html_entity_decode($comment['comment']) . '</p>';
            echo '<p class="comment-date">' . date('d/m/Y', strtotime($comment['created_at'])) . '</p>';
        echo '</div>';
    endforeach;
else:
    echo '<p></p>';
endif;
?>
