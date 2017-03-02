<template>
    <div class="panel panel-default post-panel">
        <div class="panel-body">
            <h3>Write text here:</h3>

            <div class="input-group post-input">
                <textarea class="form-control post-textarea" rows="5" placeholder="What's new?" required></textarea>
                <div class="checkbox">
                    <label><input type="checkbox" value="">Plan</label>
                </div>
                <button type="button" class="btn btn-default btn-lg" style="alignment: right">Post</button>
            </div>
        </div>
    </div>
</template>

<style>
    .post-panel {
        height: 350px;
    }

    .post-input {

    }

    .post-textarea {
        max-height: 250px;
        max-width: 500px;
    }


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