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
            responsive: true
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
        }
    }
};
</script>

<style>
/* .chart {
    height: 400px;
    width: 800px;
} */
</style>
