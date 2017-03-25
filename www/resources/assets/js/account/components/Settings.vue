<template>
    <div class="panel panel-default settings-panel">
        <div class="panel-body">
            <h3>Settings page</h3>

            <div class="input-group">
                <span class="input-group-addon">Email</span>
                <input type="text" class="form-control" id="email-field" readonly>
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Password</span>
                <input type="password" class="form-control" id="password-field" placeholder="Your password" required>
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">New Password</span>
                <input type="password" class="form-control" id="new-password-field" placeholder="New password" required>
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
        height: auto;
    }

    .input-group-addon {
        min-width: 125px;
    }
</style>

<script>
    export default {
        http: {
            root: '/home',
            headers: {
                'X-CSRF-TOKEN': window.Laravel.csrfToken,
            }
        },

        data: function () {
            return {
                newPassword: "",
                email: "",
                disable: false
            }
        },

        mounted() {
            this.disableInputs();
            this.getUserEmail();
            console.log("Settings component mounted.")
        },

        methods: {
            /**
             * Disable data input fields till email isn't loaded from server.
             */
            disableInputs() {
                $('input').attr('disabled', 'disabled');
                this.disable = true;
            },

            /**
             * Enable input fields.
             */
            enableInputs() {
                $('input').attr('disabled', false);
                this.disable = false;
            },

            /**
             * Retrieve user email with GET request to server.
             */
            getUserEmail() {
                this.$http.get('/user/info')
                    .then((data) => {
                        if(data.body.code === 404) {
                            toastr.error("Error code: " + data.body.code, 'Error');
                            return;
                        } else {
                            this.email = data.body.user.email;
                            this.setEmailField();
                            this.enableInputs();
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
            },

            /**
             * Set user email to email-field.
             */
            setEmailField() {
                document.getElementById('email-field').value = this.email;
            },

            /**
             * Send POST request to server to change user password.
             *
             * TODO
             *
             * @param userEmail current user email.
             * @param userNewPassword new user password
             */
            changeUserPassword(userEmail, userNewPassword) {

            },

            /**
             * Validate new user password.
             *
             * @returns {boolean} validation result
             */
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

            /**
             * Handle submit button actions.
             */
            handleSubmit() {
                var validPassword = this.validatePassword();

                if (validPassword) {
                    this.changeUserPassword(this.email, this.newPassword);
                }
            }
        }
    }
</script>