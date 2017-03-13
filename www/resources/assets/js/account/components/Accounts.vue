<template>
    <div class="panel panel-default accounts-panel">
        <div class="panel-body">
            <div class="socials" v-if="getSocialsCount() == 0">
                <div class="socials-info">
                    <h3>It seems, you are not connect any social networks<br>
                        Press on plus button below, to link!
                    </h3>
                </div>
            </div>

            <div class="connected-socials" v-else>
                <h3>Here connected socials. Press plus to add more.</h3>
                <div class="display-socials" v-for="item in socials">
                    <div class="currently-linked" v-if="isVkLinked() === true && isFbLinked() === true">
                        <img src="/image/vk.png" alt="vk_logo" style="width: 60px; height: auto"/>
                        <img src="/image/fb.png" alt="fb_logo" style="width: 60px; height: auto"/>
                    </div>
                </div>
            </div>

            <div class="plus-button">
                <button type="button" class="btn btn-default btn-block add-button" @click="handlePlus()">
                    <i class="fa fa-plus"></i><br/>
                </button>
            </div>

            <div class="social-enter" v-if="isOpened()">
                <a href="/socials/vkontakte/create" class="social-network vkontakte">
                    <img src="/image/socials/vk_logo.png" alt="vk_logo" class="vk-logo"/>
                    <div class="social-name"></div>
                </a>

                <a href="/socials/facebook/create" class="social-network facebook">
                    <img src="/image/socials/fb_logo.png" alt="fb_logo" class="fb-logo"/>
                    <div class="social-name"></div>
                </a>
            </div>
        </div>
    </div>
</template>

<style>
    .accounts-panel {
        height: auto;
    }

    .socials-info {
        text-align: center;
        font-style: italic;
    }

    .connected-socials {
        text-align: center;
    }
    .currently-linked {
        margin-top: 15px;
    }

    .plus-button {
        margin-top: 50px;
        margin-bottom: 10px;
    }

    .add-button:focus, .add-button:active, .add-button:hover {
        outline: none !important;
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
    .fb-logo {
        width: 80px;
        height: auto;
        margin-top: 30px;
        margin-left: 30px;
        margin-right: 30px;
    }

    .fb-logo:hover {
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
    .vk-logo {
        width: 80px;
        height: auto;
        margin-top: 30px;
        margin-left: 30px;
        margin-right: 30px;
    }
    .vk-logo:hover {
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
        data : function() {
            return {
                vkLinked: false,
                fbLinked: false,
                plusButton: false,
                socials: [],
                linked: []
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

            getLinkedSocials() {
                this.$http.get('/socials/list')
                    .then((data) => {
                        // success callback
                        this.linked = data.body.linked;

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

            isVkLinked() {
                return this.vkLinked
            },

            isFbLinked() {
                return this.fbLinked
            }
        }
    }
</script>