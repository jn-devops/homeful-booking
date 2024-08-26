<template>
    <div class="mb-4 w-full">
      <div class="flex gap-x-6">
        <div class="flex">
          <label for="hs-radio-group" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">
            {{ label }}
            <span v-if="required" class="text-red-600">*</span>
          </label>
        </div>
        <div class="flex" v-for="(option, index) in options" :key="index">
          <input
            type="radio"
            :name="name"
            :id="`${name}-${index}`"
            :value="option.value"
            v-model="selectedValue"
            :required="required"
            class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
          />
          <label :for="`${name}-${index}`" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">
            {{ option.label }}
          </label>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, watch } from 'vue';

  const props = defineProps({
    label: {
      type: String,
      required: true
    },
    options: {
      type: Array,
      required: true,
      default: () => []
    },
    modelValue: {
      type: String,
      default: ''
    },
    name: {
      type: String,
      required: true
    },
    required: {
      type: Boolean,
      default: false
    }
  });

  const emit = defineEmits(['update:modelValue']);
  const selectedValue = ref(props.modelValue);

  watch(selectedValue, (newValue) => {
    emit('update:modelValue', newValue);
  });

  watch(() => props.modelValue, (newValue) => {
    selectedValue.value = newValue;
  });
  </script>
