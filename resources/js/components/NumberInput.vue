<template>
  <div
    class="num-input-wrap"
    :class="{
      'number-input--controls': controls,
      [`number-input--${size}`]: size,
    }"
    v-on="listeners"
  >
    <button
      v-if="controls"
      class="button-base primary control-btn decrease"
      type="button"
      tabindex="-1"
      :disabled="disabled || readonly || !decreasable"
      @click="decrease"
    >
        <font-awesome-icon icon="minus"/>
    </button>
    <input
      ref="input"
      class="input num-input"
      v-bind="attrs"
      type="number"
      :name="name"
      :value="currentValue"
      :min="min"
      :max="max"
      :step="step"
      :readonly="readonly || !inputtable"
      :disabled="disabled || (!decreasable && !increasable)"
      :placeholder="placeholder"
      autocomplete="off"
      @change="change"
      @paste="paste"
    >
    <button
      v-if="controls"
      class="button-base primary control-btn increase"
      type="button"
      tabindex="-1"
      :disabled="disabled || readonly || !increasable"
      @click="increase"
    >
        <font-awesome-icon icon="plus"/>
    </button>
  </div>
</template>

<script>
const isNaN = Number.isNaN || window.isNaN;
const REGEXP_NUMBER = /^-?(?:\d+|\d+\.\d+|\.\d+)(?:[eE][-+]?\d+)?$/;
const REGEXP_DECIMALS = /\.\d*(?:0|9){10}\d*$/;
const normalizeDecimalNumber = (value, times = 100000000000) => (
  REGEXP_DECIMALS.test(value) ? (Math.round(value * times) / times) : value
);
export default {
  name: 'NumberInput',
  model: {
    event: 'change',
  },
  props: {
    attrs: {
      type: Object,
      default: undefined,
    },
    controls: Boolean,
    disabled: Boolean,
    inputtable: {
      type: Boolean,
      default: true,
    },
    max: {
      type: Number,
      default: Infinity,
    },
    min: {
      type: Number,
      default: -Infinity,
    },
    name: {
      type: String,
      default: undefined,
    },
    placeholder: {
      type: String,
      default: undefined,
    },
    readonly: Boolean,
    rounded: Boolean,
    size: {
      type: String,
      default: undefined,
    },
    step: {
      type: Number,
      default: 1,
    },
    value: {
      type: Number,
      default: NaN,
    },
  },
  data() {
    return {
      currentValue: NaN,
    };
  },
  computed: {
    /**
     * Indicate if the value is increasable.
     * @returns {boolean} Return `true` if it is decreasable, else `false`.
     */
    increasable() {
      const num = this.currentValue;
      return isNaN(num) || num < this.max;
    },
    /**
     * Indicate if the value is decreasable.
     * @returns {boolean} Return `true` if it is decreasable, else `false`.
     */
    decreasable() {
      const num = this.currentValue;
      return isNaN(num) || num > this.min;
    },
    /**
     * Filter listeners
     * @returns {Object} Return filtered listeners.
     */
    listeners() {
      const listeners = { ...this.$listeners };
      delete listeners.change;
      return listeners;
    },
  },
  watch: {
    value: {
      immediate: true,
      handler(newValue, oldValue) {
        if (
          // Avoid triggering change event when created
          !(isNaN(newValue) && typeof oldValue === 'undefined')
          // Avoid infinite loop
          && newValue !== this.currentValue
        ) {
          this.setValue(newValue);
        }
      },
    },
  },
  methods: {
    /**
     * Change event handler.
     * @param {string} value - The new value.
     */
    change(event) {
      this.setValue(Math.min(this.max, Math.max(this.min, event.target.value)));
    },
    /**
     * Paste event handler.
     * @param {Event} event - Event object.
     */
    paste(event) {
      const clipboardData = event.clipboardData || window.clipboardData;
      if (clipboardData && !REGEXP_NUMBER.test(clipboardData.getData('text'))) {
        event.preventDefault();
      }
    },
    /**
     * Decrease the value.
     */
    decrease() {
      if (this.decreasable) {
        let { currentValue } = this;
        if (isNaN(currentValue)) {
          currentValue = 0;
        }
        this.setValue(Math.min(this.max, Math.max(
          this.min,
          normalizeDecimalNumber(currentValue - this.step),
        )));
      }
    },
    /**
     * Increase the value.
     */
    increase() {
      if (this.increasable) {
        let { currentValue } = this;
        if (isNaN(currentValue)) {
          currentValue = 0;
        }
        this.setValue(Math.min(this.max, Math.max(
          this.min,
          normalizeDecimalNumber(currentValue + this.step),
        )));
      }
    },
    /**
     * Set new value and dispatch change event.
     * @param {number} value - The new value to set.
     */
    setValue(value) {
      const oldValue = this.currentValue;
      let newValue = this.rounded ? Math.round(value) : value;
      if (this.min <= this.max) {
        newValue = Math.min(this.max, Math.max(this.min, newValue));
      }
      this.currentValue = newValue;
      if (newValue === oldValue) {
        // Force to override the number in the input box (#13).
        this.$refs.input.value = newValue;
      }
      this.$emit('change', newValue, oldValue);
    },
  },
};
</script>
