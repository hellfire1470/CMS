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
use K3ksPHP\Database as Db;

class DbUser {

    private static $_db          = null;
    private static $_db_meta     = null;
    private static $_initialized = false;

    public static function Initialize() {
        if (!self::$_initialized) {
            self::$_initialized = true;
            self::$_db          = new Db\Table("users", [
                new Db\Field('id', Db\FieldType::INTEGER, 11, [Db\FieldAttribute::AUTO_INCREMENT, Db\FieldAttribute::PRIMARY_KEY]),
                new Db\Field('firstname', Db\FieldType::VARCHAR, 200),
                new Db\Field('lastname', Db\FieldType::VARCHAR, 200),
                new Db\Field('password', Db\FieldType::VARCHAR, 512),
                new Db\Field('email', Db\FieldType::VARCHAR, 200, [Db\FieldAttribute::UNIQUE, Db\FieldAttribute::NOT_NULL])
            ]);
            self::$_db_meta     = new Db\Table("users_meta", [
                new Db\Field('id', Db\FieldType::INTEGER, 11, [Db\FieldAttribute::AUTO_INCREMENT, Db\FieldAttribute::PRIMARY_KEY]),
                new Db\Field('userid', Db\FieldType::INTEGER, 11, [Db\FieldAttribute::NOT_NULL]),
                new Db\Field('metakey', Db\FieldType::VARCHAR, 255, [Db\FieldAttribute::NOT_NULL]),
                new Db\Field('metavalue', Db\FieldType::TEXT),
                new Db\Rule(Db\RuleType::UNIQUE, ['userid', 'metakey'])
            ]);
        }
    }

    public static function GetUserTable() {
        return self::$_db;
    }

    public static function GetUserMetaTable() {
        return self::$_db_meta;
    }

    public static function Set($key_values) {
        if (!self::$_initialized) {
            self::Initialize();
        }

        return self::$_db->Set($key_values);
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
        return self::Set($kv);
    }

    public static function GetByEmail($email) {
        if (!self::$_initialized) {
            self::Initialize();
        }
        $result = self::$_db->LoadAllByColumn('email', $email);
        return !empty($result) ? $result[0] : null;
    }

}
