<template>
    <div>
        <heading class="mb-6">Season Manager</heading>

        <card class="w-2/3 flex flex-col">
            <h3 class="m-4 w-1/2 text-left font-semibold">{{season.name}}</h3>
            <div class="w-1/2 flex flex-row p-3 float-right">
                <span class="font-medium text-lg mr-3 align-middle leading-loose">Market:</span>
                <toggle
                    :checkbox="statusAsBoolean"
                    :labels="{true: 'OPEN', false: 'CLOSED'}"
                    @toggled="saveStatus"
                ></toggle>
            </div>
        </card>
        <card class="w-full flex flex-col mt-4">
            <h3 class="m-4 w-1/2 text-left font-semibold">Week {{ season.current_week }} Ratings</h3>
            <div class="p-4">
                <div class="flex flex-row w-full">
                    <!-- Ratings some day -->
                    <div class="inline-block flex flex-col">
                        <div>LFC</div>
                        <div v-for="name in raters">
                            {{ name }}
                        </div>
                    </div>
                    <div v-for="houseguest in houseguests" class="inline-block flex flex-col flex-grow">
                        <div class="angled-header h-!auto">{{ houseguest.nickname }}</div>
                        <div v-for="(name, user) in raters">
                            {{ houseguest.ratings[user] }}
                        </div>
                    </div>
                </div>
            </div>
        </card>
<!--        <card class="w-full flex flex-col mt-4">-->
<!--            <h3 class="m-4 w-1/2 text-left font-semibold">Week {{ season.current_week }} Ratings</h3>-->
<!--            <div class="p-4">-->
<!--                <table class="w-full">-->
<!--                    <tr>-->
<!--                        <th>LFC</th>-->
<!--                        <th v-for="nickname in houseguests" class="angled-header">{{ nickname }}</th>-->
<!--                    </tr>-->
<!--                    <tr v-for="user in raters">-->
<!--                        <th class="text-right border p-2">{{ user.name }}</th>-->
<!--                        <td class="border p-2" v-for="(nickname, houseguest_id) in houseguests">{{ user.ratings[houseguest_id] }}</td>-->
<!--                    </tr>-->
<!--                </table>-->
<!--            </div>-->
<!--        </card>-->
    </div>
</template>

<script>
    import Toggle from "./Toggle";
    export default {
        data() {
            return {
                season: Object,
                raters: Array,
                houseguests: Array,
                // ratings: Object,
            }
        },
        mounted() {
            this.getSeason();
            this.getRatingData('current');
        },
        methods: {
            getSeason() {
                axios.get('/nova-vendor/season-manager/season/current').then(res => {
                    this.season = res.data;
                })
            },
            getRatingData(week) {
                axios.get('/nova-vendor/season-manager/rating-data/week/'+week).then(res => {
                    this.raters = res.data.raters;
                    this.houseguests = res.data.houseguests;
                    // this.ratings = res.data.ratings;
                })
            },
            saveStatus(status) {
                let opening = 'Are you sure? Toggling to OPEN will run the formula to start the week and is non-reversible';
                let closing = 'Are you sure? Toggling to CLOSE is non-reversible until after the next Roundtable';
                if (confirm(status ? opening : closing)) {
                    axios.post('/nova-vendor/season-manager/season/update/status', {
                        'status': status ? 'open' : 'closed'
                    });
                }
            }
        },
        computed: {
            statusAsBoolean() {
                return this.season.status === 'open';
            }
        },
        components:{
            Toggle
        }
    }
</script>

<style>
    .angled-header {
        transform: rotate(-60deg);
    }
</style>
