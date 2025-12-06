<?php

// $_SESSION['id'] = 1;
// $_SESSION['username'] = 'kwa';


include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validateUser.php");
include(ROOT_PATH . "/app/includes/lang.php");


$table = 'users';
$admin_users = selectAll($table);

$errors = array();
$username = '';
$id = '';
$admin = '';
$email = '';
$password = '';
$passwordConf = '';



function loginUser($user,$text)
{
    $_SESSION['id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['admin'] = $user['admin'];
    $_SESSION['message'] = $text['login_success'];
    $_SESSION['type'] = 'success';


    // Xác định URL chuyển hướng
    $redirectUrl = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : BASE_URL . '/index.php';

    // Nếu không có trang trước, chuyển hướng bình thường
    if ($_SESSION['admin']) {
        header('location: ' . BASE_URL . '/admin/dashboard.php');
    } else {
        header('location: ' . $redirectUrl);
    }
    exit();
}

if (isset($_POST['register-btn']) || isset($_POST['create-admin'])) {
    // Thêm action cho register và create-admin
    $_POST['action'] = isset($_POST['register-btn']) ? 'register' : 'create';

    // validation
    $errors = validateUser($_POST);

    // add user to db

    if (count($errors) === 0) {

        unset($_POST['passwordConf'], $_POST['register-btn'], $_POST['create-admin'], $_POST['action']);

        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if (isset($_POST['admin'])) {
            $_POST['admin'] = 1;
            $user_id = create($table, $_POST);
            $_SESSION['message'] = "Admin user created";
            $_SESSION['type'] = "success";
            header('location: ' . BASE_URL . '/admin/users/index.php');
            exit();
        } else {
            $_POST['admin'] = 0;
            $user_id = create($table, $_POST);
            $user = selectOne($table, ['id' => $user_id]);
            // log user in
            loginUser($user,$text);
        }
    } else {
        $username = $_POST['username'];
        $admin = isset($_POST['admin']) ? 1 : 0;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];
    }
}

if (isset($_POST['update-user'])) {
    adminOnly();
    $id = $_POST['id'];
    // Thêm action cho update
    $_POST['action'] = 'update';
    //update user
    $errors = validateUser($_POST);
    if (count($errors) === 0) {

        unset($_POST['passwordConf'], $_POST['update-user'], $_POST['id'], $_POST['action']);

        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $_POST['admin'] = isset($_POST['admin']) ? 1 : 0;

        $count = update($table, $id, $_POST);
        $_SESSION['message'] = "Admin user updated";
        $_SESSION['type'] = "success";
        header('location: ' . BASE_URL . '/admin/users/index.php');
        exit();
    } else {
        $username = $_POST['username'];
        $admin = isset($_POST['admin']) ? 1 : 0;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];
    }
}

if (isset($_GET['id'])) {
    //to the edit page
    $user = selectOne($table, ['id' => $_GET['id']]);

    $id = $user['id'];
    $username = $user['username'];
    $admin = $user['admin'];
    $email = $user['email'];
}

if (isset($_POST['login-btn'])) {
    // validation
    $errors = validateLogin($_POST);

    if (count($errors) === 0) {
        $user = selectOne($table, ['username' => $_POST['username']]);

        if ($user && password_verify($_POST['password'], $user['password'])) {
            //login , redirect
            loginUser($user,$text);
        } else {
            //error
            array_push($errors, 'Wrong credentials');
        }
    }
    $username = $_POST['username'];
    $password = $_POST['password'];
}

if (isset($_GET['delete_id'])) {
    adminOnly();
    $count = delete($table,  $_GET['delete_id']);
    $_SESSION['message'] = "Admin user deleted";
    $_SESSION['type'] = "success";
    header('location: ' . BASE_URL . '/admin/users/index.php');
    exit();
} else {
    # code...
}
