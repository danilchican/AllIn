<template>
    <div class="panel panel-default statistic-panel">
        <div class="panel-body">
            <h3>Statistics page</h3>
            <img src="/image/stat.png" alt="must be stat"/>
        </div>
    </div>
</template>

<style>
    .statistic-panel {
        height: 400px;
    }
</style>

<script>
    export default {
        mounted() {
            console.log("Home component mounted.")
        }
    }
</script>