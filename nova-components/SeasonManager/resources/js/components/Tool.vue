<template>
    <div>
        <heading class="mb-6">Season Manager</heading>

        <card class="w-2/3 flex flex-col">
            <h3 class="m-4 w-1/2 text-left font-semibold">{{ season.name }}</h3>
            <div class="w-1/2 flex flex-row p-3 float-right">
                <span class="font-medium text-lg mr-3 align-middle leading-loose">Market:</span>
                <toggle
                    :checkbox="statusAsBoolean"
                    :labels="{true: 'OPEN', false: 'CLOSED'}"
                    @toggled="saveStatus"
                ></toggle>
            </div>
        </card>
        <card class="mt-6 p-3">
            <div class="flex flex-row">
                <label class="font-bold">Week: <input class="w-8" type="number" v-model="week"></label>
                <houseguest-picker label="HOH" type="active" v-model="tags.hoh"></houseguest-picker>
                <houseguest-picker label="Veto" type="active" v-model="tags.veto"></houseguest-picker>
                <houseguest-picker label="Nominated" type="active" v-model="tags.nom1"></houseguest-picker>
                <houseguest-picker label="Nominated" type="active" v-model="tags.nom2"></houseguest-picker>
                <button @click="saveTags">Save</button>
            </div>
            <div class="flex flex-row">
                <table>
                    <thead>
                        <tr>
                            <th v-for="(ratings, hg) in cleanRatings">
                                {{ hg }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td v-for="(ratings, hg) in cleanRatings">
                                <rating-input :rating="ratings.Taran" :houseguest="hg" user="Taran"></rating-input>
                            </td>
                        </tr>
                        <tr>
                            <td v-for="(ratings, hg) in cleanRatings">
                                <rating-input :rating="ratings.Brent" :houseguest="hg" user="Brent"></rating-input>
                            </td>
                        </tr>
                        <tr>
                            <td v-for="(ratings, hg) in cleanRatings">
                                <rating-input :rating="ratings.Melissa" :houseguest="hg" user="Melissa"></rating-input>
                            </td>
                        </tr>
                        <tr>
                            <td v-for="(ratings, hg) in cleanRatings">
                                <rating-input :rating="ratings.Audience" :houseguest="hg" user="Audience"></rating-input>
                            </td>
                        </tr>
                        <tr>
                            <td v-for="(ratings, hg) in cleanRatings">
                                {{ avgRating(ratings) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Ratings some day -->
            </div>
        </card>
    </div>
</template>

<script>
import Toggle from "./Toggle";
import HouseguestPicker from "./HouseguestPicker";
import RatingInput from "./RatingInput";

export default {
    data() {
        return {
            season: Object,
            week: Number,
            tags: {
                hoh: '',
                veto: '',
                nom1: '',
                nom2: '',
            },
            ratings: [],
            apiPrefix: '/nova-vendor/season-manager'
        }
    },
    mounted() {
        this.getSeason();
    },
    watch: {
        week: function (newVal, oldval) {
            console.log(newVal);
            console.log(oldval);
            this.getWeekData();
        }
    },
    methods: {
        getSeason() {
            axios.get(this.apiPrefix + '/season/current').then(res => {
                this.season = res.data;
                this.week = (this.season.status === 'closed') ? this.season.current_week + 1 : this.season.current_week;
            })
        },
        getWeekData() {
            axios.get(this.apiPrefix + '/week/' + this.week).then(res => {
                this.tags.hoh = res.data.tags.hoh;
                this.tags.veto = res.data.tags.veto;
                this.tags.nom1 = res.data.tags.nom1;
                this.tags.nom2 = res.data.tags.nom2;

                this.ratings = res.data.ratings;
            })
        },
        saveStatus(status) {
            let opening = 'Are you sure? Toggling to OPEN will run the formula to start the week and is non-reversible';
            let closing = 'Are you sure? Toggling to CLOSE is non-reversible until after the next Roundtable';
            if (confirm(status ? opening : closing)) {
                axios.post(this.apiPrefix + '/season/update/status', {
                    'status': status ? 'open' : 'closed'
                });
            }
        },
        saveTags() {
            axios.post(this.apiPrefix + '/save/tags', {
                tags: this.tags,
                week: this.week
            })
        },
        avgRating(ratings) {
            return Math.round((ratings.Taran + ratings.Brent + ratings.Melissa + ratings.Audience)/4);
        }
    },
    computed: {
        statusAsBoolean() {
            return this.season.status === 'open';
        },
        cleanRatings() {
            let clean = {};
            for (const r in this.ratings) {
                if (!_.isEmpty(this.ratings[r])) {
                    clean[r] = this.ratings[r]
                } else {
                    clean[r] = {
                        Taran: null,
                        Brent: null,
                        Melissa: null,
                        Audience: null,
                    }
                }
            }
            return clean;
        }
    },
    components: {
        'toggle': Toggle,
        'houseguest-picker': HouseguestPicker,
        'rating-input': RatingInput
    }
}
</script>

<style>
    .thead {
        height: 100px;
    }
    th {
        transform: rotate(-45deg);
        transform-origin: bottom;
    }
    tr {
        border-bottom: 1px solid black;
        border-right: 1px solid black;
    }
    tr:first-child {
        border-top: 1px solid black;
    }
    td {
        border-left: 1px solid black;
    }
</style>
