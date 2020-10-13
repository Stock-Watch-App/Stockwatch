<template>
    <div>
        <label>{{ label }}:
            <select v-model="selected" @change="pick">
                <option disabled value="">Select Houseguest</option>
                <option v-for="houseguest in houseguests" :value="houseguest.nickname">{{houseguest.nickname}}</option>
            </select>
        </label>
    </div>
</template>

<script>
export default {
    model: {
      prop: 'selectedHouseguest',
      event: 'change'
    },
    props: {
        label: String,
        selectedHouseguest: '',
    },
    data() {
        return {
            houseguests: [],
            selected: this.selectedHouseguest,
        }
    },
    watch: {
        selectedHouseguest: function () {
            this.selected = this.selectedHouseguest;
        }
    },
    mounted() {
        axios.get('/nova-vendor/season-manager/houseguests/').then(res => {
            this.houseguests = res.data;
        })
    },
    methods: {
        pick() {
            // console.log(this.$event.target)
            this.$emit('change', this.selected)
        }
    }
}
</script>

<style scoped>

</style>
