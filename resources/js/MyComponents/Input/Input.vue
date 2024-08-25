<template>
    <div class="max-w-sm space-y-3 mb-5">
        <label for="input_field" class="font-semibold">{{ label }}</label>
        <input 
            id="input_field"
            type="text" 
            v-model="inputValue"
            class="py-3 px-4 block w-full border-stone-200 rounded-full text-sm m-0" 
            :placeholder="placeholder"
        >
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
    }
})

const emits = defineEmits(['update:modelValue']);

const inputValue = ref(props.modelValue);

watch(inputValue, (newValue) => {
    emits('update:modelValue', newValue);
});

</script>