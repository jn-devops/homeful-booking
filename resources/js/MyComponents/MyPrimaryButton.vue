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
        ? 'bg-gradient-to-r from-[#FCB115] to-[#CC035C] opacity-70'
        : 'bg-gradient-to-r from-[#FCB115] to-[#CC035C]'
);
</script>
<template>

    <button :class="['text-white flex items-center justify-center', buttonClass]">
        <slot />
    </button>
</template>
<style>
    .bg_color{
     background: linear-gradient(268.1deg, #CC035C 7.47%, #FCB115 98.92%);
    }
</style>
