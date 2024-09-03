<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
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
        default: ''
    },
    required: {
        type: Boolean,
        default: false
    },
    prefix: {
        type: String,
        default: '*'
    },
    type: {
        type: String,
        default: 'text',
        validator: (value) => ['text', 'email', 'number'].includes(value)
    }
});

const emit = defineEmits(['update:modelValue']);

// Create a ref for the input value
const inputValue = ref(props.modelValue);

// Watch the modelValue prop and update the input value accordingly
watch(() => props.modelValue, (newValue) => {
    inputValue.value = newValue;
});

// Emit the input value when it changes
watch(inputValue, (newValue) => {
    emit('update:modelValue', newValue);
});
</script>

<template>
    <div class="mb-4 w-full">
        <label :for="id" class="block text-sm font-medium mb-2 dark:text-white">
            {{ label }}
            <span v-if="required" class="text-red-600">*</span>
        </label>
        <div class="relative">
            <div v-if="prefix != '*'" class="flex flex-cols gap-2 items-center">
                <div class="text-stone-400 w-fit">
                    {{ prefix }}
                </div>
                <div class="w-full">
                    <input
                        :id="id"
                        :name="id"
                        :type="type"
                        :placeholder="placeholder"
                        :required="required"
                        class="py-3 px-4 block w-full text-black rounded-lg text-sm focus:ring-1 focus:ring-opacity-50 border border-stone-300   dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 placeholder:text-stone-300"
                        :class="{
                            'border-red-500 focus:border-red-500 focus:ring-red-500': errorMessage,
                            'border-teal-500 focus:border-teal-500 focus:ring-teal-500': !errorMessage && inputValue.length > 0,
                            'border-stone-300': !errorMessage && inputValue.length === 0
                        }"
                        v-model="inputValue"
                        :aria-describedby="`${id}-helper`"
                    />
                </div>
            </div>
            <div v-else>
                <input
                        :id="id"
                        :name="id"
                        :type="type"
                        :placeholder="placeholder"
                        :required="required"
                        class="py-3 px-4 block w-full text-black rounded-lg text-sm focus:ring-1 focus:ring-opacity-50 border border-stone-300   dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 placeholder:text-stone-300"
                        :class="{
                            'border-red-500 focus:border-red-500 focus:ring-red-500': errorMessage,
                            'border-teal-500 focus:border-teal-500 focus:ring-teal-500': !errorMessage && inputValue.length > 0,
                            'border-stone-300': !errorMessage && inputValue.length === 0
                        }"
                        v-model="inputValue"
                        :aria-describedby="`${id}-helper`"
                    />
            </div>
            <div v-if="errorMessage" class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                <svg class="shrink-0 size-4 text-red-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" x2="12" y1="8" y2="12"></line>
                    <line x1="12" x2="12.01" y1="16" y2="16"></line>
                </svg>
            </div>
            <div v-else-if="inputValue.length > 0" class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                <svg class="shrink-0 size-4 text-teal-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
        </div>
        <p v-if="errorMessage" class="mt-2 text-sm text-red-600" :id="`${id}-helper`">
            {{ errorMessage }}
        </p>
        <p v-if="helperText && !errorMessage" class="mt-2 text-sm text-gray-500 dark:text-neutral-400" :id="`${id}-helper`">
            {{ helperText }}
        </p>
    </div>
</template>
