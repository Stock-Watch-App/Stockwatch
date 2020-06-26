<template>
    <div class="trades-wrap">
        <div class="stock-cards-wrap">
            <ul class="stock-cards">
                <stock-card
                    v-for="stock in stocks"
                    :key="stock.id"
                    :stock="stock"
                    :bank="bank"
                    :disabled="true"
                />
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            stocks: Array,
            season: Object,
        },
        data() {
            return {
                bank: {
                    money: 0
                }
            }
        }
    }
</script>

<style scoped>

</style>
