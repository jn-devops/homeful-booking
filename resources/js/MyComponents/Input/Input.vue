<template>
    <div class="max-w-sm space-y-3 mb-5">
        <label for="input_field" class="font-semibold">{{ label }}</label>
        <input 
            :id="id"
            :name="name"
            :type="type"
            :placeholder="placeholder"
            :maxlength="maxlength"
            :value="modelValue"
            class="py-3 px-4 block w-full border-2 border-stone-200 rounded-full text-sm m-0" 
            @input="$emit('update:modelValue', $event.target.value)"
            :class="errorMessage ? 'border-2 border-rose-600' : ''"
        >
        <span v-if="errorMessage" class="text-rose-600">{{ errorMessage }}</span>
    </div>
</template>

<script setup>
import { ref, watch, defineProps, defineEmits } from 'vue';
const props = defineProps({
    modelValue: String,
    label: String,
    placeholder: String,
    type: {
        type: String,
        required: true,
    },
    id: String,
    name: String,
    label: String,
    placeholder: String,
    maxlength: String,
    errorMessage: String
})

const emit = defineEmits(['update:modelValue']);

// const inputValue = ref(props.modelValue);

// watch(inputValue, (newValue) => {
//     emits('update:modelValue', newValue);
// });

</script>