<template>
    <span >
        <img class="leaderboard-badge" :src="imageSrc" :alt="badge.name" :title="badge.name">
    </span>
</template>

<script>
export default {
    props: {
        badge: Object
    },
    computed: {
      imageSrc: function () {
          return '/storage/'+this.badge.image.filename
      }
    }
}
</script>

<style scoped>

</style>
