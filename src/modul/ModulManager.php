<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModuleManager
 *
 * @author Alexander
 */
require_once __DIR__ . '/Modul.php';

class ModulManager {

    private static $_registeredModules       = array();
    private static $_registeredModulesByName = [];
    private static $_shortcuts               = [];

    public static function IsModulRegistered($name) {
        return !empty(self::$_registeredModulesByName[$name]);
    }

    public static function IsModulEnabled($name) {
        if (self::IsModulRegistered($name)) {
            return self::$_registeredModulesByName[$name]->IsEnabled();
        }
        return false;
    }

    public static function RegisterModul($modul) {
        if ($modul instanceof Modul) {
            array_push(self::$_registeredModules, $modul);
            self::$_registeredModulesByName[$modul->GetName()] = $modul;
        }
    }

    public static function LoadModules() {
        foreach (self::$_registeredModules as $module) {
            $module->Load();
        }
    }

    public static function GetRegisteredModules() {
        return self::$_registeredModules;
    }

    public static function ShowModul($name) {
        return !empty(self::$_registeredModulesByName[$name]) ? self::$_registeredModulesByName[$name]->Show() : '';
    }

    public static function RegisterShortcut($shortcut, $modul, $func, ...$params) {
        if (!$modul instanceof Modul) {
            throw new \Exception("given second parameter is not TypeOf Modul");
        }
        if (!self::IsModulEnabled($modul->GetName())) {
            self::$_shortcuts[$shortcut] = '';
            return;
        }
        if (ModulManager::IsModulRegistered($modul->GetName())) {
            self::$_shortcuts[$shortcut] = [$modul, $func, $params];
        }
        return;
    }

    public static function ParseForShortcuts($content) {
        foreach (self::$_shortcuts as $shortcut => $arr) {

            $modul_content = '';
            if (!empty($arr)) {
                ob_start();
                call_user_func([$arr[0], $arr[1]], ...$arr[2]);
                $modul_content = ob_get_contents();
                ob_end_clean();
            }
            $content = str_replace($shortcut, $modul_content, $content);
        }
        return $content;
    }

}
