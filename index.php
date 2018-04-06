<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

require_once 'config.php';
require_once '../K3ksPHP/Database/Db.php';
require_once __DIR__ . '/src/database/DBConfig.php';
require_once __DIR__ . '/src/modul/ModulManager.php';
require_once __DIR__ . '/src/AjaxManager.php';

/*
 * Register Modules
 */

$dirs = array_filter(glob('modules/*'), 'is_dir');
foreach ($dirs as $dir) {
    $path = __DIR__ . '/' . $dir . '/Modul.php';
    if (file_exists($path)) {
        require_once $path;
    }
}

// TODO: CURRENT PATH MANAGER

ModulManager::LoadModules();

AjaxManager::HandleEvents();

// LOAD Template
if (file_exists(__DIR__ . '/template/template.php')) {
    require_once __DIR__ . '/template/template.php';
}
