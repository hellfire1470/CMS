<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (ob_start()) {
    require_once 'header.php';
    require_once 'body.php';
    require_once 'footer.php';
}
$content = ob_get_contents();
ob_end_clean();
echo ModulManager::ParseForShortcuts($content);
