<template>
    <div class="panel panel-default accounts-panel">
        <div class="panel-body">
            <h2>Manage your linked profiles</h2>
            <h4>Socials, that already linked will be circle with green border</h4>

            <div class="social-enter">
                <a href="/socials/vkontakte/create" class="social-network vkontakte" id="vkontakte">
                    <img src="/image/socials/vk_logo.png" alt="vk_logo" class="vkontakte-logo" id="vkontakte-img"/>
                </a>

                <a href="/socials/facebook/create" class="social-network facebook" id="facebook">
                    <img src="/image/socials/fb_logo.png" alt="fb_logo" class="facebook-logo" id="facebook-img"/>
                </a>
            </div>
        </div>
    </div>
</template>

<style>
    .accounts-panel {
        text-align: center;
        height: auto;
    }

    .social-enter {
        margin-top: 50px;
        text-align: center;
        alignment: center;
    }

    .social-network {
        margin: 0 8px 15px;
        width: 140px;
        height: 140px;
        border-radius: 10px;
        display: inline-block;
        vertical-align: top;
    }

    .social-network.facebook {
        background-color: #3b5998;
    }
    .facebook-logo {
        width: 80px;
        height: auto;
        margin-top: 30px;
        margin-left: 30px;
        margin-right: 30px;
    }

    .facebook-logo:hover {
        transform: scale(1.2);
        transition: all 0.3s ease;
        transition-property: all;
        transition-duration: 0.3s;
        transition-timing-function: ease;
        transition-delay: initial;
    }

    .social-network.vkontakte {
        background-color: #4C75A3;
    }
    .vkontakte-logo {
        width: 80px;
        height: auto;
        margin: 30px;
    }
    .vkontakte-logo:hover {
        transform: scale(1.2);
        transition: all 0.3s ease;
        transition-property: all;
        transition-duration: 0.3s;
        transition-timing-function: ease;
        transition-delay: initial;
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

        data : function() {
            return {
                plusButton: false,
                socials: [],
                links: []
            }
        },

        mounted() {
            this.getLinkedSocials();
            console.log("Accounts component mounted.")
        },

        methods : {
            handlePlus() {
                this.plusButton = !this.plusButton
            },

            isOpened() {
                return this.plusButton
            },

            getSocialsCount() {
                return this.socials.length
            },

            getSocialImageURL(account) {
                return "/image/" + account.provider + ".png";
            },

            isSocialLinked() {
                this.socials.forEach(function (item) {
                    var x = document.getElementById(item.provider);
                    x.style.border = "7px solid green";
                    x.style.pointerEvents = "none";

                    var img = document.getElementById(item.provider + "-img")
                    img.style.margin = "23px";
                    img.title = "Already linked";
                });
            },

            getLinkedSocials() {
                this.$http.get('/socials/list')
                    .then((data) => {
                        // success callback
                        if(data.body.message !== undefined) {
                            toastr.warning(data.body.message, 'Warning');
                            return;
                        } else {
                            this.socials = data.body.socials;
                            toastr.success('Connected networks updated!');
                            this.isSocialLinked();
                        }

                    }, (data) => {
                        // error callback
                        var errors = data.body;
                        $.each(errors, function(key, value) {
                            if(data.status !== 200) {
                                toastr.error(value[0], 'Error')
                            } else {
                                toastr.error(value, 'Error')
                            }
                        });
                    });
            },
        }
    }
</script>