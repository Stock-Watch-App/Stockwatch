<template>
  <select
    :name="name"
    @change="select"
    v-model="selected"
    :id="selectId"
    :disabled="disabled"
    :aria-label="ariaLabel"
    class="select-component"
  >
    <label v-if="label" class="visually-hidden-label" aria-hidden="true">{{ label }}</label>
    <option v-if="placeholder" value :selected="value == null" disabled>{{ placeholder }}</option>
    <option
      v-for="option in options"
      :value="option.value"
      :selected="option.value == value"
      :disabled="option.disabled"
      v-bind:key="option.value"
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
  methods: {
    /**
     * Emit an input event up to the parent.
     */
    select(e) {
      this.$emit("input", e.target.value);
    }
  },
  data() {
    return {};
  }
};
</script>
