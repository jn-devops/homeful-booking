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
                <Input
                    id="cardNumber"
                    name="cardNumber"
                    v-model="cardNumber"
                    label="Card Number"
                    type="text"
                    placeholder="Enter card number"
                    maxlength="19"
                    @input="maskCardNumber"
                    :errorMessage="cardNumberError"
                />
                <div class="flex flex-row gap-4">
                    <div class="basis-1/2">
                        <Input
                            id="expirationDate"
                            name="expirationDate"
                            label="Expiration Date"
                            type="text"
                            v-model="expirationDate"
                            placeholder="MM/YY"
                            maxlength="5"
                            @input="maskExpirationDate"
                            :errorMessage="expirationDateError"
                        />
                    </div>
                    <div class="basis-1/2">
                        <Input
                            id="cvv"
                            name="cvv"
                            label="CVV"
                            type="text"
                            v-model="cvv"
                            placeholder="Enter CVV"
                            maxlength="3"
                            @input="maskCvv"
                            :errorMessage="cvvError"
                        />
                    </div>
                </div>
                <div class="text-xl w-full font-semibold flex-none pb-6 justify-center text-center">
                    <MyPrimaryButton
                        @click="payNow"
                        :class="[
                            'rounded-full w-full p-4 mt-4 text-sm md:text-md',
                            // isFormValid ? '' : 'bg-gray-300'
                        ]"
                    >
                        Pay
                    </MyPrimaryButton>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import PaymentCards from '@/Logos/PaymentCards.vue';
import Input from '@/MyComponents/Input/Input.vue';
import Return from '@/MyComponents/Return.vue';
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import MyPrimaryButton from '@/MyComponents/MyPrimaryButton.vue';

const cardNumber = ref('');
const expirationDate = ref('');
const cvv = ref('');
const cardNumberError = ref('');
const expirationDateError = ref('');
const cvvError = ref('');

const props = defineProps({
    kwyc_code: String
});

// Mask and validation functions
const maskCardNumber = () => {
    cardNumber.value = cardNumber.value
        .replace(/\D/g, '') // Remove all non-digit characters
        .replace(/(.{4})/g, '$1-') // Add a dash every 4 digits
        .slice(0, 19); // Ensure the length does not exceed 19 characters (16 digits + 3 dashes)

    // Validation: Check if the card number is valid
    if (!/^\d{4}-\d{4}-\d{4}-\d{4}$/.test(cardNumber.value)) {
        cardNumberError.value = 'Invalid card number';
    } else {
        cardNumberError.value = '';
    }
};

const maskExpirationDate = () => {
    expirationDate.value = expirationDate.value
        .replace(/\D/g, '') // Remove all non-digit characters
        .replace(/(\d{2})(\d{1,2})?/, '$1/$2') // Add a slash after the first 2 digits
        .slice(0, 5); // Ensure the length does not exceed 5 characters (4 digits + 1 slash)

    // Validation: Check if the expiration date is valid
    if (!/^\d{2}\/\d{2}$/.test(expirationDate.value)) {
        expirationDateError.value = 'Invalid expiration date';
    } else {
        expirationDateError.value = '';
    }
};

const maskCvv = () => {
    cvv.value = cvv.value
        .replace(/\D/g, '') // Remove all non-digit characters
        .slice(0, 3); // Ensure the length does not exceed 3 digits

    // Validation: Check if the CVV is valid
    if (!/^\d{3}$/.test(cvv.value)) {
        cvvError.value = 'Invalid CVV';
    } else {
        cvvError.value = '';
    }
};

// Form validation
const isFormValid = computed(() => {
    return cardNumberError.value === '' && expirationDateError.value === '' && cvvError.value === '' &&
        cardNumber.value !== '' && expirationDate.value !== '' && cvv.value !== '';
});

const payNow = async () => {
    router.get(`/payment-choices/card/pay/${props.kwyc_code}?cardNumber=${encodeURIComponent(cardNumber.value)}&expirationDate=${encodeURIComponent(expirationDate.value)}&cvv=${encodeURIComponent(cvv.value)}`);
    if (isFormValid.value) {
    }
};
</script>
