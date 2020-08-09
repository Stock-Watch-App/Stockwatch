<template>
    <div>
        <img :src="robotAvatar" title="Custom" class="profile-pic"/>
        <img :src="customAvatar" title="Robot" class="profile-pic"/>
    </div>
</template>

<script>
export default {
    props: {
        user: Object,
        robot: {
            type: String,
            default: ''
        },
        custom: {
            type: String,
            default: ''
        },
    },
    computed: {
        robotAvatar() {
            if (this.robot !== '') {
                return this.robot;
            }
            return '/images/robot-avatar-' + this.user.banks.length + '.svg';

        },
        customAvatar() {
            if (this.custom !== '') {
                return this.custom;
            }
            return this.user.image.filename;
        }
    }
}
</script>

<style scoped>

</style>
