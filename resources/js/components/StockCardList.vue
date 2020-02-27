<template>
    <ul class="stock-cards">
        <StockCard
            v-for="houseguestDetail in houseguestDetails"
            :key="houseguestDetail.id"
            :houseguestDetails="houseguestDetail"
        />
    </ul>
</template>

<script>
    import StockCard from './StockCard.vue';

    export default {
        components: {
            StockCard
        },
        data() {
            return {
                houseguestDetails: [
                    {
                        image: 'https://source.unsplash.com/collection/190727/400x400?1',
                        name: "Jess",
                        currentPrice: "30",
                        currentRating: "5",
                        priceDifference: "2",
                        isActive: true
                    },
                    {
                        image: 'https://source.unsplash.com/collection/190727/400x400?2',
                        name: "Jerry",
                        currentPrice: "300",
                        currentRating: "5",
                        priceDifference: "12",
                        isActive: false
                    },
                    {
                        image: 'https://source.unsplash.com/collection/190727/400x400?3',
                        name: "Matt",
                        currentPrice: "330",
                        currentRating: "8",
                        priceDifference: "20",
                        isActive: true
                    },
                    {
                        image: 'https://source.unsplash.com/collection/190727/400x400?4',
                        name: "Justin",
                        currentPrice: "10",
                        currentRating: "9",
                        priceDifference: "0",
                        isActive: true
                    }
                ]
            }
        }
    }
</script>