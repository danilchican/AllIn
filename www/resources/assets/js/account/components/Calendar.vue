<template>
    <div class="panel panel-default calendar-panel">
        <div class="panel-body">
            <h3>Calendar page</h3>
        </div>

    </div>
</template>

<style>
    .calendar-panel {
        height: 330px;
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

        mounted() {
            console.log("Home component mounted.")
        }
    }

</script>