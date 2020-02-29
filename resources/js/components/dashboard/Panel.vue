<template>
    <div>

        <div class="user-details">
            <funds
                :bank="mutablebank"
                :networth="networth"
            ></funds>
        </div>
        <div class="stock-cards-wrap">
            <ul class="stock-cards">
                <stock-card
                    v-for="stock in mutableStocks"
                    :key="stock.id"
                    :stock="stock"
                />
            </ul>
        </div>
    </div>
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
                mutablebank: _.cloneDeep(this.bank),
            }
        },
        computed: {
            networth: function () {
                let stockTotal = 0;
                // add up all the stock and multiply by their prices
                return this.bank.money + stockTotal;
            },
        }
    }
</script>

<style scoped>

</style>
