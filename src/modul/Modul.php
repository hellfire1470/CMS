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

    private $_name;
    private $_version;
    private $_description;
    private $_author;
    private $_isLoaded     = false;
    private $_isInstalled  = false;
    private $_isEnabled    = false;
    private $_isShown      = false;
    private $_content      = '';
    private $_dependencies = [];

    public function __construct($name, $version = 1.0, $description = '', $author = '') {
        $this->_name        = $name;
        $this->_version     = $version;
        $this->_description = $description;
        $this->_author      = $author;

        $this->_isInstalled = empty($this->GetData('installed')) ? false : true;
        $this->_isEnabled   = empty($this->GetData('enabled')) ? false : true;
    }

    public function AddDependency($modulname) {
        if (!in_array($modulname, $this->_dependencies)) {
            $this->_dependencies[] = $modulname;
        }
    }

    public function AddDependencies($modulnames) {
        foreach ($modulnames as $modulname) {
            $this->AddDependency($modulname);
        }
    }

    public function GetName() {
        return $this->_name;
    }

    public function Enable() {
        if (!$this->_isEnabled && $this->OnEnable()) {
            $this->_isEnabled = true;
            $this->_WriteAllData();
        }
    }

    public function IsEnabled() {
        return $this->_isEnabled;
    }

    public function Disable() {
        if ($this->_isEnabled && $this->OnDisable()) {
            $this->_isEnabled = false;
            $this->_WriteAllData();
        }
    }

    public function Install() {
        if (!$this->_isInstalled && $this->OnInstall()) {
            $this->_isInstalled = true;
            $this->_WriteAllData();
        }
    }

    public function Uninstall() {
        if ($this->_isInstalled && $this->OnUninstall()) {
            $this->_isInstalled = false;
            $this->_WriteAllData();
        }
    }

    public function Load() {
        if ($this->_isInstalled && $this->_isEnabled && !$this->_isLoaded) {
            $load = true;
            foreach ($this->_dependencies as $dependency) {
                if (!ModulManager::IsModulRegistered($dependency) || !ModulManager::IsModulEnabled($dependency)) {
                    trigger_error('Modul ' . $this->_name . ' requires Modul ' . $dependency . ' to be registered and enabled');
                    $load = false;
                }
            }
            if (!$load) {
                return;
            }
            ob_start();
            $this->_isLoaded = $this->OnLoad();
            ob_end_clean();
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

    private function _WriteAlldata() {
        $this->SetData('installed', $this->_isInstalled);
        $this->SetData('enabled', $this->_isEnabled);
    }

    protected function SetData($key, $value) {
        if (empty($value)) {
            $value = '0';
        }
        DBConfig::Set($this->_GetModulIdentifier() . ":" . $key, $value);
    }

    protected function GetData($key) {
        return DBConfig::Get($this->_GetModulIdentifier() . ":" . $key);
    }

    private function _GetId() {
        return str_replace(' ', '_', $this->_name);
    }

    private function _GetModulIdentifier() {
        return 'data-modul-' . $this->_GetId();
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
