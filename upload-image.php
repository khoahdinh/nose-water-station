<?php
// upload-image.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['upload'])) {
    $file = $_FILES['upload'];

    // Kiểm tra lỗi upload
    if ($file['error'] === UPLOAD_ERR_OK) {
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/blog/assets/images/';  // Đảm bảo đúng đường dẫn tới thư mục images
        $targetFile = $targetDir . basename($file['name']);

        // Kiểm tra nếu thư mục chưa có thì tạo mới
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Di chuyển file upload
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {

            // Trả về URL của ảnh đã upload
            echo json_encode([
                'uploaded' => true,
                'fileName' => $file['name'],
                'url' => '/blog/assets/images/' . $file['name']  // Đường dẫn ảnh sẽ được trả về
            ]);
        } else {
            echo json_encode(['uploaded' => false, 'error' => ['message' => 'File move failed']]);
        }
    } else {
        echo json_encode(['uploaded' => false, 'error' => ['message' => 'Upload error']]);
    }
}
