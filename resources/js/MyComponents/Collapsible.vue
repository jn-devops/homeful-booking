<script setup>
import { ref } from 'vue';

const isOpen = ref(false);

const toggleAccordion = () => {
    isOpen.value = !isOpen.value;
};
</script>

<template>
    <div class="relative w-full overflow-hidden">
        <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-12 opacity-0 z-10 cursor-pointer" @change="toggleAccordion">
        <div class="h-12 w-full flex items-center mb-3 gap-1 border-b-2">
            <h1 v-if="$slots.collapsibleName" class="font-semibold underline dark:text-white light:text-black flex-1 pl-2">
                <slot name="collapsibleName" />
            </h1>
            <!-- Icon Arrow -->
            <div class="ml-auto transition-transform duration-500 transform" :class="{ 'rotate-180': isOpen }">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 dark:text-white light:text-black">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg> -->
                <svg width="9" height="6" viewBox="0 0 9 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.90258 0.892612L0.705012 4.1072C0.0763564 4.7392 0.52645 5.8156 1.41787 5.81227L7.62072 5.78915C8.49564 5.78588 8.9448 4.73998 8.34471 4.10328L5.33806 0.913195C4.95059 0.502091 4.30098 0.492094 3.90258 0.892612Z" fill="black"/>
                </svg>

            </div>
        </div>
        <!-- Content -->
        <div class="overflow-hidden transition-all duration-500 max-h-0 overflow-y-auto" :class="{ 'max-h-80 ': isOpen }">
            <div>
                <slot />
            </div>
        </div>
    </div>
</template>



<style scoped>
.rotate-180 {
    transform: rotate(180deg);
}
</style>
