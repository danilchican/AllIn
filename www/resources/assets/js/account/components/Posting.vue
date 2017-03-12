<template>
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <h3>Write text here:</h3>

            <div class="input-group post-input">
                <textarea class="form-control post-textarea" rows="7" cols="120" id="comment" placeholder="Write something..."></textarea>
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
        height: 350px;
    }

    .date-input {
        margin-top: 25px;
    }

    .post-button {
        margin-top: 25px;
        alignment: right;
    }

    .post-input {
        border-radius: 7px;
    }

    .post-textarea {
        resize: none;
        border-radius: 7px;
    }
</style>

<script>
    export default {
        data : function() {
            return {
                isCalendarOpened: false,
                message: "",
                dateTime: ""
            }
        },

        mounted() {
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
                return this.isCalendarOpened
            },

            handlePostButton() {
                this.dateTime = $('input#date-time').val();
                if (this.dateTime === '') {
                    toastr.success("Successfully posted!");
                } else {
                    toastr.success("Scheduled to " + this.dateTime);
                }

                this.message = $('textarea#comment').val();
                $('textarea#comment').val('');
                $('textarea#comment').attr("placeholder", "Write something...");

                $('input#date-time').val('');
            }
        }
    }

</script>