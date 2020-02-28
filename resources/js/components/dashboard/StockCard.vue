<template>
    <li class="card stockcard" v-bind:class="[stock.houseguest.status === 'active' ? '' : 'inactive']">
        <div class="hg-img">
            <img src="/storage/avatar-default.svg"/>
        </div>
        <div class="hg-details flex-col">
            <p>{{ stock.houseguest.nickname || stock.houseguest.first_name | capitalize }}</p>
            <span class="rating-wrap flex-row">
                <font-awesome-icon icon="star" class="hg-star"/>
                <span class="num-wrap flex-row">
                    <span class="hg-star-rating">{{ currentRating }}</span>
                    <span> / 10</span>
                </span>
            </span>
        </div>
        <div class="hg-price" v-bind:class="[isPos ? 'green-bg' : 'red-bg']">
            <span class="price-wrap">
                <h3>{{ currentPrice | currency }}</h3>
            </span> <span class="price-change-wrap flex-row" v-bind:class="[isPos ? 'green' : 'red']">
                <font-awesome-icon :icon="priceDifference.icon" class="price-diff-icon"/>
                <p class="price-diff">{{ priceDifference.amount | currency }} from last week</p>
            </span>
        </div>
        <div class="input-wrap">
            <button class="button-base primary ghost small buy" @click="sellAll">Sell all</button>
            <number-input v-model="stock.quantity" controls>
            </number-input>
            <button class="button-base primary ghost small sell" @click="buyMax">Buy max</button>
        </div>
        <!-- <div class="btn-wrap">
            <button class="button-base primary ghost xsmall">Sell all</button>
            <button class="button-base primary ghost xsmall">Buy all</button>
        </div> -->
    </li>
</template>

<script>
    export default {
        props: {
            stock: Object
        },
        data() {
            return {
                //
            }
        },
        methods: {
            reset: function() {
                //ask parent to reset the card data
            },
            buyMax: function() {
                //this needs to be mutated from the parent because of the bank
            },
            sellAll: function() {
                //this needs to be mutated from the parent because of the bank
            },
        },
        computed: {
            isPos: function () {
              return true;
            },
            currentPrice: function () {
                //find latest week
                return 13;
            },
            currentRating: function () {
                //find latest week
                return 6;
            },
            priceDifference: function () {
                //find latest week and week before
                return {
                    icon: 'arrow-up',
                    amount: 3
                };
            }
        }
    }
</script>
