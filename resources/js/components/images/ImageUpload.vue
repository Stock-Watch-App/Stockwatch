<template>
<div>
    <label for="file">Choose file to upload</label>
    <input id="file" name="file" type="file" accept="image/*,.jpg,.jpeg,.png" @change="onFileSelected" class="file-input">
    <p class="bodySM bodyLight">Accepted file types: jpg, png. Image must not exceed 500kb. Only one custom image will be stored alongside the default robot. Once selected, your image will be updated globally.</p>
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

.file-input {
    margin-bottom: 1rem;
}
</style>
