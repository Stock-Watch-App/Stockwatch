<template>
    <div class="leader-grid">
        <label class="label-hidden">Filter by Name:</label>
        <input class="input inline-width input-sharp input-light mg-btm-md" placeholder="Search user..." v-model="filters.name.value"/>
        <div class="table-wrap mg-btm-md">
            <v-table
                :data="leaderboard"
                :filters="filters"
                :currentPage.sync="currentPage"
                :pageSize="100"
                @totalPagesChanged="totalPages = $event"
                class="leaderboard-table"
            >
                <thead slot="head">
                <v-th sortKey="rank" defaultSort="asc" class="rank-sort">Rank</v-th>
                <th>Player</th>
                <th>Networth</th>
                <th v-for="houseguest in houseguests" v-bind:key="houseguest.id"
                >
                    <img :src="houseguestImage(houseguest)" :alt="houseguest.nickname" class="hg-img-table">
                </th>
                </thead>
                <tbody slot="body" slot-scope="{displayData}">
                <tr v-for="leaderboard in displayData" :key="leaderboard.id">
                    <td>
                        <div class="rank-num" v-bind:class="{'rank-1':leaderboard.id == 1, 'rank-2':leaderboard.id == 2, 'rank-3':leaderboard.id == 3}">
                            {{ leaderboard.id }}
                        </div>
                    </td>
                    <td class="user-row">
                        <span>{{ leaderboard.user.name }}</span>
                        <!-- <span class="tag lfc">{{ row.attribute }}</span> -->
                        <!-- <span class="tag rank-1"><font-awesome-icon icon="trophy"/></span> -->
                    </td>
                    <td class="networth">{{ leaderboard.networth | currency }}</td>
                    <td v-for="houseguest in houseguests" v-bind:key="houseguest.id">
                        {{ leaderboard.stocks[houseguest.id]}}
                    </td>
                </tr>
                </tbody>
            </v-table>
        </div>

        <smart-pagination
            :currentPage.sync="currentPage"
            :totalPages="totalPages"
        />
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
                name: {value: '', keys: ['user.name']}
            },
            currentPage: 1,
            totalPages: 0,
            // lastRank: 0,
            // lastMoney: 0
        }),
        methods: {
            // rankIterator: function(user) {
            //     let lastRank = this.lastRank
            //     if (this.lastMoney == user.networth) {
            //         return 'T-'+this.lastRank;
            //     }
            //     this.lastRank++;
            //     this.lastMoney = user.netWorth;
            //     return this.lastRank; //because the iterator is above,
            // },
            houseguestImage: function (houseguest) {
                return '/storage' + houseguest.image;
            },
        },
    }
</script>
