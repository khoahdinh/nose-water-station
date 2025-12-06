<?php
if (isset($_POST['lang'])) {
    $_SESSION['lang'] = $_POST['lang'];
    // Tải lại trang sau khi thay đổi ngôn ngữ
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

// Kiểm tra và lấy ngôn ngữ từ session
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'vi'; // 
}

$currentLang = $_SESSION['lang'] ?? 'vi';
$text = $lang[$currentLang]; // Lấy chuỗi ngôn ngữ để hiển thị header footer
?>