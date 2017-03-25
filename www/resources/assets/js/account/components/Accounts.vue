<template>
    <div class="panel panel-default accounts-panel">
        <div class="panel-body">
            <h2>Manage your linked profiles</h2>
            <h4>Socials, that already linked will be circle with green border</h4>
            <div id="social-enter" v-if="show">
                <div v-for="link in links" style="float:left">
                    <a v-if="link.linked" :class="getSocialClass(link) + ' linked'" :id="link.provider">
                        <img :src="getImageUrl(link)" :class="link.provider + '-logo'" :id="getIDImage(link)">
                    </a>
                    <a v-else :href="'/socials/' + link.provider + '/create'" :class="getSocialClass(link)" :id="link.provider">
                        <img :src="getImageUrl(link)" :class="link.provider + '-logo'" :id="getIDImage(link)">
                    </a>
                </div>
            </div>
            <div id="loader" v-else>
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
        </div>
    </div>
</template>

<style>
    .accounts-panel {
        text-align: center;
        height: auto;
    }

    #social-enter {
        margin-top: 50px;
        text-align: center;
        display: inline-block;
    }

    .social-network.linked {
        border: 7px solid #39FF14;
    }

    .social-network.linked > img {
        margin: 23px;
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
                show: false,
                socials: [],
                links: [
                    {
                        provider: "vkontakte",
                        logo: "vk_logo",
                        linked: false
                    },
                    {
                        provider: "facebook",
                        logo: "fb_logo",
                        linked: false
                    },
                    {
                        provider: "twitter",
                        logo: "tw_logo",
                        linked: false
                    }
                ]
            }
        },

        mounted() {
            this.getLinkedSocials();
        },

        methods : {

            getImageUrl(item) {
                return '/image/socials/' + item.logo + '.png'
            },

            getSocialClass(item) {
                return 'social-network ' + item.provider
            },

            getIDImage(item) {
                return ('' + item.provider + '-img')
            },

            getSocialsCount() {
                return this.socials.length
            },

            isSocialLinked() {
                var s = this.socials;

                this.links.forEach(function (link) {

                    var value = s.filter(function (item) {
                        return item.provider === link.provider;
                    });

                    if(value.length != 0) {
                        link.linked = true;
                    }
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
                            this.showSocials();
                            this.isSocialLinked();
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
                this.show = false;
            },

            showSocials() {
                this.show = true;
            }
        }
    }
</script>