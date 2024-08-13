<script setup>
import MyModal from '@/MyComponents/MyModal.vue';
import MyPrimaryButton from '@/MyComponents/MyPrimaryButton.vue';
import DisclaimerLogo from '@/Logos/DisclaimerLogo.vue';
import Timeline from '@/MyComponents/Timeline.vue';
import Agreement from '@/MyComponents/Agreement.vue';
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
import ConsultationCalculator from '@/MyComponents/ConsultationCalculator.vue';
import Collapsible from '@/MyComponents/Collapsible.vue';
import { ref } from 'vue';


const disclaimerStatus = ref(false);
const showModalDisclaimer = () =>{
    disclaimerStatus.value = !disclaimerStatus.value;
}
const updatemodalShow = (newVal) =>{
    disclaimerStatus.value = newVal;
}

const consoCalculator = ref(false);
const showConsoCalculator = () =>{
    disclaimerStatus.value = false;
    consoCalculator.value = !consoCalculator.value;
}
const updateConsoCalculatorModal = (newVal) =>{
    consoCalculator.value = newVal;
}


const quickGuide = ref(false);
const showQuickGuide = () =>{
    quickGuide.value = !quickGuide.value;
}
const updateQuickGuideModal = (newVal) =>{
    quickGuide.value = newVal;
}

const consultingContent = ref(false);
const showConsultingContent = () =>{
    quickGuide.value = false;
    consultingContent.value = !consultingContent.value;
}
const updateConsultingContent = (newVal) =>{
    consultingContent.value = newVal;
}

// Data
const props = defineProps({
    propertyDetail: Object,
    calculator: Object,
})

const formatCurrency = (value) => {
    const formatter = new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP',
    });
    return formatter.format(value);
};


</script>
<template>
    <div class="flex justify-center items-center">
        <MyPrimaryButton
        @click="showModalDisclaimer"
         class="w-full rounded-full p-4 mt-4"
        >
            Property Consultation Calculation
        </MyPrimaryButton>
       <!-- <a
        href="/proceed"
       class="border bg-gray-100 py-1 px-3">Proceed</a> -->
    </div>
      <!-- MyModal -->
    <MyModal
    :modal-show="disclaimerStatus"
    @updatemodalShow="updatemodalShow"
    >
    <template #logo>
        <div class="w-full mx-auto">
            <DisclaimerLogo class="mx-auto"/>
        </div>
    </template>
    <template #titleNoBtn>
        Disclaimer
    </template>
    <template #modalcontent>
        <Timeline class=mt-2>
                <template #success>
                    Payment of Consulting Fee is non refundable.
                </template>
            </Timeline>
            <Timeline class=mt-2>
                <template #success>
                    Payment of Consulting Fee does not guarantee reservation. Reservation is subject to final confirmation.
                </template>
            </Timeline>
    </template>
    <template #policy_terms>
        <Agreement>
            <template #agreement_context>
                By clicking Proceed, you agree to Homeful.ph's
            </template>
        </Agreement>
    </template>
    <template #buttons>
        <div class="container mx-auto p-4">
           <div class="flex justify-center">
            <button
            @click="showModalDisclaimer"
            class="bg-gray-200 text-rose-700 rounded-full p-4 mt-4 w-96 text-sm md:text-md">
                Cancel
            </button>
            <MyPrimaryButton
            @click="showConsoCalculator"
            class="rounded-full p-4 mt-4 w-96 text-sm md:text-md"
            >
                I Agree & Continue
            </MyPrimaryButton>
           </div>
        </div>
    </template>
    </MyModal>

<!-- MyModal Calculator-->
 <MyModal
:modal-show="consoCalculator"
@updatemodalShow="updateConsoCalculatorModal"
 >
    <template #title>
        Consultation Calculator
    </template>
    <template #modalcontent>
        <div class="">
            <div class="flex gap-4 items-center justify-evenly">
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
                    <button class="underline underline-offset-1 default_text-color text-sm">
                        Change
                    </button>
                </div>
            </div>
        </div>
    </template>
    <template #policy_terms>
        <!-- <p class=text-transparent> Lorem, ipsum dolor sit amet consectetur adipisicing elit. </p> -->
        <!-- <div class="py-1 px-6 border-b-2 h-80 overflow-auto"> -->
       <ConsultationCalculator :calculator="calculator" />
       <!-- <Collapsible>
            <div>
                a
            </div>
        </Collapsible> -->
    </template>
    <template #buttons>
        <!-- <a
        href="/proceed"
        > -->
        <div class="w-full md:w-3/4 mx-auto">
            <MyPrimaryButton
            @click="showQuickGuide"
            class="w-full rounded-full p-4 mt-4"
            >
            <div class="grid grid-cols-3 text-left justify-items-center items-center text-sm md:text-md md:font-bold">
                <div class="">
                    <p>₱10,000</p>
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
        <!-- </a> -->
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
                    <p class="font-bold text-xl">Register</p>
                    <p>Provide your email address and mobile number</p>
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
                    <p class="font-bold text-xl">Verify your Identity</p>
                    <p>Scan a valid Government Id and complete with a selfie</p>
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
                    <p class="font-bold text-xl">Complete Data Form</p>
                    <p>Fill-out the Contact Information Sheet</p>
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
                    <p class="font-bold text-xl">Pay Consulting Fee</p>
                    <p>Fill-out the Contact Information Sheet</p>
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
                    <p class="font-bold text-xl">Get Qualified</p>
                    <p>Wait for notification via SMS and Email</p>
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
        <ConsultingContent />
    </template>
    <template #buttons>
        <a
        href="/proceed"
        >
            <MyPrimaryButton
            class="w-full rounded-full p-4 mt-4"
            >
           I Agree & Continue
            </MyPrimaryButton>
        </a>
    </template>
   </MyModal>
</template>


<style>
.default_text-color{
    color: #CC035C;
}

</style>
