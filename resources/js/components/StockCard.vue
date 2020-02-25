<template>
    <li class="card dark stockcard">
        <img src="/storage/avatar-default.svg" />
        <div class="">
            <h3>{{ houseguestDetails.name }}</h3>
            <span class="rating-wrap">
                <font-awesome-icon icon="star"/>
                <p>{{ houseguestDetails.currentRating }} / 10</p>
            </span>
        </div>
        <div>
            <h2>${{ houseguestDetails.currentPrice }}</h2>
            <span class="price-change-wrap">
                <font-awesome-icon icon="arrow-up"/>
                <p>5 from last week</p>
            </span>
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
                photo: '/storage/avatar-default.svg'
            }
        }
    }
</script>