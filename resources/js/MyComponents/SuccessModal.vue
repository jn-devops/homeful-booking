<template>
    <div id="hs-scale-animation-modal" class="hs-overlay-backdrop-open:bg-zinc-800/50 hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none" role="dialog" tabindex="-1" aria-labelledby="hs-scale-animation-modal-label">
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
            <div class="w-full flex flex-col bg-white border border-slate-200 shadow-sm rounded-xl pointer-events-auto">
                <div class="p-4 overflow-y-auto py-10">
                    <div class="flex justify-center">
                        <div class="w-4/6">
                            <LottiefileAnimation v-if="lottieJson" :animationData="lottieJson" />
                        </div>
                    </div>
                    <p class="text-center text-3xl font-bold">
                        <slot />
                    </p>
                    <p class="text-center text-red-700">
                        Next Step ({{ seconds }}s)
                    </p>
                    <button ref="closeModalButton" type="button" class="hidden" data-hs-overlay="#hs-scale-animation-modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, onMounted, onUnmounted, nextTick} from 'vue';
import LottiefileAnimation from '@/Logos/Animation/LottiefileAnimation.vue';

const lottieJson = ref(null);
const closeModalButton = ref(null);
const seconds = ref(5);
let timer = null;

const openSuccessModal = () => {
    seconds.value = 5;
    HSOverlay.open('#hs-scale-animation-modal');
    startTimer();
}

const startTimer = () => {
    timer = setInterval(() => {
        seconds.value -= 1;
        if (seconds.value === 0) {
            closeModalButton.value.click();
            clearInterval(timer);
        }
    }, 1000);
};

defineExpose({ openSuccessModal });

onMounted(async () => {
    const response = await fetch('/animation/SuccessAnimation.json');
    lottieJson.value = await response.json();

});

onUnmounted(() => {
  if (timer) {
    clearInterval(timer);
  }
});
</script>
