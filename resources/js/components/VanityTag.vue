<template>
    <span class="tag" :class="this.name.toLowerCase()">{{ name }}</span>
</template>

<script>
export default {
    props: {
        name: String,
    },
    // computed: {
    //     color() {
    //         switch (this.name.toLowerCase()) {
    //             case 'lfc':
    //                 return
    //             default:
    //                 return
    //         }
    //     }
    // }
}
</script>

<style scoped>

</style>
