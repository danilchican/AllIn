<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <h3>Settings page</h3>
            <div class="input-group">
                <span class="input-group-addon">Email</span>
                <input type="text" class="form-control" placeholder="Email">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Password</span>
                <input type="text" class="form-control" placeholder="Password">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">New password</span>
                <input type="text" class="form-control" placeholder="Password">
            </div>
            <br>
            <div class="button-submit">
                <button type="button" class="btn btn-default btn-lg" style="alignment: right">Submit</button>
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
            console.log("Home component mounted.")
        }
    }

</script>