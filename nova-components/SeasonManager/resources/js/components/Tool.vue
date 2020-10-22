<template>
    <div>
        <heading class="mb-6">Season Manager</heading>

        <card class="w-2/3 flex flex-col">
            <h3 class="m-4 w-1/2 text-left font-semibold">{{ season.name }}</h3>
            <div class="w-1/2 flex flex-row p-3 float-right">
                <span
                    class="font-medium text-lg mr-3 align-middle leading-loose"
                >Market:</span
                >
                <toggle
                    :checkbox="statusAsBoolean"
                    :labels="{ true: 'OPEN', false: 'CLOSED' }"
                    @toggled="saveStatus"
                ></toggle>
            </div>
        </card>
        <card class="mt-6 p-3">
            <div class="flex flex-row">
                <label class="font-bold"
                >Week: <input class="w-8" type="number" v-model="week"/> </label>
                <houseguest-picker
                    label="HOH"
                    type="active"
                    v-model="tags.hoh"
                ></houseguest-picker>
                <houseguest-picker
                    label="Veto"
                    type="active"
                    v-model="tags.veto"
                ></houseguest-picker>
                <houseguest-picker
                    label="Nominated"
                    type="active"
                    v-model="tags.nom1"
                ></houseguest-picker>
                <houseguest-picker
                    label="Nominated"
                    type="active"
                    v-model="tags.nom2"
                ></houseguest-picker>
                <button @click="saveTags">Save Tags</button>
            </div>
            <div class="flex flex-row scrollable">
                <table class="rotated-header">
                    <thead>
                    <tr>
                        <th></th>
                        <th v-for="(hg, name) in allRatings" class="">
                            <div class="rotated-header-container">
                                <div
                                    class="rotated-header-content"
                                    :class="{
                                            evicted: hg.status === 'evicted'
                                        }"
                                >
                                    {{ name }}
                                </div>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td
                            v-for="(hg, name) in allRatings"
                            :key="name + 'status'"
                        >
                            <input
                                type="checkbox"
                                :checked="hg.status === 'evicted'"
                                @click="toggleEvict(name, hg)"
                                :disabled="week <= season.current_week"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Taran</td>
                        <td
                            v-for="(hg, name) in allRatings"
                            :key="name + 'Taran'"
                            :class="{
                                    evicted: hg.status === 'evicted',
                                    saved: hg.ratings.Taran.saved
                                }"
                        >
                            <rating-input
                                :rating="hg.ratings.Taran.rating"
                                :week="week"
                                :houseguest="name"
                                :status="hg.status"
                                :user="lfc['Taran']"
                                @saved="toggleSaved(hg.ratings.Taran, $event)"
                            ></rating-input>
                        </td>
                    </tr>
                    <tr>
                        <td>Brent</td>
                        <td
                            v-for="(hg, name) in allRatings"
                            :key="name + 'Brent'"
                            :class="{
                                    evicted: hg.status === 'evicted',
                                    saved: hg.ratings.Brent.saved
                                }"
                        >
                            <rating-input
                                :rating="hg.ratings.Brent.rating"
                                :week="week"
                                :houseguest="name"
                                :status="hg.status"
                                :user="lfc['Brent']"
                                @saved="toggleSaved(hg.ratings.Brent, $event)"
                            ></rating-input>
                        </td>
                    </tr>
                    <tr>
                        <td>Melissa</td>
                        <td
                            v-for="(hg, name) in allRatings"
                            :key="name + 'Melissa'"
                            :class="{
                                    evicted: hg.status === 'evicted',
                                    saved: hg.ratings.Melissa.saved
                                }"
                        >
                            <rating-input
                                :rating="hg.ratings.Melissa.rating"
                                :week="week"
                                :houseguest="name"
                                :status="hg.status"
                                :user="lfc['Melissa']"
                                @saved="toggleSaved(hg.ratings.Melissa, $event)"
                            ></rating-input>
                        </td>
                    </tr>
                    <tr>
                        <td>Audience</td>
                        <td
                            v-for="(hg, name) in allRatings"
                            :key="name + 'Audience'"
                            :class="{
                                    evicted: hg.status === 'evicted',
                                    saved: hg.ratings.Audience.saved
                                }"
                        >
                            <rating-input
                                :rating="hg.ratings.Audience.rating"
                                :week="week"
                                :houseguest="name"
                                :status="hg.status"
                                :user="lfc['Audience']"
                                @saved="toggleSaved(hg.ratings.Audience, $event)"
                            ></rating-input>
                        </td>
                    </tr>
                    <tr>
                        <td class="average">Average</td>
                        <td
                            v-for="(hg, name) in allRatings"
                            class="average"
                            :class="{
                                    evicted: hg.status === 'evicted'
                                }"
                            :key="name + 'Average'"
                        >
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
                hoh: "",
                veto: "",
                nom1: "",
                nom2: ""
            },
            ratings: [],
            lfc: [],
            apiPrefix: "/nova-vendor/season-manager"
        };
    },
    mounted() {
        this.getSeason();
        axios.get(this.apiPrefix + "/lfc").then(res => {
            this.lfc = res.data;
        });
    },
    watch: {
        week: function (newVal, oldval) {
            if (typeof newVal === 'number') {
                this.getWeekData();
            } else {
                this.week = parseInt(newVal);
            }
        }
    },
    methods: {
        getSeason() {
            axios.get(this.apiPrefix + "/season/current").then(res => {
                this.season = res.data;
                this.week =
                    this.season.status === "closed"
                        ? this.season.current_week + 1
                        : this.season.current_week;
            });
        },
        getWeekData() {
            axios.get(this.apiPrefix + "/week/" + this.week).then(res => {
                this.tags.hoh = res.data.tags.hoh;
                this.tags.veto = res.data.tags.veto;
                this.tags.nom1 = res.data.tags.nom1;
                this.tags.nom2 = res.data.tags.nom2;

                this.ratings = res.data.houseguests;
            });
        },
        saveStatus(status) {
            let opening =
                "Are you sure? Toggling to OPEN will run the formula to start the week and is non-reversible";
            let closing =
                "Are you sure? Toggling to CLOSE is non-reversible until after the next Roundtable";
            if (confirm(status ? opening : closing)) {
                axios.post(this.apiPrefix + "/season/update/status", {
                    status: status ? "open" : "closed"
                });
            }
        },
        saveTags() {
            axios.post(this.apiPrefix + "/save/tags", {
                tags: this.tags,
                week: this.week
            });
        },
        avgRating(hg) {
            if (hg.status === "active"
                && ![hg.ratings.Taran.rating, hg.ratings.Brent.rating, hg.ratings.Melissa.rating, hg.ratings.Audience.rating].includes(null)) {
                return Math.round((parseInt(hg.ratings.Taran.rating) + parseInt(hg.ratings.Brent.rating) + parseInt(hg.ratings.Melissa.rating) + parseInt(hg.ratings.Audience.rating)) / 4);
            }
        },
        toggleEvict(name, hg) {
            let url = hg.status === "active" ? "/evict/" : "/unevict/";
            axios.post(this.apiPrefix + url + name).then(r => {
                this.getWeekData();
            });
        },
        toggleSaved(hg, saved) {
            hg.saved = saved.saved
            hg.rating = saved.rating
            console.log(hg);
            console.log(saved);
        }
    },
    computed: {
        statusAsBoolean() {
            return this.season.status === "open";
        },
        allRatings() {
            let all = {};
            for (const r in this.ratings.active) {
                all[r] = this.ratings.active[r];
            }
            for (const r in this.ratings.evicted) {
                all[r] = this.ratings.evicted[r];
            }
            return all;
        }
    },
    components: {
        toggle: Toggle,
        "houseguest-picker": HouseguestPicker,
        "rating-input": RatingInput
    }
};
</script>

