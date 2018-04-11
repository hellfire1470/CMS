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
use K3ksPHP\Database as Db;

class DBConfig {

    private static $_db          = null;
    private static $_initialized = false;

    private static function _Initialize() {
        if (!self::$_initialized) {
            self::$_initialized = true;
            self::$_db          = new Db\Table("config", [
                new Db\Field('id', Db\FieldType::INTEGER, 11, [Db\FieldAttribute::AUTO_INCREMENT, Db\FieldAttribute::PRIMARY_KEY]),
                new Db\Field('ckey', Db\FieldType::VARCHAR, 200, [Db\FieldAttribute::UNIQUE]),
                new Db\Field('cvalue', Db\FieldType::TEXT)
            ]);

            self::$_db->Create();
        }
    }

    public static function Set($key, $value) {
        if (!self::$_initialized) {
            self::_Initialize();
        }

        self::$_db->Set([new Db\KeyValue('ckey', $key), new Db\KeyValue('cvalue', $value)], true);
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
