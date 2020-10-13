<template>
    <div>
        <input
            v-if="status === 'active'"
            type="number"
            min="1"
            max="10"
            class=""
            :class="{ saved: saved }"
            v-model="localRating"
            @change="save"
        />
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
            localRating: this.rating
        };
    },
    watch: {
        rating: function () {
            this.localRating = this.rating;
        }
    },
    methods: {
        save() {
            axios
                .post(
                    "/nova-vendor/season-manager/save/rating/" +
                    this.localRating +
                    "/week/" +
                    this.week +
                    "/houseguest/" +
                    this.houseguest.replace(' ', '-').toLowerCase() +
                    "/lfc/" +
                    this.user
                )
                .then(res => {
                    // this.saved = res.data.success;
                    this.$emit('saved', {
                        saved: res.data.success,
                        rating: this.localRating,
                        user: this.user,
                    })
                });
        }
    }
};
</script>

<style scoped>
div,
input {
    width: 100%;
    text-align: center;
    background-color: transparent;
}

.evicted {
    background-color: hsl(0, 81%, 90%);
}

.saved {
    background-color: hsla(224, 90%, 53%, 0.2);
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
