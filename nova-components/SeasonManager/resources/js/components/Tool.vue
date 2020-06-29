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
            <div class="flex flex-row">
                <!-- Ratings some day -->
            </div>
        </card>
    </div>
</template>

<script>
    import Toggle from "./Toggle";
    export default {
        data() {
            return {
                season: Object
            }
        },
        mounted() {
            this.getSeason();
        },
        methods: {
            getSeason() {
                axios.get('/nova-vendor/season-manager/season/current').then(res => {
                    this.season = res.data;
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

</style>
