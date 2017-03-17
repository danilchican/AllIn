<template>
    <div class="panel panel-default settings-panel">
        <div class="panel-body">
            <h3>Settings page</h3>

            <div class="input-group">
                <span class="input-group-addon">Email</span>
                <input type="text" class="form-control" placeholder="Email">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Password</span>
                <input type="text" class="form-control" placeholder="New password">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Confirmation</span>
                <input type="text" class="form-control" placeholder="Repeat new password">
            </div>
            <br>
            <div class="button-submit">
                <button type="submit" class="btn btn-primary">
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
                email: ""
            }
        },

        mounted() {
            console.log("Settings component mounted.")
        },

        methods: {
            getUserEmail() {
                this.$http.get('user/give/me/email')
                    .then((data) => {
                        // success callback
                        this.email = data.body.email;

                        if(data.body.success !== true) {
                            toastr.error('Help! I need somebody Help!', 'Error')
                        }
                    }, (data) => {
                        // error callback
                        var errors = data.body;
                        $.each(errors, function(key, value) {
                            if(data.status === 422) {
                                toastr.error(value[0], 'Error')
                            } else {
                                toastr.error(value, 'Error')
                            }
                        });
                    });
            },

            changeUserPassword(userEmail, userNewPassword) {
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
            }
        }
    }
</script>