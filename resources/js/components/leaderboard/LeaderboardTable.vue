<template>
  <div class="leader-grid">
    <label class="label-hidden">Filter by Name:</label>
    <input
      class="input inline-width input-light mg-btm-md"
      placeholder="Search user..."
      v-model="filters.name.value"
    />
    <div class="leader-overflow">
      <div class="table-wrap mg-btm-md">
        <v-table
          :data="cleanLeaderboard"
          :hideSortIcons="true"
          :filters="filters"
          :currentPage.sync="currentPage"
          :pageSize="100"
          @totalPagesChanged="totalPages = $event"
          class="leaderboard-table"
        >
          <thead slot="head">
            <tr>
              <th class="rank-sort">Rank</th>
              <th class="user-row-head">Player</th>
              <th>Networth</th>
              <th v-for="houseguest in houseguests" v-bind:key="houseguest.id">
                <img
                  :src="houseguestImage(houseguest)"
                  :alt="houseguest.nickname"
                  class="hg-img-table"
                  height="30"
                  width="30"
                />
              </th>
            </tr>
          </thead>
          <tbody slot="body" slot-scope="{displayData}">
            <tr v-for="leaderboard in displayData" :key="leaderboard.user_id">
              <td>
                <div class="rank-num" :class="'rank-'+leaderboard.rank">{{ leaderboard.rank }}</div>
              </td>
              <td class="user-row">
                <span>{{ leaderboard.user.name }}</span>
                <span
                  v-if="leaderboard.user.id === 4 || leaderboard.user.id === 6 || leaderboard.user.id === 9"
                  class="tag lfc"
                >LFC</span>
                <!-- <span class="tag rank-1"><font-awesome-icon icon="trophy"/></span> -->
              </td>
              <td class="networth">{{ leaderboard.networth | currency }}</td>
              <td
                v-for="houseguest in houseguests"
                v-bind:key="houseguest.id"
              >{{ leaderboard.stocks[houseguest.id]}}</td>
            </tr>
          </tbody>
        </v-table>
      </div>
    </div>

    <smart-pagination :currentPage.sync="currentPage" :totalPages="totalPages" />
  </div>
</template>

<script>
export default {
  props: {
    leaderboard: Array,
    houseguests: Array,
  },
  data: () => ({
    filters: {
      name: { value: "", keys: ["user.name"] },
    },
    currentPage: 1,
    totalPages: 0,
    // lastMoney: 0
  }),
  computed: {
    cleanLeaderboard: function () {
      return this.leaderboard.filter((l) => l.user !== null);
    },
  },
  methods: {
    houseguestImage: function (houseguest) {
      return "/storage" + houseguest.image;
    },
  },
};
</script>
