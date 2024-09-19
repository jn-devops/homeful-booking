<script setup>
import Collapsible from '@/MyComponents/Collapsible.vue';
import CollapsibleArrowLogo from '@/Logos/CollapsibleArrowLogo.vue';
import MyModal from '@/MyComponents/MyModal.vue';
import MyPrimaryButton from '@/MyComponents/MyPrimaryButton.vue';
import DefaultGrayButton from '@/MyComponents/DefaultGrayButton.vue';
import RoundedButton from '@/MyComponents/RoundedButton.vue';
import SliderRange from '@/MyComponents/SliderRange.vue';
import {reactive, ref, watch} from 'vue';
import { debounce } from 'lodash';
import {useForm, usePage} from "@inertiajs/vue3";
import CenterModal from '@/MyComponents/CenterModal.vue';

const props = defineProps({
    calculator: {
        type: Object,
    },
    formatCurrency: {
        type: Function,
        required: true,
    },
})

const btnDetails = ref(false);
const detailsContent = ref('');

const showBtnDetails = (params) =>{
    btnDetails.value = !btnDetails.value;
    detailsContent.value = params;
    console.log('params', detailsContent.value);
}

const updateBtnDetails = (newVal) =>{
    btnDetails.value = newVal;
}


const addIncome = ref(false);

const showAddIncome = () =>{
    addIncome.value = !addIncome.value;
}
const updateAddIncome = (newVal) =>{
    addIncome.value = newVal;
}

const activeButton = ref('wages');
const incomeDetails = (params) =>{
    // console.log('click data:', params);
    activeButton.value = params;
    // console.log('isActive:', isActive.value);
}

const loan_data  = ref({
    age: props.calculator.age,
    regional: props.calculator.regional,
    gross_monthly_income: props.calculator.guess_gross_monthly_income,
    total_contract_price: props.calculator.total_contract_price,
    appraised_value: props.calculator.total_contract_price,
    percent_down_payment: props.calculator.percent_down_payment,
    balance_payment_term: props.calculator.balance_payment_term,
    percent_miscellaneous_fees: props.calculator.percent_miscellaneous_fees,
    guess_down_payment_amount: props.calculator.guess_down_payment_amount,
    guess_dp_amortization_amount: props.calculator.guess_dp_amortization_amount,
    guess_partial_miscellaneous_fees: props.calculator.guess_partial_miscellaneous_fees,
    guess_miscellaneous_fees: props.calculator.guess_miscellaneous_fees,
    guess_balance_payment: props.calculator.guess_balance_payment,
    guess_monthly_amortization: props.calculator.guess_monthly_amortization,
    down_payment_term: props.calculator.down_payment_term,
});

const form = reactive({
    age: props.calculator.age,
    gross_monthly_income: props.calculator.guess_gross_monthly_income,
    balance_payment_term: props.calculator.balance_payment_term,
});


const debouncedUpdate = debounce(() => {
    let calculatorForm = useForm({
        age: form.age,
        regional: loan_data.value.regional,
        gross_monthly_income: form.gross_monthly_income,
        total_contract_price: loan_data.value.total_contract_price,
        appraised_value: loan_data.value.total_contract_price,
        percent_down_payment: loan_data.value.percent_down_payment,
        balance_payment_term: form.balance_payment_term,
        percent_miscellaneous_fees: loan_data.value.percent_miscellaneous_fees,
    })
    calculatorForm.get(route('calculate.loan'), {
        preserveState: true,
        preserveScroll: true,
        onError: (page) =>{
            console.log(page)
        }
    });

}, 500);

watch(() => form.age, (newValue, oldValue) => {
    debouncedUpdate();
})

