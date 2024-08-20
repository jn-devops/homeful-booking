<template>
    <nav class="fixed top-0 left-0 w-full bg-transparent z-10 ">
        <div class="bg-gradient-to-b from-black/80 to-transparent">
            <div class=" h-32 flex justify-between items-center">
            <div class="text-lg font-bold">
                <button @click="showReturn" class="flex items-center gap-2 px-4 py-2 text-white text-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left text-[#FCB115]">
                        <path d="m12 19-7-7 7-7"/>
                        <path d="M19 12H5"/>
                    </svg>
                    Consulting Process
                </button>
            </div>
            </div>
        </div>
    </nav>

    <MyModal
    :modal-show="toReturn"
    @updatemodalShow="updateShowReturn"
    >
        <template #title>
            Back to Homeful
        </template>
        <template #content_noborder class="">
            <p class="px-3 mt-5 mb-10">If you go back, you'll just land back on the Homeful Landing Page and your consultation will be canceled.</p>
        </template>
        <template #buttons>
            <MyPrimaryButton class="w-full rounded-full p-4 mt-4">
                Continue Consultation
            </MyPrimaryButton>
            <SecondaryButton @click="showReturn" class="w-full rounded-full p-4 mt-4">
                Go back to Homeful
            </SecondaryButton>
        </template>
    </MyModal>
</template>
  
<script setup>
import { ref } from 'vue';
import MyModal from '@/MyComponents/MyModal.vue';
import MyPrimaryButton from '@/MyComponents/MyPrimaryButton.vue';
import SecondaryButton from '@/MyComponents/SecondaryButton.vue';

const toReturn = ref(false)
const updateShowReturn = (newVal) => {
    toReturn.value = newVal;
}
const showReturn = () => {
    toReturn.value = !toReturn.value
}
</script> 
  