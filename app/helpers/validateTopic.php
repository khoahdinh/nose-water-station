<?php

function validateTopic($topic)
{

    $errors = array();

    if (empty($topic['name'])) {
        array_push($errors, 'Topic name is required');
    }

    // $exittingTopic = selectOne('topics', ['name' => $topic['name']]);
    // if ($exittingTopic) {
    //     array_push($errors, 'Topic already exits');
    // }

    $exittingTopic = selectOne('topics', ['name' => $topic['name']]);
    if ($exittingTopic) {
        if (isset($topic['update-topic']) && $exittingTopic['id'] != $topic['id']) {
            array_push($errors, 'Name already exits');
        }
        if (isset($topic['add-topic'])) {
            array_push($errors, 'Name already exits');
        }
    }


    return $errors;
}


