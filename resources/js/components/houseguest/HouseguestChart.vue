<template>
    <div class="container">
        <line-chart
            v-if="datacollection"
            :chart-data="datacollection"
            :options="options"
        ></line-chart>
    </div>
</template>

<script>
import LineChart from "../LineChart.vue";

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
            options: {
                maintainAspectRatio: false,
                responsive: true,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItems, data) {
                            let label =
                                data.datasets[tooltipItems.datasetIndex].label;
                            if (label === "Price") {
                                return (
                                    "Price: $" +
                                    parseFloat(tooltipItems.value).toFixed(2)
                                );
                            } else {
                                return label + ": " + tooltipItems.value;
                            }
                        }
                    }
                },
                // legendCallback: function (chart) {
                //     var text = [];
                //     text.push('<ul class="' + chart.id + '-legend">');
                //     text.push('<li>Click to Toggle:</li>');
                    // for (var i = 0; i < chart.data.datasets.length; i++) {
                    //     text.push('<li><span style="background-color:' + chart.data.datasets[i].backgroundColor + '"></span>');
                    //     if (chart.data.datasets[i].label) {
                    //         text.push(chart.data.datasets[i].label);
                    //     }
                    //     text.push('</li>');
                    // }
                    // text.push('</ul>');
                    // return text.join('');
                // },
                scales: {
                    xAxes: [
                        {
                            gridLines: {
                                display: false
                            }
                        }
                    ],
                    yAxes: [
                        {
                            display: true,
                            id: "ratings",
                            precision: 0,
                            ticks: {
                                min: 1,
                                max: 10
                            },
                            gridLines: {
                                display: false
                            }
                        },
                        {
                            display: true,
                            id: "prices",
                            position: "right",
                            precision: 2,
                            ticks: {
                                beginAtZero: true,
                                maxTicksLimit: 9,
                                suggestedMax: 9,
                                callback: function (value, index, values) {
                                    return "$" + value.toFixed(2);
                                }
                            },
                            gridLines: {
                                display: false
                            }
                        }
                    ]
                }
            }
        };
    },
    mounted() {
        this.fillData();
        // this.generateLegend();
    },
    methods: {
        fillData() {
            let labels = [];
            let datasets = [];
            let colors = {
                Taran: {
                    solid: " hsl(224, 90%, 53%)",
                    transparent: "hsla(224, 90%, 53%, 0.2)"
                },
                Guest: {
                    solid: "hsl(320, 91%, 52%)",
                    transparent: "hsla(320, 91%, 52%, 0.3)"
                },
                Melissa: {
                    solid: " hsl(272, 100%, 49%)",
                    transparent: " hsla(272, 100%, 49%, 0.3)"
                },
                Audience: {
                    solid: "hsl(183, 97%, 72%)",
                    transparent: "hsla(183, 97%, 72%, 0.3)"
                },
                Average: {
                    solid: " hsl(126, 100%, 49%)",
                    transparent: " hsla(126, 100%, 49%, 0.3)"
                },
                Prices: {
                    solid: "hsl(0, 81%, 58%)",
                    transparent: "hsla(0, 81%, 58%)"
                }
            };

            for (const week in this.sortedRatings["Average"]) {
                labels.push("Week " + week);
            }
            for (const lfc in this.sortedRatings) {
                datasets.push({
                    label: lfc,
                    backgroundColor: colors[lfc].transparent,
                    borderColor: colors[lfc].solid,
                    yAxisID: "ratings",
                    fill: false,
                    data: Object.values(this.sortedRatings[lfc])
                });
            }
            datasets.push({
                label: "Price",
                backgroundColor: colors["Prices"].transparent,
                borderColor: colors["Prices"].solid,
                yAxisID: "prices",
                fill: false,
                data: Object.values(this.formattedPrices)
            });
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
                prices.push(parseFloat(p).toFixed(2));
            });
            return prices;
        }
    }
};
</script>

<style scoped>
.container {
    width: 100%;
}
</style>
