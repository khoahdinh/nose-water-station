<?php
include("path.php");
include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . '/app/includes/lang.php');
include(ROOT_PATH . '/app/includes/getLang.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Cấu hình SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // SMTP của Gmail
    $mail->SMTPAuth = true;
    $mail->Username = 'hoangdinhkhoa4097@gmail.com'; // Địa chỉ Gmail của bạn
    $mail->Password = 'tvnk grgj biev kesh'; // Mật khẩu ứng dụng Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    // Gán địa chỉ người gửi (bạn)
    $mail->setFrom('khoa.hdinh@gmail.com', 'Khoa');

    // Gán email người dùng vào Reply-To
    $userEmail = $_POST['email']; // Email người dùng nhập vào
    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] =  $text['invalid_email'];
        $_SESSION['type'] = "error";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
    $mail->addReplyTo($userEmail, 'User');

    // Gửi email tới địa chỉ của bạn
    $mail->addAddress('khoa.hdinh@gmail.com');

    // Nội dung email
    $mail->isHTML(true);
    $mail->Subject = 'Blog Notification ';
    $mail->Body    = 'Email từ: ' . htmlspecialchars($userEmail) . '<br>Nội dung: ' . nl2br(htmlspecialchars($_POST['message']));

    // Gửi email
    $mail->send();

    if ($mail->send()) {
        // Nếu gửi thành công, chuyển hướng về trang hiện tại
        $_SESSION['message'] = $text['success_sent_mail'];
        $_SESSION['type'] = "success";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // echo 'Message has been sent';
} catch (Exception $e) {
    $_SESSION['message'] = $text['error_sent_mail'];
    $_SESSION['type'] = "error";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
