<template>
  <input
    id="myinput"
    type="range"
    :min="min"
    :max="max"
    ref="rangeInput"
    class="range-slider"
    :value="modelValue"
    @input="updateRange"
  >
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';

const props = defineProps({
    modelValue: {
        type: Number,
        default: 0
    },
    min: {
        type: [Number, String],
        default: 0,
    },
    max: {
        type: [Number, String],
        default: 100,
    },
});

const emit = defineEmits(['update:modelValue']);
const rangeInput = ref(null);

const updateRange = (event) => {
    const range = event.target;
    updateRangeBackground(range);
    emit('update:modelValue', Number(range.value));
};

const updateRangeBackground = (range) => {
    if (!range) return;
    const value = (props.modelValue - range.min) / (range.max - range.min) * 100;
    range.style.background = `linear-gradient(to right, #C87A2C 0%, #C87A2C ${value}%, #cfcfcf ${value}%, #cfcfcf 100%)`;
};

watch(() => props.modelValue, (newVal) => {
    if (rangeInput.value) {
        updateRangeBackground(rangeInput.value);
    }
}, { immediate: true });

onMounted(() => {
    if (rangeInput.value) {
        updateRangeBackground(rangeInput.value);
    }
});

</script>

<style scoped>
#myinput {
  background: linear-gradient(to right, #C87A2C 0%, #cfcfcf 0%, #cfcfcf 100%);
  border: solid 1px #cfcfcf;
  border-radius: 8px;
  height: 15px;
  width: 100%;
  outline: none;
  transition: background 450ms ease-in;
  -webkit-appearance: none;
}

input[type=range]::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 30px; /* Thumb width */
  height: 30px; /* Thumb height */
  border-radius: 50%;
  background: #fff; /* Thumb color */
  cursor: pointer;
  box-shadow: 2px 2px 5px #797979;
}
</style>
