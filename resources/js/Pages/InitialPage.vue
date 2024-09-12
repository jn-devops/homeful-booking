<script setup>
import EntryPointImg from '@/Logos/EntryPointImg.vue';
import Agreement from '@/MyComponents/Agreement.vue';
import ConsultationCalculator from '@/MyComponents/ConsultationCalculator.vue';
import MyModal from '@/MyComponents/MyModal.vue';
import MyPrimaryButton from '@/MyComponents/MyPrimaryButton.vue';
import ReturnToPagev2 from '@/MyComponents/ReturnToPagev2.vue';
import {ref, onMounted} from 'vue';
import GuideRegisterLogo from '@/Logos/GuideRegisterLogo.vue';
import GuideVerifyLogo from '@/Logos/GuideVerifyLogo.vue';
import GuideFormLogo from '@/Logos/GuideFormLogo.vue';
import GuideQualified from '@/Logos/GuideQualifiedLogo.vue';
import GuideConsulting from '@/Logos/GuideConsultingLogo.vue';
import OneLogo from '@/Logos/1Logo.vue';
import TwoLogo from '@/Logos/2Logo.vue';
import ThreeLogo from '@/Logos/3Logo.vue';
import FourLogo from '@/Logos/4Logo.vue';
import FiveLogo from '@/Logos/5Logo.vue';
import ModalV2 from '@/MyComponents/ModalV2.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    supplementaryData: Object,
    calculator: Object,
    propertyDetail: Object,
    productDetails: Object,
    sku:String,
    code:String,
    homefulBookingUrl: String
});

console.log(props.homefulBookingUrl);

const loading = ref(true);
const isAgreementChecked = ref(false);
const lottieJson = ref(null);
const homefulAnimation = ref(null);
const consoCalculator = ref(false);
const quickGuide = ref(false);

const showAgreement = (newVal) => {
    isAgreementChecked.value = newVal; 
}
const updateConsoCalculatorModal = (newVal) => {
    consoCalculator.value = newVal;
}
const toggleQuickGuide = (newVal) => {
    quickGuide.value = newVal;
}

onMounted(async () => {
    setTimeout(() => {
        loading.value = false;
    }, 3000);

//   const response = await fetch('/animation/proceed.json');

//   lottieJson.value = await response.json();
//   homefulAnimation.value = await homefulMainAnimation.json();

});

const formatCurrency = (value) => {
    const formatter = new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP',
        
    });
    return formatter.format(value);
};

const redirectToProceed = () => {
    window.location.href = `/proceed/${props.sku}/${props.code}`;
}

