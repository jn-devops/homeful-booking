<script setup>
import { computed } from 'vue';
const props = defineProps({
    isDisabled: {
        type: Boolean,
        default: false
    }
});
const buttonClass = computed(() =>
    props.isDisabled
        ? 'bg-transparent border-solid border-2 border[#CC035C] opacity-70'
        : 'bg-transparent border-solid border-2 border[#CC035C]'
);
</script>
<template>

    <button :class="['text-[#CC035C] flex items-center justify-center', buttonClass]">
        <slot />
    </button>
</template>
<style>
    .bg_color{
     background: linear-gradient(268.1deg, #CC035C 7.47%, #FCB115 98.92%);
    }
</style>
