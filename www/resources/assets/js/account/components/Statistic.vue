<template>
    <div class="panel panel-default statistic-panel">
        <div class="panel-body">
            <h3>Statistics page</h3>
            <!--
            <img src="/image/stat.png" alt="must be stat"/>
            -->

            <canvas id="myChart" style="width: auto; height: 400px;"></canvas>
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
        mounted() {
            var ctx = document.getElementById("myChart").getContext('2d');

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
                    datasets: [{
                        label: ' Number of Posts',
                        data: [12, 19, 13, 5, 7, 10, 21],
                        backgroundColor: [
                            'rgba(255, 99,  132, 0.5)',
                            'rgba(54,  162, 235, 0.5)',
                            'rgba(255, 206, 86,  0.5)',
                            'rgba(75,  192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                            'rgba(255, 159, 64,  0.5)',
                            'rgba(215, 136, 255, 0.5)'

                        ],
                        borderColor: [
                            'rgba(255, 99,  132, 1)',
                            'rgba(54,  162, 235, 1)',
                            'rgba(255, 206, 86,  1)',
                            'rgba(75,  192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64,  1)',
                            'rgba(215, 136, 255, 1)'
                        ],
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });

            console.log("Home component mounted.")
        }
    }
</script>