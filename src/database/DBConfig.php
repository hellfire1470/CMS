<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBConfig
 *
 * @author Alexander
 */
require_once __DIR__ . '/IDB.php';

class DBConfig implements IDB {

    private static $_db          = null;
    private static $_initialized = false;

    private static function _Initialize() {
        if (!self::$_initialized) {
            self::$_initialized = true;
            self::$_db          = new K3ksPHP\Database\DBObj("config", "id", ["id", "ckey", "cvalue"]);
        }
    }

    public static function Set($key, $value) {
        if (self::$_db == null) {
            self::_Initialize();
        }

        self::$_db->Set(['ckey' => $key, 'cvalue' => $value]);
    }

    public static function Get($key) {
        if (self::$_db == null) {
            self::_Initialize();
        }
        $result = self::$_db->LoadAllByColumn('ckey', $key);

        if (sizeof($result) > 0) {
            $value = $result[0]->GetAttr('cvalue');
            return $value;
        }

        return null;
    }

}
