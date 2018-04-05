<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DbUser
 *
 * @author Alexander
 */
use K3ksPHP\Database\DbTable as DbT;
use K3ksPHP\Database\DbField as DbF;
use K3ksPHP\Database\DbKeyValue as DbKV;
use K3ksPHP\Database\DbFieldType as DbFT;
use K3ksPHP\Database\DbFieldAttribute as DbFA;

class DbUser {

    private static $_db          = null;
    private static $_initialized = false;

    private static function _Initialize() {
        if (!self::$_initialized) {
            self::$_initialized = true;
            self::$_db          = new DbT("users", [
                new DbF('id', DbFT::INTEGER, 11, [DbFA::AUTO_INCREMENT, DbFA::PRIMARY_KEY]),
                new DbF('firstname', DbFT::VARCHAR, 200),
                new DbF('lastname', DbFT::VARCHAR, 200),
                new DbF('password', DbFT::VARCHAR, 512),
                new DbF('email', DbFT::VARCHAR, 200, [DbFA::UNIQUE, DbFA::NOT_NULL])
            ]);

            self::$_db->Create();
        }
    }

    public static function Set($key_values) {
        if (!self::$_initialized) {
            self::_Initialize();
        }

        self::$_db->Set($key_values);
    }

    public static function SetAll($firstname, $lastname, $password, $email, $id = null) {
        $kv = [];
        if ($id != null) {
            $kv[] = new DbKV('id', $id);
        }
        $kv[] = new DbKV('firstname', $firstname);
        $kv[] = new DbKV('lastname', $lastname);
        $kv[] = new DbKV('password', hash('sha512', $password));
        $kv[] = new DbKV('email', $email);
        self::Set($kv);
    }

    public static function GetByEmail($email) {
        if (!self::$_initialized) {
            self::_Initialize();
        }
        $result = self::$_db->LoadAllByColumn('email', $email);
        return !empty($result) ? $result[0] : null;
    }

}
