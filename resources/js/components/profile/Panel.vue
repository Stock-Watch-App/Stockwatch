<template>
  <div class="dashboard-wrap">
    <img
      src="../../../../storage/app/public/avatar-default.svg"
      title="Profile image"
      class="profile-pic"
      width="50px"
      height="50px"
    />
    <h4>{{ user.name }}</h4>
    <div class="dash-cards-wrap mg-btm-lg">
      <h3 class="mg-btm-lg">Summary</h3>
      <div class="funds-wrap">
        <div class="funds">
          <h1 class="net-worth">Net worth: $200 {{ networth | currency }}</h1>
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
    networth: Number
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
