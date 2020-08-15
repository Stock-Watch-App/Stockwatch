<template>
    <div>
        <heading class="mb-6">Stats Manager</heading>
        <button class="bg-primary px-4 py-2 rounded-lg text-white bold" @click="generate">Generate Stat Report</button>
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            files: Array
        }
    },
    mounted() {
        this.getFiles();
    },
    methods: {
        generate() {
            axios.post('/nova-vendor/stats-manager/generate').then(res => {
                this.getFiles();
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
        }
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
</style>
