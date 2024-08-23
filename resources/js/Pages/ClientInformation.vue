<template>
    <ReturnToPage />
    <div class="bg_layout p-0 ">
        <div class="w-full">
            <ClientInfoImg class="w-full" />
        </div>
        <div class="py-1 w-full">
            <div class="flex flex-row p-5">
                <div class="basis-1/5">
                    <CircularProgress :currentProgress="3" />
                </div>
                <div class="ps-5 basis-4/5 flex flex-col justify-center">
                    <div class="text-md font-semibold text-[#CC035C]">
                        Step 3:
                    </div>
                    <div class="text-xl font-extrabold">
                        Complete the Customer Information From
                    </div>
                </div>
            </div>
            <div class="px-5">
                <p>
                    You will be redirected to the Customer Information Form to provide additional details for your application. 
                </p>
                <div class="pt-3">
                    <Agreement v-model="isAgreementChecked" :agreement="supplementaryData.agreement">
                        <template #agreement_context>
                            By proceeding to the Customer Information Form, I agree to the Homeful.ph’s
                        </template>
                    </Agreement>
                </div>
                <div class="mb-4">
                    <Link href="/"> <!-- TODO: Update the link -->
                        <MyPrimaryButton
                            :disabled="!isAgreementChecked"
                            :isDisabled="!isAgreementChecked"
                            :class="[
                                'rounded-full p-4 mt-4 w-full text-sm md:text-md',
                                isAgreementChecked ? '' : 'bg-gray-300'
                            ]"
                        >
                            <div class="flex items-center space-x-2">
                                <span>Proceed</span>
                                <div class="w-8 h-8 flex items-center justify-center p-0 text-white">
                                    <LottiefileAnimation v-if="lottieJson" :animationData="lottieJson" />
                                </div>
                            </div>
                        </MyPrimaryButton>
                    </Link>
                </div>
            </div>
            <div class="max-w-7xl sm:px-6 lg:px-8 py-2 bg-slate-100">
                <div class="shadow-xl sm:rounded-xl px-3 py-4">
                    <p class="mb-4 ms-4">Status:</p>
                    <FiveStepTimeline :currrentStep="3" />
                </div>
            </div>
        </div>
    </div>
    <SuccessModal ref="successRefModal">
        Payment Successful
    </SuccessModal>
</template>

<script setup>
import LottiefileAnimation from '@/Logos/Animation/LottiefileAnimation.vue';
import ClientInfoImg from '@/Logos/ClientInfoImg.vue';
import Agreement from '@/MyComponents/Agreement.vue';
import CircularProgress from '@/MyComponents/CircularProgress.vue';
import FiveStepTimeline from '@/MyComponents/FiveStepTimeline.vue';
import MyPrimaryButton from '@/MyComponents/MyPrimaryButton.vue';
import ReturnToPage from '@/MyComponents/ReturnToPage.vue';
import SuccessModal from '@/MyComponents/SuccessModal.vue';
import { Link } from '@inertiajs/vue3'
import { onMounted, ref, onUpdated, nextTick } from 'vue';

const props = defineProps({
    supplementaryData: Object,
});

const lottieJson = ref(null);
const successRefModal = ref(null);
const isAgreementChecked = ref(false);

onMounted(async () => {
    const response = await fetch('/animation/proceed.json');
    lottieJson.value = await response.json();
});
</script>

<style scoped>
.bg_layout{
    z-index: 1;
}
.bg-rose {
  background-color: #ff007f;
}
</style>