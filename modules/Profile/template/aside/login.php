<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
    <div class="card">
        <div class="card-header">Login
        </div>
        <div class="card-body">
            <form id="form-profile-login">
            <div class="form-group">
                <label for="form-profile-login-email">E-mail</label>
                <input class="form-control" type="email" name="form-profile-login-email" id="form-profile-login-email" placeholder="E-mail">
            </div>
            <div class="form-group">
                <label for="form-profile-login-password">Password</label>
                <input class="form-control" type="password" name="form-profile-login-password" id="form-profile-login-password" placeholder="Password">
            </div>
            <div class="row">
            <div class="col">
            <input class="btn btn-primary" type="submit" value="Login">
            </div>
            </div>
            </form>
            <div class="col">
                <input class="btn btn-secondary" type="submit" value="Register">
            </div>
        </div>
    </div>
    <script>
        ajax_request('profile-modul-login', 'form-profile-login', function (msg) {
            if (msg !== undefined) {
                var status = msg.success ? 'success' : 'error';
                alert(msg.data.message, status);
                if (msg.success) {
                    profile_modul_load_aside();
                }
            }
        });
    </script>
</form>