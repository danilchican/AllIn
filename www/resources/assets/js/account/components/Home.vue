<template>
    <div class="panel panel-default home-panel">
        <div class="panel-body">
            <h3>Latest</h3>
            <p class="lead">Yesterday posts:<br>
               Plan: 01.03.2017 at 00:00 Happy Birthday, Mary!<br>
                <img src="/image/pusheencat.png" alt="must be cat" style="width: 100px; height: auto"/>
            <p class="lead"> Posted in:</p>
                <img src="/image/vkontakte.png" alt="must be cat" style="width: 50px; height: auto"/>
                <img src="/image/facebook.png" alt="must be cat" style="width: 50px; height: auto"/>
            </p>
        </div>
    </div>
</template>

<style>
    .home-panel {
        height: 380px;
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
            console.log("Home component mounted.")
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