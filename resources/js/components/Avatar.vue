<template>
  <img
    :src="userAvatar"
    class="avatar"
    :width="width"
    :height="height"
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
    return {};
  },
    computed: {
        userAvatar: function () {
            return (this.user.avatar_url !== null && this.user.avatar_approved && !this.user.use_robot_avatar)
                ? this.user.avatar_url
                : '/images/robot-avatar-'+this.user.banks.length+'.svg';
        }
    }
};
</script>
