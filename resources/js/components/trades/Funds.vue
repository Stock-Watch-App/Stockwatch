<template>
  <div class="funds-wrap">
    <div class="funds">
      <p class="avail-funds">Available Funds</p>
      <h1 v-bind:class="[this.inthered() ? 'red-text' : '']">{{ bank.money | currency }}</h1>
      <p class="net-worth">Net worth: {{ networth | currency }}</p>
    </div>
    <!-- <div class="fund-history"> -->
    <!--            <p>Leaderboard rank: {{ rank }}</p>-->
    <!-- </div> -->
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
    };
  },
  methods: {
    inthered() {
      return this.bank.money < 0;
    }
  },
  computed: {
    // rank: function () {
    //     return 40;
    // }
  }
};
</script>
