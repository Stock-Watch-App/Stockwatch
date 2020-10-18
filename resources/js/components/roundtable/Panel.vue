<template>
    <div class="roundtable-page-wrap">
        <h1 class="header2">Live Roundtable Ratings</h1>
        <div class="table-wrap mg-btm-md">
            table here
        </div>

        <div class="">
            <h3>Previous Weeks</h3>
            <!-- <div class="week-picker">
                <icon-button
                    icon="chevron-left"
                    ariaLabelledById="my-label"
                    buttonLabel="Last week"
                    class="prev-button"
                    :disabled="selectedWeek === minWeek"
                    @click="mutateRank('down')"
                ></icon-button>
                <select-component
                    v-model.number="selectedWeek"
                    placeholder="Current Week"
                    :options="weekSelectorOptions"
                ></select-component>
                <icon-button
                    icon="chevron-right"
                    ariaLabelledById="my-other-label"
                    buttonLabel="Next week"
                    class="next-button"
                    :disabled="selectedWeek === maxWeek"
                    @click="mutateRank('up')"
                ></icon-button>
            </div> -->
            <div>
                copy table here hooked into week picker above
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        user: Object,
        bank: Object,
        houseguests: Array,
        week: Number
    },
    data() {
        return {
            selectedWeek: this.week,
            minWeek: 2,
            maxWeek: Number, //set in weekSelectorOptions
            currentRank: null
        };
    },
    mounted() {
    },
    watch: {},
    methods: {
        mutateRank(direction) {
            let result =
                direction === "up"
                    ? this.selectedWeek + 1
                    : this.selectedWeek - 1;

            if (this.weekSelectorOptions.find(o => o.value === result)) {
                this.selectedWeek = result;
            }
        }
    },
    computed: {
        networth: function () {
            return this.user.leaderboard.find(l => l.week === this.selectedWeek).networth;
        },
        networthDiff: function () {
            let lastWeek = Object.assign(
                {networth: 0},
                this.user.leaderboard.find(l => {
                    return l.week === this.selectedWeek - 1;
                })
            ).networth;

            let diff = this.networth - lastWeek;
            let isIncrease = diff > 0;

            return {
                amount: Math.abs(diff),
                icon: isIncrease ? "arrow-up" : diff === 0 ? "" : "arrow-down",
                class: isIncrease ? "green" : diff === 0 ? "" : "red"
            };
        },
        selectedRank: function () {
            let rank = Object.assign(
                {rank: "N/A"},
                this.user.leaderboard.find(l => {
                    return l.week === this.selectedWeek;
                })
            ).rank;

            this.currentRank = this.currentRank || rank;

            return rank;
        },
        rankDiff: function () {
            let lastWeek = Object.assign(
                {rank: 0},
                this.user.leaderboard.find(l => {
                    return l.week === this.selectedWeek - 1;
                })
            ).rank;

            let diff =
                this.selectedRank === "N/A" ? 0 : this.selectedRank - lastWeek;
            let isIncrease = diff > 0;

            return {
                amount: Math.abs(diff),
                icon: isIncrease ? "arrow-down" : diff === 0 ? "" : "arrow-up",
                class: isIncrease ? "red" : diff === 0 ? "" : "green"
            };
        },
        weekSelectorOptions: function () {
            let options = [];
            this.user.leaderboard.forEach(l => {
                options.push({value: l.week, text: "Week " + l.week});
                this.maxWeek = l.week;
            });
            return options;
        },
        weeklyStocks: function () {
            let mappedStocks = [];
            let stocks = this.user.leaderboard.find(l => l.week === this.selectedWeek).stocks;
            for (const [key, value] of Object.entries(stocks)) {
                if (value !== 0 && typeof this.houseguests.find(h => h.id === parseInt(key)) !== 'undefined') {
                    mappedStocks.push({
                        houseguest_id: parseInt(key),
                        quantity: value,
                        week: this.selectedWeek
                    });
                }
            }
            ;
            return mappedStocks;
        }
    }
};
</script>