watch (
    () => usePage().props.flash.event,
    (event) => {
        switch (event?.name) {
            case 'loan.calculated':
                console.log('Event',event.data);
                loan_data.value.gross_monthly_income = event.data.borrower.gross_monthly_income;
                loan_data.value.total_contract_price = event.data.property.total_contract_price;
                loan_data.value.appraised_value = event.data.property.appraised_value;
                loan_data.value.percent_down_payment = event.data.percent_down_payment;
                loan_data.value.balance_payment_term = event.data.bp_term;
                loan_data.value.percent_miscellaneous_fees = event.data.percent_mf;
                loan_data.value.guess_down_payment_amount = event.data.down_payment;
                loan_data.value.guess_dp_amortization_amount = event.data.dp_amortization;
                loan_data.value.guess_partial_miscellaneous_fees = event.data.partial_miscellaneous_fees;
                loan_data.value.guess_miscellaneous_fees = event.data.miscellaneous_fees;
                loan_data.value.guess_balance_payment = event.data.loan_amount;
                loan_data.value.guess_monthly_amortization = event.data.loan_amortization;
                loan_data.value.down_payment_term = event.data.dp_term;
                break;
        }
    },
    { immediate: true }
);

const formatCurrency = (value) => {
    const formatter = new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });
    return formatter.format(value);
};

const addSliderValue = (propName, increment = 1) => {
    form[propName] = form[propName] + increment
}
const subSliderValue = (propName, decrement = 1) => {
    form[propName] = form[propName] - decrement
}

const isDownpaymentOpen = ref(false);
const downpaymentModal = (newVal) =>{
    isDownpaymentOpen.value = newVal;
}
const isBalancePaymnentOpen = ref(false);
const balancePaymentModal = (newVal) =>{
    isBalancePaymnentOpen.value = newVal;
}

