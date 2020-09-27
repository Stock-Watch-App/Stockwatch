<template>
    <div class="small">
        <line-chart v-if="datacollection" :chart-data="datacollection" :options="options"></line-chart>
        <button @click="fillData()">Randomize</button>
    </div>
</template>

<script>
import LineChart from "../LineChart.js";

export default {
    props: {
        sortedRatings: Object
    },
    components: {
        LineChart
    },
    data() {
        return {
            datacollection: null,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        };
    },
    mounted() {
        this.fillData();
    },
    methods: {
        fillData() {
            let labels = [];
            let datasets = [];

            for(const week in this.sortedRatings['Average']) {
                labels.push('Week ' + week);
            }
            for(const lfc in this.sortedRatings) {
                datasets.push({
                    label: lfc.split(' ').shift(),
                    backgroundColor: '#f87979',
                    data: Object.values(this.sortedRatings[lfc])
                })
            }

            this.datacollection = {
                labels,
                datasets
            };
        },
        getRandomInt() {
            return Math.floor(Math.random() * (50 - 5 + 1)) + 5;
        }
    }
};
</script>

<style>
.small {
    max-height: 600px;
    margin: 150px auto;
}
</style>
