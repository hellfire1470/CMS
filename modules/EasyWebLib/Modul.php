<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Module
 *
 * @author Alexander
 */
class EasyWebLibModul extends Modul {

    public function __constructor($name, $version = 1.0, $descr = '', $author = '') {
        parent::__constructor($name, $version, $descr, $author);
    }

    public function OnLoad() {
        return true;
    }

    protected function OnAdmin() {
        ?>
        <div>
            <p> here is the admin panel </p>
        </div>
        <?php
    }

    //put your code here
    public function OnShow() {

    }

    public function ShowJS() {
        ?>
        <script src="/modules/EasyWebLib/js/jquery-3.3.1.min.js"></script>
        <script src="/modules/EasyWebLib/js/bootstrap.js"></script>
        <?php
    }

    public function ShowCSS() {
        ?>
        <link rel="stylesheet" type="text/css" href="/modules/EasyWebLib/css/bootstrap-grid.min.css">
        <link rel="stylesheet" type="text/css" href="/modules/EasyWebLib/css/bootstrap-reboot.min.css">
        <link rel="stylesheet" type="text/css" href="/modules/EasyWebLib/css/bootstrap.min.css">
        <?php
    }

}

$modul = new EasyWebLibModul('EasyWebLibModul', 0.1, "Compilation for the most used JS/CSS Libraries", 'Alexander');
ModulManager::RegisterModul($modul);
ModulManager::RegisterShortcut('%EASYWEBLIBJS%', $modul, 'ShowJS');
ModulManager::RegisterShortcut('%EASYWEBLIBCSS%', $modul, 'ShowCSS');
