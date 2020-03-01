<template>
    <div>
        <div class="funds">
            <p>Available Funds</p>
            <h1 v-bind:class="[this.inthered() ? 'red-text' : '']">{{ bank.money | currency }}</h1>
        </div>
        <div class="fund-history">
            <p>Net worth: {{ networth | currency }}</p>
<!--            <p>Leaderboard rank: {{ rank }}</p>-->
        </div>
    </div>
</template>

<script>
   export default {
        props: {
            bank: Object,
            networth: Number
        },
        data() {
            return {
                //
            }
        },
        methods: {
            inthered() {
               return (this.bank.money < 0);
            }
        },
        computed: {
            // rank: function () {
            //     return 40;
            // }
        }
   }
</script>
