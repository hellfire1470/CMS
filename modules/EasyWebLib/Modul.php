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
class EasyWebLibModul extends Modul {

    private $_jquery_active;
    private $_bootstrap_js_active;
    private $_bootstrap_css_active;
    private $_notify_active;
    private $_notify_override_alert;

    public function __construct($name, $version = 1.0, $descr = '', $author = '') {
        parent::__construct($name, $version, $descr, $author);
        $this->_jquery_active         = $this->GetData('jquery-active');
        $this->_bootstrap_js_active   = $this->GetData('bootstrap-js-active');
        $this->_bootstrap_css_active  = $this->GetData('bootstrap-css-active');
        $this->_notify_active         = $this->GetData('notify-active');
        $this->_notify_override_alert = $this->GetData('notify-override-alert');
    }

    public function OnLoad() {
        return true;
    }

    public function OnAdmin() {
        ?>
        <form method="post" id="EasyWebLib-admin-settings">
            <div class="card">
                <div class="card-header"> Bootstrap </div>
                <div class="card-body">

                    <div class="checkbox">
                        <label for="EasyWebLib-bootstrap-css-active">
                            <input type="checkbox" name="EasyWebLib-bootstrap-css-active" id="EasyWebLib-bootstrap-css-active" <?php echo $this->_bootstrap_css_active ? 'checked' : '' ?>/>
                            Use Bootstrap CSS
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="EasyWebLib-bootstrap-js-active">
                            <input type="checkbox" name="EasyWebLib-bootstrap-js-active" id="EasyWebLib-bootstrap-js-active" <?php echo $this->_bootstrap_js_active ? 'checked' : '' ?>/>
                            Use Bootstrap.js
                        </label>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header"> jQuery.js </div>
                <div class="card-body">
                    <div class="checkbox">
                        <label for="EasyWebLib-jquery-active">
                            <input type="checkbox" name="EasyWebLib-jquery-active" id="EasyWebLib-jquery-active" <?php echo $this->_jquery_active ? 'checked' : '' ?>/>
                            Use jQuery.js
                        </label>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header"> Notify.js </div>
                <div class="card-body">
                    <div class="checkbox">
                        <label for="EasyWebLib-notify-active">
                            <input type="checkbox" name="EasyWebLib-notify-active" id="EasyWebLib-notify-active" <?php echo $this->_notify_active ? 'checked' : '' ?>/>
                            Use Notify.js
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="EasyWebLib-notify-override-alert">
                            <input type="checkbox" name="EasyWebLib-notify-override-alert" id="EasyWebLib-notify-override-alert" <?php echo $this->_notify_override_alert ? 'checked' : '' ?>/>
                            Override alert with Notify
                        </label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Speichern</button>
            <script>
                function ajax_request(action, formid, callback) {
                    $('#' + formid).on('submit', function (e) {
                        e.preventDefault();
                        $.ajax({
                            type: 'post',
                            url: '',
                            data: 'action=' + action + '&' + $(this).serialize(),
                            success: function (msg) {
                                callback(JSON.parse(msg));
                            }
                        })
                    })
                }

                ajax_request('EasyWebLibModul-ajax-save-admin', 'EasyWebLib-admin-settings', function (msg) {
                    alert(msg.data.message);
                })
            </script>
        </form>
        <?php
    }

    //put your code here
    public function OnShow() {

    }

    public function ShowJS() {
        ?>
        <?php if ($this->_jquery_active) : ?>
            <script src="/modules/EasyWebLib/js/jquery-3.3.1.min.js"></script>
        <?php endif; ?>
        <?php if ($this->_notify_active) : ?>
            <script src="/modules/EasyWebLib/js/notify.min.js"></script>
        <?php endif; ?>
        <?php if ($this->_notify_override_alert) : ?>
            <script>
                function alert(msg, status) {
                    if (status == undefined) {
                        status = "info";
                    }
                    $.notify(msg, status);
                }
            </script>
        <?php endif; ?>
        <?php if ($this->_bootstrap_js_active) : ?>
            <script src="/modules/EasyWebLib/js/bootstrap.js"></script>
            <?php
        endif;
    }

    public function ShowCSS() {
        ?>
        <?php if ($this->_bootstrap_css_active) : ?>
            <link rel="stylesheet" type="text/css" href="/modules/EasyWebLib/css/bootstrap-grid.css">
            <link rel="stylesheet" type="text/css" href="/modules/EasyWebLib/css/bootstrap-reboot.css">
            <link rel="stylesheet" type="text/css" href="/modules/EasyWebLib/css/bootstrap.css">
            <?php
        endif;
    }

    public function ajax_save_admin($params) {
        $msg = ['success' => true, 'data' => []];

        $bootstrap_css_active  = !empty($params['EasyWebLib-bootstrap-css-active']) ? true : false;
        $bootstrap_js_active   = !empty($params['EasyWebLib-bootstrap-js-active']) ? true : false;
        $jquery_active         = !empty($params['EasyWebLib-jquery-active']) ? true : false;
        $notify_active         = !empty($params['EasyWebLib-notify-active']) ? true : false;
        $notify_override_alert = !empty($params['EasyWebLib-notify-override-alert']) ? true : false;

        if ($this->_bootstrap_css_active != $bootstrap_css_active) {
            $this->SetData('bootstrap-css-active', $bootstrap_css_active);
        }

        if ($this->_bootstrap_js_active != $bootstrap_js_active) {
            $this->SetData('bootstrap-js-active', $bootstrap_js_active);
        }

        if ($this->_jquery_active != $jquery_active) {
            $this->SetData('jquery-active', $jquery_active);
        }

        if ($this->_notify_active != $notify_active) {
            $this->SetData('notify-active', $notify_active);
        }

        if ($this->_notify_active != $notify_active || $this->_notify_override_alert != $notify_override_alert) {
            $this->SetData('notify-override-alert', ($notify_active && $notify_override_alert));
        }
        $msg['data']['message'] = "Einstellungen übernommen";
        return $msg;
    }

}

$modul = new EasyWebLibModul('EasyWebLibModul', 0.1, "Compilation for the most used JS/CSS Libraries", 'Alexander');
ModulManager::RegisterModul($modul);
ModulManager::RegisterShortcut('%EASYWEBLIBJS%', $modul, 'ShowJS');
ModulManager::RegisterShortcut('%EASYWEBLIBCSS%', $modul, 'ShowCSS');
ModulManager::RegisterShortcut('%EASYWEBLIBADMIN%', $modul, 'OnAdmin');
// Register All Ajax Requersts
AjaxManager::RegisterEvent('EasyWebLibModul-ajax-save-admin', $modul, 'ajax_save_admin');
