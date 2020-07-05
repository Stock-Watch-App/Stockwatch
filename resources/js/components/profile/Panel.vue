<template>
  <div class="profile-page-wrap">
    <div class="profile-details">
      <avatar height="60px" width="60px"></avatar>
      <p class="bold">{{ user.name }}</p>
      <p>#1000 {{ user.rank }}</p>
    </div>

    <div class="profile-stats-wrap mg-btm-lg">
      <h3 class="mg-btm-lg">Summary</h3>
      <div class="stats-summary">
        <div class="networth-wrap">
          <div class="stats">
            <p>Net worth:</p>
            <h1>$200 {{ networth | currency }}</h1>
            <p class="bodySM">up $20</p>
          </div>
        </div>
        <div class="rank-wrap">
          <div class="stats">
            <p>Rank:</p>
            <h1>#1000</h1>
            <p class="bodySM">down 40</p>
          </div>
        </div>
      </div>
      <ul class="dash-cards">
        <holdings-card-profile
          v-for="stock in user.stocks"
          :stock="stock"
          :houseguests="houseguests"
          :key="stock.houseguest_id"
        ></holdings-card-profile>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    user: Object,
    houseguests: Array,
    bank: Object,
    networth: Number,
    leaderboard: Array
  },
  data() {
    return {
      currentPage: 1,
      totalPages: 0,
      mutableBank: _.cloneDeep(this.bank)
    };
  },
  mounted() {},
  watch: {},
  methods: {
    transactionMessage: function(t) {
      let verb;
      if (t.action === "buy") {
        verb = "bought";
      } else if (t.action === "sell") {
        verb = "sold";
      }

      //find houseguest
      let houseguest;
      for (let hg of this.houseguests) {
        if (hg.id === t.houseguest_id) {
          houseguest = hg;
        }
      }

      return (
        verb +
        " " +
        t.quantity +
        " stock" +
        (t.quantity === 1 ? "" : "s") +
        " of " +
        houseguest.nickname
      );
    }
  },
  computed: {
    //
  }
};
</script>
