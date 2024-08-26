<template>
    <Return link="/payment-choices"> Credit Card Payment</Return>
    <div class="bg-stone-100 h-screen">
        &nbsp;
        <div class="mt-24 px-3">
            <div class="rounded-lg bg-white p-4">
                <div class="flex flex-row">
                    <div class="text-xl font-semibold flex-none pb-6">
                        Card details
                    </div>
                    <div class="grow flex justify-end">
                        <PaymentCards />
                    </div>
                </div>
                <Input label="Card Number" type="text" placeholder="Enter card number" />
                <div class="flex flex-row gap-4">
                    <div class="basis-1/2">
                        <Input label="Expiration Date" type="cardExpDate" v-model="date" placeholder="MM/YY" />
                        {{ date }}
                    </div>
                    <div class="basis-1/2">
                        <Input label="CCV" type="text" />
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script setup>
import PaymentCards from '@/Logos/PaymentCards.vue';
import Input from '@/MyComponents/Input/Input.vue';
import Return from '@/MyComponents/Return.vue';
import { ref } from 'vue';

const date = ref('');

</script>