<template>
    <img
        :src="userAvatar"
        class="avatar"
        :width="width"
        :height="height"
        :title="title"
    />
</template>

<script>
export default {
    props: {
        user: Object,
        width: String,
        height: String
    },
    data() {
        return {
            title: ''
        };
    },
    methods: {
        suffix: function (i) {
            let j = i % 10,
                k = i % 100;
            if (j === 1 && k !== 11) {
                return i + "st";
            }
            if (j === 2 && k !== 12) {
                return i + "nd";
            }
            if (j === 3 && k !== 13) {
                return i + "rd";
            }
            return i + "th";
        }
    },
    computed: {
        userAvatar: function () {
            let count = this.user.banks.length
            this.title = this.suffix(count) + ' time player';
            // this is misleadingr on the all-time leaderboard. fix later?

            if (this.user.avatar_url !== null && this.user.avatar_approved && !this.user.use_robot_avatar) {
                return this.user.avatar_url;
            } else {
                return '/images/robot-avatar-'+count+'.svg';
            }
        }
    }
}
;
</script>
