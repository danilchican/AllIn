<template>
    <div class="panel panel-default home-panel">
        <ul class="nav nav-tabs nav-justified" role="tablist">
            <li class="active"><a data-target="#latest" role="tab" data-toggle="tab" style="cursor: hand;">Latest posts</a></li>
            <li><a data-target="#scheduled" role="tab" data-toggle="tab" style="cursor: hand;">Scheduled posts</a></li>
        </ul>

        <div class="panel-body tab-content">
            <div class="row">
                <div class="col-md-5 col-md-offset-5 loader" id="loader">
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

            <div role="tabpanel" class="tab-pane active" id="latest">
                <h3 align="center">Latest post</h3>
                <div class="latest-list" v-if="this.latestPost != null">
                    <section class="user-post">
                        <p class="lead" style="margin: 10px 10px; white-space: pre-wrap;">{{this.latestPost.body}}</p>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6" style="margin-left: 5px;">
                                    <div v-for="social in this.latestPost.socials" style="display: inline-block;">
                                        <img :src="getImageUrl(social)" :class="'logo-' + social" :id="social + '-logo-id'">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div v-else>
                    <p class="lead">
                        You have not published anything yet!<br>
                        Go spread the word and check back later!
                    </p>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="scheduled">
                <h3 align="center">Scheduled post</h3>
                <div class="latest-list" v-if="this.plannedPost != null">
                    <section class="user-post">
                        <p class="lead" style="margin: 10px 10px; white-space: pre-wrap;">{{this.plannedPost.body}}</p>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6" style="margin-left: 5px;">
                                    <div v-for="social in this.plannedPost.socials" style="display: inline-block;">
                                        <img :src="getImageUrl(social)" :class="'logo-' + social" :id="social + '-logo-id'">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div v-else>
                    <p class="lead">
                        You have not planned anything yet!<br>
                        Go spread the word and check back later!
                    </p>
                </div>
            </div>
        </div>

    </div>
</template>

<style>
    .home-panel {
        min-height: 100px;
    }

    .loader {
        margin-top: 20px;
        width: 70px;
        height: 20px;
    }

    .user-post {
        background-color: white;
        border-radius: 4px;
        border: 1px solid #d3e0e9;
        padding: 5px 0;
        margin-bottom: 15px;
    }

    img[id$="-logo-id"]{
        width: 40px;
        height: auto;
        margin: 10px 5px;
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
                latestPost: {},
                plannedPost: {},
                data: ""
            }
        },

        mounted() {
            $("#latest").hide();
            this.getLatestPosts();
            this.getPlannedPosts();
        },

        methods: {
            getImageUrl(item) {
                return '/image/' + item.provider + '.png'
            },

            hideLoaderBar() {
                $("#loader").hide("slow", function () {
                    $("#latest").show("fast");

                });
            },

            getLatestPosts() {
                this.$http.get('/post/last')
                    .then((data) => {
                        // success callback
                        if(data.body.message !== undefined) {
                            toastr.warning(data.body.message, 'Warning');
                            return;
                        }

                        this.latestPost = data.body.post;
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

            getPlannedPosts() {
                this.$http.get('/post/last/planned')
                    .then((data) => {
                        // success callback
                        if(data.body.message !== undefined) {
                            toastr.warning(data.body.message, 'Warning');
                            return;
                        }

                        this.plannedPost = data.body.post;
                        this.hideLoaderBar();

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
                        this.hideLoaderBar();

                    });
            },
        }
    }

</script>