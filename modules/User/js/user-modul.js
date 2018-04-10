/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class UserModul{
    
    constructor(asideId){
        this.asideId = asideId;
        this.events = [];
    }
    
    AddEvent(event, callback){
        if(this.events[event] === undefined) {
            this.events[event] = [];
        }
        this.events[event].push(callback);
    }
    
    CallEvent(event, params){
        if(this.events[event] !== undefined){
            for(var i = 0; i < this.events[event].length; i++){
                this.events[event][i](params);
            }
        }
    }

    
    LoadAside() {
        $.ajax('', {
            method: 'post',
            data: {action: 'user-modul-load-aside'},
            success: function (msg) {
                if (msg.length > 0) {
                    try {
                        var msg = JSON.parse(msg);
                        this.ShowAside(msg.data.html);
                    } catch (e) {

                    }
                }
            },
            context: this
        });
    }
    
    ShowAside(html) {
        $('#' + this.asideId).html(html);
    }
    
    _Login(){
        var self = this;
        ajax.request('user-modul-login', 'form-user-login', function (msg) {
            if (msg !== undefined) {
                var status = msg.success ? 'success' : 'error';
                alert(msg.data.message, status);
                if (msg.success) {
                    self.CallEvent('OnLogin', msg.data.user);
                    self.LoadAside();
                }
            }
        });
    }
    _Logout(){
        var self = this;
        ajax.request('user-modul-logout', 'user-modul-logout', function (msg) {
            if (msg === undefined)
                return;
            self.LoadAside();
            alert(msg.data.message);
        });
    }
    
    _Register(){
        var self = this;
        ajax.request('user-modul-register', 'user-modul-register', function (msg, error) {
                    if (error) {
                        alert(msg, 'error');
                        return;
                    }
                    if (msg !== undefined && msg.success) {
                        alert(msg.data.message, 'success');
                        self.LoadAside();
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
                });
    }
    
    _ChangeLayout(){
        var self = this;
        ajax.request('user-modul-change-layout', 'user-modul-change-layout', function (msg) {
            if (msg !== undefined && msg.success) {
                self.ShowAside(msg.data.html);
            }
        });
    }
}