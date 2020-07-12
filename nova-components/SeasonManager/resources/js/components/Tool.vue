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
        <card class="w-full mt-4">
            <h3 class="m-4 w-1/2 text-left font-semibold pt-4">Week {{ season.current_week }} Ratings
            </h3>
            <button class="m-2 border p-2 rounded" @click="newWeek">Add Week {{ season.current_week + 1 }}</button>
            <div class="p-4 flex flex-col ">
                <div class="flex flex-row w-full rating-table">
                    <!-- Ratings some day -->
                    <div class="inline-block flex flex-col">
                        <div class="header-row font-bold text-right">&nbsp;</div>
                        <div class="font-bold text-right p-2">Taran</div>
                        <div class="font-bold text-right p-2">Brent</div>
                        <div class="font-bold text-right p-2">Melissa</div>
                        <div class="font-bold text-right p-2">Audience</div>
                        <div class="font-bold text-right p-2 border-t border-black pt-4">Final Rating</div>
                    </div>
                    <div v-for="(rating, houseguest_id) in ratings" class="inline-block flex flex-col flex-grow">
                        <div class="header-row angled-header">{{ houseguests[houseguest_id] }}</div>
                        <div class="p-1 pb-2"><input class="w-full border border-50" type="number" min="1" max="10" v-model="rating.ratings[4]"/></div>
                        <div class="p-1 pb-2"><input class="w-full border border-50" type="number" min="1" max="10" v-model="rating.ratings[6]"/></div>
                        <div class="p-1 pb-2"><input class="w-full border border-50" type="number" min="1" max="10" v-model="rating.ratings[9]"/></div>
                        <div class="p-1 pb-2"><input class="w-full border border-50" type="number" min="1" max="10" v-model="rating.ratings[1]"/></div>
                        <div class="font-bold border-t border-black pt-3 text-center text-2xl">{{ rate(rating.ratings) }}</div>
                    </div>
                    <div></div>
                </div>
            </div>
        </card>
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
                ratings: Object,
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
                axios.get('/nova-vendor/season-manager/rating-data/week/' + week).then(res => {
                    this.raters = res.data.raters;
                    this.houseguests = res.data.houseguests;
                    this.ratings = res.data.ratings;
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
            },
            rate(object) {
                let total = 0;
                for (let key in object) {
                    total += parseInt(object[key]);
                }
                return Math.round(total/4);
            }
        },
        computed: {
            statusAsBoolean() {
                return this.season.status === 'open';
            }
        },
        components: {
            Toggle
        }
    }
</script>

<style>
    .cell {
        padding: .5rem;
    }
    .header-row {
        min-height: 2.5rem;
    }
    /*.angled-header {*/
    /*    transform: rotate(-60deg);*/
    /*}*/
</style>
