<template>
    <div class="leader-grid">
        <label class="label-hidden">Filter by Name:</label>
        <form method="GET">
            <input
                class="input inline-width input-light mg-btm-md"
                placeholder="Search user..."
                name="search"
                :value="search"
            />
            <input type="hidden" name="page" value="1" />
            <button type="submit" class="button-base primary mg-btm-lg">Search</button>
        </form>
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
                            <th
                                v-for="houseguest in houseguests"
                                v-bind:key="houseguest.id"
                            >
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
                    <tbody slot="body" slot-scope="{ displayData }">
                        <tr
                            v-for="leaderboard in displayData"
                            :key="leaderboard.user_id"
                        >
                            <td>
                                <div
                                    class="rank-num"
                                    :class="'rank-' + leaderboard.rank"
                                    v-tooltip="'Top ' + leaderboard.rank_percentile + '%'"
                                >
                                    {{ leaderboard.rank }}
                                </div>
                            </td>
                            <td class="user-row">
                                 <avatar :user="leaderboard.user" height="25" width="25" class="leaderboard-avatar"></avatar>
                                <span>{{ leaderboard.user.name }}</span>
                                <vanity-tag v-if="leaderboard.user.vanitytags" :label="leaderboard.user.vanitytags.tag"></vanity-tag>
                                <first-badge
                                v-if="leaderboard.user.id === 1727"
                                class="leaderboard-badge"
                                v-tooltip="'BB21 1st'"
                            ></first-badge>
                            <second-badge
                                v-if="leaderboard.user.id === 1068"
                                class="leaderboard-badge"
                                v-tooltip="'BB21 2nd'"
                            ></second-badge>
                            <third-badge
                                v-if="leaderboard.user.id === 341"
                                class="leaderboard-badge"
                                v-tooltip="'BB21 3rd'"
                            ></third-badge>
                            <topfive-badge
                                v-if="
                                    leaderboard.user.id === 4 ||
                                        leaderboard.user.id === 12
                                "
                                class="leaderboard-badge"
                                v-tooltip="'BB21 top 5'"
                            ></topfive-badge>
                            <topten-badge
                                v-if="
                                    leaderboard.user.id === 986 ||
                                        leaderboard.user.id === 895 ||
                                        leaderboard.user.id === 808
                                "
                                class="leaderboard-badge"
                                v-tooltip="'BB21 top 10'"
                            ></topten-badge>
                            </td>
                            <td class="networth">
                                {{ leaderboard.networth | currency }}
                            </td>
                            <td
                                v-for="houseguest in houseguests"
                                v-bind:key="houseguest.id"
                            >
                                {{ leaderboard.stocks[houseguest.id] }}
                            </td>
                        </tr>
                    </tbody>
                </v-table>
            </div>
        </div>

        <smart-pagination
            :currentPage.sync="currentPage"
            :totalPages="totalPages"
            :maxPageLinks="8"
        />
    </div>
</template>

<script>
export default {
    props: {
        leaderboard: Array,
        houseguests: Array,
        search: String
    },
    data: () => ({
        filters: {
            name: { value: "", keys: ["user.name"] }
        },
        currentPage: 1,
        totalPages: 0,
        maxPageLinks: 5
        // lastMoney: 0
    }),
    computed: {
        cleanLeaderboard: function() {
            return this.leaderboard.filter(l => l.user !== null);
        }
    },
    methods: {
        houseguestImage: function(houseguest) {
            return "/storage/" + houseguest.image;
        }
    }
};
</script>
