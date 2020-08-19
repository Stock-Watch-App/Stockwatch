<template>
    <div>
        <heading class="mb-6">Stats Manager</heading>
        <Tabs>
            <Tab name="Stocks Owned" :selected="true">
                <card class="bg-white inline-flex flex-col w-1/2 mt-4">
                    <div v-for="stock in stocks" class="relative pt-1">
                        <div :style="computeWidth(stock.total, topStock)" class="overflow-hidden h-4 mb-4 text-xs flex rounded bg-green-200">
                            <span>
                                {{ stock.nickname }}
                            </span>
                            <span class="float-right">
                                {{ currency(stock.total) }}
                            </span>
                        </div>
                    </div>
                </card>
            </Tab>
            <Tab name="Money Spent">
                <card class="bg-white inline-flex flex-col w-1/2 mt-4">
                    test
                </card>
            </Tab>
            <Tab name="Reports">
                <button v-if="!generating" class="inline-block bg-primary px-4 py-2 rounded-lg text-white bold" @click="generate">Generate Stat Report</button>
                <button v-if="generating" class="inline-block bg-primary px-4 py-2 rounded-lg text-white bold">Generating...</button>
                <card class="bg-white flex flex-col w-full mt-4">
                    <table class="table-fixed">
                        <thead>
                        <tr>
                            <th class="w-2/5 px-4 py-2">File</th>
                            <th class="w-1/5 px-4 py-2">Season</th>
                            <th class="w-1/5 px-4 py-2">Week</th>
                            <th class="w-1/5 px-4 py-2">Download</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="file in files">
                            <td>{{ file.filename }}</td>
                            <td>{{ file.season.name }}</td>
                            <td>{{ file.week }}</td>
                            <td>
                                <button class="bg-primary px-4 py-2 rounded-lg text-white bold" @click="download(file)">Download</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </card>
            </Tab>
        </Tabs>

    </div>
</template>

<script>
import Tab from "./Tab";
import Tabs from "./Tabs";

export default {
    data() {
        return {
            files: Array,
            generating: false,
            stocks: Array,
            topStock: Number,
            money: Array,
            topMoney: Number
        }
    },
    mounted() {
        this.getFiles();
        this.getStats();
    },
    methods: {
        generate() {
            this.generating = true;
            axios.post('/nova-vendor/stats-manager/generate').then(res => {
                this.getFiles();
                this.generating = false;
            })
        },
        getFiles() {
            axios.get('/nova-vendor/stats-manager/files').then(res => {
                this.files = res.data;
            })
        },
        download(file) {
            axios.get('/nova-vendor/stats-manager/file/' + file.type + '/' + file.filename).then(res => {
                let anchor = document.createElement('a');
                anchor.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(res.data);
                anchor.target = '_blank';
                anchor.download = file.filename;
                anchor.click();
            });
        },
        getStats() {
            axios.get('/nova-vendor/stats-manager/stats/total/stocks').then(res => {
                this.stocks = res.data;
                this.topStock = res.data[0].total;
            })
            axios.get('/nova-vendor/stats-manager/stats/total/money').then(res => {
                this.money = res.data;
                this.topMoney = res.data[0].total;
            })
        },
        computeWidth(numerator, denominator) {
            return 'width:' + (numerator / denominator) * 100 + '%'
        },
        currency(num) {
            return '$' + parseFloat(num).toFixed(2);
        }
    },
    components: {
        Tab,
        Tabs,
    }
}
</script>

<style>
thead th:first-child {
    border-top-left-radius: 4px;
}

thead th:last-child {
    border-top-right-radius: 4px;
}

thead tr {
    background-color: #252d37;
    color: #fff;
    /*border-top-right-radius: 4px;*/
    /*border-top-left-radius: 4px;*/
}

td {
    padding: 1.5rem 1rem;
    border-bottom: 1px solid rgba(64, 153, 222, .3);
}

tbody tr:hover {
    background-color: rgba(36, 36, 36, .1);
}

tr:last-child td {
    border: none
}

.relative {
    position: relative;
}

.pt-1 {
    padding-top: .25rem;
}

.text-xs {
    font-size: .75rem;
}

.overflow-hidden {
    overflow: hidden;
}

.mb-4 {
    margin-bottom: 1rem;
}

.h-2 {
    height: .5rem;
}

.flex {
    display: flex;
}

.rounded {
    border-radius: .25rem;
}

.bg-green-200 {
    background-color: #c6f6d5;
}
</style>
