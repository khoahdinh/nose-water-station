<?php

function validatePost($post)
{

    $errors = array();

    if (empty($post['title'])) {
        array_push($errors, 'Title is required');
    }

    if (empty($post['body'])) {
        array_push($errors, 'Body is required');
    }

    if (empty($post['preview'])) {
        array_push($errors, 'Preview is required');
    }


    if (empty($post['title_eng'])) {
        array_push($errors, 'Title English is required');
    }

    if (empty($post['body_eng'])) {
        array_push($errors, 'Body English is required');
    }

    if (empty($post['preview_eng'])) {
        array_push($errors, 'Preview English is required');
    }

    if (empty($post['slug'])) {
        array_push($errors, 'Slug is required');
    }

    if (empty($post['topic_id'])) {
        array_push($errors, 'Please select a topic');
    }


    // Kiểm tra tiêu đề chính `title`
    $existingPostByTitle = selectOne('posts', ['title' => $post['title']]);
    if ($existingPostByTitle) {
        if (isset($post['update-post']) && $existingPostByTitle['id'] != $post['id']) {
            array_push($errors, 'Post with that title already exists');
        }
        if (isset($post['add-post'])) {
            array_push($errors, 'Post with that title already exists');
        }
    }

    // Kiểm tra tiêu đề tiếng Anh `title_eng`
    $existingPostByTitleEng = selectOne('posts', ['title_eng' => $post['title_eng']]);
    if ($existingPostByTitleEng) {
        if (isset($post['update-post']) && $existingPostByTitleEng['id'] != $post['id']) {
            array_push($errors, 'Post with that English title already exists');
        }
        if (isset($post['add-post'])) {
            array_push($errors, 'Post with that English title already exists');
        }
    }

    return $errors;
}
