<template>
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <h3>Write text here:</h3>

            <div class="input-group post-input">
                <textarea class="form-control post-textarea" rows="7" cols="120" id="comment" placeholder="Write something..."></textarea>
            </div>
            <div class="row">
                <div class="display-socials" align="left">
                    <ul>
                        <li>
                            <input type="checkbox" id="select-vkontakte"/>
                            <label for="select-vkontakte">
                                <img src="/image/vkontakte.png" style="width: 60px; height: auto; margin: 0 10px;" />
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="select-facebook" />
                        <label for="select-facebook">
                            <img src="/image/facebook.png" style="width: 60px; height: auto; margin: 0 10px;" />
                        </label>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 date-input">
                    <div class='input-group date' id='datetimepicker'>
                        <input type='text' class="form-control" id="date-time"/>
                        <span class="input-group-addon" @click="handleCalendar()"><span class="fa fa-calendar"></span></span>
                    </div>
                </div>

                <div class="col-sm-3 post-button">
                    <button type="submit" class="btn btn-primary" @click="handlePostButton()">
                        Post
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .post-panel {
        height: auto;
    }


    .post-input {
        border-radius: 7px;
    }

    .post-textarea {
        resize: none;
        border-radius: 7px;
    }

    .display-socials {
        margin-top: 20px;
        margin-bottom: 5px;
    }

    ul {
        list-style-type: none;
    }

    li {
        display: inline-block;
    }

    input[type="checkbox"][id^="select-"] {
        display: none;
    }

    label {
        border: 0px solid #fff;
        display: block;
        position: relative;
        cursor: pointer;
    }

    label:before {
        background-color: white;
        color: white;
        content: " ";
        display: block;
        border-radius: 50%;
        border: 1px solid grey;
        position: absolute;
        top: -5px;
        left: -5px;
        width: 25px;
        height: 25px;
        text-align: center;
        transition-duration: 0.4s;
        transform: scale(0);
    }

    label img {
        height: 60px;
        width: 60px;
        transition-duration: 0.2s;
        transform-origin: 50% 50%;
    }

    :checked + label {
        border-color: white;
    }

    :checked + label:before {
        content: "✓";
        background-color: green;
        transform: scale(1);
    }

    :checked + label img {
        transform: scale(0.9);
        z-index: -1;
    }
</style>

<script>
    export default {
        data : function() {
            return {
                isCalendarOpened: false,
                message: "",
                dateTime: "",
                linkedSocials: [],
                socialsForPost: []
            }
        },

        mounted() {
            this.getLinkedSocials();
            console.log("Post component mounted.")
        },

        methods : {
            handleCalendar() {
                if (this.isCalendarOpened == true) {
                    $('#datetimepicker').datetimepicker('hide');
                    this.isCalendarOpened = false;
                } else {
                    $('#datetimepicker').datetimepicker('show');
                    this.isCalendarOpened = true;
                }
            },

            isOpened() {
                return this.isCalendarOpened;
            },

            getSelectedNetworksCount() {
                return this.socialsForPost.length;
            },

            getSocialImageURL(account) {
                return "/image/" + account.provider + ".png";
            },

            isLinked(social) {
                this.linkedSocials.forEach(function (key) {
                    if (key.provider === social) {
                        return true;
                    }
                });

                return false;
            },

            handlePostButton() {
                this.message = $('textarea#comment').val();

                if (this.message == '') {
                    toastr.warning('Nothing to post.');
                    return;
                }

                this.dateTime = $('input#date-time').val();
                if (this.dateTime === '') {
                    toastr.success("Successfully posted!");
                } else {
                    toastr.success("Scheduled to " + this.dateTime);
                }

                $('textarea#comment').val('');
                $('textarea#comment').attr("placeholder", "Write something...");

                $('input#date-time').val('');
            },

            getLinkedSocials() {
                this.$http.get('/socials/list')
                    .then((data) => {
                        // success callback
                        if(data.body.message !== undefined) {
                            toastr.warning(data.body.message, 'Warning');
                            return;
                        } else {
                            toastr.success('Connected networks updated!');
                        }

                        this.linkedSocials = data.body.socials;
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

            sendPostData(data, networks) {
                this.$http.post('usage/post', { message: data, socials: networks })
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
                        toastr.error(errors, "Error");
                    });
            },

            schedulePostData(data, networks, time) {
                this.$http.post('usage/schedule', { message: data, socials: networks, schedule: time })
                    .then((data) => {
                        // success callback

                        if(data.body.success === true) {
                            var messages = data.body.messages;

                            $.each( messages, function( key, value ) {
                                toastr.success(value, 'Success')
                            });
                        } else {
                            toastr.error("It's seems something went wrong...", 'Error');
                        }
                    }, (data) => {
                        // error callback
                        var errors = data.body;
                        toastr.error(errors, "Error");
                    });
            }
        }
    }

</script>