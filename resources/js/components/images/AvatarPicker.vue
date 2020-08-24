<template>
    <div>



        <img :src="robotAvatar" title="Robot" class="profile-pic" :class="{selected: selected === 'robot'}" @click="pick('robot')"/>
        <img :src="customAvatar" title="Custom" class="profile-pic" :class="{selected: selected === 'custom'}" @click="pick('custom')"/>
        <image-upload to="/account/avatar/upload" @uploaded-file="uploadedFile"></image-upload>
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
    data() {
        return {
            selected: (this.user.use_robot_avatar) ? 'robot' : 'custom'
        }
    },
    methods: {
        uploadedFile(e) {
            console.log(e);
            this.custom = '/storage/' + e;
        },
        pick(type) {
            this.selected = type;
            axios.post('/account/avatar/use/' + type);
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
            if (this.user.avatar !== null) {
                return this.user.avatar.filename;
            }
            return '';
        }
    }
}
</script>

<style scoped>
img {
    max-height: 150px;
    max-width: 150px;
}
.selected {
    border: 3px solid blue;
}
</style>
