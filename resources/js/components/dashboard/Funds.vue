<template>
    <div class="user-panel">
        <div class="funds">
            <p>Available Funds</p>
            <h1>{{ bank.money | currency }}</h1>
        </div>
        <div class="fund-history">
            <p>Net worth: {{ networth | currency }}</p>
<!--            <p>Leaderboard rank: {{ rank }}</p>-->
        </div>
        <div class="flex-col trade">
            <!-- enable button when input fields become active -->
            <button class="button-base secondary" @click="x" disabled>Submit trade</button>
            <!-- enable button when submit button becomes active -->
            <button class="button-base link" @click="x">Cancel</button>
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
           x() {

           }
        },
        computed: {
            // rank: function () {
            //     return 40;
            // }
        }
   }
</script>
