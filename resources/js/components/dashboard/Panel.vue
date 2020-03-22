<template>
    <div class="dashboard-wrap">
        <div class="stock-cards-wrap">
            <ul class="stock-cards">
                <holdings-card
                    v-for="stock in user.stocks"
                    :stock="stock"
                    :houseguests="houseguests"
                    :key="stock.id"
                ></holdings-card>
            </ul>
        </div>
        <v-table
            :data="user.transactions"
            :hideSortIcons="true"
            :filters="filters"
            :currentPage.sync="currentPage"
            :pageSize="100"
            @totalPagesChanged="totalPages = $event"
            class="leaderboard-table"
        >
            <thead slot="head">
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody slot="body" slot-scope="{displayData}">
            <tr v-for="transaction in displayData" :key="transaction.user_id">
                <td>{{ transaction.created_at }}</td>
                <td> {{ transactionMessage(transaction) | capitalize }} </td>
                <td>{{ transaction.quantity }}</td>
                <td>{{ transaction.quantity*transaction.current_price }}</td>
            </tr>
            </tbody>
        </v-table>
    </div>
</template>

<script>
    export default {
        props: {
            user: Object,
            houseguests: Array
        },
        data() {
            return {};
        }, mounted() {
        },
        watch: {},
        methods: {
            transactionMessage: function (t) {
                
                let verb
                if (t.action === 'buy') {
                    verb = 'bought';
                } else if (t.action === 'sell') {
                    verb = 'sold';
                }

                //find houseguest
                let houseguest;
                for (let hg of this.houseguests) {
                    if (hg.id === t.houseguest_id) {
                        houseguest = hg;
                    }
                }

                return verb + ' ' + t.quantity + ' stocks of ' + houseguest.nickname;
            }
        },
        computed: {
            //
        }
    }
</script>
