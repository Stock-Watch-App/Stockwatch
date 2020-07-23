<template>
    <select
        :name="name"
        @change="select"
        v-model="selectedValue"
        :id="selectId"
        :disabled="disabled"
        :aria-label="ariaLabel"
        class="select-component"
    > <label v-if="label" class="visually-hidden-label" aria-hidden="true">{{ label }}</label>
        <option v-if="placeholder" :selected="selectedValue === null" disabled>{{ placeholder }}</option>
        <slot></slot>
        <option
            v-for="option in options"
            :value="option.value"
            :selected="option.value === selectedValue"
            :disabled="option.disabled"
            :key="option.value"
            v-text="option.text"
        ></option>
    </select>
</template>

<script>
    export default {
        props: {
            selectId: String,
            disabled: Boolean,
            ariaLabel: String,
            options: {
                type: Array,
                default: () => []
            },
            name: String,
            label: String,
            placeholder: String,
            value: {
                default: null
            }
        },
        data() {
            return {
                selectedValue: this.value,
            }
        },
        watch: {
            value: function (value) {
                this.selectedValue = value;
            }
        },
        methods: {
            /**
             * Emit an input event up to the parent.
             */
            select(e) {
                this.$emit("input", e.target.value);
            }
        },
    };
</script>
