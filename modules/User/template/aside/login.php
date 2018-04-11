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
        <form id="form-user-login" onsubmit="UserModul.Login($(this).find('input[name=email]').val(), $(this).find('input[name=password]').val()); return false;">
            <div class="form-group">
                <label for="form-user-login-email">E-mail</label>
                <input class="form-control" type="email" name="email" id="form-user-login-email" placeholder="E-mail">
            </div>
            <div class="form-group">
                <label for="form-user-login-password">Password</label>
                <input class="form-control" type="password" name="password" id="form-user-login-password" placeholder="Password">
            </div>
            <div class="row">
                <div class="col">
                    <input class="btn btn-primary" type="submit" value="Login">
                    <?php UserModul::GetNavigationForm('register', 'Registrieren') ?>
                </div>
            </div>
        </form>
    </div>
</div>