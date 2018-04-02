<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Alexander
 */
interface IModul {

    //put your code here
    function OnInstall();

    function OnUninstall();

    function OnLoad();

    function OnUnload();

    function OnShow();

    function OnAdmin();

    function OnEnable();

    function OnDisable();
}
