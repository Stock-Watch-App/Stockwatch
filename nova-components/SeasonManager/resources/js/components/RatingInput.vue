<template>
    <div>
        <input
            v-if="status === 'active'"
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
        rating: function() {
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
                        this.houseguest +
                        "/lfc/" +
                        this.user
                )
                .then(res => {
                    this.saved = res.data.success;
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
}

.evicted {
    background-color: hsl(0, 81%, 90%);
}

.saved {
    background-color: hsla(224, 90%, 53%, 0.2);
}
</style>
