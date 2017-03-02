<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <h3>Calendar page</h3>
            <div class="col-sm-6" style="height:130px;">
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker'>
                        <input type='text' class="form-control" />
                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    #myTab {
        margin-bottom: 15px;
    }
</style>

<script>

    export default {
        mounted() {
            $('#datetimepicker').datetimepicker('show');
            console.log("Home component mounted.")
        }
    }

</script>