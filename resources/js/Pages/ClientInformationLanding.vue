<template>
        <ReturnToPagev2 :icon="supplementaryData.homefulBookingUrl"> Home Loan Consultation</ReturnToPagev2>
    <div class="bg_layout p-0 ">
        <div class="w-full bg-[#F3F4F6] p-8 flex flex-row gap-4">
            <!-- <ClientInfoImg class="w-full" /> -->
            <div class="basis-4/12">
                <VerifyIdentityImg />
                </div>
                <div class="basis-7/12 flex flex-col justify-center">
                <div class="text-md font-semibold text-[#CC035C]">
                    Step 3 of 5:
                </div>
                <div class="text-2xl font-extrabold">
                    Complete Data From
                </div>
            </div>
        </div>
        <div class="py-1 w-full">
            <div class="px-5 pt-9">
                <p class="font-bold ps-4 pb-5">
                    You will be redirected to the Customer Information Form to provide additional details for your Home Loan Consultation 
                </p>
                <div class="pt-3">
                    <Agreement v-model="isAgreementChecked" :agreement="supplementaryData.agreement">
                        <template #agreement_context>
                            By proceeding to the Customer Information Form, I agree to the Homeful.ph’s
                        </template>
                    </Agreement>
                </div>
                <div class="mb-4">
                    <Link :href="`/client-information/${props.kwyc_code}`"> <!-- TODO: Update the link -->
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
                                    <!-- <LottiefileAnimation :animationData="lottieJson"  :class="{
                                        'hidden': lottieJson,
                                    }"/> -->
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
        Payment Successful <!-- TODO: Update the text -->
    </SuccessModal>
</template>

<script setup>
import LottiefileAnimation from '@/Logos/Animation/LottiefileAnimation.vue';
import ClientInfoImg from '@/Logos/ClientInfoImg.vue';
import VerifyIdentityImg from '@/Logos/VerifyIdentityImg.vue';
import Agreement from '@/MyComponents/Agreement.vue';
import CircularProgress from '@/MyComponents/CircularProgress.vue';
import FiveStepTimeline from '@/MyComponents/FiveStepTimeline.vue';
import MyPrimaryButton from '@/MyComponents/MyPrimaryButton.vue';
import ReturnToPage from '@/MyComponents/ReturnToPage.vue';
import ReturnToPagev2 from '@/MyComponents/ReturnToPagev2.vue';
import SuccessModal from '@/MyComponents/SuccessModal.vue';
import { Link } from '@inertiajs/vue3'
import { onMounted, ref, onUpdated, nextTick } from 'vue';

const props = defineProps({
    supplementaryData: Object,
    kwyc_code: String,
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
