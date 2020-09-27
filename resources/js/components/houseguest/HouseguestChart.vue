<template>
    <line-chart :chart-data="datacollection"></line-chart>
</template>

<script>
import LineChart from "../LineChart.js";

export default {
    props: {
        // sortedRatings: Array
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
            this.datacollection = {
                // labels: [one, two, three],
                datasets: [
                    {
                        label: "Rating",
                        backgroundColor: "hsla(224, 90%, 53%, 0.8)",
                        borderColor: "hsla(224, 90%, 53%)",
                        pointBackgroundColor: "white",
                        borderWidth: 1,
                        pointBorderColor: "white",
                        data: [2, 9, 6]
                    },
                    {
                        label: "Price",
                        backgroundColor: "hsl(22.5, 95.1%, 40.2%, 0.8)",
                        borderColor: "hsl(22.5, 95.1%, 40.2%)",
                        pointBackgroundColor: "white",
                        borderWidth: 1,
                        pointBorderColor: "white",
                        data: [2.5, 4.6, 7.5]
                    }
                ]
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
