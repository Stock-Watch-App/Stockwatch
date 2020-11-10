<template>
    <img :class="customClass" :width="width" :height="height" :src="imageSrc" :alt="badge.name" :title="badge.name">
</template>

<script>
export default {
    props: {
        badge: Object,
        width: String,
        height: String,
        customClass: String
    },
    computed: {
      imageSrc: function () {
          return '/storage/'+this.badge.image.filename
      }
    }
}
</script>
