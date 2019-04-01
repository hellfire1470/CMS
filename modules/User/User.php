<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User {

    private $dbUser = null;

    function __construct($dbUser) {
        $this->dbUser = $dbUser;
    }

    function GetFirstname() {
        return $this->IsLoggedIn() ? $this->dbUser->GetAttr('firstname') : null;
    }

    function GetLastname() {
        return $this->IsLoggedIn() ? $this->dbUser->GetAttr('lastname') : null;
    }

    function GetFullName() {
        return $this->GetFirstname() . " " . $this->GetLastname();
    }

    function GetId() {
        return $this->IsLoggedIn() ? $this->dbUser->GetAttr('id') : null;
    }

    function GetEmail() {
        return $this->IsLoggedIn() ? $this->dbUser->GetAttr('email') : null;
    }

    function IsLoggedIn() {
        return $this->dbUser != null;
    }

}
