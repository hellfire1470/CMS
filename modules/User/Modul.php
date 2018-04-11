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

class UserModul extends Modul {

    private static $_user;
    public static $modul_prefix = 'user-modul-';
    private $_show_form         = 'login';

    public static function CreateUser($firstname, $lastname, $password, $email) {
        return DbUser::SetAll($firstname, $lastname, $password, $email);
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
        add_header('<script type="text/javascript" src="modules/User/js/user-modul.js"></script>');
        $this->_SetActiveLayout();
        return true;
    }

    //put your code here
    public function ShowAside() {
        ?>
        <div id="user-modul-aside"></div>


        <script>
            UserModul.init('user-modul-aside');
            UserModul.LoadAside();
            UserModul.AddListener('onlogin', function (user) {
                alert('Logged in as ' + user.firstname, 'success');
                UserModul.LoadAside('profile');
            });
            UserModul.AddListener('onlogout', function () {
                alert('Logged out', 'success');
                UserModul.LoadAside();
            });
        </script>
        <?php
    }

    public static function GetNavigationForm($navigateTo, $btnVal) {
        ?>
        <button class="btn btn-secondary" onclick="UserModul.LoadAside('<?php echo $navigateTo; ?>');
                return false;"><?php echo $btnVal; ?></button>
        <?php
    }

    private function _GetPublicUserData() {
        if (!$this->IsLoggedIn()) {
            return [];
        }
        return [
            'firstname' => self::$_user->GetAttr('firstname'),
            'lastname'  => self::$_user->GetAttr('lastname'),
            'email'     => self::$_user->GetAttr('email')
        ];
    }

    public function ajax_login($params) {
        if ($this->IsLoggedIn()) {
            return ['success' => true, 'data' => ['message' => 'Already Logged in']];
        }


        $res = ['success' => false, 'data' => ['message' => 'Login failed']];

        if (empty($params['email']) || empty($params['password'])) {
            $res['data']['message'] = 'Some fields are empty';
            return $res;
        }


        $success        = $this->Login($params['email'], $params['password']);
        $res['success'] = $success;

        if ($success) {
            $res['data']['message'] = 'Logged in as ' . self::$_user->GetAttr('firstname');
            $res['data']['user']    = $this->_GetPublicUserData();
        }
        return $res;
    }

    public function ajax_logout() {
        unset($_SESSION['user']);
        return ['success' => true];
    }

    private function _GetLayout() {
        ob_start();
        require __DIR__ . '/template/aside/profile_aside.php';
        $layout = ob_get_contents();
        ob_end_clean();
        return $layout;
    }

    private function _SetActiveLayout($layout = null) {
        if (!empty($layout)) {
            //todo: add protection
            $this->_show_form = $layout;
            return;
        }
        $this->_show_form = 'login';

        if ($this->IsLoggedIn()) {
            $this->_show_form = 'profile';
        }
    }

    public function ajax_load_aside($params) {
        if (!empty($params['layout'])) {
            $this->_SetActiveLayout($params['layout']);
        }

        $res = ['success' => true, 'data' => ['html' => '']];

        $res['data']['html'] = $this->_GetLayout();

        return $res;
    }

    public function ajax_register($params) {
        $preKey = 'form-user-register-';

        $res = ['success' => false, 'data' => ['message' => '']];

        $firstname = $params[$preKey . 'firstname'];
        $lastname  = $params[$preKey . 'lastname'];
        $email     = $params[$preKey . 'email'];
        $pass1     = $params[$preKey . 'password'];
        $pass2     = $params[$preKey . 'password2'];

        if (empty($firstname) ||
                empty($lastname) ||
                empty($email) ||
                empty($pass1) ||
                empty($pass2)) {
            $res['data']['message'] = "Eines der Felder is Leer";
            return $res;
        }

        if ($pass1 == $pass2) {
            $success        = UserModul::CreateUser($firstname, $lastname, $pass1, $email);
            $res['success'] = $success;
            if ($success) {
                $res['data']['message'] = 'Benutzer wurde erstellt';
            } else {
                $res['data']['message'] = 'E-Mail ist bereits vergeben';
            }
        } else {
            $res['data']['message'] = 'Passwörter stimmen nicht überein';
        }

        return $res;
    }

    public function ajax_get_user_data() {
        $res = ['success' => true, 'data' => ['user' => $this->_GetPublicUserData()]];
        return $res;
    }

}

$modul = new UserModul("UserModul");
ModulManager::RegisterModul($modul);

ModulManager::RegisterShortcut('%USERPROFILE_ASIDE%', $modul, 'ShowAside');
AjaxManager::RegisterEvent(UserModul::$modul_prefix . 'login', $modul, 'ajax_login');
AjaxManager::RegisterEvent(UserModul::$modul_prefix . 'logout', $modul, 'ajax_logout');
AjaxManager::RegisterEvent(UserModul::$modul_prefix . 'register', $modul, 'ajax_register');
AjaxManager::RegisterEvent(UserModul::$modul_prefix . 'load-aside', $modul, 'ajax_load_aside');
AjaxManager::RegisterEvent(UserModul::$modul_prefix . 'get-user-data', $modul, 'ajax_get_user_data');
