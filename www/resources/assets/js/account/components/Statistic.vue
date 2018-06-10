<template>
    <div class="panel panel-default statistic-panel">
        <div class="panel-body">
            <h3>Like statistics page</h3>
            <div id="loader" v-if="showLoader" style="text-align:center;">
                <svg width="120" height="30" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg" fill="#127cd0">
                    <circle cx="15" cy="15" r="15">
                        <animate attributeName="r" from="15" to="15"
                                 begin="0s" dur="0.8s"
                                 values="15;9;15" calcMode="linear"
                                 repeatCount="indefinite" />
                        <animate attributeName="fill-opacity" from="1" to="1"
                                 begin="0s" dur="0.8s"
                                 values="1;.5;1" calcMode="linear"
                                 repeatCount="indefinite" />
                    </circle>
                    <circle cx="60" cy="15" r="9" fill-opacity="0.3">
                        <animate attributeName="r" from="9" to="9"
                                 begin="0s" dur="0.8s"
                                 values="9;15;9" calcMode="linear"
                                 repeatCount="indefinite" />
                        <animate attributeName="fill-opacity" from="0.5" to="0.5"
                                 begin="0s" dur="0.8s"
                                 values=".5;1;.5" calcMode="linear"
                                 repeatCount="indefinite" />
                    </circle>
                    <circle cx="105" cy="15" r="15">
                        <animate attributeName="r" from="15" to="15"
                                 begin="0s" dur="0.8s"
                                 values="15;9;15" calcMode="linear"
                                 repeatCount="indefinite" />
                        <animate attributeName="fill-opacity" from="1" to="1"
                                 begin="0s" dur="0.8s"
                                 values="1;.5;1" calcMode="linear"
                                 repeatCount="indefinite" />
                    </circle>
                </svg>
            </div>
            <canvas id="myChart" style="width: auto; max-width: 850px; height: 400px;"></canvas>
        </div>
    </div>
</template>

<style>
    .statistic-panel {
        height: auto;
    }
</style>

<script>
    export default {
        data() {
            return {
                showLoader: true,
                labels: [],
                likes: []
            }
        },

        mounted() {
            this.getStatistics();
        },

        methods: {
            createChart() {
                const ctx = document.getElementById("myChart").getContext('2d');
                let facebookData = [];
                let twitterData = [];

                $.each(this.likes, function(index, value) {
                    facebookData.push(value.facebook);
                    twitterData.push(value.twitter);
                });

                this.showLoader = false;
                const myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: this.labels,
                        datasets: [
                            {
                                label: "Twitter",
                                fill: false,
                                lineTension: 0.1,
                                backgroundColor: "rgba(75,192,192,0.4)",
                                borderColor: "rgba(75,192,192,1)",
                                borderCapStyle: 'butt',
                                borderDash: [],
                                borderDashOffset: 0.0,
                                borderJoinStyle: 'miter',
                                pointBorderColor: "rgba(75,192,192,1)",
                                pointBackgroundColor: "#fff",
                                pointBorderWidth: 1,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                                pointHoverBorderColor: "rgba(220,220,220,1)",
                                pointHoverBorderWidth: 2,
                                pointRadius: 1,
                                pointHitRadius: 10,
                                data: twitterData,
                                spanGaps: false,
                            },
                            {
                                label: "Facebook",
                                fill: false,
                                lineTension: 0.1,
                                backgroundColor: "rgba(75, 79, 192, 0.8)",
                                borderColor: "rgb(131, 75, 192)",
                                borderCapStyle: 'butt',
                                borderDash: [],
                                borderDashOffset: 0.0,
                                borderJoinStyle: 'miter',
                                pointBorderColor: "rgba(75,192,192,1)",
                                pointBackgroundColor: "#fff",
                                pointBorderWidth: 1,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: "rgba(75, 79, 192, 0.8)",
                                pointHoverBorderColor: "rgb(131, 75, 192)",
                                pointHoverBorderWidth: 2,
                                pointRadius: 1,
                                pointHitRadius: 10,
                                data: facebookData,
                                spanGaps: false,
                            }
                        ]
                    },
                    options: {
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        },
                        scales: {
                            xAxes: [{
                                display: true
                            }]
                        }
                    }
                });
            },

            getStatistics() {
                this.$http.get('/statistics/likes')
                    .then((data) => {
                        // success callback
                        if (data.body.message !== undefined) {
                            toastr.warning(data.body.message, 'Warning');
                            return;
                        } else {
                            this.labels = data.body.labels;
                            this.likes = data.body.likes;

                            // TODO add calculate labels
                            // TODO add calculate data

                            this.showStatistics();
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
            },

            /**
             * Show statistics
             */
            showStatistics() {
                this.createChart();
            }
        }
    }
</script>