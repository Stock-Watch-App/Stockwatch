<template>
    <li class="card holdingscard">
        <img
            :src="houseguestImage(houseguest)"
            :alt="houseguest.nickname"
            height="50"
            width="50"
        />
        <div class="details-wrap">
            <h4 class="hg-name">
                {{ houseguest.nickname || houseguest.first_name | capitalize }}
            </h4>
            <div class="user-holdings">
                <div>
                    <span class="num">{{ stock.quantity }}</span>
                    <span class="word"
                        >share{{ stock.quantity === 1 ? "" : "s" }}</span
                    >
                </div>
                <div>
                    <span
                        v-if="priceDifference.amount >= 0"
                        class="stock-change-wrap"
                        v-bind:class="priceDifference.class.text"
                    >
                        <font-awesome-icon
                            :icon="priceDifference.icon"
                            size="small"
                            class="stock-diff-icon"
                        />
                        <span class="stock-diff word">3</span>
                    </span>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
export default {
    props: {
        houseguests: Array,
        stock: Object
    },
    data() {
        return {
            //
        };
    },
    methods: {
        houseguestImage: function(houseguest) {
            return "/storage" + houseguest.image;
        }
    },
    computed: {
        houseguest: function() {
            let houseguest;
            for (let hg of this.houseguests) {
                if (hg.id === this.stock.houseguest_id) {
                    houseguest = hg;
                }
            }
            return houseguest;
        },
        // convert this function to stock increase/decrease from prev week
        priceDifference: function() {
            if (this.houseguest.prices.length === 1) {
                return {
                    amount: -1, //because we use abs(), we will never have a negative number. Thus we can use it as a check.
                    icon: "",
                    class: ""
                };
            }

            //find latest week and week before
            let currentWeek;
            let lastWeek;
            this.houseguest.prices.forEach(week => {
                if (typeof currentWeek === "undefined") {
                    currentWeek = week;
                } else if (week.week > currentWeek.week) {
                    lastWeek = currentWeek;
                    currentWeek = week;
                }
            });

            let diff = currentWeek.price - lastWeek.price;
            let isIncrease = diff > 0;

            return {
                amount: Math.abs(diff),
                icon: isIncrease | (diff === 0) ? "plus" : "minus",
                class: {
                    background: isIncrease
                        ? "green-bg"
                        : diff === 0
                        ? ""
                        : "red-bg",
                    text: isIncrease ? "green" : diff === 0 ? "" : "red"
                }
            };
        }
    }
};
</script>
