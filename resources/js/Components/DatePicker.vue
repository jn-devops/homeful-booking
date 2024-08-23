<template>
  <div class="mb-4 w-full">
    <label :for="id" class="block text-sm font-medium mb-2 dark:text-white">
      <span v-if="required" class="text-red-600">*</span>
      {{ label }}
    </label>
    <DatePicker v-model="date" :popover="popover">
      <template #default="{ togglePopover }">
        <button
          type="button"
          class="py-3 px-4 block w-full rounded-lg text-left text-sm border-2 border-stone-300 focus:ring-1 focus:ring-opacity-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400"
          @click="togglePopover"
        >
       {{  date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) }}
        </button>
      </template>
    </DatePicker>
    <p v-if="helperText" class="mt-2 text-sm text-gray-500 dark:text-gray-400">
      {{ helperText }}
    </p>
    <p v-if="errorMessage" class="mt-2 text-sm text-red-600">
      {{ errorMessage }}
    </p>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { setupCalendar, Calendar, DatePicker } from 'v-calendar';
import 'v-calendar/style.css';

const props = defineProps({
  id: {
    type: String,
    required: true
  },
  label: {
    type: String,
    required: true
  },
  required: {
    type: Boolean,
    default: false
  },
  helperText: {
    type: String,
    default: ''
  },
  errorMessage: {
    type: String,
    default: ''
  }
});

const date = ref(new Date());
const popover = ref({
  visibility: 'click',
});
</script>
