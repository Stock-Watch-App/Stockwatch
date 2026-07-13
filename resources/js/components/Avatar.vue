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
            switch (true) {
                case this.user.banks.length === 1:
                    return "avatarBorder1";
                case this.user.banks.length === 2:
                    return "avatarBorder2";
                case this.user.banks.length === 3:
                    return "avatarBorder3";
                case this.user.banks.length === 4:
                    return "avatarBorder4";
                // Times played of 5 and above use the same avatar color so set 5+ to the highest rank color
                case this.user.banks.length >= 5:
                    return "avatarBorderHighestRank";
                default:
                    return "";
            }
        }
    }
};
</script>
