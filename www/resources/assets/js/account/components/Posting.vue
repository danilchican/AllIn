<template>
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <h3>Write text here:</h3>

            <div class="input-group post-input">
                <textarea class="form-control post-textarea" rows="7" cols="120" id="comment" placeholder="Write something..."></textarea>
            </div>
            <div class="row">
                <div class="col-sm-3 loader" id="loader">
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
            <div class="row">
                <div class="display-socials" id="socials-checkbox" align="left">
                    <ul class="socials">
                        <li class="socials-list" v-for="item in linkedSocials">
                            <input type="checkbox" :id="getInputIDSocial(item)"/>
                            <label :for="getInputIDSocial(item)">
                                <img :src="getCheckboxImage(item)" style="width: 60px; height: auto; margin: 0 10px;" />
                            </label>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 file-input">
                    <div class='input-group date' id='file-chooser'>
                        <input type='text' class="form-control" id="file-choose" placeholder="Choose file..."/>
                        <span class="input-group-btn">
                            <button class="btn btn-secondary file-button" type="button">File...</button>
                        </span>
                    </div>
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
                    <button type="submit" class="btn btn-primary" id="post-btn" @click="handlePostButton()">
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

    .loader {
        margin-top: 20px;
        width: 70px;
        height: 20px;
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

    ul.socials {
        list-style-type: none;
    }

    li.socials-list {
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

    .file-input {
        margin-bottom: 15px;
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
                disable: false,
                isCalendarOpened: false,
                isPlanned: false,
                message: "",
                dateTime: "",
                linkedSocials: [],
                socialsForPost: [],
                obj: null
            }
        },

        mounted() {
            this.disableInput();
            this.getLinkedSocials();
            console.log("Post component mounted.")
        },

        methods : {
            disableInput() {
                $('textarea').prop('disabled', 'disabled');
                $('input').prop('disabled', 'disabled');
                $('#post-btn').prop('disabled', 'disabled');
                this.disable = true;
            },

            enableInput() {
                $('textarea').prop('disabled', false);
                $('input').prop('disabled', false);
                $('#post-btn').prop('disabled', false);
                this.disable = false;
            },

            clearFields() {
                $('textarea#comment').val('');
                $('textarea#comment').attr("placeholder", "Write something...");
                $('input#date-time').val('');
                this.clearSocialsForPost();
            },

            hideCheckboxes() {
                $("#socials-checkbox").hide();
            },

            /**
             * Handle calendar button press.
             */
            handleCalendar() {
                if (this.isCalendarOpened == true) {
                    $('#datetimepicker').datetimepicker('hide');
                    this.isCalendarOpened = false;
                } else {
                    $('#datetimepicker').datetimepicker('show');
                    this.isCalendarOpened = true;
                }
            },

            /**
             * Return current calendar state.
             */
            isOpened() {
                return this.isCalendarOpened;
            },

            /**
             * Get connected networks count.
             */
            getSelectedNetworksCount() {
                return this.socialsForPost.length;
            },

            /**
             * Get URL of image using it's name.
             */
            getSocialImageURL(account) {
                return "/image/" + account.provider + ".png";
            },

            /**
             * Check if social network with given name
             * exist in array of linked socials.
             *
             * @param social name of social network.
             */
            isLinked(social) {
                this.linkedSocials.forEach(function (key) {
                    if (key.provider === social) {
                        return true;
                    }
                });

                return false;
            },

            /**
             * Handle Post button actions:
             *
             * 1. Get data from input fields;
             * 2. Collect checked socials;
             * 3. Clear all input fields;
             * 4. Send POST request to server for post data if
             *    date and time wasn't set.
             * 5. Send POST request to server to schedule post
             *    if date and time was set.
             */
            handlePostButton() {
                this.disableInput();
                this.message = $('textarea#comment').val();

                if (this.message == '') {
                    toastr.warning('Nothing to post.');
                    return;
                }

                this.dateTime = $('input#date-time').val();
                if (this.dateTime === '') {
                    this.dateTime = null;
                    this.isPlanned = false;
                } else {
                    this.isPlanned = true;
                }

                this.getSocialsForPost();

                this.obj = null;

                if (this.isPlanned) {
                    this.obj = {
                        is_plan: this.isPlanned,
                        date: this.dateTime,
                        socials: this.socialsForPost,
                        body: this.message
                    }
                } else {
                    this.obj = {
                        is_plan: this.isPlanned,
                        socials: this.socialsForPost,
                        body: this.message
                    }
                }

                this.sendPostData(this.obj);
            },

            /**
             * Get every checkbox state and make
             * array of socials for posting.
             */
            getSocialsForPost() {
                var forPost = [];

                this.linkedSocials.forEach(function (item) {
                    var checkbox = document.getElementById("select-" + item.provider);

                    if (checkbox.checked) {
                        var prov = item.provider;
                        var id = item.id;

                        forPost.push({
                            "id": id,
                            "provider": prov
                        });
                    }
                });

                this.socialsForPost = forPost;
            },

            clearSocialsForPost() {
                $('input[type=checkbox]').each(function() {
                    this.checked = false;
                });
            },

            /**
             * Send GET request to server and retrieve
             * connected networks of current user.
             */
            getLinkedSocials() {
                this.$http.get('/socials/list')
                    .then((data) => {
                        // success callback
                        if(data.body.message !== undefined) {
                            toastr.warning(data.body.message, 'Warning');
                            return;
                        }

                        this.linkedSocials = data.body.socials;
                        this.enableInput();
                        this.hideLoadBar();
                        this.showSocials();
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


            /**
             * Send POST request on server for immediate post
             * user data in socials.
             *
             * @param isPlan Boolean is post planned
             * @param dateTime Time for post if it's planned
             * @param networks Linked networks for post
             * @param data User data for posting
             */
            sendPostData(obj) {
                this.$http.post('/post/store', obj)
                    .then((data) => {
                        // success callback
                        if(data.body.code === 200) {
                            toastr.success(data.body.message);
                            this.clearFields();
                            this.enableInput();
                        } else {
                            toastr.error('Что-то пошло не так...', 'Error');
                        }
                    }, (data) => {
                        // error callback
                        var errors = data.body;

                        if(data.status === 400) {
                            var errors = data.body.errors;
                        }
                        $.each( errors, function( key, value ) {
                            if(data.status === 422) {
                                toastr.error(value[0], 'Error')
                            } else {
                                toastr.error(value.message, 'Error')
                            }
                        });
                    });
            },

            getInputIDSocial(item) {
                return "select-" + item.provider;
            },

            getCheckboxImage(item) {
                return "/image/" + item.provider + ".png";
            },

            hideLoadBar() {
                $("#loader").hide();
            },

            showSocials() {
                $("#socials-checkbox").show("slow");
            }
        }
    }
</script>