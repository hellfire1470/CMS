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
class SecondMod extends Modul {

    public function __construct($name, $version = 1.0, $descr = '', $author = '') {
        parent::__construct($name, $version, $descr, $author);
    }

    public function OnLoad() {

        return true;
    }

    //put your code here
    public function OnShow() {
        ?>
        <div id="myfirstmodul-container">Hier kann Ihre Werbung stehen</div>
        <script>
            function secondmodul_user_changed(user) {
                if (user !== undefined) {
                    $('#myfirstmodul-container').html('Hier kann Ihre Werbung stehen, ' + user.firstname);
                } else {
                    $('#myfirstmodul-container').html('Hier kann Ihre Werbung stehen');
                }
            }

            UserModul.AddListener('onuserchanged', secondmodul_user_changed);
        </script>
        <?php
    }

}

$modul = new SecondMod('Second Modul');
ModulManager::RegisterModul($modul);

ModulManager::RegisterShortcut('%MYSECONDMODUL%', $modul, 'OnShow', 'here is your parameter');
