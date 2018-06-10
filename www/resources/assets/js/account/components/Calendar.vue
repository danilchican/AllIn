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
                isCalendarOpened: false,
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
                let beginDate = $("#datepicker-begin").datepicker('getFormattedDate');
                let endDate = $("#datepicker-end").datepicker('getFormattedDate');

                let requestURL = '/posts/from/' + beginDate + '/to/' + endDate;

                this.$http.get(requestURL)
                    .then((data) => {
                        // success callback
                        if (data.body.message !== undefined) {
                            toastr.warning(data.body.message, 'Warning');
                            return;
                        } else {
                            console.log(data.body);
                        }

                    }, (data) => {
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
            }
        }
    }

</script>