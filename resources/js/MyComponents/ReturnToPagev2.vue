<script setup>
import { ref } from 'vue';
import MyModal from '@/MyComponents/MyModal.vue';
import MyPrimaryButton from '@/MyComponents/MyPrimaryButton.vue';
import SecondaryButton from '@/MyComponents/SecondaryButton.vue';

const props = defineProps({
    icon: String
})

const toReturn = ref(false)
const updateShowReturn = (newVal) => {
    toReturn.value = newVal;
}
const showReturn = () => {
    toReturn.value = !toReturn.value
}
</script> 
  
<template>
    <nav class="top-0 left-0 w-full bg-white z-10 ">
        <div class="flex justify-between items-center border-b-[1px] border-neutral-200 mt-14 pb-4">
            <div class="text-lg font-bold">
                <button @click="showReturn" class="flex items-center gap-2 px-4 text-black text-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left text-[#CC035C]">
                        <path d="m12 19-7-7 7-7"/>
                        <path d="M19 12H5"/>
                    </svg>
                    <slot />
                </button>
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
            <p class="px-3 mt-5 mb-10">If you go back to Homeful, you will be directed to the <b>Homeful Landing Page</b>. Your consultation will be canceled, and if you decide to avail the property again, you will begin from the first step.</p>
        </template>
        <template #buttons>
            <MyPrimaryButton class="w-full rounded-full p-4 mt-4">
                Continue Consultation
            </MyPrimaryButton>
            <SecondaryButton @click="showReturn" class="w-full rounded-full p-4 mt-4 font-semibold">
                <img :src="icon" class="w-5 me-2">
                Go back to Homeful
            </SecondaryButton>
        </template>
    </MyModal>
</template>