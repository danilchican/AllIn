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
                <span class="input-group-addon">Current Password</span>
                <input v-model="currentPassword" type="password" class="form-control" id="password-field"
                       placeholder="Your password" required>
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">New Password</span>
                <input v-model="newPassword" type="password" class="form-control" id="new-password-field"
                       placeholder="New password" required>
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Confirmation</span>
                <input v-model="newPasswordConfirmation" type="password" class="form-control"
                       id="repeat-password-field" placeholder="Repeat new password" required>
            </div>
            <br>
            <div class="button-submit">
                <button type="submit" class="btn btn-primary" id="submit-btn" @click="handleSubmit()">
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
                currentPassword: null,
                newPassword: null,
                newPasswordConfirmation: null,
                email: null,
                disable: false
            }
        },

        mounted() {
            this.disableInputs();
            this.getUserEmail();
        },

        methods: {
            /**
             * Disable data input fields till email isn't loaded from server.
             */
            disableInputs() {
                $('input').attr('disabled', true);
                $('button').attr('disabled', true);

                this.disable = true;
            },

            /**
             * Enable input fields.
             */
            enableInputs() {
                $("input").attr('disabled', false);
                $("button").attr('disabled', false);

                this.disable = false;
            },

            /**
             * Retrieve user email with GET request to server.
             */
            getUserEmail() {
                this.$http.get('/user/info')
                    .then((data) => {
                        if (data.body.code === 404) {
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
                        $.each(errors, function (key, value) {
                            if (data.status === 422) {
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
             */
            changeUserPassword() {
                const data = {
                    currentPassword: this.currentPassword,
                    newPassword: this.newPassword,
                    newPassword_confirmation: this.newPasswordConfirmation
                };

                this.$http.post('/account/password/change', data)
                    .then((data) => {
                        // success callback
                        if (data.body.success === true) {
                            toastr.success(data.body.message, 'Success');
                            this.clearFields();
                        } else {
                            toastr.error(data.body.message, 'Error');
                        }

                        this.enableInputs();
                    }, (data) => {
                        // error callback
                        var errors = data.body;
                        this.enableInputs();

                        $.each(errors, function (key, value) {
                            if (data.status === 422) {
                                toastr.error(value[0], 'Error')
                            } else {
                                toastr.error(value.message, 'Error')
                            }
                        });
                    });
            },

            /**
             * Validate new user password.
             *
             * @returns {boolean} validation result
             */
            validatePassword() {
                if (this.currentPassword.length < 1 || this.newPassword.length < 1
                    || this.newPasswordConfirmation.length < 1) {

                    toastr.warning('Passwords fields is empty!');
                    return false;
                } else {
                    if (this.newPassword.localeCompare(this.newPasswordConfirmation) === 0) {
                        return true;
                    } else {
                        toastr.warning('Entered passwords are not equal!');
                        return false;
                    }
                }
            },

            /**
             * Clear input fields.
             */
            clearFields() {
                this.currentPassword = '';
                this.newPassword = '';
                this.newPasswordConfirmation = '';
            },

            /**
             * Handle submit button actions.
             */
            handleSubmit() {
                this.disableInputs();

                if (this.validatePassword()) {
                    this.changeUserPassword();
                } else {
                    this.enableInputs();
                }
            },
        }
    }
</script>