<template>
    <div class="panel panel-default accounts-panel">
        <div class="panel-body">
            <h2>Manage your linked profiles</h2>
            <h4>Socials, that already linked will be circle with green border</h4>

            <div id="loader">
                <!--
                <svg width="135" height="140" viewBox="0 0 135 140" xmlns="http://www.w3.org/2000/svg" fill="#127cd0">
                    <rect y="10" width="15" height="120" rx="6">
                        <animate attributeName="height"
                                 begin="0.5s" dur="1s"
                                 values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                                 repeatCount="indefinite" />
                        <animate attributeName="y"
                                 begin="0.5s" dur="1s"
                                 values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                                 repeatCount="indefinite" />
                    </rect>
                    <rect x="30" y="10" width="15" height="120" rx="6">
                        <animate attributeName="height"
                                 begin="0.25s" dur="1s"
                                 values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                                 repeatCount="indefinite" />
                        <animate attributeName="y"
                                 begin="0.25s" dur="1s"
                                 values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                                 repeatCount="indefinite" />
                    </rect>
                    <rect x="60" width="15" height="140" rx="6">
                        <animate attributeName="height"
                                 begin="0s" dur="1s"
                                 values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                                 repeatCount="indefinite" />
                        <animate attributeName="y"
                                 begin="0s" dur="1s"
                                 values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                                 repeatCount="indefinite" />
                    </rect>
                    <rect x="90" y="10" width="15" height="120" rx="6">
                        <animate attributeName="height"
                                 begin="0.25s" dur="1s"
                                 values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                                 repeatCount="indefinite" />
                        <animate attributeName="y"
                                 begin="0.25s" dur="1s"
                                 values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                                 repeatCount="indefinite" />
                    </rect>
                    <rect x="120" y="10" width="15" height="120" rx="6">
                        <animate attributeName="height"
                                 begin="0.5s" dur="1s"
                                 values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                                 repeatCount="indefinite" />
                        <animate attributeName="y"
                                 begin="0.5s" dur="1s"
                                 values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                                 repeatCount="indefinite" />
                    </rect>
                </svg>
                -->

                <svg width="120" height="30" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg" fill="#127cd0">
                    <circle cx="15" cy="15" r="15">
                        <animate attributeName="r" from="15" to="15"
                                 begin="0s" dur="0.8s"
                                 values="15;9;15" calcMode="linear"
                                 repeatCount="indefinite" />
                        <animate attributeName="fill-opacity" from="1" to="1"
                                 begin="0s" dur="0.8s"
                                 values="1;.5;1" calcMode="linear"
                                 repeatCount="indefinite" />
                    </circle>
                    <circle cx="60" cy="15" r="9" fill-opacity="0.3">
                        <animate attributeName="r" from="9" to="9"
                                 begin="0s" dur="0.8s"
                                 values="9;15;9" calcMode="linear"
                                 repeatCount="indefinite" />
                        <animate attributeName="fill-opacity" from="0.5" to="0.5"
                                 begin="0s" dur="0.8s"
                                 values=".5;1;.5" calcMode="linear"
                                 repeatCount="indefinite" />
                    </circle>
                    <circle cx="105" cy="15" r="15">
                        <animate attributeName="r" from="15" to="15"
                                 begin="0s" dur="0.8s"
                                 values="15;9;15" calcMode="linear"
                                 repeatCount="indefinite" />
                        <animate attributeName="fill-opacity" from="1" to="1"
                                 begin="0s" dur="0.8s"
                                 values="1;.5;1" calcMode="linear"
                                 repeatCount="indefinite" />
                    </circle>
                </svg>

            </div>

            <div id="social-enter">
                <a href="/socials/vkontakte/create" class="social-network vkontakte" id="vkontakte">
                    <img src="/image/socials/vk_logo.png" alt="vk_logo" class="vkontakte-logo" id="vkontakte-img"/>
                </a>

                <a href="/socials/facebook/create" class="social-network facebook" id="facebook">
                    <img src="/image/socials/fb_logo.png" alt="fb_logo" class="facebook-logo" id="facebook-img"/>
                </a>

                <a href="/socials/twitter/create" class="social-network twitter" id="twitter">
                    <img src="/image/socials/tw_logo.png" alt="tw_logo" class="twitter-logo" id="twitter-img"/>
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

    social-enter {
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

    .social-network.twitter {
        background-color: #4099FF;
    }
    .twitter-logo {
        width: 80px;
        height: auto;
        margin: 30px;
    }
    .twitter-logo:hover {
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
                socials: [],
                links: []
            }
        },

        mounted() {
            $("#social-enter").hide();
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
                    x.style.border = "7px solid #39FF14";
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
                            this.hideLoadBar();
                            this.isSocialLinked();
                            this.showSocials();
                            toastr.success('Connected networks updated!');
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

            hideLoadBar() {
                $("#loader").hide("slow");
            },

            showSocials() {
                $("#social-enter").show("slow");
            }
        }
    }
</script>