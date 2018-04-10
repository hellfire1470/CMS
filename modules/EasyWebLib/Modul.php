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

    private $_settings = [
        'jquery-active'         => '',
        'bootstrap-js-active'   => '',
        'bootstrap-css-active'  => '',
        'notify-active'         => '',
        'notify-override-alert' => '',
        'angular-active'        => '',
        'vue-active'            => ''
    ];

    public function __construct($name, $version = 1.0, $descr = '', $author = '') {
        parent::__construct($name, $version, $descr, $author);
        foreach ($this->_settings as $key => $_value) {
            $this->_settings[$key] = $this->GetData($key);
        }
    }

    public function OnLoad() {
        return true;
    }

    private function GenerateCheckbox($id, $text) {
        ?>
        <div class="checkbox">
            <label for="EasyWebLib-<?php echo $id; ?>">
                <input type="checkbox" name="EasyWebLib-<?php echo $id; ?>" id="EasyWebLib-<?php echo $id; ?>" <?php echo $this->_settings[$id] ? 'checked' : '' ?>/>
                <?php echo $text; ?>
            </label>
        </div>
        <?php
    }

    private function GenerateInput($id, $type, $text, $placeholder = null) {
        ?>
        <div class="checkbox">
            <label for="EasyWebLib-<?php echo $id; ?>"><?php echo $text; ?> </label>
            <input type="<?php echo $type; ?>" name="EasyWebLib-<?php echo $id; ?>" id="EasyWebLib-<?php echo $id; ?>" value="<?php echo $this->_settings[$id]; ?>" />

        </div>
        <?php
    }

    public function OnAdmin() {
        ?>
        <form method="post" id="EasyWebLib-admin-settings">
            <div class="card">
                <div class="card-header"> Bootstrap </div>
                <div class="card-body">
                    <?php $this->GenerateCheckbox('bootstrap-css-active', 'Use Bootstrap CSS') ?>
                    <?php $this->GenerateCheckbox('bootstrap-js-active', 'Use Bootstrap JS') ?>
                </div>
            </div>
            <div class="card">
                <div class="card-header"> jQuery.js </div>
                <div class="card-body">
                    <?php $this->GenerateCheckbox('jquery-active', 'Use jQuery') ?>
                </div>
            </div>
            <div class="card">
                <div class="card-header"> Notify.js </div>
                <div class="card-body">

                    <?php $this->GenerateCheckbox('notify-active', 'Use Notify.js') ?>
                    <?php $this->GenerateCheckbox('notify-override-alert', 'Override alert message with Notify') ?>

                </div>
            </div>
            <div class="card">
                <div class="card-header"> Angular.js </div>
                <div class="card-body">
                    <?php $this->GenerateCheckbox('angular-active', 'Use Angular.js') ?>
                </div>
            </div>
            <div class="card">
                <div class="card-header"> Vue.js </div>
                <div class="card-body">
                    <?php $this->GenerateCheckbox('vue-active', 'Use Vue.js') ?>
                </div>
            </div>
            <button type = "submit" class = "btn btn-primary">Speichern</button>
            <button type = "reset" class = "btn btn-secondary">Zurücksetzen</button>
            <script>
                var ajax = {
                    requests: [],
                    request: function (action, formid, callback, precall) {

                        this.requests[action] = function () {
                            $('#' + formid).on('submit', function (e) {

                                e.preventDefault();

                                if (precall !== undefined && !precall()) {
                                    return;
                                }

                                $.ajax({
                                    type: 'post',
                                    url: '',
                                    data: 'action=' + action + '&' + $(this).serialize(),
                                    success: function (msg) {
                                        try {
                                            callback(JSON.parse(msg));
                                        } catch (e) {
                                            callback(msg, true);
                                        }
                                    }
                                });
                            });
                        }
                        this.requests[action]();
                    }
                }
                ajax.request('EasyWebLibModul-ajax-save-admin', 'EasyWebLib-admin-settings', function (msg) {
                    if (msg !== undefined) {
                        alert(msg.data.message);
                    }
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
        <?php if ($this->_settings['jquery-active']) : ?>
            <script src="/modules/EasyWebLib/js/jquery-3.3.1.min.js"></script>
        <?php endif; ?>
        <?php if ($this->_settings['notify-active']) : ?>
            <script src="/modules/EasyWebLib/js/notify.min.js"></script>
        <?php endif; ?>
        <?php if ($this->_settings['notify-override-alert']) : ?>
            <script>
                    function alert(msg, status) {
                        if (status === undefined) {
                            status = "info";
                        }
                        $.notify(msg, status);
                    }
            </script>
        <?php endif; ?>
        <?php if ($this->_settings['bootstrap-js-active']) : ?>
            <script src="/modules/EasyWebLib/js/bootstrap.js"></script>
        <?php endif; ?>
        <?php if ($this->_settings['vue-active']) : ?>
            <script src="/modules/EasyWebLib/js/vue.min.js"></script>
        <?php endif; ?>
        <?php if ($this->_settings['angular-active']) : ?>
            <script src="/modules/EasyWebLib/js/angular.min.js"></script>
            <?php
        endif;
    }

    public function ShowCSS() {
        ?>
        <?php if ($this->_settings['bootstrap-css-active']) : ?>
            <link rel="stylesheet" type="text/css" href="/modules/EasyWebLib/css/bootstrap-grid.css">
            <link rel="stylesheet" type="text/css" href="/modules/EasyWebLib/css/bootstrap-reboot.css">
            <link rel="stylesheet" type="text/css" href="/modules/EasyWebLib/css/bootstrap.css">
            <?php
        endif;
    }

    private function _SaveData($key, &$_orig, $change_to) {
        if ($_orig != $change_to) {
            $_orig = $change_to;
            $this->SetData($key, $change_to);
        }
    }

    public function ajax_save_admin($params) {
        $msg = ['success' => true, 'data' => []];

        foreach ($this->_settings as $key => $_value) {
            $val = $params['EasyWebLib-' . $key];
            $this->_SaveData($key, $_value, $val);
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
