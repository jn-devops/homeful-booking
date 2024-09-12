<template>
    <ReturnToPagev2 :icon="supplementaryData.homefulBookingUrl"> Home Loan Consultation</ReturnToPagev2>
    <div class="bg_layout p-0 ">
        <div class="w-full bg-[#F3F4F6] p-8 flex flex-row gap-4">
            <!-- <VerifyIdentityHeaderImg class="w-full" /> -->
            <div class="basis-4/12">
                <ClientInfoHeaderImg />
                </div>
                <div class="basis-7/12 flex flex-col justify-center">
                <div class="text-md font-semibold text-[#CC035C]">
                    Step 2 of 5:
                </div>
                <div class="text-2xl font-extrabold">
                    Verify your Identity
                </div>
            </div>
        </div>
        <div class="py-1 w-full">
            <!-- <div class="flex flex-row p-5">
                <div class="basis-1/5">
                    <CircularProgress :currentProgress="2" />
                </div>
                <div class="ps-5 basis-4/5 flex flex-col justify-center">
                    <div class="text-md font-semibold text-[#CC035C]">
                        Step 2:
                    </div>
                    <div class="text-2xl font-extrabold">
                        Verify your Identity
                    </div>
                </div>
            </div> -->
            <div class="px-5 pt-7">
                <ul class="px-5 pb-4 font-bold">
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4"><path d="M20 6 9 17l-5-5"/></svg>
                        Ensure good lighting with no glares.
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4"><path d="M20 6 9 17l-5-5"/></svg>
                        Scan your government-issued ID.
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4"><path d="M20 6 9 17l-5-5"/></svg>
                        Take a selfie.
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4"><path d="M20 6 9 17l-5-5"/></svg>
                        A browser window will display the results.
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4"><path d="M20 6 9 17l-5-5"/></svg>
                        You're done!
                    </li>
                </ul>
                <div class="mb-4">
                    <MyPrimaryButton
                        :class="[
                            'rounded-full p-4 mt-4 w-full text-sm md:text-md',
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
                    <FiveStepTimeline :currrentStep="2" />
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
import ClientInfoHeaderImg from '@/Logos/ClientInfoHeaderImg.vue';
import RegisterHeaderImg from '@/Logos/RegisterHeaderImg.vue';
import VerifyIdentityHeaderImg from '@/Logos/VerifyIdentityHeaderImg.vue';
import VerifyIdentityImg from '@/Logos/VerifyIdentityImg.vue';
import CircularProgress from '@/MyComponents/CircularProgress.vue';
import FiveStepTimeline from '@/MyComponents/FiveStepTimeline.vue';
import MyPrimaryButton from '@/MyComponents/MyPrimaryButton.vue';
import ReturnToPage from '@/MyComponents/ReturnToPage.vue';
import ReturnToPagev2 from '@/MyComponents/ReturnToPagev2.vue';
import SuccessModal from '@/MyComponents/SuccessModal.vue';
import { onMounted, ref, onUpdated, nextTick } from 'vue';

const lottieJson = ref(null);
const successRefModal = ref(null);

const props = defineProps({
    supplementaryData: Object,
    sku:String,
    code:String,
    url:String,
});
async function proceedWithAnimation() {
    try {
        // Ensure the DOM is updated before proceeding
        // await nextTick();

        // Open the success modal
        // successRefModal.value.openSuccessModal();

        // Fetch the Lottie animation JSON
        const response = await fetch('/animation/proceed.json');

        // Check if the response is successful
        if (!response.ok) {

            // throw new Error(`Failed to fetch the animation: ${response.statusText}`);
        }

        // Parse the JSON response
        lottieJson.value = await response.json();
        console.log('response json:', lottieJson.value);
    } catch (error) {
        // Handle any errors that occur
        console.error('Error during proceedWithAnimation:', error);
    }
}

function goToKwyc(){
    window.location.href = props.url;
}
onMounted(async () => {
    proceedWithAnimation();
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
