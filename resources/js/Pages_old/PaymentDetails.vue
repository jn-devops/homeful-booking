<script setup>
import HomefulLogo from '@/Logos/HomefulLogo.vue';
import ContractSigningLogo from '@/Logos/ContractSigningLogo.vue';
import MySecondaryButton from '@/MyComponents/MySecondaryButton.vue';
import GcashLogo from '@/Logos/GCashLogo.vue'
import CreditCardLogo from '@/Logos/CreditCardLogo.vue'
import MyTertiaryButton from '@/MyComponents/MyTertiaryButton.vue';
import Timeline from '@/MyComponents/Timeline.vue';
import MyModal from '@/MyComponents/MyModal.vue';
import FloatingLabels from '@/MyComponents/FloatingLabels.vue';
import MyPrimaryButton from '@/MyComponents/MyPrimaryButton.vue';
import CreditCard from './CreditCard.vue';
import Agreement from '@/MyComponents/Agreement.vue';
// import InputLabel from '@/Components/InputLabel.vue';
import { ref,watch} from 'vue';

const modalShowDefault = ref(false);
const termsCondition = ref(false);

const showModal = (e) =>{
    // console.log('e.target: ', e.target);
    modalShowDefault.value = !modalShowDefault.value;
}

const modalCreditCard = ref(false);
const updatemodalFunc = (newVal) =>{
    modalShowDefault.value = newVal;
}
const updatemodalFuncCredit = (newVal) =>{
    termsCondition.value = false;
    console.log('click', newVal)
    modalCreditCard.value = newVal;
}
const updateModalCreditCard = () =>{
   modalCreditCard.value = !modalCreditCard.value;
   console.log('modalShowDefault:', modalShowDefault.value);
}


const updateTermsCondition = () =>{
    termsCondition.value = !termsCondition.value;
}

const payStatus = ref(false);
const handlePayStatus = (payNowStatus) =>{
    payNowStatus.value = payNowStatus;
    console.log('adsasd', payNowStatus);
};
console.log('newStatus', payStatus.value);

// watch(payStatus, (newStatus, oldStatus) => {
//     console.log('Pay status changed from', oldStatus, 'to', newStatus);
// });
</script>
<template>
    <div class="container mx-auto px-4">
        <div class="w-1/2 mx-auto pt-6">
            <HomefulLogo class="mx-auto"/>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-2">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl p-3">
                <!-- <Welcome /> -->
                    <!-- <LandingPage /> -->
                <div>
                    <ContractSigningLogo class="mx-auto"/>
                    <div class="text-center pt-6">
                    <h1 class="text-2xl font-bold">Thank you!</h1>
                    <p class="pt-4">For completing the Contact Information Form. 
                        Please pay the Holding Fee using our payment options below:</p>
                    </div>
                    <div class="flex gap-2 justify-center mt-6">
                        <MySecondaryButton 
                        @click="updateModalCreditCard"
                        class="w-96">
                            <div class="flex items-center gap-2 w-full justify-center text-blue-400">
                                <CreditCardLogo />
                                Credit Card
                            </div>
                        </MySecondaryButton>
                        <MySecondaryButton class="w-96">
                            <div class="flex items-center gap-2 w-full justify-center text-blue-400">
                                <GcashLogo />
                                Gcash
                            </div>
                        </MySecondaryButton>
                    </div>
                    <div class="text-center my-4">
                        <p class="text-xl">or</p>
                    </div>
                    <div class="w-full md:w-1/2 md:mx-auto">
                        <MyTertiaryButton 
                        @click="showModal"
                        class="w-full underline underline-offset-1 text-amber-600 font-bold">
                        Schedule Site Visit
                        </MyTertiaryButton>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden md:block max-w-7xl mx-auto sm:px-6 lg:px-8 py-2">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl px-3 py-4">
                    <!-- <Welcome /> -->
                     <!-- <LandingPage /> -->
                     <div class="mb-4">
                        <p>Status:</p>
                    </div>
                    <div>
                        <Timeline>
                            <template #success>
                                <p>Register and Verify your Identity</p>
                            </template>
                        </Timeline>
                        <Timeline class="mt-4">
                            <template #success>
                                <p>Complete Data Form</p>
                            </template>
                        </Timeline>
                        <Timeline>
                            <template #pending>
                                <p>Pay Consulting Fee</p>
                            </template>
                            <template #inprogress>
                                <p>Get Qualified</p>
                            </template>
                        </Timeline>
                    </div>
                </div>
            </div>
        <div class="mt-4 block md:hidden">
            <div class="mb-4">
                <p>Status:</p>
            </div>
            <div>
                <Timeline>
                    <template #success>
                        <p>Register and Verify your Identity</p>
                    </template>
                </Timeline>
                <Timeline class="mt-4">
                    <template #success>
                        <p>Complete Data Form</p>
                    </template>
                </Timeline>
                <Timeline>
                    <template #pending>
                        <p>Pay Consulting Fee</p>
                    </template>
                    <template #inprogress>
                        <p>Get Qualified</p>
                    </template>
                </Timeline>
            </div>
        </div>
    </div>
    <div class="hidden">
        <CreditCard @paystatus="handlePayStatus" />
    </div>
