<?php

// Bao gồm file config.php để lấy thông tin cấu hình
// include_once(__DIR__ . '/../../config.php');

// Sử dụng các giá trị cấu hình từ config.php
// $host = DB_HOST;
// $user = DB_USER;
// $pass = DB_PASSWORD;
// $db_name = DB_NAME;

$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'blog';

$conn = new MYSQli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die('Database connection error:' . $conn->connect_error);
}
