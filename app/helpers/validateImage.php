<?php

function validateImage($post ,$file)
{

    $errors = array();

    if (empty($post['author'])) {
        array_push($errors, 'Author is required');
    }

    if (empty($post['date'])) {
        array_push($errors, 'Date is required');
    }

    if (empty($post['caption'])) {
        array_push($errors, 'Please write some caption');
    }

    if (empty($post['caption_eng'])) {
        array_push($errors, 'Please write some caption in English');
    }

    // if (empty($file['image']['name'])) {
    //     array_push($errors, 'Please choose image file');
    // }
    return $errors;
}

?>
