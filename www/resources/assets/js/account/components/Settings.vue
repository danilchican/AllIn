<template>
    <div class="panel panel-default settings-panel">
        <div class="panel-body">
            <h3>Settings page</h3>

            <div class="input-group">
                <span class="input-group-addon">Email    </span>
                <input type="text" class="form-control" placeholder="Email">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Password</span>
                <input type="text" class="form-control" placeholder="New password">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon">Confirmation</span>
                <input type="text" class="form-control" placeholder="Repeat new password">
            </div>
            <br>
            <div class="button-submit">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>
    </div>
</template>

<style>
    .settings-panel {
        height: 330px;
    }

    .input-group-addon {
        min-width: 110px;
    }
</style>

<script>
    export default {
        mounted() {
            console.log("Settings component mounted.")
        }
    }
</script>