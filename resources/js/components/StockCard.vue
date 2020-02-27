<template>
    <li class="card stockcard" v-bind:class="[houseguestDetails.isActive ? '' : 'inactive']">
        <div class="hg-img">
            <img src="/storage/avatar-default.svg" />
        </div>
        <div class="hg-details flex-col">
            <p>{{ houseguestDetails.name }}</p>
            <span class="rating-wrap flex-row">
                <font-awesome-icon icon="star" class="hg-star" />
                <span class="num-wrap flex-row">
                    <span class="hg-star-rating">{{ houseguestDetails.currentRating }}</span>
                    <span> / 10</span>
                </span>
            </span>
        </div>
        <div class="hg-price">
            <span class="price-wrap">
                <h3>${{ houseguestDetails.currentPrice }}</h3>
            </span>
            <span class="price-change-wrap flex-row" v-bind:class="[isPos ? 'green' : 'red']">
                <font-awesome-icon icon="arrow-up"/>
                <!-- need a check for up, down, no-change -->
                <!-- <font-awesome-icon icon="arrow-down"/>
                <font-awesome-icon icon="arrow-right"/> -->
                <p>{{ houseguestDetails.priceDifference }} from last week</p>
            </span>
        </div>
        <div class="input-wrap">
            <number-input v-model="value" controls>
            </number-input>
        </div>
        <div class="btn-wrap">
            <button class="button-base primary ghost xsmall">Sell all</button>
            <button class="button-base primary ghost xsmall">Buy all</button>
        </div>
    </li>
</template>

<script>
    export default {
        props: {
            houseguestDetails: {
                name: String,
                currentRating: Number,
                currentPrice: Number,
                priceDifference: Number,
                photo: '/storage/avatar-default.svg',
                isActive: Boolean
            }
        }
    }
</script>