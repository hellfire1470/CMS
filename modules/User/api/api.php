<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function apiLogin($params) {
    if (GetUser() && GetUser()->IsLoggedIn()) {
        return ['success' => true, 'data' => ['message' => 'Already Logged in']];
    }

    $res = ['success' => false, 'data' => ['message' => 'Login failed']];
    if (empty($params['email']) || empty($params['password'])) {
        $res['data']['message'] = 'Some fields are empty';
        return $res;
    }

    $success        = Login($params['email'], $params['password']);
    $res['success'] = $success;

    if ($success) {
        $res['data']['message'] = 'Logged in as ' . GetUser()->GetFirstname();
        $res['data']['user']    = _GetPublicUserData();
    }
    return $res;
}

function apiLogout() {
    unset($_SESSION['user']);
    global $_USER;
    unset($_USER);
    return ['success' => true];
}
