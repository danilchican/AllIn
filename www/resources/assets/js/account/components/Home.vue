<template>
    <div class="panel panel-default home-panel">
        <ul class="nav nav-tabs nav-justified" role="tablist">
            <li class="active"><a data-target="#latest" role="tab" data-toggle="tab" style="cursor: hand;">Latest posts</a></li>
            <li><a data-target="#scheduled" role="tab" data-toggle="tab" style="cursor: hand;">Scheduled posts</a></li>
        </ul>

        <div class="panel-body tab-content">
            <div role="tabpanel" class="tab-pane active" id="latest">
                <h3>Latest</h3>
                <h4>Have a nice day, everyone!<br>
                    P.S. Your face, while you are finished all before sprint deadline :)
                </h4>
                <img src="/image/last.jpg" alt="last_picture" style="width: 200px; height: auto"/>
                <p class="lead"><br>Posted in:</p>
                <img src="/image/twitter.png" alt="twitter_logo" style="width: 50px; height: auto"/>
                <img src="/image/facebook.png" alt="facebook_logo" style="width: 50px; height: auto"/>
            </div>

            <div role="tabpanel" class="tab-pane" id="scheduled">
                <h3>Scheduled</h3>
                <h4>Plan: 01.05.2017 at 00:00
                    <br>Happy Birthday, Mary!</h4><br>
                    <img src="/image/pusheencat.png" alt="last_picture" style="width: 200px; height: auto"/>
                <p class="lead"> Post in:</p>
                    <img src="/image/twitter.png" alt="twitter_logo" style="width: 50px; height: auto"/>
                    <img src="/image/facebook.png" alt="facebook_logo" style="width: 50px; height: auto"/>
            </div>
        </div>

    </div>
</template>

<style>
    .home-panel {
        height: auto;
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

            }
        },

        mounted() {
            console.log("Home component mounted.")
        },

        methods: {

        }
    }

</script>