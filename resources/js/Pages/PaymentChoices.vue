<template>
    <ReturnToPagev2 :icon="supplementaryData.homefulBookingUrl"> Home Loan Consultation</ReturnToPagev2>
    <div class="bg_layout p-0 ">
        <div class="w-full bg-[#F3F4F6] p-8 flex flex-row gap-4">
            <div class="basis-4/12">
                <PaymentChoicesHeaderImg />
            </div>
            <div class="basis-7/12 flex flex-col justify-center">
                <div class="text-md font-semibold text-[#CC035C]">
                    Step 4 of 5:
                </div>
                <div class="text-xl font-extrabold">
                    Pay Home Loan  Consultation Fee
                </div>
            </div>
        </div>
        <div class="py-1 w-full">
            <div class="px-5 pt-6">
                <p class="py-10 px-4 font-bold">
                    Please pay the Consulting Fee. If you choose not to pay within 2 working days, your qualification process will not proceed.
                </p>
                <div class="mb-4">
                    <MyPrimaryButton
                        @click="updatePaymentOption(true)"
                        :class="[
                            'rounded-full p-4 mt-4 w-full text-sm md:text-md',
                        ]"
                    >
                        <div class="flex items-center space-x-2">
                            <span>Pay Now</span>
                        </div>
                    </MyPrimaryButton>
                </div>
            </div>
            <div class="max-w-7xl sm:px-6 lg:px-8 py-2 bg-slate-100">
                <div class="shadow-xl sm:rounded-xl px-3 py-4">
                    <p class="mb-4 ms-4">Status:</p>
                    <FiveStepTimeline :currrentStep="4" />
                </div>
            </div>
        </div>
    </div>
    <SuccessModal ref="successRefModal">
        Payment Successful <!-- TODO: Update the text -->
    </SuccessModal>

    <!-- Payment Option Modal -->
    <MyModal
    :modal-show="paymentOption"
    @updatemodalShow="updatePaymentOption"
    >
        <template #title>
            Payment Option
        </template>
        <template #content_noborder>
            <div class="flex flex-wrap gap-3 mb-20">
                <!-- Payment Method 1 -->
                <TertiaryButton @click="choosePaymentMethod(1)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card">
                        <rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/>
                    </svg>
                    <span>
                        Credit/Debit Card
                    </span>
                </TertiaryButton>
                <!-- Payment Method 2 -->
                <TertiaryButton @click="choosePaymentMethod(2)">
                    <Gcash />
                    <span>
                        GCash
                    </span>
                </TertiaryButton>
                <!-- Payment Method 3 -->
                <TertiaryButton @click="choosePaymentMethod(3)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-qr-code"><rect width="5" height="5" x="3" y="3" rx="1"/>
                        <rect width="5" height="5" x="16" y="3" rx="1"/><rect width="5" height="5" x="3" y="16" rx="1"/><path d="M21 16h-3a2 2 0 0 0-2 2v3"/><path d="M21 21v.01"/><path d="M12 7v3a2 2 0 0 1-2 2H7"/><path d="M3 12h.01"/><path d="M12 3h.01"/><path d="M12 16v.01"/><path d="M16 12h1"/><path d="M21 12v.01"/><path d="M12 21v-1"/>
                    </svg>
                    <span>
                        InstaPay QRCode
                    </span>
                </TertiaryButton>
            </div>
        </template>
    </MyModal>



    <!-- Payment Reminder Modal -->
    <MyModal
    :modal-show="paymentReminder"
    @updatemodalShow="updatePaymentReminder"
    >
        <template #title>
            Payment Reminders
        </template>
        <template #modalcontent>
            <div class="py-5">
                <Timeline class="mt-5">
                    <template #success>
                        Payment of Consulting Fee is non refundable.
                    </template>
                </Timeline>
                <Timeline class="mt-5">
                    <template #success>
                        Payment of Consulting Fee does not guarantee reservation. Reservation is subject to final confirmation.
                    </template>
                </Timeline>
                <Timeline class="mt-5">
                    <template #success>
                        You will receive an SMS notification if payment is successful.
                    </template>
                </Timeline>

            </div>
            <br>
        </template>
        <template #policy_terms>
            <Agreement v-model="isDisclaimerChecked" :agreement="supplementaryData.agreement" shorterModal>
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
                        @click="payNow"
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

      <!-- InstaPay QRCode -->
    <MyModal
    :modal-show="instaPayQrModal"
    @updatemodalShow="updateInstaPayQrModal"
    >
        <template #title>
            Scan to Pay
        </template>
        <template #content_noborder>
            <div class="flex flex-wrap gap-3 mb-20 justify-center">
                <div id="instaPayQRCode" ></div>
            </div>
        </template>
    </MyModal>

