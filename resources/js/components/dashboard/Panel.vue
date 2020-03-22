<template>
    <div class="dashboard-wrap">
        <div class="stock-cards-wrap">
            <ul class="stock-cards">
                <li class="card stockcard" v-for="houseguest in houseguests" v-bind:key="houseguest.id">
                    <div class="hg-details">
                        <h5>{{ houseguest.nickname || houseguest.first_name | capitalize }}</h5>
                        <!-- <p>{{ user.stocks[houseguest_id] }} ugh</p> -->
                        <!-- {{ user.transactions[user_id] }} -->
                    </div>
                    <div class="hg-img" >
                        <img :src="houseguestImage(houseguest)" :alt="houseguest.nickname" />
                    </div>
                </li>
                <!-- <li class="card stockcard">
                    {{ user.transactions }}
                </li> -->
            </ul>
        </div>
        <!-- <v-table
            :data="user"
            :hideSortIcons="true"
            :filters="filters"
            :currentPage.sync="currentPage"
            :pageSize="100"
            @totalPagesChanged="totalPages = $event"
            class="leaderboard-table"
        > -->
        <table class="leaderboard-table">
            <thead slot="head">
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <!-- <tbody slot="body" slot-scope="{displayData}"> -->
            <tbody>
            <tr v-for="user in transactions" :key="user.user_id">
                <td>{{ transaction.created_at }}</td>
                <td>Sold Sheldon</td>
                <td>2</td>
                <td>$20</td>
            </tr>
            </tbody>
        <!-- </v-table> -->
        </table>
    </div>
</template>

<script>
    export default {
        props: {
            user: Object,
            houseguests: Array,
            bank: Object,
        },
        data() {
            return {
                mutableStocks: _.cloneDeep(this.stocks),
                mutableBank: _.cloneDeep(this.bank),
                prices: [],
                filters: {
                    name: {value: '', keys: ['user.name']}
                },
                currentPage: 1,
                totalPages: 0,
                }
        }, mounted() {
        },
        watch: {
            mutableStocks: {
                handler(mutatedStocks, oldVal) {
                    let stockTotal = 0;
                    let prices = this.prices;

                    mutatedStocks.forEach((stock) => {
                        if (stock.quantity < 0) {
                            stock.quantity = 0;
                        }
                        stockTotal += stock.quantity * prices[stock.houseguest_id];
                    });
                    if (this.networth < stockTotal) {
                        this.mutableStocks = oldVal;
                    } else {
                        this.mutableBank.money = this.networth - stockTotal;
                    }
                },
                deep: true
            }
        },
        methods: {
            houseguestImage: function (houseguest) {
                return '/storage' + houseguest.image;
            },
        },
        computed: {
            //
        }
    }
</script>
