<template>
    <div class="panel panel-default calendar-panel">
        <div class="panel-body">
            <h3>Calendar page</h3>

            <div class="row">
                <div class="col-md-5">
                    <p class="lead">Begin date:</p>
                </div>
                <div class="col-md-5">
                    <p class="lead">End date:</p>
                </div>

                <div class="col-md-5">
                    <div class="input-group date" id="datepicker-begin" data-provide="datepicker">
                        <input data-date-format="yyyy-mm-dd" class="form-control" id="date-begin"/>
                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="input-group date" id="datepicker-end" data-provide="datepicker">
                        <input data-date-format="yyyy-mm-dd" class="form-control" id="date-end"/>
                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" id="find-btn" @click="handleFindButton()">
                        Find
                    </button>
                </div>
            </div>

            <br/>
            <br/>
            <div id="loader" v-if="showLoader" style="text-align:center;">
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
            <div v-if="posts.length > 0 && !showLoader" class="row">
                <div v-for="post in posts" class="col-md-6">
                    <section class="user-post">
                        <h3 style="padding-left: 10px; padding-bottom: 12px; margin-bottom: 0; margin-top: 8px; border-bottom: 1px solid #d3e0e9;">
                            Post #{{ post.id }}
                        </h3>
                        <p style="padding: 10px; border-bottom: 1px solid #d3e0e9;">
                            <b>Is planned:</b> {{ post.planned === 1 ? 'yes' : 'no' }}
                            <br/><b>Published at:</b> {{ post.updated_at }}
                        </p>
                        <p class="lead" style="font-style: italic;padding: 10px; white-space: pre-wrap;">{{post.body}}</p>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-12" style="margin-left: 5px;">
                                    <div v-for="social in post.socials" style="display: inline-block;">
                                        <img :src="getImageUrl(social)" :class="'logo-' + social"
                                             :id="social + '-logo-id'">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .calendar-panel {
        min-height: 300px;
    }

    .input-group-addon {
        min-width: 75px !important;
    }

    .date {
        width: 100% !important;
    }

    img[id$="-logo-id"] {
        width: 40px;
        height: auto;
        margin: 10px 5px;
    }

    .user-post {
        background-color: white;
        border-radius: 4px;
        border: 1px solid #d3e0e9;
        padding: 5px 0;
        margin-bottom: 15px;
    }
    .lead {
        margin-bottom: 0;
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
                posts: [],
                isCalendarOpened: false,
                showLoader: false,
            }
        },

        mounted() {
            $("#datepicker-begin").datepicker({
                format: 'yyyy-mm-dd',
                endDate: '+0d',
                autoclose: true
            });

            $("#datepicker-end").datepicker({
                format: 'yyyy-mm-dd',
                endDate: '+0d',
                autoclose: true
            });

            $("#datepicker-end").datepicker('update', new Date());
        },

        methods: {
            handleFindButton() {
                this.showLoader = true;
                $('input').attr('disabled', true);
                $('button').attr('disabled', true);

                let beginDate = $("#datepicker-begin").datepicker('getFormattedDate');
                let endDate = $("#datepicker-end").datepicker('getFormattedDate');

                let requestURL = '/posts/from/' + beginDate + '/to/' + endDate;

                this.$http.get(requestURL)
                    .then((data) => {
                        // success callback
                        if (data.body.message !== undefined) {
                            toastr.warning(data.body.message, 'Warning');
                            this.showLoader = false;
                            $('input').attr('disabled', false);
                            $('button').attr('disabled', false);
                            return;
                        } else {
                            if (data.body.success === true) {
                                this.posts = data.body.posts;
                            } else {
                                toastr.error(value, 'Something went wrong...')
                            }

                            $('input').attr('disabled', false);
                            $('button').attr('disabled', false);
                            this.showLoader = false;
                        }

                    }, (data) => {
                        this.showLoader = false;
                        $('input').attr('disabled', false);
                        $('button').attr('disabled', false);
                        // error callback
                        var errors = data.body;
                        $.each(errors, function (key, value) {
                            if (data.status !== 200) {
                                toastr.error(value[0], 'Error')
                            } else {
                                toastr.error(value, 'Error')
                            }
                        });
                    });
            },

            getImageUrl(item) {
                return '/image/' + item.provider + '.png'
            },
        }
    }

</script>