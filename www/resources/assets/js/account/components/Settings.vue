<template>
    <div class="panel panel-default settings-panel">
        <div class="panel-body">
            <h3>Settings page</h3>

            <div class="input-group">
                <span class="input-group-addon">Email</span>
                <input type="email" class="form-control" id="email-field" placeholder="Email" required>
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Password</span>
                <input type="password" class="form-control" id="password-field" placeholder="New password" required>
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Confirmation</span>
                <input type="password" class="form-control" id="repeat-password-field" placeholder="Repeat new password" required>
            </div>
            <br>
            <div class="button-submit">
                <button type="submit" class="btn btn-primary" @click="handleSubmit()">
                    Submit
                </button>
            </div>
        </div>
    </div>
</template>

<style>
    .settings-panel {
        height: 330px;
    }

    .input-group-addon {
        min-width: 110px;
    }
</style>

<script>
    export default {
        data: function () {
            return {
                newPassword: "",
                email: "",
            }
        },

        mounted() {
            this.getUserEmail();
            console.log("Settings component mounted.")
        },

        methods: {
            getUserEmail() {
                this.$http.get('/user/info')
                    .then((data) => {
                        // success callback
                        if(data.body.code === 404) {
                            toastr.error("Error code: " + data.body.code, 'Error');
                            return;
                        } else {
                            this.email = data.body.user.email;
                            toastr.success('User email loaded! ' + this.email);
                        }
                    });
            },

            changeUserPassword(userEmail, userNewPassword) {
                /*
                this.$http.post('change/password/blya', {email: userEmail, password: userNewPassword})
                    .then((data) => {
                        // success callback

                        if(data.body.success === true) {
                            var messages = data.body.messages;

                            $.each( messages, function( key, value ) {
                                toastr.success(value, 'Success')
                            });
                        } else {
                            toastr.error('Что-то пошло не так...', 'Error')
                        }
                    }, (data) => {
                        // error callback
                        var errors = data.body;
                        $.each( errors, function( key, value ) {
                            if(data.status === 422) {
                                toastr.error(value[0], 'Error')
                            } else {
                                toastr.error(value, 'Error')
                            }
                        });
                    });
                    */
            },

            validateEmail() {
                var userEmail = $('input#email-field').val();

                if (userEmail == '') {
                    toastr.warning('Email is required.');
                    return false;
                } else {
                    toastr.warning('User enter email: ' + userEmail);
                    document.getElementById('email-field').value = "";
                    document.getElementById('email-field').placeholder = "Email";

                    if (this.email.localeCompare(userEmail) === 0) {
                        toastr.success('Email: ok!');
                        return true;
                    } else {
                        toastr.warning('Entered email is not valid!');
                        return false;
                    }
                }
            },

            validatePassword() {
                var newPassword = $('input#password-field').val();
                var newPasswordRepeat = $('input#repeat-password-field').val();

                if (newPassword === '' || newPasswordRepeat === '') {
                    toastr.warning('Passwords fields is empty!');
                    return false;
                } else {
                    document.getElementById('password-field').value = "";
                    document.getElementById('repeat-password-field').value = "";
                    document.getElementById('password-field').placeholder = "New password";
                    document.getElementById('repeat-password-field').placeholder = "Repeat new password";

                    if (newPassword.localeCompare(newPasswordRepeat) === 0) {
                        toastr.success('Password: ok!');
                        this.newPassword = newPassword;
                        return true;
                    } else {
                        toastr.warning('Entered passwords are not equal!');
                        return false;
                    }
                }
            },

            handleSubmit() {
                var validEmail = this.validateEmail();
                var validPassword = this.validatePassword();

                if (validEmail && validPassword) {
                    this.changeUserPassword(this.email, this.newPassword);
                }
            }
        }
    }
</script>