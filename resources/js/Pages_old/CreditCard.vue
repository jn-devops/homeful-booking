<script setup>
import LeftArrow from '@/Logos/LeftArrow.vue';
import BankingLogos from '@/Logos/BankingLogos.vue';
import InputLabel from '@/Components/InputLabel.vue';
import MyPrimaryButton from '@/MyComponents/MyPrimaryButton.vue';
import { ref } from 'vue';

const payNowStatus = ref(false);

const emit = defineEmits(['paystatus'])
const payNowFunc = () =>{
    payNowStatus.value = true;
    emit('paystatus', payNowStatus.value);
    console.log('payStatus', payNowStatus.value);
}
</script>
<template>
    <div class="flex gap-4 items-center p-4">
       <div>
        <a href="/payments">
            <LeftArrow />
        </a>
       </div>
       <div>
            <h1 class="font-bold text-xl">Credit Card Payments</h1>
       </div>
    </div>
    <div class="max-w-7xl md:max-w-2xl mx-auto sm:px-6 lg:px-8 py-2 mt-4">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl px-3 py-4">
                    <!-- <Welcome /> -->
                     <!-- <LandingPage /> -->
                  <div class="flex justify-between">
                    <div>
                        <h1 class="font-bold text-xl">Credit Details</h1>
                    </div>
                    <div>
                        <BankingLogos />
                    </div>
                  </div>
                  <div class="mt-4">
                    <div class="mt-3">
                        <InputLabel for="card_number" value="Card Number" class="font-bold" />
                        <input 
                            id="card_number"
                            type="text"
                            placeholder="12345678910111213141516"
                            class="mt-2 block w-full rounded-full border-0 py-3 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                            >
                    </div>
                    <div class="flex gap-2">
                        <div class="mt-3">
                            <InputLabel for="expiration_date" value="Expiration Date" class="font-bold" />
                            <input 
                                id="expiration_date"
                                type="text"
                                placeholder="06/26"
                                class="mt-2 block w-full rounded-full border-0 py-3 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                                >
                        </div>
                        <div class="mt-3">
                            <InputLabel for="cvv" value="CVV" class="font-bold" />
                            <input 
                                id="cvv"
                                type="text"
                                placeholder="234"
                                class="mt-2 block w-full rounded-full border-0 py-3 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                                >
                        </div>

                    </div>
                    <div>
                        
                        <a @click="payNowFunc" href="/paymentsuccessful"
                        >
                            <MyPrimaryButton
                                class="w-full rounded-full p-4 mt-4"
                                >
                                Pay Now
                            </MyPrimaryButton>
                        </a>
                    </div>
                  </div>
                </div>
            </div>
</template>