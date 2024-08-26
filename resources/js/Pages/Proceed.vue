<template>
    <div v-if="loading" class="flex items-center justify-center h-screen"> <!-- If -->
        <div class="w-2/6">
            <LottiefileAnimation v-if="homefulAnimation" :animationData="homefulAnimation" />
        </div>
    </div> <!-- End If -->
    <div v-else class="md:w-[415px] md:mx-auto"> <!-- Else -->
        <ReturnToPage />
        <div class="bg_layout p-0 ">
            <div class="w-full">
                <ConsultingHeaderImg class="w-full" />
            </div>
            <div class="py-1 w-full">
                <div class="flex flex-row p-5">
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
                </div>
                <div class="px-5">
                    <p>
                        Sign up with your phone number and email to receive notification about your consultation and concerns.
                    </p>
                    <div class="pt-3">
                        <Agreement v-model="isAgreementChecked" :agreement="supplementaryData.agreement" agreementType="TermOfServices">
                            <template #agreement_context>
                                By clicking the button below you are agreeing to the 
                            </template>
                        </Agreement>
                    </div>
                    <div class="mb-4">
                        <Link href="/kwyc-verify">
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
        
        <!-- Consultation Calculator-->
        <MyModal
        :modal-show="consoCalculator"
        @updatemodalShow="updateConsoCalculatorModal"
        >
            <template #title>
                Consultation Calculator
            </template>
            <template #modalcontent>
                <div class="">
                    <div class="flex gap-3 items-center justify-evenly">
                        <div class="bg-gray-300 h-20 w-1/3 flex items-center rounded-xl justify-center">
                            <!-- img -->
                            sample img here
                        </div>
                        <div>
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
                <div class="w-full md:w-3/4 mx-auto">
                    <MyPrimaryButton
                    @click="showQuickGuide"
                    class="w-full rounded-full p-4 mt-4"
                    >
                    <div class="grid grid-cols-3 text-left justify-items-center items-center text-sm md:text-md md:font-bold">
                        <div class="pl-4">
                            <p>{{ formatCurrency(propertyDetail.consulting_fee) }}</p>
                            <p>Consulting Fee</p>
                        </div>
                        <div class="">
                            |
                        </div>
                        <div>
                            <p>Avail Now</p>
                        </div>
                    </div>
                    </MyPrimaryButton>
                </div>
            </template>
        </MyModal>

        <!-- QuickGuide -->
        <MyModal
        :modal-show="quickGuide"
        @updatemodalShow="updateQuickGuideModal"
        >

            <template #title>
                Quick Guide
            </template>
            <template #content_noborder>
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
                            <p class="text-[#5E5E5E]">Scan a valid Government Id and complete with a selfie</p>
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
                            <p class="text-[#5E5E5E]">Fill-out the Contact Information Sheet</p>
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
                            <p class="text-[#5E5E5E]">Select from available payment option</p>
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
                            <p class="text-[#5E5E5E]">Wait for notification via SMS and Email</p>
                        </div>
                    </div>
                </div>
            </template>
            <template #buttons>
                <MyPrimaryButton
                    @click="showConsultingContent"
                    class="w-full rounded-full p-4 mt-4"
                    >
                    Continue
                </MyPrimaryButton>
            </template>
        </MyModal>

        <!-- Consulting Content -->
        <MyModal
        :modal-show="consultingContent"
        @updatemodalShow="updateConsultingContent"
        >
            <template #title>
                Consulting Content
            </template>
            <template #content_noborder>
                <ConsultingContent :pdfUrl="supplementaryData.consulting_content_link" />
            </template>
            <template #buttons>
                <MyPrimaryButton
                class="w-full rounded-full p-4 mt-4"
                @click="closeAllModals"
                >
                    I Agree & Continue
                </MyPrimaryButton>
            </template>
        </MyModal>


        <!-- Select Unit Location -->
        <MyModal
        :modal-show="unitLocation"
        @updatemodalShow="updateUnitLocation"
        >
            <template #title>
                <div class="flex items-center gap-2" @click="updateUnitLocation(false)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left text-[#FCB115]">
                        <path d="m12 19-7-7 7-7"/>
                        <path d="M19 12H5"/>
                    </svg>
                    <span>
                        Select Phase Block Lot
                    </span>
                </div>
            </template>
            <template #content_noborder>
                <div class="w-full space-y-3">
                    <input type="text" class="py-3 px-4 block w-full border-slate-200 rounded-lg text-sm disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Search">
                    <ul class="w-full px-5 flex flex-col divide-y divide-slate-200 dark:divide-neutral-700">
                        <li class="inline-flex items-center gap-x-2 py-3 text-sm font-medium text-slate-800">
                            Phase [X] Block [X] Lot [X]
                        </li>
                        <li class="inline-flex items-center gap-x-2 py-3 text-sm font-medium text-slate-800">
                            Phase [X] Block [X] Lot [X]
                        </li>
                        <li class="inline-flex items-center gap-x-2 py-3 text-sm font-medium text-slate-800">
                            Phase [X] Block [X] Lot [X]
                        </li>
                        <li class="inline-flex items-center gap-x-2 py-3 text-sm font-medium text-slate-800">
                            Phase [X] Block [X] Lot [X]
                        </li>
                        <li class="inline-flex items-center gap-x-2 py-3 text-sm font-medium text-slate-800">
                            Phase [X] Block [X] Lot [X]
                        </li>
                        <li class="inline-flex items-center gap-x-2 py-3 text-sm font-medium text-slate-800">
                            Phase [X] Block [X] Lot [X]
                        </li>
                        <li class="inline-flex items-center gap-x-2 py-3 text-sm font-medium text-slate-800">
                            Phase [X] Block [X] Lot [X]
                        </li>
                    </ul>
                </div>
            </template>
        </MyModal>

        <!-- Success Modal -->
         <SuccessModal ref="successRefModal" />
        <!-- End of Success Modal -->


    </div>  <!-- End Else -->
