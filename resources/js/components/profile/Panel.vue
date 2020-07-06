<template>
    <div class="profile-page-wrap">
        <div class="profile-details">
            <avatar height="60px" width="60px"></avatar>
            <p class="bold">{{ user.name }}</p>
            <p>current rank {{ user.rank }}</p>
            <p>all-time rank {{ user.rank }}</p>
            <p>badges here</p>
        </div>

        <div class="profile-stats-wrap mg-btm-lg">
            <div class="week-picker-wrap mg-btm-sm">
                <h3>Summary</h3>
                <icon-button
                    icon="chevron-left"
                    ariaLabelledById="my-label"
                    buttonLabel="Last week"
                    class="prev-button"
                ></icon-button>
                <select-component
                    v-model="selected"
                    placeholder="Current Week"
                    :options="[
                        { value: 'foo', text: 'This is foo', disabled: false },
                        { value: 'bar', text: 'This is bar' }
                    ]"
                ></select-component>
                <icon-button
                    icon="chevron-right"
                    ariaLabelledById="my-label"
                    buttonLabel="Next week"
                    class="next-button"
                ></icon-button>
            </div>
            <div class="weekly-stats-wrap">
                <div class="stats-summary">
                    <div class="networth-wrap">
                        <div class="stats">
                            <p>Net worth:</p>
                            <h1>$200 {{ networth | currency }}</h1>
                            <p class="bodySM">up $20</p>
                        </div>
                    </div>
                    <div class="rank-wrap">
                        <div class="stats">
                            <p>Rank:</p>
                            <h1>#1000</h1>
                            <p class="bodySM">down 40</p>
                        </div>
                    </div>
                </div>
                <ul class="stats-cards">
                    <holdings-card-profile
                        v-for="stock in user.stocks"
                        :stock="stock"
                        :houseguests="houseguests"
                        :key="stock.houseguest_id"
                    ></holdings-card-profile>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        user: Object,
        houseguests: Array,
        bank: Object,
        networth: Number,
        leaderboard: Array,
        options: [{ value: "foo", text: "This is Foo", disabled: true }]
        // options: Array
    },
    data() {
        return {
            currentPage: 1,
            totalPages: 0,
            mutableBank: _.cloneDeep(this.bank)
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
            let houseguest;
            for (let hg of this.houseguests) {
                if (hg.id === t.houseguest_id) {
                    houseguest = hg;
                }
            }

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
