
<script setup>
import PaymentSuccess from '@/Logos/PaymentSuccess.vue';
import Timeline from '@/MyComponents/Timeline.vue';
import HomefulLogo from '@/Logos/HomefulLogo.vue';
import MyPrimaryButton from '@/MyComponents/MyPrimaryButton.vue';

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
                    <h1 class="text-2xl font-bold">Congratulations!!</h1>
                    <p class="pt-4">Payment successful. 
                    You will receive an SMS notification with your 
                    Contact Reference Code (CRC).</p>
                    <p class="pt-4">Your application will now be subject for evaluation. You will receive another SMS notification upon successful qualification.</p>
                    <p class="pt-4">Visit our website to learn more about us.</p>
                    </div>
                    <div class="flex gap-2 justify-center mt-6 md:w-1/2 md:mx-auto">
                      <MyPrimaryButton
                       class="w-full rounded-full p-4 mt-4"
                      >
                        Browse
                      </MyPrimaryButton>
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
                        <Timeline class="mt-4">
                            <template #success>
                                <p>Pay Consulting Fee</p>
                            </template>
                        </Timeline>
                        <Timeline>
                            <template #pending>
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
                <Timeline class="mt-4">
                    <template #success>
                        <p>Pay Consulting Fee</p>
                    </template>
                </Timeline>
                <Timeline>
                    <template #pending>
                        <p>Get Qualified</p>
                    </template>
                </Timeline>
            </div>
        </div>
    </div>
</template>