<style>
:root {
    --border: hsl(240, 4%, 60%);
    --average-bg: hsla(173, 90%, 53%, 0.2);
    --evicted-bg: hsl(0, 81%, 90%);
    --evicted-text: hsl(240, 5%, 48%);
    --saved: hsla(224, 90%, 53%, 0.2);
}

.scrollable {
    overflow: auto;
}

thead tr {
    border: none;
}

tr {
    border-bottom: 1px solid var(--border);
    border-right: 1px solid var(--border);
}

tr:first-child {
    border-top: 1px solid var(--border);
}

td {
    border-left: 1px solid var(--border);
}

tr,
td,
th {
    padding: 0.5rem;
}

tr td:first-child {
    padding: 0.5rem 1rem;
    text-align: left;
}

/* input containers */
tr td {
    width: 45px;
    text-align: center;
}

.rotated-header th {
    height: 150px;
    vertical-align: bottom;
    text-align: left;
    line-height: 1;
    border: none;
}

.rotated-header-container {
    width: 45px;
}

.rotated-header-content {
    width: 170px;
    transform-origin: bottom left;
    transform: translateX(45px) rotate(-45deg);
}

.average {
    background: var(--average-bg);
    font-weight: bold;
}

.evicted {
    background: var(--evicted-bg);
}

.saved {
    background-color: var(--saved);
}

/* target evicted name */
div.evicted {
    color: var(--evicted-text);
    background: transparent;
}
</style>
