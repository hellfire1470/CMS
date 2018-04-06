<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modul
 *
 * @author Alexander
 */
require_once __DIR__ . '/DbUser.php';

class ProfileModul extends Modul {

    private static $_user;
    private $_show_form = 'login';

    public static function CreateUser($firstname, $lastname, $password, $email) {
        DbUser::SetAll($firstname, $lastname, $password, $email);
    }

    public function Login($email, $password) {
        $user = DbUser::GetByEmail($email);
        if (empty($user)) {
            return false;
        }
        $hash = hash('sha512', $password);
        if ($hash == $user->GetAttr('password')) {
            $_SESSION['user'] = serialize($user);
            self::$_user      = $user;
            return true;
        }
        return false;
    }

    public static function IsLoggedIn() {
        return !empty($_SESSION['user']);
    }

    public static function GetUser() {
        return self::$_user;
    }

    public function OnLoad() {
        if (self::IsLoggedIn()) {
            self::$_user = unserialize($_SESSION['user']);
        }
        return true;
    }

    //put your code here
    public function ShowAside() {
        ?>
        <div id="profile-modul-aside">
            <script>
                function profile_modul_load_aside() {
                    $('#profile-modul-aside').empty();
                    $.ajax('', {
                        method: 'post',
                        data: {action: 'profile-modul-load-aside'},
                        success: function (msg) {
                            if (msg.length > 0) {
                                try {
                                    var msg = JSON.parse(msg);
                                    $('#profile-modul-aside').append(msg.data.html);
                                } catch (e) {

                                }
                            }
                        }
                    })
                }
                profile_modul_load_aside();
            </script>
        </div>
        <?php
    }

    public function ajax_login($params) {
        if ($this->IsLoggedIn()) {
            return ['success' => true, 'data' => ['message' => 'Already Logged in']];
        }
        
        
        $res = ['success' => false, 'data' => ['message' => 'Login failed']];
        
        if (empty($params['form-profile-login-email']) || empty($params['form-profile-login-password'])) {
            $res['data']['message'] = 'Some fields are empty';
            return $res;
        }

        
        $success        = $this->Login($params['form-profile-login-email'], $params['form-profile-login-password']);
        $res['success'] = $success;

        if ($success) {
            $res['data']['message'] = 'Logged in as ' . self::$_user->GetAttr('firstname');
        }
        return $res;
    }

    public function ajax_logout() {
        unset($_SESSION['user']);
        return ['success' => true];
    }
    
    private function _SetActiveForm(){
        if($this->IsLoggedIn()){
            $this->_show_form = 'profile';
        } else {
            $this->_show_form = 'login';
        }
    }

    public function ajax_load_aside($param) {
        $res                 = ['success' => true, 'data' => ['html' => '']];
        
        $this->_SetActiveForm();
        
        ob_start();
        require __DIR__ . '/template/aside/profile_aside.php';
        $aside               = ob_get_contents();
        ob_end_clean();
        $res['data']['html'] = $aside;
        return $res;
    }

}

$modul = new ProfileModul("ProfileModul");
ModulManager::RegisterModul($modul);
$modul->Install();
$modul->Enable();

ModulManager::RegisterShortcut('%USERPROFILE_ASIDE%', $modul, 'ShowAside');
AjaxManager::RegisterEvent('profile-modul-login', $modul, 'ajax_login');
AjaxManager::RegisterEvent('profile-modul-logout', $modul, 'ajax_logout');
AjaxManager::RegisterEvent('profile-modul-register', $modul, 'ajax_register');
AjaxManager::RegisterEvent('profile-modul-load-aside', $modul, 'ajax_load_aside');