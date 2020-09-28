<template>
    <div class="small">
        <line-chart v-if="datacollection" :chart-data="datacollection" :options="options"></line-chart>
    </div>
</template>

<script>
import LineChart from "../LineChart.js";

export default {
    props: {
        sortedRatings: Object,
        sortedPrices: Object
    },
    components: {
        LineChart
    },
    data() {
        return {
            datacollection: null,
            responsive: true,
            options: {
                tooltips: {
                    callbacks: {
                        label: function (tooltipItems, data) {
                            let label = data.datasets[tooltipItems.datasetIndex].label
                            if (label === 'Price') {
                                return 'Price: $' + parseFloat(tooltipItems.value).toFixed(2);
                            } else {
                                return label + ': ' + tooltipItems.value;
                            }
                        }
                    }
                },
                scales: {
                    yAxes: [{
                        display: true,
                        id: 'ratings',
                        precision: 0,
                        ticks: {
                            min: 1,
                            max: 10
                        }
                    }, {
                        display: true,
                        id: 'prices',
                        position: 'right',
                        precision: 2,
                        ticks: {
                            beginAtZero: true,
                            maxTicksLimit: 9,
                            suggestedMax: 9,
                            callback: function (value, index, values) {
                                return '$' + value.toFixed(2);
                            }
                        }
                    },
                    ]
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
            let colors = {
                'Taran': {
                    solid: 'rgba(0,0,255,1)',
                    transparent: 'rgba(0,0,255,.3)'
                },
                'Brent': {
                    solid: 'rgba(0,0,0,1)',
                    transparent: 'rgba(0,0,0,.3)'
                },
                'Melissa': {
                    solid: 'rgba(0,255,0,1)',
                    transparent: 'rgba(0,255,0,.3)'
                },
                'Audience': {
                    solid: 'rgba(255,255,0,1)',
                    transparent: 'rgba(255,255,0,.3)'
                },
                'Average': {
                    solid: 'rgba(255,0,0,1)',
                    transparent: 'rgba(255,0,0,.3)'
                },
                'Prices': {
                    solid: 'rgba(255,69,0,1)',
                    transparent: 'rgba(255,69,0,.3)'
                },
            }

            for (const week in this.sortedRatings['Average']) {
                labels.push('Week ' + week);
            }
            for (const lfc in this.sortedRatings) {
                datasets.push({
                    label: lfc,
                    backgroundColor: colors[lfc].transparent,
                    borderColor: colors[lfc].solid,
                    yAxisID: 'ratings',
                    fill: false,
                    data: Object.values(this.sortedRatings[lfc])
                })
            }
            datasets.push({
                label: 'Price',
                backgroundColor: colors['Prices'].transparent,
                borderColor: colors['Prices'].solid,
                yAxisID: 'prices',
                fill: false,
                data: Object.values(this.formattedPrices)
            })
            this.datacollection = {
                labels,
                datasets
            };
        }
    },
    computed: {
        formattedPrices: function () {
            let prices = [];
            Object.values(this.sortedPrices).forEach(p => {
                console.log(parseFloat(p).toFixed(2));
                prices.push(parseFloat(p).toFixed(2));
            })
            return prices
        }
    }
};
</script>
