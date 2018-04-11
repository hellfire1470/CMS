<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TemplateManager
 *
 * @author Alexander
 */
class LayoutManager {

    //put your code here
    private static $_layers = [];

    public static function AddToLayer($layer, $html) {
        if (!array_key_exists($layer, self::$_layers)) {
            self::$_layers[$layer] = [];
        }
        self::$_layers[$layer][] = $html;
    }

    public static function GetAllContent($layer) {
        if (!array_key_exists($layer, self::$_layers)) {
            return '';
        }
        return join('', self::$_layers[$layer]);
    }

    public static function GetAllHeaderContent() {
        return self::GetAllContent('header');
    }

}
