<template>
  <div class="table-wrap mg-btm-md">
    <v-table
      :data="sortedRatings"
      :hideSortIcons="true"
      :currentPage.sync="currentPage"
      :pageSize="100"
      @totalPagesChanged="totalPages = $event"
      class="leaderboard-table"
    >
      <thead slot="head">
        <tr>
          <th class="rank-sort">Week</th>
          <th class="user-row-head">Brent</th>
          <th>Melissa</th>
          <th>Taran</th>
          <th>Audience</th>
        </tr>
      </thead>
      <tbody slot="body" slot-scope="{ displayData }">
        <tr v-for="sortedRatings in displayData" :key="sortedRatings">
          <td>
            <div class="rank-num"></div>
          </td>
          <td class="user-row"></td>
          <td class="networth"></td>
        </tr>
      </tbody>
    </v-table>
  </div>
</template>

<script>
export default {
  props: {
    sortedRatings: Array,
  },
  computed: {},
  methods: {},
};
</script>
