<template>
    <li class="card stockcard">
        <div class="hg-details">
            <!-- <h5>{{ houseguest.nickname || houseguest.first_name | capitalize }}</h5> -->
            <p>HG name</p>
            <!-- <p>{{ user.stocks }}</p> -->
        </div>
        <div class="hg-img">
            <!-- <img v-for="houseguest in houseguests" v-bind:key="houseguest.id" :src="houseguestImage" :alt="houseguest.nickname" /> -->
            <img src="/storage/avatar-default.svg" />
        </div>
    </li>
</template>

<script>
    export default {
        props: {
            houseguests: Object,
            stock: Object,
            bank: Object,
            disabled: Boolean,
        },
        data() {
            return {
                // originalStock: _.cloneDeep(this.stock),
            }
        },
        methods: {
        },
        computed: {
            houseguestImage: function () {
              return '/storage'+this.stock.houseguest.image;
            },
            currentPrice: function () {
                //find latest week
                let currentWeek;
                this.stock.houseguest.prices.forEach(week => {
                    if (typeof currentWeek === 'undefined' || week.week > currentWeek.week) {
                        currentWeek = week;
                    }
                });

                this.$emit('current-price', {
                    houseguest: this.stock.houseguest_id,
                    price: currentWeek.price
                });

                return currentWeek.price;
            },
            currentRating: function () {
                //find latest week
                let currentWeek = [];
                this.stock.houseguest.ratings.forEach(week => {
                    if (typeof currentWeek[week.user_id] === 'undefined' || week.week > currentWeek[week.user_id].week) {
                        currentWeek[week.user_id] = week;
                    }
                });

                let total = 0;
                currentWeek.forEach(rating => {
                    total += rating.rating;
                });
                return Math.round(total / 4);
            },
            priceDifference: function () {
                if (this.stock.houseguest.prices.length === 1) {
                    return {
                        amount: -1, //because we use abs(), we will never have a negative number. Thus we can use it as a check.
                        icon: '',
                        class: ''
                    };
                }

                //find latest week and week before
                let currentWeek;
                let lastWeek;
                this.stock.houseguest.prices.forEach(week => {
                    if (typeof currentWeek === 'undefined') {
                        currentWeek = week;
                    } else if (week.week > currentWeek.week) {
                        lastWeek = currentWeek;
                        currentWeek = week;
                    }
                });

                let diff = currentWeek.price - lastWeek.price;
                let isIncrease = (diff > 0);

                return {
                    amount: Math.abs(diff),
                    icon: (isIncrease | diff === 0? 'arrow-up' : 'arrow-down'),
                    class: {
                        background: (isIncrease ? 'green-bg' : (diff === 0 ? '' : 'red-bg')),
                        text: (isIncrease ? 'green' : (diff === 0 ? '' : 'red'))
                    }
                };
            }
        }
    }
</script>
