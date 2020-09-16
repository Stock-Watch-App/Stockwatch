<template>
    <span class="tag" :class="color">{{ label }}</span>
</template>

<script>
export default {
    props: {
        label: String,
    },
    computed: {
        color() {
            switch (this.label.toLowerCase()) {
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
