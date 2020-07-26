<template>
    <div class="profile-page-wrap">
        <div class="profile-details">
            <avatar :user="user" height="60px" width="60px"></avatar>
            <p class="bold">{{ user.name }}</p>
            <p>current rank {{ currentRank }}</p>
            <p>all-time rank {{ user.rank }}</p>
            <p>badges here</p>
        </div>

        <div class="profile-stats-wrap mg-btm-lg">
            <div class="week-picker-wrap mg-btm-sm">
                <h3>Summary</h3>
                <icon-button
                    icon="chevron-left"
                    ariaLabelledById="my-label"
                    buttonLabel="Last week"
                    class="prev-button"
                    @click="mutateRank('down')"
                ></icon-button>
                <select-component
                    v-model.number="selectedWeek"
                    placeholder="Current Week"
                    :options="weekSelectorOptions"
                ></select-component>
                <icon-button
                    icon="chevron-right"
                    ariaLabelledById="my-label"
                    buttonLabel="Next week"
                    class="next-button"
                    @click="mutateRank('up')"
                ></icon-button>
            </div>
            <div class="weekly-stats-wrap">
                <div class="stats-summary">
                    <div class="networth-wrap">
                        <div class="stats">
                            <p>Net worth:</p>
                            <h1>{{ networth | currency }}</h1>
                            <span
                                v-if="networthDiff.amount >= 0"
                                class="stat-change-wrap"
                                :class="networthDiff.class"
                            >
                                <font-awesome-icon
                                    v-if="networthDiff.amount >= 0"
                                    :icon="networthDiff.icon"
                                    size="sm"
                                    class="stat-diff-icon"
                                />
                                <span v-if="networthDiff.amount >= 0">{{
                                    networthDiff.amount | currency
                                }}</span>
                            </span>
                        </div>
                    </div>
                    <div class="rank-wrap">
                        <div class="stats">
                            <p>Rank:</p>
                            <h1>{{ selectedRank }}</h1>
                            <span
                                v-if="rankDiff.amount >= 0"
                                class="stat-change-wrap"
                                :class="rankDiff.class"
                            >
                                <font-awesome-icon
                                    v-if="rankDiff.amount - selectedRank"
                                    :icon="rankDiff.icon"
                                    size="sm"
                                    class="stat-diff-icon"
                                />
                                <span v-if="rankDiff.amount - selectedRank">{{
                                    rankDiff.amount
                                }}</span>
                            </span>
                        </div>
                    </div>
                </div>
                <ul class="stats-cards">
                    <holdings-card-profile
                        v-for="stock in user.stocks"
                        :stock="stock"
                        :houseguests="houseguests"
                        :key="stock.houseguest_id"
                    ></holdings-card-profile>
                </ul>
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
            currentRank: null
        };
    },
    mounted() {},
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
        networth: function() {
            let value = parseFloat(this.bank.money);

            this.user.stocks.forEach(stock => {
                let price = parseFloat(
                    this.houseguests
                        .find(hg => {
                            return hg.id === stock.houseguest_id;
                        })
                        .prices.find(p => {
                            return p.week === this.week;
                        }).price
                );

                value += stock.quantity * price;
            });

            return value;
        },
        networthDiff: function() {
            let lastWeek = Object.assign(
                { networth: 0 },
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
        selectedRank: function() {
            let rank = Object.assign(
                { rank: "N/A" },
                this.user.leaderboard.find(l => {
                    return l.week === this.selectedWeek;
                })
            ).rank;

            this.currentRank = this.currentRank || rank;

            return rank;
        },
        rankDiff: function() {
            let lastWeek = Object.assign(
                { rank: 0 },
                this.user.leaderboard.find(l => {
                    return l.week === this.selectedWeek - 1;
                })
            ).rank;

            let diff =
                this.selectedRank === "N/A" ? 0 : this.selectedRank - lastWeek;
            let isIncrease = diff > 0;

            return {
                amount: Math.abs(diff),
                icon: isIncrease ? "arrow-up" : diff === 0 ? "" : "arrow-down",
                class: isIncrease ? "green" : diff === 0 ? "" : "red"
            };
        },
        weekSelectorOptions: function() {
            let options = [];
            this.user.leaderboard.forEach(l => {
                options.push({ value: l.week, text: "Week " + l.week });
            });
            return options;
        }
    }
};
</script>
