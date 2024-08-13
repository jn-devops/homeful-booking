<script setup>
import DetailsHeader from '@/MyComponents/DetailsHeader.vue';
import DetailsContent from '@/MyComponents/DetailsContent.vue';
import DetailsNavigation from '@/MyComponents/DetailsNavigation.vue';
import MyPrimaryButton from '@/MyComponents/MyPrimaryButton.vue';
import ArrowLogo from '@/Logos/ArrowLogo.vue';
import { ref } from 'vue';

const nxtPage = ref(false);
const nxtPageforSubmit = ref(false);
const employmentDetailsPage = ref(false);
const nextPageforPayment = ref(false);

const myFunctionToSubmit = () =>{
    nxtPageforSubmit.value = !nxtPageforSubmit.value
}

const myFunc = (param) =>{
    console.log('oldValue', nxtPage.value);
    nxtPage.value = param;
    console.log('newValue:', nxtPage.value);
}

const employmentInfo = (e) =>{
    // console.log(e.target);
    console.log('employmentDetails', employmentDetailsPage.value);
    employmentDetailsPage.value = !employmentDetailsPage.value;
    console.log('employmentDetails', employmentDetailsPage.value);
}

const proceedPayment = (params) =>{ 
    // console.log(e.target);
    console.log('payment:', nextPageforPayment.value);
    nextPageforPayment.value = params;
    console.log('payment:', nextPageforPayment.value);
}
</script>
<template>
    <header class="block md:hidden">
        <DetailsHeader :employmentDetails="employmentDetailsPage" />
    </header>
    <main>

        <DetailsContent
        class="h-3/4 overflow-auto" 
        :employmentDetails="employmentDetailsPage"
        :payment="nextPageforPayment">
        <template #head>
            <DetailsHeader :employmentDetails="employmentDetailsPage">
                <template #btnNavigation>
                    <DetailsNavigation>
                        <div class="bg-white rounded-full" :class="employmentDetailsPage ? 'hidden' : 'block'">
                            <MyPrimaryButton
                            v-if="!nxtPage"
                            @click="myFunc(true)"
                            class="rounded-full p-4 w-1/4">
                            <ArrowLogo  class="mx-auto h-auto w-auto"/>
                            </MyPrimaryButton>
                            <MyPrimaryButton
                            @click="employmentInfo"
                            v-if="nxtPage"
                            class="w-full rounded-full p-4"
                            >
                            Go to Employment Information
                            </MyPrimaryButton>
                        </div>
                        <div class="bg-white rounded-full" :class="employmentDetailsPage ? 'block' : 'hidden'">
                            <MyPrimaryButton
                            v-if="!nxtPageforSubmit"
                            @click="myFunctionToSubmit"
                            class="rounded-full p-4 w-1/4">
                            <ArrowLogo  class="mx-auto h-auto w-auto"/>
                            </MyPrimaryButton>
                            <a
                            href="/payments"
                            >
                                <MyPrimaryButton
                                v-if="nxtPageforSubmit"
                                class="w-full rounded-full p-4"
                                >
                                Submit & Proceed to Payment
                                </MyPrimaryButton>
                            </a>
                        </div>
                    </DetailsNavigation>
                </template>
            </DetailsHeader>
        </template>
        </DetailsContent>
    </main>
    <div class="block md:hidden">
        <DetailsNavigation>
            <div class="bg-white rounded-full" :class="employmentDetailsPage ? 'hidden' : 'block'">
                <MyPrimaryButton
                v-if="!nxtPage"
                @click="myFunc(true)"
                class="rounded-full p-4 w-1/4">
                <ArrowLogo  class="mx-auto h-auto w-auto"/>
                </MyPrimaryButton>
                <MyPrimaryButton
                @click="employmentInfo"
                v-if="nxtPage"
                class="w-full rounded-full p-4"
                >
                Go to Employment Information
                </MyPrimaryButton>
            </div>
            <div class="bg-white rounded-full" :class="employmentDetailsPage ? 'block' : 'hidden'">
                <MyPrimaryButton
                v-if="!nxtPageforSubmit"
                @click="myFunctionToSubmit"
                class="rounded-full p-4 w-1/4">
                <ArrowLogo  class="mx-auto h-auto w-auto"/>
                </MyPrimaryButton>
                <a
                href="/payments"
                >
                    <MyPrimaryButton
                    v-if="nxtPageforSubmit"
                    class="w-full rounded-full p-4"
                    >
                    Submit & Proceed to Payment
                    </MyPrimaryButton>
                </a>
            </div>
        </DetailsNavigation>
    </div>
</template>


<style>
    .bg_color{
     background: linear-gradient(268.1deg, #CC035C 7.47%, #FCB115 98.92%);
    }
</style>