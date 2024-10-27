<script setup>
import { watch, toRefs } from 'vue';

const props = defineProps({
    currentStep: {
        type: Number,
        required: true
    },
    employmentDetails: Boolean
});

const { currentStep } = toRefs(props);

watch(currentStep, (newVal, oldVal) => {
    console.log('Step changed from', oldVal, 'to', newVal);
});
</script>

<template>
    <div class="block md:hidden bg-[#E1ECF8] pt-10 pb-4 px-4">
        <div class="flex gap-2 justify-around items-center">
            <!-- Step 1 -->
            <div v-if="currentStep === 0" class="relative size-20">
                <svg class="size-full -rotate-90" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-stone-300" stroke-width="2"></circle>
                    <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-green-600 " stroke-width="2" stroke-dasharray="100" stroke-dashoffset="66.67" stroke-linecap="square"></circle>
                </svg>
                <div class="absolute top-1/2 start-1/2 transform -translate-y-1/2 -translate-x-1/2">
                    <span class="text-center text-xs font-bold">1 of 3</span>
                </div>
            </div>

            <!-- Step 2 -->
            <div v-if="currentStep === 1" class="relative size-20">
                <svg class="size-full -rotate-90" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-stone-300 dark:text-neutral-700" stroke-width="2"></circle>
                    <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-green-600 dark:text-blue-500" stroke-width="2" stroke-dasharray="100" stroke-dashoffset="33.33" stroke-linecap="round"></circle>
                </svg>
                <div class="absolute top-1/2 start-1/2 transform -translate-y-1/2 -translate-x-1/2">
                    <span class="text-center text-xs font-bold ">2 of 3</span>
                </div>
            </div>

            <!-- Step 3 or 4 -->
            <div v-if="currentStep === 2 || currentStep === 3" class="relative size-20">
                <svg class="size-full -rotate-90" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-stone-300 dark:text-neutral-700" stroke-width="2"></circle>
                    <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-green-600 dark:text-blue-500" stroke-width="2" stroke-dasharray="100" stroke-dashoffset="0" stroke-linecap="round"></circle>
                </svg>
                <div class="absolute top-1/2 start-1/2 transform -translate-y-1/2 -translate-x-1/2">
                    <span class="text-center text-xs font-bold">3 of 3</span>
                </div>
            </div>
            <div class="text-right">
                <div v-if="currentStep === 0">
                    <h1 class="font-bold">Personal Information</h1>
                    <p class="text-xs/relaxed">Next Employment Information</p>
                </div>
                <div v-if="currentStep === 1">
                    <h1 class="font-bold">Employment Information</h1>
                    <p class="text-xs/relaxed">Next Payment</p>
                </div>
                <div v-if="currentStep === 2">
                    <h1 class="font-bold">Attachment</h1>
                    <p class="text-xs/relaxed">Review and Submit</p>
                </div>
                <div v-if="currentStep === 3">
                    <h1 class="font-bold">Review Details</h1>
                    <p class="text-xs/relaxed">Review and Submit</p>
                </div>
            </div>
        </div>
    </div>
    <!-- The desktop version can be similarly updated -->
</template>

<style>
.bg-top-right-green {
    background: linear-gradient(to bottom left, #68D391 30%, transparent 30%);
}
.bg-top-left-green {
    background: linear-gradient(to bottom right, #68D391 50%, transparent 50%);
}
</style>
