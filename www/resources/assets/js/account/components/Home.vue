<template>
    <div class="panel panel-default home-panel">
        <div class="panel-body">
            <h3>Latest</h3>
            <p class="lead">Yesterday posts now:<br>
               Plan: 01.03.2017 at 00:00 Happy Birthday, Mary!<br>
                <img src="/image/pusheencat.png" alt="must be cat" style="width: 100px; height: auto"/>
            <p class="lead"> Posted in:</p>
                <img src="/image/vk.png" alt="must be cat" style="width: 50px; height: auto"/>
                <img src="/image/fb.png" alt="must be cat" style="width: 50px; height: auto"/>
            </p>
        </div>
    </div>
</template>

<style>
    .home-panel {
        height: 380px;
    }
</style>

<script>

    export default {
        mounted() {
            console.log("Home component mounted.")
        }
    }

</script>