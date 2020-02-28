<template>
    <ul class="stock-cards">
        <stock-card
            v-for="stock in mutableStocks"
            :key="stock.id"
            :stock="stock"
        />
    </ul>
</template>

<script>
    import StockCard from './StockCard.vue';

    export default {
        props: {
            stocks: Array,
            bank: Object,
            market: String,
            user: Object
        },
        data() {
            return {
                mutableStocks: _.cloneDeep(this.stocks),
            }
        }
        // mounted() {
        //     alert(this.market);
        // }
    }
</script>

<style scoped>

</style>
