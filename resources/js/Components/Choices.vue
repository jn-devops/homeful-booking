<template>
    <div class="mb-4 w-full">
      <label :for="id" class="block text-sm font-medium mb-2 dark:text-white">
        <span v-if="required" class="text-red-600">*</span>
        {{ label }}
      </label>
      <div class="relative">
        <select
          ref="selectElement"
          :id="id"
          :required="required"
          :disabled="disabled"
          :data-hs-select="computedSelectOptions"
          :value="modelValue"
          @change="onInputChange"
          class="hidden">
          <option value="">{{ placeholder }}</option>
          <option
            v-for="option in Object.keys(options).map(key => ({ id: options[key], name: key }))"
            :key="option.id"
            :value="option.id">{{ option.name }}
          </option>
        </select>
      </div>
      <p v-if="errorMessage" class="mt-2 text-sm text-red-600" :id="`${id}-helper`">
        {{ errorMessage }}
      </p>
      <p v-if="helperText && !errorMessage" class="mt-2 text-sm text-gray-300 dark:text-neutral-400" :id="`${id}-helper`">
        {{ helperText }}
      </p>
    </div>
  </template>
<script>
import { ref, watch } from 'vue';

export default {
  name: "CustomSelect",
  props: {
    id: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: true
    },
    modelValue: {
      type: String,
      default: ''
    },
    errorMessage: {
      type: String,
      default: ''
    },
    helperText: {
      type: String,
      default: ''
    },
    placeholder: {
      type: String,
      default() {
        return ``;
      }
    },
    options: {
      type: Object,
      default: () => ({}),
    },
    required: {
      type: Boolean,
      default: false
    },
    searchable: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      hsSelectInstance: null,
      uniqueKey: 0, // A key to force re-render
      inputValue: ref(this.modelValue) // Initialize ref for input value
    };
  },
  computed: {
    computedSelectOptions() {
      return JSON.stringify({
        "hasSearch": this.searchable,
        "searchPlaceholder": this.placeholder,
        "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
        "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",
        "placeholder": this.placeholder,
        "toggleTag": "<button type=\"button\" aria-expanded=\"false\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-300 dark:text-neutral-200 \" data-title></span></button>",
        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-stone-300 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600",
        "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-stone-300 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
        "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
        "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 dark:text-neutral-200 \" data-title></div></div></div>",
        "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
      });
    }
  },
  watch: {
    options: {
      handler() {
        this.reinitializeSelect();
      },
      deep: true,
    },
    modelValue(newValue) {
      this.inputValue = newValue;
    },
    inputValue(newValue) {
    //   this.$emit('update:modelValue', newValue);
    }
  },
  mounted() {
    this.initializeSelect();
  },
  methods: {
    initializeSelect() {
      this.destroySelect();
      this.$nextTick(() => {
        if (!this.$refs.selectElement) {
          this.hsSelectInstance = new HSSelect(this.$refs.selectElement);
          this.hsSelectInstance.on('change', this.onInputChange);
        }
      });
    },
    destroySelect() {
      if (this.hsSelectInstance) {
        this.hsSelectInstance.destroy();
        this.hsSelectInstance = null;
      }
    },
    reinitializeSelect() {
      this.uniqueKey += 1;
      this.$nextTick(() => {
        this.initializeSelect();
      });
    },
    onInputChange(event) {
        this.$emit('update:modelValue', event.target.value);
    },
  },
};
</script>

<style scoped>
</style>
