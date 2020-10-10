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
                <button @click="saveTags">Save Tags</button>
            </div>
            <div class="flex flex-row">
                <table>
                    <thead>
                    <tr>
                        <th v-for="(hg, name) in allRatings">
                            {{ name }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td v-for="(hg, name) in allRatings" :key="name+'status'">
                            <input type="checkbox" :checked="hg.status === 'evicted'" @click="toggleEvict(name, hg)" :disabled="week <= season.current_week">
                        </td>
                    </tr>
                    <tr>
                        <td v-for="(hg, name) in allRatings" :key="name+'Taran'">
                            <rating-input :rating="hg.ratings.Taran" :week="week" :houseguest="name" :status="hg.status" :user="lfc['Taran']"></rating-input>
                        </td>
                    </tr>
                    <tr>
                        <td v-for="(hg, name) in allRatings" :key="name+'Brent'">
                            <rating-input :rating="hg.ratings.Brent" :week="week" :houseguest="name" :status="hg.status" :user="lfc['Brent']"></rating-input>
                        </td>
                    </tr>
                    <tr>
                        <td v-for="(hg, name) in allRatings" :key="name+'Melissa'">
                            <rating-input :rating="hg.ratings.Melissa" :week="week" :houseguest="name" :status="hg.status" :user="lfc['Melissa']"></rating-input>
                        </td>
                    </tr>
                    <tr>
                        <td v-for="(hg, name) in allRatings" :key="name+'Audience'">
                            <rating-input :rating="hg.ratings.Audience" :week="week" :houseguest="name" :status="hg.status" :user="lfc['Audience']"></rating-input>
                        </td>
                    </tr>
                    <tr>
                        <td v-for="(hg, name) in allRatings" :class="{'evicted':hg.status === 'evicted'}" :key="name+'Average'">
                            {{ avgRating(hg) }}
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
            lfc: [],
            apiPrefix: '/nova-vendor/season-manager'
        }
    },
    mounted() {
        this.getSeason();
        axios.get(this.apiPrefix + '/lfc').then(res => {
            this.lfc = res.data;
        })
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

                this.ratings = res.data.houseguests;
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
        avgRating(hg) {
            if (hg.status === 'active' && ![hg.ratings.Taran, hg.ratings.Brent, hg.ratings.Melissa, hg.ratings.Audience].includes(null)) {
                return Math.round((hg.ratings.Taran + hg.ratings.Brent + hg.ratings.Melissa + hg.ratings.Audience) / 4);
            }
        },
        toggleEvict(name, hg) {
            let url = (hg.status === 'active') ? '/evict/' : '/unevict/';
            axios.post(this.apiPrefix + url + name).then(r => {
                this.getWeekData();
            })
        }
    },
    computed: {
        statusAsBoolean() {
            return this.season.status === 'open';
        },
        allRatings() {
            let all = {};
            for (const r in this.ratings.active) {
                all[r] = this.ratings.active[r];
            }
            for (const r in this.ratings.evicted) {
                all[r]  = this.ratings.evicted[r];
            }
            return all;
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
thead tr {
    /*height: 100px;*/
}

th {
    /*transform: rotate(-45deg);*/
    /*transform-origin: bottom;*/
}

tr {
    border-bottom: 1px solid black;
    border-right: 1px solid black;
}

tr:first-child {
    border-top: 1px solid black;
}

td {
    padding: 0;
    border-left: 1px solid black;
}

.evicted {
    background-color: rgba(255, 0, 0, .3);
}
</style>
