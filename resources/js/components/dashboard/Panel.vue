<template>
 <ul class="stock-cards">
        <stock-card
            v-for="stock in stocks"
            :key="stock.id"
            :stock="stock"
        />
    </ul>
</template>

<script>
    import StockCard from './StockCard.vue';
    export default {
        props: [
            'stocks'
        ]
    }
</script>

<style scoped>

</style>
