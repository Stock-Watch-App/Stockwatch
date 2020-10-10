<template>
    <div>
        <input v-if="status === 'active'" class="w-16" :class="{'saved': saved}" type="number" v-model="localRating" @change="save">
        <div v-else class="evicted"></div>
    </div>
</template>

<script>
export default {
    props: {
        houseguest: String,
        user: Number,
        week: Number,
        status: String,
        rating: null,
        saved: false
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
            axios.post('/nova-vendor/season-manager/save/rating/' + this.localRating + '/week/' + this.week + '/houseguest/' + this.houseguest + '/lfc/' + this.user)
                .then(res => {
                    this.saved = res.data.success;
                })
        }
    }
}
</script>

<style scoped>
div, input {
    /*background-color: transparent;*/
    min-height: 20px;
    min-width: 50px;
    width: 100%;
}

.evicted {
    background-color: rgba(255, 0, 0, .3);
}

.saved {
    background-color: rgba(0, 255, 0, .3);
}
</style>
