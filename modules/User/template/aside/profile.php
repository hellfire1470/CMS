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
                Willkommen, <?php echo GetUser()->GetFirstname(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form id="user-modul-logout" onsubmit="UserModul.Logout(); return false;">
                    <input class="btn btn-primary" type="submit" value="Logout">
                </form>
            </div>
        </div>
    </div>

</div>
