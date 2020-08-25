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
    methods: {},
    computed: {
        userAvatar: function () {
            let count = this.user.times_played || this.user.banks.length;
            this.title = count + ' time player';

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