</script>
<template>
    <div v-if="loading" class="flex items-center justify-center h-screen"> <!-- If -->
        <div class="w-2/6">
            <img :src="homefulBookingUrl" class="shimmer w-full" />
        </div>
    </div>
    <div v-else class="md:w-[415px] md:mx-auto"> <!-- Else -->
        <ReturnToPagev2 :icon="homefulBookingUrl"> Home Loan Consultation </ReturnToPagev2>
        <div class="flex justify-center">
            <div class="w-56 text-center">
                <EntryPointImg />
            </div>
        </div>
        <div class="text-center py-3">
            <span class="text-[#135DBD] text-2xl font-semibold">Home Loan Consultation</span>
        </div>
        <div class="px-6">
            <p>
                Home buying is a long term purchase that requires a long term commitment in the form of a dedicated fund.  Therefore, buying a home is a significant decision with long-term implications, making it crucial to carefully consider several factors before committing.
            </p>
        </div>
        <div class="hs-accordion-group">
            <div class="hs-accordion active" id="hs-basic-heading-one">
                <button class="hs-accordion-toggle bg-[#F3F4F6] w-full px-6 py-2 mt-2 flex" aria-expanded="true" aria-controls="hs-basic-collapse-one">
                    <span class="text-lg font-semibold flex-auto text-start">
                        What is Home Loan Consultation?
                    </span>
                    <div class="flex-none w-fit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hs-accordion-active:hidden lucide lucide-chevron-down text-[#F59E0B]">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hs-accordion-active:block hidden lucide lucide-chevron-up text-[#F59E0B]">
                            <path d="m18 15-6-6-6 6"/>
                        </svg>
                    </div>
                </button>
                <div id="hs-basic-collapse-one" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 px-6" role="region" aria-labelledby="hs-basic-heading-one">
                    <p class="my-3">
                        Our home loan consultation is designed to: 
                    </p>
                    <ol class="list-decimal list-inside text-gray-800 dark:text-white">
                        <li class="mb-2">Guide you in understanding your options and determining the best home budget.</li>
                        <li class="mb-2">Provides guidance on how to complete your Home Loan Consultation accurately and gather the necessary documentation, reducing the likelihood of errors or delays.</li>
                        <li class="mb-2">Assist you throughout the Home Loan Consultation process.</li>
                    </ol>
                </div>
            </div>

            <div class="hs-accordion" id="hs-basic-heading-two">
                <button class="hs-accordion-toggle bg-[#F3F4F6] w-full px-6 py-2 mt-2 flex" aria-expanded="false" aria-controls="hs-basic-collapse-two">
                    <span class="text-lg font-semibold flex-auto text-start">
                        Is there a Consultation Fee?
                    </span>
                    <div class="flex-none w-fit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hs-accordion-active:hidden lucide lucide-chevron-down text-[#F59E0B]">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hs-accordion-active:block hidden lucide lucide-chevron-up text-[#F59E0B]">
                            <path d="m18 15-6-6-6 6"/>
                        </svg>
                    </div>
                </button>
                <div id="hs-basic-collapse-two" class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300 px-6" role="region" aria-labelledby="hs-basic-heading-two">
                    <p class="my-3">
                        Yes! 
                    </p>
                    <p class="my-3">
                        The Consultation Fee shall be utilized to compensate the time and expertise in evaluating and guiding you thru your buying decision process.  
                    </p>
                    <p class="my-3"> 
                        Should you choose to proceed with the purchase, the fee will be credited as your processing fee, which will serve to officially reserve the unit under your name. 
                    </p>
                </div>
            </div>
        </div>


        <div class="px-4 my-6">
            <Agreement v-model="isAgreementChecked" :agreement="supplementaryData.welcome_agreement" agreementType="TermOfServices">
                <template #agreement_context>
                    By clicking the button below you are agreeing to the 
                </template>
            </Agreement>
            <MyPrimaryButton
                :disabled="!isAgreementChecked"
                :isDisabled="!isAgreementChecked"
                @click="updateConsoCalculatorModal(true)"
                :class="[
                    'rounded-full p-4 mt-4 w-full text-sm md:text-md',
                    isAgreementChecked ? '' : 'bg-gray-300'
                ]"
            >
                I Agree & Continue
            </MyPrimaryButton>
        </div>

    </div>

    <!-- Consultation Calculator-->
    <MyModal
    :modal-show="consoCalculator"
    @updatemodalShow="updateConsoCalculatorModal"
    >
        <template #title>
            <span class="text-lg">Home Loan Consultation Form</span>
        </template>
        <template #modalcontent>
            <div class="">
                <div class="flex gap-3 items-center justify-evenly">
                    <div class="bg-gray-300 h-20 w-1/3 rounded-xl">
                        <!-- img -->
                        <img :src="propertyDetail.image" alt="Property Image" class="w-full">
                    </div>
                    <div class="text-sm">
                        <p class="font-bold">{{ propertyDetail.unit_location }}</p>
                        <p class="font-bold">{{ formatCurrency(propertyDetail.price) }}</p>
                        <p class="text-sm text-gray-500">Total Contract Price</p>
                    </div>
                    <div>
                        <button @click="showSelectUnitLoc" class="underline underline-offset-1 default_text-color text-sm bg-[#F6FAFF] p-3 rounded-full">
                            Change
                        </button>
                    </div>
                </div>
            </div>
        </template>
        <template #policy_terms>
            <ConsultationCalculator :calculator="calculator" :formatCurrency="formatCurrency" />
        </template>
        <template #buttons>
            <div class="w-full mt-auto">
                <MyPrimaryButton
                @click="toggleQuickGuide(true)"
                class="w-full rounded-full p-4 mt-4"
                >
                    <div class="flex justify-items-center items-center text-sm md:text-md md:font-bold">
                        Proceed
                    </div>
                </MyPrimaryButton>
            </div>
        </template>
    </MyModal> 


    <!-- QuickGuide -->
    <MyModal
        :modal-show="quickGuide"
        @updatemodalShow="toggleQuickGuide"
        >

            <template #title>
                Quick Guide
            </template>
            <template #content_noborder>
                <div class="h-fit flex flex-col gap-7">
                    <div class="flex gap-3">
                        <div>
                            <GuideRegisterLogo />
                        </div>
                        <div class="flex gap-2">
                            <div>
                                <OneLogo />
                            </div>
                            <div>
                                <p class="font-bold text-xl text-[#1973E8]">Register</p>
                                <p class="text-[#5E5E5E]">Provide your email address and mobile number</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div>
                            <GuideVerifyLogo />
                        </div>
                        <div class="flex gap-2">
                            <div>
                                <TwoLogo />
                            </div>
                            <div>
                                <p class="font-bold text-xl text-[#1973E8]">Verify your Identity</p>
                                <p class="text-[#5E5E5E]">Scan a valid Government ID and complete with a selfie.</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div>
                            <GuideFormLogo />
                        </div>
                        <div class="flex gap-2">
                            <div>
                                <ThreeLogo />
                            </div>
                            <div>
                                <p class="font-bold text-xl text-[#1973E8]">Complete Data Form</p>
                                <p class="text-[#5E5E5E]">Fill-out the Customer Information Sheet.</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div>
                            <GuideConsulting />
                        </div>
                        <div class="flex gap-2">
                            <div>
                                <FourLogo />
                            </div>
                            <div>
                                <p class="font-bold text-xl text-[#1973E8]">Pay Consulting Fee</p>
                                <p class="text-[#5E5E5E]">Select from available payment options.</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div>
                            <GuideQualified />
                        </div>
                        <div class="flex gap-2">
                            <div>
                                <FiveLogo />
                            </div>
                            <div>
                                <p class="font-bold text-xl text-[#1973E8]">Get Qualified</p>
                                <p class="text-[#5E5E5E]">Wait for notification via SMS and Email.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template #buttons>
                <MyPrimaryButton
                    @click="redirectToProceed"
                    class="w-full rounded-full p-4 mt-4"
                    >
                    Continue
                </MyPrimaryButton>
            </template>
        </MyModal>
</template>

<style scoped>
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