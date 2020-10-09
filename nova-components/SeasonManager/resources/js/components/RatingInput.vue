<template>
    <div>
        <input type="number" v-model="localRating">
    </div>
</template>

<script>
export default {
    props: {
        houseguest: String,
        user: String,
        rating: null,
    },
    data() {
        return {
            localRating: this.rating,
        }
    },
    watch: {
        rating: function () {
            this.localRating = this.rating;
        }
    },
    methods: {
        save() {
            axios.post('/save/rating/'+this.houseguest+'/'+this.localRating+'/'+this.user)
        }
    }
}
</script>

<style scoped>

</style>
