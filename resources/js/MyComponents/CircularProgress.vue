<script setup>
import { ref } from 'vue';

const props = defineProps({
    currentProgress: Number,
})
let percentProgress = ref(0);

switch(props.currentProgress){
    case 1:
        percentProgress = 80
        break
    case 2:
        percentProgress = 60
        break
    case 3:
        percentProgress = 40
        break
    case 4:
        percentProgress = 20
        break
    case 5:
        percentProgress = 0
        break
    default:
        percentProgress = 80
}

</script>
<template>
    <!-- Circular Progress -->
    <div class="relative size-24">
        <svg class="size-full -rotate-90" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
            <!-- Background Circle -->
            <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-slate-300 dark:text-neutral-700" stroke-width="3"></circle>
            <!-- Progress Circle -->
            <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-blue-600" stroke-width="3" stroke-dasharray="100" :stroke-dashoffset="percentProgress" stroke-linecap="round"></circle>
        </svg>

        <!-- Percentage Text -->
        <div class="absolute top-1/2 start-1/2 transform -translate-y-1/2 -translate-x-1/2">
            <span class="text-center text-md font-semibold">{{ currentProgress }} of 5</span>
        </div>
    </div>
    <!-- End Circular Progress -->
</template>