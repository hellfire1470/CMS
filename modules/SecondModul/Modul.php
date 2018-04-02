<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modul
 *
 * @author Alexander
 */
class SecondMod extends Modul {

    public function __construct($name, $version = 1.0, $descr = '', $author = '') {
        parent::__construct($name, $version, $descr, $author);
    }

    //put your code here
    public function OnShow() {
        echo "Hello World";
    }

}

$modul = new SecondMod('Second Modul');
ModulManager::RegisterModul($modul);

ModulManager::RegisterShortcut('%MYSECONDMODUL%', $modul, 'OnShow', 'here is your parameter');
