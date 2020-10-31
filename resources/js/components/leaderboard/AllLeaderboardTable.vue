<template>
    <div class="leader-grid alltime-leader">
        <label class="label-hidden">Filter by Name:</label> <input
        class="input inline-width input-light mg-btm-md"
        placeholder="Search user..."
        v-model="filters.name.value"
    />
        <div class="table-wrap mg-btm-md">
            <v-table
                :data="rankedLeaderboard"
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
                            :class="leaderboard.rank.class"
                        >
                            {{ leaderboard.rank.rank }}
                        </div>
                    </td>
                    <td class="user-row-wrap">
                        <a :href="'/profile/' + leaderboard.user.hashid" class="user-row">
                            <avatar
                                :user="leaderboard.user"
                                height="25"
                                width="25"
                                class="leaderboard-avatar"
                            ></avatar>
                            <span>{{ leaderboard.user.name }}</span>
                            <vanity-tag v-if="leaderboard.user.vanitytags" :label="leaderboard.user.vanitytags.tag"></vanity-tag>
                            <badge
                                v-for="badge in leaderboard.user.badges"
                                :badge="badge"
                                :key="badge.name"
                                v-tooltip="badge.name"
                                width="35"
                                height="35"
                                customClass="leaderboard-badge"
                            ></badge>
                        </a>
                    </td>
                    <td class="networth">
                        {{ leaderboard.networth | currency }}
                    </td>
                </tr>
                </tbody>
            </v-table>
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
        leaderboard: Array
    },
    data: () => ({
        filters: {
            name: {value: "", keys: ["user.name"]}
        },
        currentPage: 1,
        totalPages: 0,
        rank: {
            rank: 0,
            class: null
        }
    }),
    computed: {
        rankedLeaderboard: function () {
            let rank = 1;
            let lastValue = "1";
            let hiddenRank = 1;
            let ranked = [];
            for (let leaderboard of this.leaderboard) {
                if (leaderboard.user === null) continue;
                let newRank = {
                    rank: 0,
                    class: null
                };
                if (lastValue === leaderboard.networth) {
                    newRank.rank = rank;
                } else {
                    newRank.rank = hiddenRank;
                    rank = hiddenRank;
                }
                switch (newRank.rank) {
                    case 1:
                        newRank.class = "rank-1";
                        break;
                    case 2:
                        newRank.class = "rank-2";
                        break;
                    case 3:
                        newRank.class = "rank-3";
                        break;
                    default:
                        newRank.class = "";
                        break;
                }
                leaderboard.rank = newRank;
                ranked.push(leaderboard);
                lastValue = leaderboard.networth;
                hiddenRank++;
            }
            return ranked;
        }
    },
    methods: {
        houseguestImage: function (houseguest) {
            return "/storage" + houseguest.image;
        }
    }
};
</script>
