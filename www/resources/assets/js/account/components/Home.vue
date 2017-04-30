<template>
    <div class="panel panel-default home-panel">
        <ul class="nav nav-tabs nav-justified" role="tablist">
            <li class="active"><a data-target="#latest" role="tab" data-toggle="tab" style="cursor: hand;">Latest posts</a></li>
            <li><a data-target="#scheduled" role="tab" data-toggle="tab" style="cursor: hand;">Scheduled posts</a></li>
        </ul>

        <div class="panel-body tab-content">
            <div role="tabpanel" class="tab-pane active" id="latest">
                <h3>Latest post</h3>
                <div class="latest-list" v-if="this.latestPost != null">
                    <section class="user-post">
                        <p class="lead" style="margin: 10px 10px; white-space: pre-wrap;">{{this.latestPost.body}}</p>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <div v-for="social in this.latestPost.socials">
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
                <h3>Scheduled post</h3>
                <div class="latest-list" v-if="this.plannedPost != null">
                    <section class="user-post">
                        <p class="lead" style="margin: 10px 10px; white-space: pre-wrap;">{{this.plannedPost.body}}</p>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <div v-for="social in this.plannedPost.socials">
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
        height: auto;
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
        margin: 10px 15px;
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
            this.getLatestPosts();
            this.getPlannedPosts();
            console.log("Home component mounted.")
        },

        methods: {
            getImageUrl(item) {
                return '/image/' + item.provider + '.png'
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