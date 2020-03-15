<template>
    <div class="leader-grid">
      <label class="label-hidden">Filter by Name:</label>
      <input class="input inline-width input-sharp input-light mg-btm-md" placeholder="Search user..." v-model="filters.name.value"/>

      <v-table
        :data="leaderboard"
        :filters="filters"
        :currentPage.sync="currentPage"
        :pageSize="5"
        @totalPagesChanged="totalPages = $event"
        class="leaderboard-table"
      >
        <thead slot="head">
            <v-th sortKey="rank" defaultSort="asc" class="rank-sort">Rank</v-th>
            <th>User</th>
            <th>Networth</th>
            <!-- <th v-for="houseguest in houseguests" key="houseguest.id"
            ></th> -->
<!--            <th><img :src="houseguestImage" :alt="houseguest.nickname"></th>-->
<!--            <th>houseguest2</th>-->
<!--            <th>houseguest3</th>-->
<!--            <th>houseguest4</th>-->
<!--            <th>houseguest5</th>-->
<!--            <th>houseguest6</th>-->
<!--            <th>houseguest7</th>-->
<!--            <th>houseguest8</th>-->
<!--            <th>houseguest9</th>-->
<!--            <th>houseguest10</th>-->
<!--            <th>houseguest11</th>-->
<!--            <th>houseguest12</th>-->
<!--            <th>houseguest13</th>-->
<!--            <th>houseguest14</th>-->
        </thead>
        <tbody slot="body" slot-scope="{displayData}">
        <tr v-for="leaderboard in displayData" :key="leaderboard.id">
            <td>
                <!-- rank-1 rank-2 rank-3 -->
                <div class="rank-num rank-1">
                    {{ leaderboard.id }}
                </div>
            </td>
            <td class="user-row">
                <span>{{ leaderboard.user_id }}</span>
                <!-- <span class="tag lfc">{{ row.attribute }}</span> -->
                <span class="tag rank-1"><font-awesome-icon icon="trophy"/></span>
            </td>
            <td>{{ leaderboard.networth }}</td>
            <td v-for="stock in stocks" v-bind:key="stock.id">{{ leaderboard.networth }}</td>
<!--            <td>{{ row.houseguest1 }}</td>-->
<!--            <td>{{ row.houseguest2 }}</td>-->
<!--            <td>{{ row.houseguest3 }}</td>-->
<!--            <td>{{ row.houseguest4 }}</td>-->
<!--            <td>{{ row.houseguest5 }}</td>-->
<!--            <td>{{ row.houseguest6 }}</td>-->
<!--            <td>{{ row.houseguest7 }}</td>-->
<!--            <td>{{ row.houseguest8 }}</td>-->
<!--            <td>{{ row.houseguest9 }}</td>-->
<!--            <td>{{ row.houseguest10 }}</td>-->
<!--            <td>{{ row.houseguest11 }}</td>-->
<!--            <td>{{ row.houseguest12 }}</td>-->
<!--            <td>{{ row.houseguest13 }}</td>-->
<!--            <td>{{ row.houseguest14 }}</td>-->
        </tr>
        </tbody>
      </v-table>
      <!-- <smart-pagination
        :currentPage.sync="currentPage"
        :totalPages="totalPages"
      /> -->
      <!-- <nav class="smart-pagination">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link">1</a>
                <a class="page-link">2</a>
                <a class="page-link">3</a>
            </li>
        </ul>
        </nav> -->
        <!-- just put this here to test styles... -->
    </div>
</template>

<script>
    export default {
        name: 'BasicFiltering',
        props: {
            leaderboard: Array
        },
        computed: {
            houseguestImage: function () {
                return '';
            },
        },
        data: () => ({
            filters: {
            name: { value: '', keys: ['username'] }
            },
            currentPage: 1,
            totalPages: 0,
            users: [
                {
                    username: "Katie",
                    rank: "1",
                    netWorth: "200",
                    attribute: "LFC",
                    winner: "BB21",
                    houseguest1: "20",
                    houseguest2: "20",
                    houseguest3: "20",
                    houseguest4: "20",
                    houseguest5: "20",
                    houseguest6: "20",
                    houseguest7: "20",
                    houseguest8: "20",
                    houseguest9: "20",
                    houseguest10: "20",
                    houseguest11: "20",
                    houseguest12: "20",
                    houseguest13: "20",
                    houseguest14: "20",
                },
                {
                    username: "Timothy",
                    rank: "2",
                    netWorth: "200",
                    attribute: "LFC",
                    winner: "BB21",
                    houseguest1: "20",
                    houseguest2: "20",
                    houseguest3: "20",
                    houseguest4: "20",
                    houseguest5: "20",
                    houseguest6: "20",
                    houseguest7: "20",
                    houseguest8: "20",
                    houseguest9: "20",
                    houseguest10: "20",
                    houseguest11: "20",
                    houseguest12: "20",
                    houseguest13: "20",
                    houseguest14: "20",
                }
            ]
        })
    }
</script>
