<template>
    <span class="tag" :class="color">{{ name }}</span>
</template>

<script>
export default {
    props: {
        name: String,
    },
    computed: {
        color() {
            switch (this.name.toLowerCase()) {
                case 'lfc':
                    return 'lfc';
                case 'nominated':
                    return 'nom';
                case 'hoh':
                    return 'hoh';
                case 'veto':
                    return 'veto';
                default:
                    return
            }
        }
    }
}
</script>

<style scoped>

</style>
