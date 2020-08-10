<template>
    <div>
        <img :src="robotAvatar" title="Robot" class="profile-pic"/>
        <img :src="customAvatar" title="Custom" class="profile-pic"/>
        <image-upload to="/account/avatar" @uploaded-file="uploadedFile"></image-upload>
    </div>
</template>

<script>
import ImageUpload from "./ImageUpload";
export default {
    components: {ImageUpload},
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
    methods: {
        uploadedFile(e) {
            this.custom = '/'+e;
        }
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
            if (this.user.avatar !== null) {
                return this.user.avatar.filename;
            }
            return '';
        }
    }
}
</script>

<style scoped>

</style>
