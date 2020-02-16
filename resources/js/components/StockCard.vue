<template>
    <li class="bg-gray-800 text-white rounded-lg border shadow-md p-3 z-10">
        <img src="/" />
        <h3>{{ houseguestDetails.name }}</h3>
        <div>
            <font-awesome-icon icon="star"/>
            <p>{{ houseguestDetails.currentRating }} / 10</p>
        </div>
        <div>
            <h2>${{ houseguestDetails.currentPrice }}</h2>
            <span>
                <font-awesome-icon icon="arrow-up"/>
                <p>5 from last week</p>
            </span>
        </div>
    </li>
</template>

<script>
    // import TCard from 'vue-tailwind/src/components/TCard.vue'
    //     export default {
    //     components: {
    //         TCard
    //     }
    // }

    // Vue.component("stock-card", {
    //     props: {
    //       image: String,
    //       title: String,
    //       user: String
    //     },

    export default {
        props: {
            houseguestDetails: {
                name: String,
                currentRating: Number,
                currentPrice: Number
            }
        }
    }
</script>