<!-- Modal -->
 <MyModal 
 :modal-show="modalShowDefault" 
 @updatemodalShow="updatemodalFunc"
 >
    <template #title>
        Schedule a Visit Form
    </template>
    <template #modalcontent>
        <FloatingLabels #label>
            Name of Concern
        </FloatingLabels>
        <div class="mt-3">
            <!-- <InputLabel for="project" value="Project" /> -->
            <select id="project" name="project" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
            >
                <option value="Twinhomes in Hopeful Green">Twinhomes in Hopeful Green</option>
                <option value="Others">Others</option>
                <!-- <option value="Widowed">Widowed</option> -->
            </select>
        </div>
        <div class="mt-3">
            <!-- <InputLabel for="location" value="Location" /> -->
            <select id="Location" name="Location" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
            >
                <option value="Calamba, Laguna">Calamba, Laguna</option>
                <option value="Others">Others</option>
                <!-- <option value="Widowed">Widowed</option> -->
            </select>
        </div>
        <FloatingLabels #label class="mt-3">
            Name
        </FloatingLabels>
        <FloatingLabels #label class="mt-3">
            Number
        </FloatingLabels>
        <FloatingLabels #label class="mt-3">
            Email Address
        </FloatingLabels>
        <div class="block md:flex">
            <div class="mt-3">
                <!-- <InputLabel for="date_birth" value="Date of Birth" /> -->
                <input 
                    id="last_name"
                    type="date"
                    class="mt-2 block w-full rounded-full border-0  text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                    >
            </div>
            <div class="mt-3">
                <!-- <InputLabel for="date_birth" value="Date of Birth" /> -->
                <input 
                    id="last_name"
                    type="date"
                    class="mt-2 block w-full rounded-full border-0  text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                    >
            </div>
            <FloatingLabels #label class="mt-3">
                Remarks
            </FloatingLabels>
        </div>
    </template>
    <template #policy_terms>
        <Agreement>
            <template #agreement_context>
                By clicking Submit, you are agree to Homeful.ph's
            </template>
        </Agreement>
        <!-- <div class="flex gap-2 mt-4">
            <input type="checkbox">
            <p>By clicking Submit, you are agree to Homeful.ph's
                <span class="font-bold">
                    <a
                    href="#"
                    >
                        Privacy Policy
                    </a>
                </span>
                and
                <span class="font-bold">
                    <a
                    href="#"
                    >
                        Terms & Condition
                    </a>
                </span>
            </p>
        </div> -->
    </template>
   <template #buttons>
    <MyPrimaryButton
        class="w-full rounded-full p-4 mt-4"
        >
        Submit
    </MyPrimaryButton>
   </template>
</MyModal>
<MyModal
:modal-show="modalCreditCard"
@updatemodalShow="updatemodalFuncCredit"
>
        <template 
         v-if="!termsCondition"
        #title>
            Payment Reminders
        </template>
        <template 
         v-else
        #title>
            Terms and Condition
        </template>
        <template
        v-if="!termsCondition"
        #modalcontent>
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
            <Timeline class=mt-2>
                <template #success>
                    You will receive an SMS notification if payment is successful.
                </template>
            </Timeline>
        </template>
        <template
        v-else
        #modalcontent>
           <div class="h-80 overflow-auto md:max-w-screen-sm">
                <p class="">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
                <p class="mt-4">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
           </div>
        </template>
        <template 
         v-if="!termsCondition"
        #policy_terms>
        <Agreement>
            <template #agreement_context>
                By clicking Proceed, you agree to Homeful.ph's
            </template>
        </Agreement>
            <!-- <div class="flex gap-2 mt-4">
                <input type="checkbox">
                <p>By clicking Submit, you are agree to Homeful.ph's
                    <span class="font-bold">
                        <a
                        href="#"
                        >
                            Privacy Policy
                        </a>
                    </span>
                    and
                    <span class="font-bold">
                        <a
                        href="#"
                        >
                            Terms & Condition
                        </a>
                    </span>
                </p>
            </div> -->
        </template>
       <template 
       v-if="!termsCondition"
       #buttons>
        <MyPrimaryButton
        @click="updateTermsCondition"
            class="w-full rounded-full p-4 mt-4"
            >
            Proceed
        </MyPrimaryButton>
       </template>
       <template 
       v-else
       #buttons>
       <a href="/creditdetails">
           <MyPrimaryButton
               class="w-full rounded-full p-4 mt-4"
               >
               Proceed
           </MyPrimaryButton>
       </a>
       </template>
</MyModal>
</template>