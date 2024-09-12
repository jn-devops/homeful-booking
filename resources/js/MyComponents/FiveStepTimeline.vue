<template>
    <div class="flex px-6 text-sm">
        <div class="space-y-5 border-l-2 border-solid border-[#DFDFDF]">
            <!-- Step 1 -->
            <div class="relative w-full">
                <div :class="['absolute -top-0.5 z-5 -ml-3.5 h-6 w-6 rounded-full', { 'bg-[#DFDFDF]': currrentStep < 1, 'bg-[#E5883C]': currrentStep == 1, 'bg-[#4CAF50]': currrentStep > 1 }]">
                    <div v-if="currrentStep < 1">
                        &nbsp;
                    </div>
                    <div v-else-if="currrentStep == 1">
                        <LottiefileAnimation v-if="lottieJson" :animationData="lottieJson" />
                    </div>
                    <div class="p-1" v-else-if="currrentStep > 1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check text-white"><path d="M20 6 9 17l-5-5"/></svg>
                    </div>
                </div>
                <div class="ml-6">
                    <h4 :class="[{ 'text-[#8B8B8B]': currrentStep < 1, 'text-[#E5883C] font-bold': currrentStep == 1, 'text-[#4CAF50]': currrentStep > 1}]">Register</h4>
                </div>
            </div>
            <!-- Step 2 -->
            <div class="relative w-full">
                <div :class="['absolute -top-0.5 z-5 -ml-3.5 h-6 w-6 rounded-full', { 'bg-[#DFDFDF]': currrentStep < 2, 'bg-[#E5883C]': currrentStep == 2, 'bg-[#4CAF50]': currrentStep > 2 }]">
                    <div v-if="currrentStep < 2">
                        &nbsp;
                    </div>
                    <div v-else-if="currrentStep == 2">
                        <LottiefileAnimation v-if="lottieJson" :animationData="lottieJson" />
                    </div>
                    <div class="p-1" v-else-if="currrentStep > 2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check text-white"><path d="M20 6 9 17l-5-5"/></svg>
                    </div>
                </div>
                <div class="ml-6">
                    <h4 :class="[{ 'text-[#8B8B8B]': currrentStep < 2, 'text-[#E5883C] font-bold': currrentStep == 2, 'text-[#4CAF50]': currrentStep > 2}]">Verify your Identity</h4>
                </div>
            </div>
            <!-- Step 3 -->
            <div class="relative w-full">
                <div :class="['absolute -top-0.5 z-5 -ml-3.5 h-6 w-6 rounded-full', { 'bg-[#DFDFDF]': currrentStep < 3, 'bg-[#E5883C]': currrentStep == 3, 'bg-[#4CAF50]': currrentStep > 3 }]">
                    <div v-if="currrentStep < 3">
                        &nbsp;
                    </div>
                    <div v-else-if="currrentStep == 3">
                        <LottiefileAnimation v-if="lottieJson" :animationData="lottieJson" />
                    </div>
                    <div class="p-1" v-else-if="currrentStep > 3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check text-white"><path d="M20 6 9 17l-5-5"/></svg>
                    </div>
                </div>
                <div class="ml-6">
                    <h4 :class="[{ 'text-[#8B8B8B]': currrentStep < 3, 'text-[#E5883C] font-bold': currrentStep == 3, 'text-[#4CAF50]': currrentStep > 3}]">Complete Data Form</h4>
                </div>
            </div>
            <!-- Step 4 -->
            <div class="relative w-full">
                <div :class="['absolute -top-0.5 z-5 -ml-3.5 h-6 w-6 rounded-full', { 'bg-[#DFDFDF]': currrentStep < 4, 'bg-[#E5883C]': currrentStep == 4, 'bg-[#4CAF50]': currrentStep > 4 }]">
                    <div v-if="currrentStep < 4">
                        &nbsp;
                    </div>
                    <div v-else-if="currrentStep == 4">
                        <LottiefileAnimation v-if="lottieJson" :animationData="lottieJson" />
                    </div>
                    <div class="p-1" v-else-if="currrentStep > 4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check text-white"><path d="M20 6 9 17l-5-5"/></svg>
                    </div>
                </div>
                <div class="ml-6">
                    <h4 :class="[{ 'text-[#8B8B8B]': currrentStep < 4, 'text-[#E5883C] font-bold': currrentStep == 4, 'text-[#4CAF50]': currrentStep > 4}]">Pay Consulting Fee</h4>
                </div>
            </div>
            <!-- Step 5 -->
            <div class="relative w-full">
                <div :class="['absolute -top-0.5 z-5 -ml-3.5 h-6 w-6 rounded-full', { 'bg-[#DFDFDF]': currrentStep < 5, 'bg-[#E5883C]': currrentStep == 5, 'bg-[#4CAF50]': currrentStep > 5 }]">
                    <div v-if="currrentStep < 5">
                        &nbsp;
                    </div>
                    <div v-else-if="currrentStep == 5">
                        <LottiefileAnimation v-if="lottieJson" :animationData="lottieJson" />
                    </div>
                    <div class="p-1" v-else-if="currrentStep > 5">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check text-white"><path d="M20 6 9 17l-5-5"/></svg>
                    </div>
                </div>
                <div class="ml-6">
                    <h4 :class="[{ 'text-[#8B8B8B]': currrentStep < 5, 'text-[#E5883C] font-bold': currrentStep == 5, 'text-[#4CAF50]': currrentStep > 5}]">Get Qualified</h4>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {ref, onMounted} from 'vue';
import LottiefileAnimation from '@/Logos/Animation/LottiefileAnimation.vue';

const lottieJson = ref(null);
const props = defineProps({
    currrentStep: Number,
});

onMounted(async () => {
  const response = await fetch('/animation/proceed.json');

  lottieJson.value = await response.json();
});
</script>