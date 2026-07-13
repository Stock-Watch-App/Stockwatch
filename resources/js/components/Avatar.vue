<template>
    <img
        :src="userAvatar"
        class="avatar"
        v-bind:class="userAvatarBorder"
        :width="width"
        :height="height"
        :title="title"
        :alt="title"
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
    methods: {},
    computed: {
        userAvatar: function () {
            let count = this.user.times_played || this.user.banks.length;
            this.title = count + ' time player';

            if (this.user.avatar_url !== null && this.user.avatar_approved && !this.user.use_robot_avatar) {
                return this.user.avatar_url;
            } else {
                // robot-avatar-9.svg is the highest avatar available so use that avatar for users who have played 9+ times
                // Note: Avatars 5-9 are all the same color (black)
                const timesPlayedRank = count < 9 ? count : 9;
                return `/images/robot-avatar-${timesPlayedRank}.svg`;
            }
        },
        userAvatarBorder: function () {
            if (this.user.banks.length === 1) {
                return "avatarBorder1"
            }
            if (this.user.banks.length === 2) {
                return "avatarBorder2"
            }
            else if (this.user.banks.length === 3) {
                return "avatarBorder3"
            }
        }
    }
}
;
</script>
