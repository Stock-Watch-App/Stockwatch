<template>
    <span class="tag" :class="this.name.toLowerCase()">{{ name }}</span>
</template>

<script>
export default {
    props: {
        name: String,
    },
    computed: {
        color() {
            switch (this.name.toLowerCase()) {
                // katie's attempt, it doesn't work
                case lfc:
                    name.class = "lfc";
                    break;
                case nom:
                    name.class = "nom";
                    break;
                case hoh:
                    name.class = "hoh";
                    break;
                case veto:
                    name.class = "veto";
                    break;
                // case 'lfc':
                //     return
                default:
                    return
            }
        }
    }
}
</script>

<style scoped>

</style>
