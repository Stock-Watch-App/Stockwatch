<template>
    <div class="avatar-picker">
        <h4>Profile Picture</h4>
        <div class="avatar-wrap" >
            <div :class="{selected: selected === 'robot'}" class="avatar-img-wrap" @click="pick('robot')" role="button">
                <img :src="robotAvatar" title="Robot" />
                <div><p v-show="selected === 'robot'" class="selected-text">Selected</p></div>
            </div>
            <div :class="{selected: selected === 'custom'}"  class="avatar-img-wrap" @click="pick('custom')" role="button">
                <img :src="customAvatar" title="Custom" />
                <div><p v-show="selected === 'custom'" class="selected-text">Selected</p></div>
            </div>
        </div>
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
    height: 100px;
    width: 100px;
    object-fit: none;
    object-position: center;
    border: 1px solid hsl(240, 4%, 75%);
    place-self: center;
}

.avatar-wrap {
    display: grid;
    grid-template-columns: 130px 130px;
    grid-template-rows: 130px;
    grid-gap: 1rem;
    margin-bottom: 1rem;
}

.avatar-img-wrap {
    display: grid;
    cursor: pointer;
}

.selected {
    border: 3px solid hsl(224, 90%, 53%);
}

.selected img {
    border: none;
}

.selected-text {
    background-color: hsl(224, 90%, 53%);
    color: white;
    text-align: center;
    margin-bottom: 0;
}
</style>