</template>

<script setup>
import Gcash from '@/Logos/Gcash.vue';
import PaymentChoicesImg from '@/Logos/PaymentChoicesImg.vue';
import Agreement from '@/MyComponents/Agreement.vue';
import CircularProgress from '@/MyComponents/CircularProgress.vue';
import FiveStepTimeline from '@/MyComponents/FiveStepTimeline.vue';
import MyModal from '@/MyComponents/MyModal.vue';
import MyPrimaryButton from '@/MyComponents/MyPrimaryButton.vue';
import ReturnToPage from '@/MyComponents/ReturnToPage.vue';
import SuccessModal from '@/MyComponents/SuccessModal.vue';
import TertiaryButton from '@/MyComponents/TertiaryButton.vue';
import Timeline from '@/MyComponents/Timeline.vue';
import { router } from '@inertiajs/vue3';
import { onMounted, ref, onUpdated, nextTick } from 'vue';
import QRCodeStyling from 'qr-code-styling';
import ReturnToPagev2 from '@/MyComponents/ReturnToPagev2.vue';
import PaymentChoicesHeaderImg from '@/Logos/PaymentChoicesHeaderImg.vue';
const props = defineProps({
    supplementaryData: Object,
    kwyc_code: String
});

const paymentOption = ref(false);
const paymentReminder = ref(false);
const instaPayQrModal = ref(false);
const isDisclaimerChecked = ref(false);
const selectedPaymentMethod = ref(0);

const instaPayQr = ref('');
const updatePaymentOption = (newVal) => {
    paymentOption.value = newVal;
}
const updateInstaPayQrModal = (newVal) => {
    instaPayQrModal.value = newVal;
}
const updatePaymentReminder = (newVal) => {
    paymentReminder.value = newVal;
}
const choosePaymentMethod = (pm) => {
    updatePaymentReminder(true);
    selectedPaymentMethod.value = pm;
}

const payNow =async () => {
    switch(selectedPaymentMethod.value){
        case 1:
            router.get(`/payment-choices/credit-debit-card/${props.kwyc_code}`);
            // router.get(`/api/payment-cashier?reference_code=${props.kwyc_code}`);
            break;
        case 2:
            try {
                console.log(`/payment-choices/wallet/pay/${props.kwyc_code}?wallet=gcash`)
                // Make the request to get the payment URL
                const response = await axios.get(`/payment-choices/wallet/pay/${props.kwyc_code}?wallet=gcash`);

                if (response.data) {
                    window.location.href = response.data;
                } else {
                    console.error('Payment URL not found in response.');
                }
            } catch (error) {
                console.error('An error occurred while fetching the payment URL:', error);
            }
            break;
        case 3:
            try {
                // Make the request to get the payment URL
                instaPayQrModal.value = true;
                console.log(`/payment-choices/qr/pay/${props.kwyc_code}`)
                const response = await axios.get(`/payment-choices/qr/pay/${props.kwyc_code}`);
                if (response.data) {
                    instaPayQr.value=response.data;
                    console.log(instaPayQr.value)
                    const qrCode = new QRCodeStyling({
                        width: 300,
                        height: 300,
                        type: "svg",
                        data: instaPayQr.value,
                        // image: "https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg",
                        dotsOptions: {
                            color: "#4267b2",
                            type: "rounded"
                        },
                        backgroundOptions: {
                            color: "#e9ebee",
                        },
                        imageOptions: {
                            crossOrigin: "anonymous",
                            margin: 20
                        }
                    });

                    console.log(document.getElementById("instaPayQRCode"));
                    qrCode.append(document.getElementById("instaPayQRCode"));

                } else {
                    console.error('Payment URL not found in response.');
                }
            } catch (error) {
                console.error('An error occurred while fetching the payment URL:', error);
            }
            break;
    }
}

</script>

<style scoped>
.bg_layout{
    z-index: 1;
}
.bg-rose {
  background-color: #ff007f;
}
</style>