</script>
<template>
     <div class="py-1 px-0 md:px-4 h-[600px] overflow-auto md:h-auto md:overflow-hidden">
            <!-- Mobile -->
            <div class="block md:hidden">
                <div class="mt-1">
                    <h3 class="font-bold text-lg mb-2">Downpayment</h3>
                    <div class="bg-[#F6FAFF] px-4 py-2 rounded-lg" @click="downpaymentModal(true)">
                        <div class="flex gap-2 mb-5">
                            <div class=" flex-none w-36">
                                <p class="text-black text-sm">Total Down Payment</p>
                                <p class="font-bold text-[#8B8B8B] text-lg">{{ formatCurrency(loan_data.guess_down_payment_amount) }}</p>
                            </div>
                            <div class="grow w-62">
                                <div class="flex gap-0">
                                    <div class="text-sm flex-grow-1 flex-shrink-0 overflow-hidden">
                                        <p class="text-sm">Payable in {{ loan_data.down_payment_term }} months:</p>
                                        <div class="default_text-color font-bold flex py-1 " >
                                            <p class="text-lg py-0">{{ formatCurrency(loan_data.guess_dp_amortization_amount) }}++</p>
                                            <p class="font-normal">/ month</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <div class="flex-none w-36">
                                <p class="text-black text-sm">Miscellaneous Fee</p>
                                <p class="font-bold text-[#8B8B8B] text-lg">{{ formatCurrency(loan_data.guess_miscellaneous_fees) }}</p>
                            </div>
                            <div class="grow w-62">
                                <div class="flex gap-0">
                                    <div class="text-sm flex-grow-1">
                                        <p class="text-sm">Partial Payment Miscellaneous Fee</p>
                                        <div class="default_text-color font-bold flex py-1">
                                            <p class="text-lg py-0">{{ formatCurrency(loan_data.guess_partial_miscellaneous_fees) }}</p>
                                            <p class="text-xs font-normal ps-2">/ Pay on 13th month</p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-1">
                    <h3 class="font-bold text-lg mb-2">Balance Payment</h3>
                    <div class="bg-[#F6FAFF] px-4 py-4 rounded-lg" @click="balancePaymentModal(true)">
                        <div class="flex gap-2">
                            <div class="flex-none w-36">
                                <p class="text-text text-sm">{{ 100 - (loan_data.percent_down_payment * 100) }}% Balance Downpayment<br>Tru Bank Financing:</p>
                                <p class="font-bold text-[#8B8B8B] text-lg">{{ formatCurrency(loan_data.guess_balance_payment) }}</p>
                            </div>
                            <div class="grow w-62">
                                <div class="flex gap-0">
                                    <div class="text-sm flex-grow-1">
                                        <p class="text-sm">{{ loan_data.balance_payment_term }} years to pay after loan takeout</p>
                                        <div class="default_text-color font-bold flex py-1 border-b-2">
                                            <p class="text-lg py-0">{{ formatCurrency(loan_data.guess_monthly_amortization) }}++</p>
                                            <p class="font-normal">/ month</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2 border-t-2 border-t-slate-200">
                    <div class="">
                        <p class="font-semibold text-lg pt-3">Customize by Age:</p>
                        <div class="flex justify-between mb-6">
                            <div class="text-left pt-4">
                                <p class="default_text-color font-bold">
                                    {{ form.age }} years old
                                </p>
                                <p>Age</p>
                            </div>
                            <div class="">
                                <div class="flex gap-2">
                                    <button @click="subSliderValue('age')" class="default_text-color font-bold text-3xl border border-amber-400 p-1 w-12 rounded-full">-</button>
                                    <button @click="addSliderValue('age')" class="default_text-color font-bold text-3xl border border-amber-400 p-1 w-12 rounded-full">+</button>
                                </div>
                            </div>
                        </div>
                        <div>
                            <SliderRange v-model="form.age" :min="18" :max="60" />
                        </div>
                        <div class="flex gap-4 pt-4">
                            <div>
                                <p class="default_text-color font-bold">
                                    {{ formatCurrency(loan_data.guess_monthly_amortization) }}
                                </p>
                                <p class="text-sm">Required Monthly Amortization</p>
                            </div>
                            <div>
                                <p class="default_text-color font-bold">
                                    {{ formatCurrency(loan_data.gross_monthly_income) }}
                                </p>
                                <p class="text-sm">Required Monthly Income</p>

                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- Dekstop -->
            <div class="hidden md:block">
                <div class="mt-4">
                    <div class="grid grid-cols-2 gap-2 items-center">
                        <div class="">
                            <p class="font-bold text-xl">{{ calculator.downpayment }}</p>
                            <p class="text-gray-500">5% Downpayment</p>
                        </div>
                        <div class="">
                            <div class="bg-amber-50 p-3 rounded-lg flex gap-2 items-center justify-between">
                                <div>
                                    <div class="default_text-color font-bold flex gap-2">
                                        <p class=" text-2xl border-b-2 py-1">₱10,417++</p>
                                        <p class="font-normal">/ month</p>
                                    </div>
                                    <p class="py-1">Payable in 12 months</p>
                                </div>
                                <div>
                                    <RoundedButton
                                    @click="showBtnDetails('downpayment')">
                                        <CollapsibleArrowLogo />
                                    </RoundedButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="grid grid-cols-2 gap-2 items-center">
                        <div class="">
                            <p class="font-bold text-xl">{{ calculator.miscfee }}</p>
                            <p class="text-gray-500">Partial Miscellaneous Fee</p>
                        </div>
                        <div class="">
                            <div class="bg-amber-50 p-3 rounded-lg">
                                <div class="default_text-color font-bold flex gap-2">
                                    <p class=" text-2xl border-b-2 py-1">{{ calculator.miscfee }}</p>
                                    <!-- <p class="font-normal">/ month</p> -->
                                </div>
                                <p class="py-1">Payable in 13th months</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="grid grid-cols-2 gap-2 items-center">
                        <div class="">
                            <p class="font-bold text-xl">{{ calculator.balDP }}</p>
                            <p class="text-gray-500">95% Balance Downpayment</p>
                        </div>
                        <div class="">
                            <div class="bg-amber-50 p-3 rounded-lg flex gap-2 items-center justify-between">
                                <div>
                                    <div class="default_text-color font-bold flex gap-2">
                                        <p class=" text-2xl border-b-2 py-1">₱17,144</p>
                                        <p class="font-normal">/ month</p>
                                    </div>
                                    <p class="py-1">30 years monthly starting
                                        on the 14th month</p>
                                </div>
                                <div>
                                    <RoundedButton
                                    @click="showBtnDetails('balance')">
                                        <CollapsibleArrowLogo />
                                    </RoundedButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-top-2">
                    <Collapsible >
                        <template #collapsibleName>
                                <p class="text-right">Customize</p>
                        </template>
                        <div class="mt-4">
                            <div class="">
                                <div class="flex justify-between mb-6">
                                    <div class="text-left">
                                        <p class="default_text-color font-bold">
                                            {{ calculator.age }} years old
                                        </p>
                                        <p>Age</p>
                                    </div>
                                    <div class="">
                                        <div class="flex gap-2">
                                            <button class="default_text-color font-bold text-3xl border border-amber-400 p-1 w-12 rounded-full">-</button>
                                            <button class="default_text-color font-bold text-3xl border border-amber-400 p-1 w-12 rounded-full">+</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="w-full h-4 bg-gray-200 rounded-lg relative z-10"> -->
                                    <!-- <div class="absolute -top-3 w-8 h-8 bg-gray-500 rounded-full z-20 left-1/2 transform -translate-x-1/2">
                                    </div> -->
                                <!-- </div> -->
                                 <div>
                                    <SliderRange />
                                 </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex justify-between mb-6">
                                    <div class="text-left">
                                        <p class="default_text-color font-bold">
                                            {{ calculator.gmi }}
                                        </p>
                                        <p>Gross Monthly Income</p>
                                    </div>
                                    <div class="">
                                        <div class="flex gap-2">
                                            <button class="default_text-color font-bold text-3xl border border-amber-400 p-1 w-12 rounded-full">-</button>
                                            <button class="default_text-color font-bold text-3xl border border-amber-400 p-1 w-12 rounded-full">+</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="w-full h-4 bg-gray-200 rounded-lg relative z-10"> -->
                                    <!-- <div class="absolute -top-3 w-8 h-8 bg-gray-500 rounded-full z-20 left-1/2 transform -translate-x-1/2">
                                    </div> -->
                                <!-- </div> -->
                                 <div>
                                    <SliderRange />
                                 </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex gap-2 items-center justify-between">
                                    <p class="text-blue-600 text-md">Your Income is enough to own a property.</p>
                                    <button
                                    @click="showAddIncome"
                                    class="default_text-color font-bold bg-blue-50 p-2 rounded-lg">Add Income</button>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex justify-between mb-6">
                                    <div class="text-left">
                                        <p class="default_text-color font-bold">
                                            {{ calculator.terms }} years to pay
                                        </p>
                                        <p>Terms</p>
                                    </div>
                                    <div class="">
                                        <div class="flex gap-2">
                                            <button class="default_text-color font-bold text-3xl border border-amber-400 p-1 w-12 rounded-full">-</button>
                                            <button class="default_text-color font-bold text-3xl border border-amber-400 p-1 w-12 rounded-full">+</button>
                                        </div>
                                    </div>
                                </div>



                                <!-- <label for="default-range" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Default range</label> -->

                                <div>
                                    <!-- <label for="large-range" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Large range</label> -->
                                   <SliderRange />
                                </div>

                                <!-- <input id="large-range" type="range" value="0" class="w-full h-3 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"> -->

                                <!-- <div class="w-full h-4 bg-gray-200 rounded-lg relative z-10"> -->
                                    <!-- <div class="absolute -top-3 w-8 h-8 bg-gray-500 rounded-full z-20 left-1/2 transform -translate-x-1/2">
                                    </div> -->
                                <!-- </div> -->
                            </div>
                        </div>
                    </Collapsible>
                </div>
            </div>
        </div>

        <!-- Downpayment Modal -->
        <CenterModal :isOpen="isDownpaymentOpen" @update:isOpen="isDownpaymentOpen = $event">
            <div class="grid grid-cols-10 gap-2">
                <div class="col-span-4">
                    <p class="font-bold text-black text-xl">{{ formatCurrency(loan_data.guess_down_payment_amount) }}</p>
                    <p class="text black text-sm">{{ loan_data.percent_down_payment * 100 }}% Downpayment</p>
                </div>
                <div class=" col-span-6">
                    <div class="bg-[#F6F6F6] py-2 px-4 rounded-2xl ">
                        <div class="default_text-color font-bold flex gap-2">
                            <p class="border-b-2 py-1">{{ formatCurrency(loan_data.guess_dp_amortization_amount) }}++ <span class="font-normal"> / month</span></p>
                        </div>
                        <p class="py-1 text-sm">Payable in {{ loan_data.down_payment_term }} months</p>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <div class="grid grid-cols-3 gap-3">
                    <table class="w-full col-span-3 text-sm">
                        <tbody>
                            <tr>
                                <td class="w-4/6 text-[#7F7F7F]">DP Amount</td>
                                <td class="w-2/6 font-semibold">{{ formatCurrency(loan_data.guess_down_payment_amount) }}</td>
                            </tr>
                            <tr>
                                <td class="text-[#7F7F7F]">DP Percentage</td>
                                <td class="font-semibold">{{ loan_data.percent_down_payment * 100 }}%</td>
                            </tr>
                            <tr>
                                <td class="text-[#7F7F7F]">Terms</td>
                                <td class="font-semibold">{{ loan_data.down_payment_term }} months</td>
                            </tr>
                            <tr>
                                <td class="text-[#7F7F7F]">Downypayment Monthly Amortization</td>
                                <td class="default_text-color font-semibold">{{ formatCurrency(loan_data.guess_dp_amortization_amount) }}</td>
                            </tr>
                            <tr>
                                <td class="text-[#7F7F7F]">Miscellaneous Fee(Pay on 13th month)</td>
                                <td class="default_text-color font-semibold">{{ formatCurrency(loan_data.guess_partial_miscellaneous_fees) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-full flex items-center justify-center mt-3" @click="downpaymentModal(false)">
                <div class="basis-4/5 bg-[#F0F0F0] text-center rounded-full p-4 text-[#CC035C] font-semibold">Close</div>
            </div>
        </CenterModal>

        <!-- Balance Payment Modal -->
        <CenterModal :isOpen="isBalancePaymnentOpen" @update:isOpen="isBalancePaymnentOpen = $event">
            <div class="grid grid-cols-10 gap-2">
                <div class="col-span-4">
                    <p class="font-bold text-black text-xl">{{ formatCurrency(loan_data.guess_balance_payment) }}</p>
                    <p class="text black text-sm">{{ 100 - (loan_data.percent_down_payment * 100) }}% Balance Downpayment</p>
                </div>
                <div class=" col-span-6">
                    <div class="bg-[#F6F6F6] py-2 px-4 rounded-2xl ">
                        <div class="default_text-color font-bold flex gap-2">
                            <p class="border-b-2 py-1">{{ formatCurrency(loan_data.guess_monthly_amortization) }}++ <span class="font-normal"> / month</span></p>
                        </div>
                        <p class="py-1 text-sm">{{ loan_data.balance_payment_term }} years to pay after loan takeout</p>
                    </div>
                    <div class="py-1 ps-5 text-sm">
                        <p>GMI: <b>{{ formatCurrency(loan_data.gross_monthly_income) }}</b> </p>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <div class="grid grid-cols-3 gap-3">
                    <table class="w-full col-span-3 text-sm">
                        <tbody>
                            <tr>
                                <td class="w-4/6 text-[#7F7F7F]">Balance Payment Amount:</td>
                                <td class="w-2/6 font-semibold">{{ formatCurrency(loan_data.guess_balance_payment) }}</td>
                            </tr>
                            <tr>
                                <td class="text-[#7F7F7F]">Balance Miscellaneous Fee:</td>
                                <td class="font-semibold">{{ formatCurrency(loan_data.guess_miscellaneous_fees) }}</td>
                            </tr>
                            <tr>
                                <td class="text-[#7F7F7F]">Total Balance(BP+MF):</td>
                                <td class="font-semibold">{{ formatCurrency(loan_data.guess_balance_payment +  loan_data.guess_miscellaneous_fees) }}</td>
                            </tr>
                            <tr>
                                <td class="text-[#7F7F7F]">Terms</td>
                                <td class="default_text-color font-semibold">{{ loan_data.balance_payment_term }} years</td>
                            </tr>
                            <tr>
                                <td class="text-[#7F7F7F]">Monthly Amortization</td>
                                <td class="default_text-color font-semibold">{{ formatCurrency(loan_data.guess_monthly_amortization) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-full flex items-center justify-center mt-3" @click="balancePaymentModal(false)">
                <div class="basis-4/5 bg-[#F0F0F0] text-center rounded-full p-4 text-[#CC035C] font-semibold">Close</div>
            </div>
        </CenterModal>

        <!-- MyModal -->
        <MyModal
        :modal-show="btnDetails"
        @updatemodalShow="updateBtnDetails"
        >
            <template #content_noborder>
                <div
                v-if="detailsContent ===  'downpayment'"
                >
                    <div class="grid grid-cols-10 gap-2 items-center">
                        <div class="col-span-4">
                            <p class="font-bold">{{ formatCurrency(loan_data.guess_down_payment_amount) }}</p>
                            <p class="text-gray-500">{{ loan_data.percent_down_payment * 100 }}% Downpayment</p>
                        </div>
                        <div class=" col-span-6">
                            <div class="bg-amber-50 px-3 py-2 rounded-lg ">
                                <div class="default_text-color font-bold flex gap-2">
                                    <p class=" text-xl border-b-2 py-1">{{ formatCurrency(loan_data.guess_dp_amortization_amount) }}++</p>
                                    <p class="font-normal">/ month</p>
                                </div>
                                <p class="py-1">Payable in {{ loan_data.down_payment_term }} months</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="grid grid-cols-3 gap-3">
                            <table class="w-full col-span-3">
                            <tbody>
                                <tr>
                                    <td class="w-4/6">DP Amount</td>
                                    <td class="w-2/6 font-semibold">{{ formatCurrency(loan_data.guess_down_payment_amount) }}</td>
                                </tr>
                                <tr>
                                    <td>DP Percentage</td>
                                    <td class="font-semibold">{{ loan_data.percent_down_payment * 100 }}%</td>
                                </tr>
                                <tr>
                                    <td>Terms</td>
                                    <td class="font-semibold">{{ loan_data.down_payment_term }} months</td>
                                </tr>
                                <tr>
                                    <td>Downypayment Monthly Amortization</td>
                                    <td class="default_text-color font-semibold">{{ formatCurrency(loan_data.guess_dp_amortization_amount) }}</td>
                                </tr>
                                <tr>
                                    <td>Miscellaneous Fee(Pay on 13th month)</td>
                                    <td class="default_text-color font-semibold">{{ formatCurrency(loan_data.guess_partial_miscellaneous_fees) }}</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div v-if="detailsContent === 'balance'">
                    <div class="grid grid-cols-10 gap-2 items-center">
                        <div class="col-span-4">
                            <p class="font-bold ">{{ formatCurrency(loan_data.guess_balance_payment) }}</p>
                            <p class="text-gray-500">{{ 100 - (loan_data.percent_down_payment * 100) }}% Balance Downpayment</p>
                        </div>
                        <div class="col-span-6">
                            <div class="bg-amber-50 p-3 rounded-lg ">
                                <div class="default_text-color font-bold flex gap-2">
                                    <p class=" text-2xl border-b-2 py-1">{{ formatCurrency(loan_data.guess_monthly_amortization) }}</p>
                                    <p class="font-normal">/ month</p>
                                </div>
                                <p class="py-1">Payable in {{ loan_data.balance_payment_term }} years</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="grid grid-cols-3 gap-3">
                            <div class="col-span-2 text-gray-400">
                                <div>
                                    <p>Balance Payment Amount:</p>
                                    <p>Balance Miscellaneous Fee:</p>
                                    <p>Total Balance(BP+MF):</p>
                                    <p>Terms</p>
                                    <p>Monthly Amortization</p>
                                </div>
                            </div>
                            <div class="col-span-1 font-bold">
                                <p>{{ formatCurrency(loan_data.guess_balance_payment) }}</p>
                                <p>{{ formatCurrency(loan_data.guess_partial_miscellaneous_fees) }}</p>
                                <p>{{ formatCurrency(loan_data.guess_balance_payment +  loan_data.guess_partial_miscellaneous_fees) }}</p>
                                <p class="">{{ loan_data.balance_payment_term }} years</p>
                                <p class="default_text-color">{{  formatCurrency(loan_data.guess_monthly_amortization)  }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template #buttons>
                <div class="w-1/2 mx-auto">
                    <DefaultGrayButton
                    @click="showBtnDetails"
                    class="rounded-full p-4 mt-4 font-bold w-full"
                    >
                        Close
                    </DefaultGrayButton>
                </div>
            </template>
        </MyModal>

        <!-- Add Income Modal -->
        <MyModal
        :modal-show="addIncome"
        @updatemodalShow="updateAddIncome"
        >
            <template #titeNoBorder>
                Add Income
            </template>
            <template #content_noborder class="">
                <div class="pt-2">
                    <div class="mb-3">
                        <input type="text"
                        placeholder="₱5,000"
                        class="focus:border-current focus:ring-0 border-t-0 border-l-0 border-r-0 border-gray-400 w-full text-center text-2xl font-bold"/>
                    </div>
                    <div class="flex gap-2">
                        <div
                        :class="{'isActive': activeButton === 'wages'}"
                        class="border border-gray-400 py-1 px-4 rounded-xl font-bold text-gray-400 text-sm md:text-md">
                            <button
                            @click="incomeDetails('wages')"
                            >Wages</button>
                        </div>
                        <div
                        :class="{'isActive': activeButton === 'co_borrower'}"
                        class="border border-gray-400 py-1 px-4 rounded-xl font-bold text-gray-400 text-sm md:text-md">
                            <button

                            @click="incomeDetails('co_borrower')"
                            >Co-borrower</button>
                        </div>
                        <div
                        :class="{'isActive': activeButton === 'other_income'}"
                        class="border border-gray-400 py-1 px-4 rounded-xl font-bold text-gray-400 text-sm md:text-md">
                            <button
                            @click="incomeDetails('other_income')"
                            >Other Income</button>
                        </div>
                    </div>
                </div>
            </template>
            <template #buttons>
                <div class="flex gap-2">
                    <div class=" w-1/2 mx-auto ">
                        <DefaultGrayButton
                        @click="showAddIncome"
                        class="w-full rounded-full p-4 mt-4"
                        >
                            Close
                        </DefaultGrayButton>
                    </div>
                    <div class="w-1/2 mx-auto">
                        <MyPrimaryButton
                        class="w-full rounded-full p-4 mt-4"
                        >
                            Add Income
                        </MyPrimaryButton>
                    </div>
                </div>
            </template>
        </MyModal>
</template>


<style>
.default_text-color{
    color: #CC035C;
}
.isActive {
   /* border-rose-600 */
  color: #CC035C; /* text-rose-500 */
  border: 1px solid #CC035C;
  /* font-weight: bold; */
}
</style>
