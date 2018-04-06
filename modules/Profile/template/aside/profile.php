<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="card">
    <div class="card-header">Profil</div>
    <div class="card-body">
        <div class="row">
            <div class="col">
                Willkommen, <?php echo $this->GetUser()->GetAttr('firstname'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form id="profile-modul-logout">
                    <input class="btn btn-primary" type="submit" value="Logout">
                    <script>
                        ajax_request('profile-modul-logout', 'profile-modul-logout', function (msg) {
                            if (msg === undefined)
                                return;

                            profile_modul_load_aside();
                            alert(msg.data.message);
                        })
                    </script>
                </form>
            </div>
        </div>
    </div>

</div>
