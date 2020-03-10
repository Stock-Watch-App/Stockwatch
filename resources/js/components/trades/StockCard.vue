<template>
    <li class="card stockcard" v-bind:class="[stock.houseguest.status === 'active' ? '' : 'inactive']">
        <div class="hg-details">
            <h5>{{ stock.houseguest.nickname || stock.houseguest.first_name | capitalize }}</h5>
        </div>
        <div class="hg-img">
            <img :src="houseguestImage"/>
        </div>
        <div class="hg-rating">
            <span class="rating-wrap">
                <h3 class="num-wrap flex-row">
                    <font-awesome-icon icon="star" class="hg-star"/>
                    <span class="hg-star-rating">{{ currentRating }}</span>
                    <span class="hg-star-outof"> /10</span>
                </h3>
            </span>
        </div>
        <div class="hg-price" v-bind:class="priceDifference.class.background">
            <span class="price-wrap">
                <h3>{{ currentPrice | currency }}</h3>
            </span>
            <span v-if=" priceDifference.amount >= 0" class="price-change-wrap flex-row" v-bind:class="priceDifference.class.text">
                <font-awesome-icon :icon="priceDifference.icon" class="price-diff-icon"/>
                <p class="price-diff">{{ priceDifference.amount | currency }}</p>
            </span>
        </div>
        <div class="input-wrap">
            <button v-if="!disabled" class="button-base primary ghost small sell" @click="sellAll">Sell all</button>
            <number-input
                v-model="stock.quantity"
                :min="0"
                :max="bank.money < parseFloat(currentPrice)?stock.quantity:stock.quantity+1"
                controls
                :disabled="disabled"
            ></number-input>
            <button v-if="!disabled" class="button-base primary ghost small buy" @click="buyMax">Buy max</button>
            <button v-if="!disabled" class="button-base link icon-col small" @click="reset">
                <font-awesome-icon icon="undo-alt"/>
                reset
            </button>
        </div>
    </li>
</template>

<script>
    export default {
        props: {
            stock: Object,
            bank: Object,
            disabled: Boolean
        },
        data() {
            return {
                originalStock: _.cloneDeep(this.stock),
            }
        },
        methods: {
            reset: function () {
                this.stock.quantity = this.originalStock.quantity;
            },
            buyMax: function () {
                //this needs to be mutated from the parent because of the bank
                this.$emit('buy-max', {
                    houseguest: this.stock.houseguest_id
                })
            },
            sellAll: function () {
                //this needs to be mutated from the parent because of the bank
                this.$emit('sell-all', {
                    houseguest: this.stock.houseguest_id
                })
            }
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
