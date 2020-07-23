<template>
    <button class="button-base primary" :aria-labelledby="ariaLabelledById" @click="$emit('click')">
        <font-awesome-icon :icon="icon"/>
        <div :id="ariaLabelledById" hidden>{{ buttonLabel }}</div>
    </button>
</template>

<script>
    export default {
        props: {
            buttonLabel: String,
            disabled: Boolean,
            ariaLabelledById: String,
            icon: String
        },
        methods: {},
        data() {
            return {};
        }
    };
</script>
