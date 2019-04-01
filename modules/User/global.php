<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$_USER = unserialize($_SESSION['user']);

function GetUser() {
    global $_USER;
    return $_USER;
}

function Login($email, $password) {
    $user = DbUser::GetByEmail($email);
    if (empty($user)) {
        return false;
    }
    $hash = hash('sha512', $password);
    if ($hash == $user->GetAttr('password')) {
        $USER             = new User($user);
        $_SESSION['user'] = serialize($USER);
        global $_USER;
        $_USER            = $USER;
        return true;
    }
    return false;
}

function _GetPublicUserData() {
    if (empty(GetUser()) || !GetUser()->IsLoggedIn()) {
        return [];
    }
    return [
        'firstname' => GetUser()->GetFirstname(),
        'lastname'  => GetUser()->GetLastname(),
        'email'     => GetUser()->GetEmail()
    ];
}
