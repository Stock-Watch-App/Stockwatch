<template>
<div>
    <input type="file" @change="onFileSelected">
    <button class="button-base icon secondary small uploadbtn" :disabled="!selectedFile" @click="onUpload">
        <figure>
            <font-awesome-icon :icon="['fas', 'file-upload']" />
        </figure>
        <span>Upload</span>
    </button>
</div>
</template>

<script>
export default {
    props: {
        to: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            selectedFile: null
        }
    },
 methods: {
     onFileSelected(e) {
        this.selectedFile = e.target.files[0]
     },
     onUpload() {
         const fd = new FormData();
         fd.append('image', this.selectedFile, this.selectedFile.name)
         axios.post(this.to, fd, {
             onUploadProgress: uploadEvent => {
                 // console.log(uploadEvent.loaded/uploadEvent.total * 100)
             }
         }).then(res => {
             this.$emit('uploaded-file', res.data);
         })
     }
 }
}
</script>

<style scoped>
.uploadbtn {
    margin-top: 1rem;
}
</style>
