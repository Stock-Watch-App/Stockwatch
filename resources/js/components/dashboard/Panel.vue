<template>
    <div class="dashboard-wrap">
        <div class="dash-cards-wrap mg-btm-lg">
            <h3 class="mg-btm-lg">Current Holdings</h3>
            <p v-if="user.stocks.length === 0">
                You haven't bought any stock yet! When the market opens, check
                out the <a href="./trades">available stocks</a> and get yourself
                on the leaderboard!
            </p>
            <ul class="dash-cards" v-if="user.stocks.length > 0">
                <holdings-card
                    v-for="stock in user.stocks"
                    :stock="stock"
                    :houseguests="houseguests"
                    :key="stock.houseguest_id"
                ></holdings-card>
            </ul>
        </div>

        <div class="transaction-history" v-if="user.transactions.length > 0">
            <h4>Transaction History</h4>
            <v-table
                :data="user.transactions"
                :hideSortIcons="true"
                :currentPage.sync="currentPage"
                :pageSize="20"
                @totalPagesChanged="totalPages = $event"
                class="leaderboard-table mg-btm-md"
            >
                <thead slot="head">
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody slot="body" slot-scope="{ displayData }">
                    <tr
                        v-for="transaction in displayData"
                        :key="transaction.id"
                    >
                        <td>{{ transaction.created_at | date }}</td>
                        <td>
                            {{ transactionMessage(transaction) | capitalize }}
                        </td>
                        <td>{{ transaction.quantity }}</td>
                        <td>
                            {{
                                (transaction.quantity *
                                    transaction.current_price)
                                    | currency
                            }}
                        </td>
                    </tr>
                </tbody>
            </v-table>
            <smart-pagination
                :currentPage.sync="currentPage"
                :totalPages="totalPages"
            />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        user: Object,
        houseguests: Array
    },
    data() {
        return {
            currentPage: 1,
            totalPages: 0
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
            let houseguest = this.houseguests.find(hg => {
                return hg.id === t.houseguest_id
            });

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
