<template>
    <div class="user-panel">
        <div class="funds">
            <p>Available Funds</p>
            <h1>{{ fluidCash | currency }}</h1>
        </div>
        <div class="fund-history">
            <p>Net worth: {{ netWorth | currency }}</p>
            <p>Leaderboard rank: {{ rank }}</p>
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
            fluidCash: String,
            netWorth: String
        },
        data() {
            return {
                //
            }
        },
        methods: {
           //
        },
        computed: {
            fluidCash: function () {
              return 200;
            },

            netWorth: function() {
                return 200;
            },

            rank: function () {
                return 40;
            }
        }
   }
</script>
