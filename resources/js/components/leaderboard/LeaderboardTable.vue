<template>
    <div class="leader-grid">
        <label class="label-hidden">Filter by Name:</label>
        <input class="input inline-width input-sharp input-light mg-btm-md" placeholder="Search user..." v-model="filters.name.value"/>
        <div class="table-wrap mg-btm-md">
            <v-table
                :data="rankedLeaderboard"
                :filters="filters"
                :currentPage.sync="currentPage"
                :pageSize="100"
                @totalPagesChanged="totalPages = $event"
                class="leaderboard-table"
            >
                <thead slot="head">
                    <tr>
                        <v-th sortKey="rank" defaultSort="asc" class="rank-sort">Rank</v-th>
                        <th class="user-row-head">Player</th>
                        <th>Networth</th>
                        <th v-for="houseguest in houseguests" v-bind:key="houseguest.id"
                        >
                            <img :src="houseguestImage(houseguest)" :alt="houseguest.nickname" class="hg-img-table">
                        </th>
                    </tr>
                </thead>
                <tbody slot="body" slot-scope="{displayData}">
                <tr v-for="leaderboard in displayData" :key="leaderboard.user_id">
                    <td>
                        <div class="rank-num" :class="leaderboard.rank.class">
                            {{ leaderboard.rank.rank }}
                        </div>
                    </td>
                    <td class="user-row">
                        <span>{{ leaderboard.user.name }}</span>
                        <span v-if="leaderboard.user.id === (4 || 6 || 9)" class="tag lfc">LFC</span>
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
            rank: {
                rank: 0,
                class: null
            },
            // lastMoney: 0
        }),
        computed: {
            rankedLeaderboard: function () {
                let rank = 1;
                let ranked = [];
                for (let leaderboard of this.leaderboard) {
                    let newRank = {
                        rank: 0,
                        class: null
                    };
                    newRank.rank = rank;
                    switch (rank) {
                        case 1:
                            newRank.class = 'rank-1';
                            break;
                        case 2:
                            newRank.class = 'rank-2';
                            break;
                        case 3:
                            newRank.class = 'rank-3';
                            break;
                        default:
                            newRank.class = '';
                            break;
                    }
                    leaderboard.rank = newRank;
                    ranked.push(leaderboard);
                    rank++;
                }
                return ranked;
            }
        },
        methods: {
            getUserRank: function () {
                this.rank.rank++;
                switch (this.rank.rank) {
                    case 1:
                        this.rank.class = 'rank-1';
                        break;
                    case 2:
                        this.rank.class = 'rank-2';
                        break;
                    case 3:
                        this.rank.class = 'rank-3';
                        break;
                    default:
                        this.rank.class = '';
                        break;
                }
                return this.rank.rank;
            },
            houseguestImage: function (houseguest) {
                return '/storage' + houseguest.image;
            },
        },
    }
</script>
