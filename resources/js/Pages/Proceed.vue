<template>
    <div v-if="loading" class="flex items-center justify-center h-screen"> <!-- If -->
        <div class="w-2/6">
            <img :src="homefulBookingUrl" class="shimmer w-full" />
        </div>
    </div> <!-- End If -->
    <div v-else class="md:w-[415px] md:mx-auto"> <!-- Else -->
        <ReturnToPagev2 :icon="supplementaryData.homefulBookingUrl"> Home Loan Consultation</ReturnToPagev2>
        <div class="bg_layout p-0 ">
            <div class="w-full bg-[#F3F4F6] p-8 flex flex-row gap-4">
                <!-- <ConsultingHeaderImg class="w-full" /> -->
                 <div class="basis-4/12">
                    <RegisterHeaderImg />
                 </div>
                 <div class="basis-7/12 flex flex-col justify-center">
                    <div class="text-md font-semibold text-[#CC035C]">
                        Step 1 of 5:
                    </div>
                    <div class="text-3xl font-extrabold">
                        Register
                    </div>
                 </div>
            </div>
            <div class="py-1 w-full">
                <!-- <div class="flex flex-row p-5">
                    <div class="basis-1/5">
                        <CircularProgress :currentProgress="1" />
                    </div>
                    <div class="ps-5 basis-4/5 flex flex-col justify-center">
                        <div class="text-md font-semibold text-[#CC035C]">
                            Step 1:
                        </div>
                        <div class="text-3xl font-extrabold">
                            Register
                        </div>
                    </div>
                </div> -->
                <div class="px-5 pt-6">
                    <p class="font-semibold px-5 py-6">
                        Sign up with your Phone Number and Email to register your Home Loan Consultation.
                    </p>
                    <div class="pt-3">
                        <Agreement v-model="isAgreementChecked" :agreement="supplementaryData.agreement" agreementType="TermOfServices">
                            <template #agreement_context>
                                By clicking the button below you are agreeing to the
                            </template>
                        </Agreement>
                    </div>
                    <div class="mb-6">
                            <MyPrimaryButton
                                :disabled="!isAgreementChecked"
                                :isDisabled="!isAgreementChecked"
                                :class="[
                                    'rounded-full p-4 mt-4 w-full text-sm md:text-md',
                                    isAgreementChecked ? '' : 'bg-gray-300'
                                ]"
                                @click="goToKwyc"
                            >
                                <div class="flex items-center space-x-2">
                                    <span>Proceed</span>
                                    <div class="w-8 h-8 flex items-center justify-center p-0 text-white">
                                        <LottiefileAnimation v-if="lottieJson" :animationData="lottieJson" />
                                    </div>
                                </div>
                            </MyPrimaryButton>
                    </div>
                </div>
                <div class="max-w-7xl sm:px-6 lg:px-8 py-2 bg-slate-100">
                    <div class="shadow-xl sm:rounded-xl px-3 py-4">
                        <p class="mb-4 ms-4">Status:</p>
                        <FiveStepTimeline :currrentStep="1" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Disclamer Modal -->
        <MyModal
        :modal-show="disclaimerStatus"
        @updatemodalShow="updatemodalShow"
        >
            <template #title>
                Disclaimer
            </template>
            <template #modalcontent>
                <br>
                <Timeline class="mt-2">
                    <template #success>
                        Payment of Consulting Fee is non refundable.
                    </template>
                </Timeline>
                <Timeline class="mt-2">
                    <template #success>
                        Payment of Consulting Fee does not guarantee reservation. Reservation is subject to final confirmation.
                    </template>
                </Timeline>
                <br> <br>
            </template>
            <template #policy_terms>
                <Agreement v-model="isDisclaimerChecked" :agreement="supplementaryData.agreement">
                    <template #agreement_context>
                        By clicking Proceed, you agree to Homeful.ph's
                    </template>
                </Agreement>
            </template>
            <template #buttons>
                <div class="container mx-auto p-4">
                <div class="flex justify-center">
                    <MyPrimaryButton
                        :disabled="!isDisclaimerChecked"
                        :isDisabled="!isDisclaimerChecked"
                        @click="showConsoCalculator"
                        :class="[
                            'rounded-full p-4 mt-4 w-96 text-sm md:text-md',
                            isDisclaimerChecked ? '' : 'bg-gray-300'
                        ]"
                    >
                        I Agree & Continue
                    </MyPrimaryButton>
                </div>
            </div>
        </template>
        </MyModal>


        <!-- Success Modal -->
         <SuccessModal ref="successRefModal" />
        <!-- End of Success Modal -->


    </div>  <!-- End Else -->
</template>

<script setup>
import MyPrimaryButton from '../MyComponents/MyPrimaryButton.vue';
import Timeline from '@/MyComponents/Timeline.vue';
import Agreement from '@/MyComponents/Agreement.vue';
import {ref, onMounted} from 'vue';
import MyModal from '@/MyComponents/MyModal.vue';
import LottiefileAnimation from '@/Logos/Animation/LottiefileAnimation.vue';
import FiveStepTimeline from '@/MyComponents/FiveStepTimeline.vue';
import SuccessModal from '@/MyComponents/SuccessModal.vue';
import { usePage } from '@inertiajs/vue3'
import RegisterHeaderImg from '@/Logos/RegisterHeaderImg.vue';
import ReturnToPagev2 from '@/MyComponents/ReturnToPagev2.vue';

const page = usePage()

const props = defineProps({
    supplementaryData: Object,
    calculator: Object,
    sku:String,
    code:String,
    homefulBookingUrl: String
});

const loading = ref(false);
const lottieJson = ref(null);

// For Modals:
const disclaimerStatus = ref(false);
const consoCalculator = ref(false);
const successRefModal = ref(null);

const isDisclaimerChecked = ref(false);
const isAgreementChecked = ref(false);

const updatemodalShow = (newVal) => {
    console.log("xxx", newVal);
    disclaimerStatus.value = newVal;
}
const showConsoCalculator = () => {
    disclaimerStatus.value = !disclaimerStatus.value;
    consoCalculator.value = !consoCalculator.value;
}

onMounted(async () => {
    // setTimeout(() => {
    //     loading.value = false;
    // }, 3000);
  const response = await fetch('/animation/proceed.json');
  lottieJson.value = await response.json();

});

const goToKwyc = () => {
    const url = `/kwyc-verify/${props.sku}/${props.code}`;

    const params = new URLSearchParams({
        calculator: JSON.stringify(props.calculator),
    });
    console.log(params.toString());
    console.log(`${url}?${params.toString()}`);
    window.location.href = `${url}?${params.toString()}`;
};

</script>

<style scoped>
.bg_layout{
    z-index: 1;
}

.custom-checkbox {
  appearance: none;
  width: 1.25rem; /* 20px */
  height: 1.25rem; /* 20px */
  border: 2px solid #ccc;
  border-radius: 0.25rem; /* 4px */
  cursor: pointer;
  display: inline-block;
  vertical-align: middle;
  transition: background-color 0.3s ease;
}

.custom-checkbox:checked {
  border-color: transparent;
}

.bg-rose {
  background-color: #ff007f;
}

.shimmer {
  color: grey;
  display: inline-block;
  mask: linear-gradient(-60deg, #000 30%, #0005, #000 70%) right/350% 100%;
  animation: shimmer 2.5s infinite;
  font-size: 50px;
  max-width: 200px;
}

@keyframes shimmer {
  100% {
    mask-position: left
  }
}
</style>
