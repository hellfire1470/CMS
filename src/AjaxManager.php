<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AjaxManager {

    private static $_ajax_events = [];

    public static function RegisterEvent($action, $obj_or_method, $method = null) {
        if (is_callable($obj_or_method)) {
            self::$_ajax_events[$action] = $obj_or_method;
            return true;
        } else {
            self::$_ajax_events[$action] = [$obj_or_method, $method];
        }
        return false;
    }

    public static function HandleEvents() {

        $error_reporting = error_reporting();
        error_reporting(0);

        if (empty($_POST)) {
            return;
        }

        $pAction = filter_input(INPUT_POST, 'action');

        foreach (self::$_ajax_events as $action => $event) {
            if ($pAction == $action) {
                echo json_encode(call_user_func($event, filter_input_array(INPUT_POST)));
                die();
            }
        }

        error_reporting($error_reporting);
    }

}
