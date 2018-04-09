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
use K3ksPHP\Database\DbTable as DbT;
use K3ksPHP\Database\DbKeyValue as DbKV;
use K3ksPHP\Database\DbField as DbF;
use K3ksPHP\Database\DbFieldType as DbFT;
use K3ksPHP\Database\DbFieldAttribute as DbFA;

class DBConfig {

    private static $_db = null;
    private static $_initialized = false;

    private static function _Initialize() {
        if (!self::$_initialized) {
            self::$_initialized = true;
            self::$_db = new DbT("config", [
                new DbF('id', DbFT::INTEGER, 11, [DbFA::AUTO_INCREMENT, DbFA::PRIMARY_KEY]),
                new DbF('ckey', DbFT::VARCHAR, 200, [DbFA::UNIQUE]),
                new DbF('cvalue', DbFT::TEXT)
            ]);

            self::$_db->Create();
        }
    }

    public static function Set($key, $value) {
        if (!self::$_initialized) {
            self::_Initialize();
        }

        self::$_db->Set([new DbKV('ckey', $key), new DbKV('cvalue', $value)], true);
    }

    public static function Get($key) {
        if (!self::$_initialized) {
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
