<?php
include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validateTopic.php");


$table = 'topics';
$errors = array();
$id = '';
$name = '';
$name_eng = '';
$description = '';
$sort_order = '';

$topics = selectAll($table);
// dd($topics);
if (isset($_POST['add-topic'])) {
    adminOnly();
    $errors = validateTopic($_POST);
    if (count($errors) === 0) {
        unset($_POST['add-topic']);
        $topic_id = create($table, $_POST);
        $_SESSION['message'] = 'Topic created successfully';
        $_SESSION['type'] = 'success';
        header('location: ' . BASE_URL . '/admin/topics/index.php');
        exit();
    } else {
        $name = $_POST['name'];
        $name_eng = $_POST['name_eng'];
        $description = $_POST['description'];
        $sort_order = $_POST['sort_order'];
    }
}

// lay info tu page index bo vao trong page edit 
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $topic = selectOne($table, ['id' => $id]);
    $id = $topic['id'];
    $name = $topic['name'];
    $name_eng = $topic['name_eng'];
    $description = $topic['description'];
    $sort_order = $topic['sort_order'];
}
//delete topic
if (isset($_GET['del_id'])) {
    adminOnly();
    $id = $_GET['del_id'];
    $count = delete($table, $id);

    $_SESSION['message'] = 'Topic deleted successfully';
    $_SESSION['type'] = 'success';
    header('location: ' . BASE_URL . '/admin/topics/index.php');
    exit();
}

if (isset($_POST['update-topic'])) {
    adminOnly();
    $errors = validateTopic($_POST);
    if (count($errors) === 0) {
        $id = $_POST['id'];
        unset($_POST['update-topic']);
        unset($_POST['id']);
        $topic_id = update($table, $id, $_POST);

        $_SESSION['message'] = 'Topic updated successfully';
        $_SESSION['type'] = 'success';
        header('location: ' . BASE_URL . '/admin/topics/index.php');
        exit();
    } else {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $name_eng = $_POST['name_eng'];
        $description = $_POST['description'];
        $sort_order = $topic['sort_order'];
    }
}
