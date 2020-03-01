<template>
    <div class="dashboard-wrap">
        <div class="user-details">
            <funds
                :bank="mutablebank"
                :networth="networth"
            ></funds>
        </div>
        <div class="flex-col trade">
            <!-- enable button when input fields become active -->
            <button class="button-base secondary" @click="submit" disabled>Submit trade</button>
            <!-- enable button when submit button becomes active -->
            <button class="button-base link" @click="resetAll">Cancel</button>
        </div>
        <div class="stock-cards-wrap">
            <ul class="stock-cards">
                <stock-card
                    v-for="stock in mutableStocks"
                    :key="stock.id"
                    :stock="stock"
                    v-on:current-price="saveCurrentPrice"
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
                prices: [],
            }
        },
        watch: {
            mutableStocks: {
                handler(mutatedStocks, oldVal) {
                    let stockTotal = 0;
                    let prices = this.prices;
                    mutatedStocks.forEach((stock) => {
                        stockTotal += stock.quantity * prices[stock.houseguest_id];
                    });
                    this.mutablebank.money = this.networth - stockTotal;
                },
                deep: true
            }
        },
        methods: {
            saveCurrentPrice(value) {
                this.prices[value.houseguest] = parseFloat(value.price);
            },
            submit() {
                //save to DB
            },
            resetAll() {
                //reset to initial values
            }
        },
        computed: {
            networth: function () {
                let stockTotal = 0;
                // add up all the stock and multiply by their prices
                return parseFloat(this.bank.money + stockTotal);
            },
        }
    }
</script>

<style scoped>

</style>
