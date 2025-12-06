<?php
function validateUser($user)
{

    $errors = array();

    if (empty($user['username'])) {
        array_push($errors, 'Username is required');
    }

    if (empty($user['email'])) {
        array_push($errors, 'Email is required');
    }

    if (empty($user['password'])) {
        array_push($errors, 'Password is required');
    }

    if (empty($user['passwordConf'])) {
        array_push($errors, 'Password Confirmation is required');
    }

    if ($user['password'] !== $user['passwordConf']) {
        array_push($errors, 'Password do not match');
    }

    $existingUser = selectOne('users', ['email' => $user['email']]);
    if ($existingUser) {
        if (($user['action'] === 'update' && $existingUser['id'] != $user['id']) ||
            $user['action'] === 'create' || $user['action'] === 'register') {
            array_push($errors, 'Email already exists');
        }
    }
    return $errors;
}

function validateLogin($user)
{

    $errors = array();

    if (empty($user['username'])) {
        array_push($errors, 'Username is required');
    }

    if (empty($user['password'])) {
        array_push($errors, 'Password is required');
    }

    return $errors;
}
