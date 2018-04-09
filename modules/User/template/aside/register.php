<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="card">
    <div class="card-header">Registrierung</div>
    <div class="card-body">
        <form id="user-modul-register">

            <div class="form-group"> 
                <label for="form-user-register-firstname">Vorname</label>
                <input class="form-control" type="text" name="form-user-register-firstname" id="form-user-register-firstname" placeholder="Vorname">
            </div>
            <div class="form-group">
                <label for="form-user-register-lastname">Nachname</label>
                <input class="form-control" type="text" name="form-user-register-lastname" id="form-user-register-lastname" placeholder="Nachname">
            </div>

            <div class="form-group">
                <label for="form-user-register-email">Email</label>
                <input class="form-control" type="email" name="form-user-register-email" id="form-user-register-email" placeholder="Email">
            </div>

            <div class="form-group">
                <label for="form-user-register-password">Passwort</label>
                <input class="form-control" type="password" name="form-user-register-password" id="form-user-register-password" placeholder="Passwort">
            </div>
            <div class="form-group">
                <label for="form-user-register-password2">Passwort</label>
                <input class="form-control" type="password" name="form-user-register-password2" id="form-user-register-password2" placeholder="Passwort Wiederholen">
            </div>
            <input class="btn btn-primary" type="submit" value="Registrieren">
            <script>
                ajax_request('user-modul-register', 'user-modul-register', function (msg, error) {
                    if (error) {
                        alert(msg, 'error');
                        return;
                    }
                    if (msg !== undefined && msg.success) {
                        alert(msg.data.message, 'success');
                        user_modul_load_aside();
                    } else if (msg !== undefined) {
                        alert(msg.data.message, 'error');
                    }
                }, function () {
                    var error = false;
                    var email = $('#form-user-register-email');
                    var p1 = $('#form-user-register-password');
                    var p2 = $('#form-user-register-password2');

                    p1.removeClass('is-invalid');
                    p2.removeClass('is-invalid');
                    email.removeClass('is-invalid');

                    if (email.val().length === 0) {
                        email.addClass('is-invalid');
                        error = true;
                    }
                    if ((p1.val() !== p2.val()) || p1.val().length === 0 || p2.val().length === 0) {
                        p1.addClass('is-invalid');
                        p2.addClass('is-invalid');
                        error = true;
                    }

                    return !error;
                })
            </script>
        </form>
        <?php UserModul::GetNavigationForm('login', 'Zurück zum Login'); ?>
    </div>
</div>
