<template>
    <ReturnToPage />
    <div class="bg_layout p-0 ">
        <div class="w-full">
            <GetQualifiedImg class="w-full" />
        </div>
        <div class="py-1 w-full">
            <div class="flex flex-row p-5">
                <div class="basis-1/5">
                    <CircularProgress :currentProgress="5" />
                </div>
                <div class="ps-5 basis-4/5 flex flex-col justify-center">
                    <!-- <div class="text-md font-semibold text-[#CC035C]">
                        Step 5:
                    </div> -->
                    <div class="text-3xl font-extrabold">
                        Get Qualified
                    </div>
                </div>
            </div>
            <div class="px-5">
                <div class="px-5 font-medium mb-10">
                    <p class="mb-3">
                        Congratulations Payment successful! You will receive an SMS notification with your Customer Reference Code (CRC).
                    </p>
                    <p class="mb-3">
                        Your application will now be subject for evaluation. You will receive another SMS notification upon successful qualification.
                    </p>
                    <p class="mb-3">
                        Visit our website to learn more about us.
                    </p>
                </div>
                <div class="mb-4">
                    <MyPrimaryButton
                        @click="updatePaymentOption(true)"
                        :class="[
                            'rounded-full p-4 mt-4 w-full text-sm md:text-md',
                        ]"
                    >
                        <div class="flex items-center space-x-2">
                            <span class="font-semibold">Back to Homepage</span>
                        </div>
                    </MyPrimaryButton>
                </div>
            </div>
            <div class="max-w-7xl sm:px-6 lg:px-8 py-2 bg-slate-100">
                <div class="shadow-xl sm:rounded-xl px-3 py-4">
                    <p class="mb-4 ms-4">Status:</p>
                    <FiveStepTimeline :currrentStep="5" />
                </div>
            </div>
        </div>
    </div>
    <SuccessModal ref="successRefModal">
        Payment Successful <!-- TODO: Update the text -->
    </SuccessModal>


</template>

<script setup>
import GetQualifiedImg from '@/Logos/GetQualifiedImg.vue';
import PaymentChoicesImg from '@/Logos/PaymentChoicesImg.vue';
import CircularProgress from '@/MyComponents/CircularProgress.vue';
import FiveStepTimeline from '@/MyComponents/FiveStepTimeline.vue';
import MyPrimaryButton from '@/MyComponents/MyPrimaryButton.vue';
import ReturnToPage from '@/MyComponents/ReturnToPage.vue';
import SuccessModal from '@/MyComponents/SuccessModal.vue';
import { router } from '@inertiajs/vue3';
import { onMounted, ref, onUpdated, nextTick } from 'vue';

const props = defineProps({
    supplementaryData: Object,
});

const paymentOption = ref(false);
const paymentReminder = ref(false);
const selectedPaymentMethod = ref(0);
const updatePaymentOption = (newVal) => {
    paymentOption.value = newVal;
}
const updatePaymentReminder = (newVal) => {
    paymentReminder.value = newVal;
}

</script>

<style scoped>
.bg_layout{
    z-index: 1;
}
</style>