</template>

<script setup>
import HomefulLogo from '@/Logos/HomefulLogo.vue';
import BiometricLogo from '@/Logos/BiometricLogo.vue'
import MyPrimaryButton from '../MyComponents/MyPrimaryButton.vue';
import Timeline from '@/MyComponents/Timeline.vue';
import Agreement from '@/MyComponents/Agreement.vue';
import {ref, onMounted} from 'vue';
import ConsultingHeaderImg from '@/Logos/ConsultingHeaderImg.vue';
import CircularProgress from '@/MyComponents/CircularProgress.vue';
import MyModal from '@/MyComponents/MyModal.vue';
import LottiefileAnimation from '@/Logos/Animation/LottiefileAnimation.vue';
import ReturnToPage from '@/MyComponents/ReturnToPage.vue';
import FiveStepTimeline from '@/MyComponents/FiveStepTimeline.vue';
import ConsultationCalculator from '@/MyComponents/ConsultationCalculator.vue';
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
import ConsultingContent from  '@/Logos/ConsultingContent.vue';
import { Link } from '@inertiajs/vue3'
import SuccessModal from '@/MyComponents/SuccessModal.vue';


const props = defineProps({
    supplementaryData: Object,
    calculator: Object,
    propertyDetail: Object,
});

const loading = ref(true);
const chkbox = ref(false);
const lottieJson = ref(null);
const homefulAnimation = ref(null);

// For Modals:
const disclaimerStatus = ref(true);
const consoCalculator = ref(false);
const quickGuide = ref(false);
const consultingContent = ref(false);
const unitLocation = ref(false);
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
const updateConsoCalculatorModal = (newVal) => {
    consoCalculator.value = newVal;
}
const showQuickGuide = () =>{
    quickGuide.value = !quickGuide.value;
}
const updateQuickGuideModal = (newVal) =>{
    quickGuide.value = newVal;
}
const showConsultingContent = () =>{
    quickGuide.value = false;
    consultingContent.value = !consultingContent.value;
}
const updateConsultingContent = (newVal) => {
    consultingContent.value = newVal;
}
const updateUnitLocation = (newVal) => {
    unitLocation.value = newVal;
}
const showSelectUnitLoc = () => {
    unitLocation.value = !unitLocation.value;
}

const closeAllModals = () => {
    disclaimerStatus.value = false;
    consoCalculator.value = false;
    quickGuide.value = false;
    consultingContent.value = false;
    unitLocation.value = false;
}

const formatCurrency = (value) => {
    const formatter = new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP',
    });
    return formatter.format(value);
};

onMounted(async () => {
    setTimeout(() => {
        loading.value = false;
    }, 3000);
  const response = await fetch('/animation/proceed.json');
  const homefulMainAnimation = await fetch('/animation/HomefulLogoAnimation.json');

  lottieJson.value = await response.json();
  homefulAnimation.value = await homefulMainAnimation.json();
});

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
</style>