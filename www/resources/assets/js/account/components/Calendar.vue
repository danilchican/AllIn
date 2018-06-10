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
                        <input data-date-format="dd/mm/yyyy" class="form-control" id="date-begin"/>
                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="input-group date" id="datepicker-end" data-provide="datepicker">
                        <input data-date-format="dd/mm/yyyy" class="form-control" id="date-end"/>
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
                format: 'dd/mm/yyyy',
                endDate: '+0d',
                autoclose: true
            });
            $("#datepicker-end").datepicker({
                format: 'dd/mm/yyyy',
                endDate: '+0d',
                autoclose: true
            });
            $("#datepicker-end").datepicker('update', new Date());
        },

        methods: {
            handleFindButton() {

            }
        }
    }

</script>