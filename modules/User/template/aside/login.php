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
        <form id="form-user-login">
            <div class="form-group">
                <label for="form-user-login-email">E-mail</label>
                <input class="form-control" type="email" name="form-user-login-email" id="form-user-login-email" placeholder="E-mail">
            </div>
            <div class="form-group">
                <label for="form-user-login-password">Password</label>
                <input class="form-control" type="password" name="form-user-login-password" id="form-user-login-password" placeholder="Password">
            </div>
            <div class="row">
                <div class="col">
                    <input class="btn btn-primary" type="submit" value="Login" onclick="userModul._Login()">
                </div>
            </div>
        </form>
        <?php UserModul::GetNavigationForm('register', 'Registrieren') ?>
    </div>
</div>