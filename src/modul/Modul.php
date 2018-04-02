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
abstract class Modul {

    private $_id;
    private $_name;
    private $_version;
    private $_description;
    private $_author;
    private $_isLoaded    = false;
    private $_isInstalled = false;
    private $_isEnabled   = false;
    private $_isShown     = false;
    private $_content     = '';

    public function __construct($name, $version = 1.0, $description = '', $author = '') {
        $this->_name        = $name;
        $this->_version     = $version;
        $this->_description = $description;
        $this->_author      = $author;

        $this->_isInstalled = empty($this->_GetSetting('installed')) ? false : true;
        $this->_isEnabled   = empty($this->_GetSetting('enabled')) ? false : true;
    }

    public function GetName() {
        return $this->_name;
    }

    public function Enable() {
        if (!$this->_isEnabled && $this->OnEnable()) {
            $this->_isEnabled = true;
            $this->_WriteAllSettings();
        }
    }

    public function IsEnabled() {
        return $this->_isEnabled;
    }

    public function Disable() {
        if ($this->_isEnabled && $this->OnDisable()) {
            $this->_isEnabled = false;
            $this->_WriteAllSettings();
        }
    }

    public function Install() {
        if (!$this->_isInstalled && $this->OnInstall()) {
            $this->_isInstalled = true;
            $this->_WriteAllSettings();
        }
    }

    public function Uninstall() {
        if ($this->_isInstalled && $this->OnUninstall()) {
            $this->_isInstalled = false;
            $this->_WriteAllSettings();
        }
    }

    public function Load() {
        if ($this->_isInstalled && $this->_isEnabled && !$this->_isLoaded && $this->OnLoad()) {
            $this->_isLoaded = true;
        }
    }

    public function IsLoaded() {
        return $this->_isLoaded;
    }

    public function Show() {
        if ($this->_isLoaded && !$this->_isShown) {
            $this->_isShown = true;
            $ob             = ob_start();
            if ($ob) {
                $this->OnShow();
            }
            $this->_content = ob_get_contents();
            ob_end_clean();
        }
        return $this->_content;
    }

    public function _WriteAllSettings() {
        $this->_WriteSetting('installed', $this->_isInstalled);
        $this->_WriteSetting('enabled', $this->_isEnabled);
    }

    private function _WriteSetting($key, $value) {
        DBConfig::Set($this->_GetModulIdentifier() . ":" . $key, $value);
    }

    private function _GetSetting($key) {
        return DBConfig::Get($this->_GetModulIdentifier() . ":" . $key);
    }

    private function _GetId() {
        return str_replace(' ', '_', $this->_name);
    }

    private function _GetModulIdentifier() {
        return 'setting_modul_' . $this->_GetId();
    }

// <editor-fold defaultstate="collapsed">

    protected function OnInstall() {
        return true;
    }

    protected function OnUninstall() {
        return true;
    }

    protected function OnLoad() {
        return true;
    }

    protected function OnUnload() {
        return true;
    }

    protected function OnShow() {

    }

    protected function OnEnable() {
        return true;
    }

    protected function OnDisable() {
        return true;
    }

    protected function OnAdmin() {

    }

// </editor-fold>
}
