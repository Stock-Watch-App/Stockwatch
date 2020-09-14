<template>
    <div>
        <heading class="mb-6">Stats Manager</heading>
        <Tabs>
            <Tab name="Stocks Owned" :selected="true">
                <div v-for="stock in stocks" v-bind:key="stock.nickname" class="item-row-wrap">
                    <div class="item-row">
                        <span class="name">
                            {{ stock.nickname }}
                        </span>
                        <span class="total">
                            {{ numberFormat(stock.total) }}
                        </span>
                    </div>
                    <div :style="computeWidth(stock.total, topStock)" class="chart-row"></div>
                </div>
            </Tab>
            <Tab name="Money Spent">
                <div v-for="m in money" v-bind:key="m.nickname" class="item-row-wrap">
                    <div class="item-row">
                        <span class="name">
                            {{ m.nickname }}
                        </span>
                        <span class="total">
                            ${{ numberFormat(m.total) }}
                        </span>
                    </div>
                    <div :style="computeWidth(m.total, topMoney)" class="chart-row-alt"></div>
                </div>
            </Tab>
            <Tab name="Reports">
                <button v-if="!generating" class="inline-block bg-primary px-4 py-2 rounded-lg text-white bold mb-4" @click="generate">Generate Stat Report</button>
                <button v-if="generating" class="inline-block bg-primary px-4 py-2 rounded-lg text-white bold mb-4">Generating...</button>
                <table class="table-fixed w-full">
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
                        <td class="text-center">{{ file.season.name }}</td>
                        <td class="text-center">{{ file.week }}</td>
                        <td class="text-center">
                            <button class="bg-primary px-4 py-2 rounded-lg text-white bold" @click="download(file)">Download</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
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
            console.log(numerator / denominator);
            return 'width:' + (numerator / denominator) * 100 + '%'
        },
        numberFormat(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        }
    },
    components: {
        Tab,
        Tabs,
    }
}
</script>

<style>

.item-row-wrap {
    display: flex;
    justify-items: flex-start;
    margin: 1rem 0;
}

.item-row {
    padding: 0.5rem 0;
    flex: 0 0 22%;
    display: flex;
}

.name {
    font-weight: bold;
    flex: 0 0 100px;
}

.total {
    flex: 1 1 auto;
}

.chart-row {
    background-color: hsl(224, 90%, 53%);
}

.chart-row-alt {
    background-color: hsl(173, 90%, 53%);
}

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

.rounded {
    border-radius: .25rem;
}

</style>
