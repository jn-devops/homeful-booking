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

const props = defineProps({
    calculator: {
        type: Object,
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

const debouncedUpdate = debounce(() => {
    console.log('Updating')
}, 300);

const form = reactive({
    age: Number(props.calculator.age),
    gross_monthly_income: Number(props.calculator.guess_gross_monthly_income),
    loan_term: props.calculator.loan_term,
});

watch(() => form.age, (newValue, oldValue) => {
    debouncedUpdate();

})

const formatCurrency = (value) => {
    const formatter = new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP',
    });
    return formatter.format(value);
};

const addSliderValue = (propName) => {
    form[propName]++
}
const subSliderValue = (propName) => {
    form[propName]--
}

</script>
<template>
     <div class="py-1 px-0 md:px-4 h-80 overflow-auto md:h-auto md:overflow-hidden">
     <!-- <div class="py-1 h-80 overflow-auto px-4"> -->
            <!-- <div class="mt-4">
                <p class="font-bold text-xs md:text-sm">A. Downpayment</p>
                <div class="grid grid-cols-2 gap-4 mt-3">
                    <div class="mt-3">
                        <select id="civil_status" name="civil_status" class="block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                        </select>
                        <select id="civil_status" name="civil_status" class="block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                        </select>
                    </div>
                    <div class="bg-blue-50 text-sm p-3">
                        <p class="font-bold ">₱9,583</p>
                        <p>Downpayment</p>
                        <p>Monthly Amortization</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-3">
                    <div class="mt-3">
                        <p class="font-bold text-xs md:text-sm">B. Partial Miscellaneous Fee</p>
                    </div>
                    <div class="bg-blue-50 text-sm p-3">
                        <p class="font-bold ">₱9,583</p>
                    </div>
                </div>
                <div class="grid grid-rows-1 mt-3 w-full sm:w-32">
                    <div class="mt-3">
                        <p class="font-bold text-xs md:text-sm">B. Balance Payment Financial Institution</p>
                    </div>
                    <div class="mt-3">
                        <p class="font-bold ">₱9,583</p>
                        <p class="text-xs">Balance Payment</p>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <div class="grid grid-cols-2 gap-4 mt-3">
                    <div class="mt-3">
                        <select id="civil_status" name="civil_status" class="block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                        </select>
                        <select id="civil_status" name="civil_status" class="block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                        </select>
                    </div>
                    <div class="bg-blue-50 text-sm p-3 grid grid-rows-1 items-center">
                        <p class="font-bold ">₱19,887</p>
                        <p>Monthly Amortization</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4 mt-3">
                    <div class="mt-3">
                        <p class="font-bold text-xs md:text-sm">D. Required Gross Monthly Income</p>
                    </div>
                    <div class="grid grid-cols-2">
                       <div>
                        <p class="font-bold ">May 27,2024</p>
                        <p class="text-gray-600 text-sm">Reservation Date</p>
                       </div>
                       <div>
                        <p class="font-bold ">June 15,2024</p>
                        <p class="text-gray-600 text-sm">Document Completion Date</p>
                       </div>
                    </div>
                </div>
            </div> -->
            <!-- Mobile -->
            <div class="block md:hidden">
                <div class="mt-4">
                    <div class="flex gap-2 items-center">
                    <div class="w-32">
                        <p class="font-bold">{{ calculator.guess_down_payment_amount }}</p>
                        <p class="text-gray-500 text-sm">{{ calculator['percent_down_payment'] }}% Downpayment</p>
                    </div>
                    <div class="grow w-62">
                        <div class="bg-amber-50 p-3 rounded-lg flex gap-0 items-center overflow-hidden">
                        <div class="text-sm flex-grow-1 flex-shrink-0 overflow-hidden">
                            <div class="default_text-color font-bold flex py-1">
                            <p class="text-xl border-b-2 py-0 text-md">{{ calculator.guess_dp_amortization_amount }}++</p>
                            <p class="font-normal">/ month</p>
                            </div>
                            <p class="py-1 text-sm">Payable in {{ calculator.down_payment_term }} months</p>
                        </div>
                        <div>
                            <RoundedButton @click="showBtnDetails('downpayment')">
                            <CollapsibleArrowLogo />
                            </RoundedButton>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="mt-4">
                    <!-- <div class="flex gap-2 items-center">
                        <div class="grow">
                            <p class="font-bold">{{ calculator.miscfee }}</p>
                            <p class="text-gray-500 w-36">Partial Miscellaneous Fee</p>
                        </div>
                        <div class="grow w-64">
                            <div class="bg-amber-50 p-3 rounded-lg flex gap-1 items-center">
                                <div class="text-sm ">
                                    <div class="default_text-color font-bold flex py-1">
                                        <p class="text-xl border-b-2 py-0 text-md">{{ calculator.miscfee }}</p>

                                    </div>
                                    <p class="py-1 text-sm">Payable in 12 months</p>
                                </div>
                                <div>
                                    <RoundedButton
                                    @click="showBtnDetails('downpayment')">
                                        <CollapsibleArrowLogo />
                                    </RoundedButton>
                                </div>
                            </div>
                        </div>

                    </div> -->
                    <div class="flex gap-2 items-center">
                        <div class="w-32">
                            <p class="font-bold">{{ calculator.guess_partial_miscellaneous_fees }}</p>
                            <p class="text-gray-500 text-sm">Partial Miscellaneous Fee</p>
                        </div>
                        <div class="grow w-62">
                            <div class="bg-amber-50 p-3 rounded-lg flex gap-0 items-center overflow-hidden">
                            <div class="text-sm flex-grow-1 flex-shrink-0 overflow-hidden">
                                <div class="default_text-color font-bold flex py-1">
                                <p class="text-xl border-b-2 py-0 text-md">{{ calculator.guess_partial_miscellaneous_fees }}</p>
                                <!-- <p class="font-normal">/ month</p> -->
                                </div>
                                <p class="py-1 text-sm">Pay on 13th month</p>
                            </div>
                            <!-- <div>
                                <RoundedButton @click="showBtnDetails('miscfee')">
                                <CollapsibleArrowLogo class="" />
                                </RoundedButton>
                            </div> -->
                            </div>
                        </div>
                        </div>
                    </div>
                <div class="mt-4">
                    <div class="flex gap-2 items-center">
                    <div class="w-32">
                        <p class="font-bold">{{ calculator.guess_balance_payment }}</p>
                        <p class="text-gray-500 text-sm">95% Balance Downpayment</p>
                    </div>
                    <div class="grow w-62">
                        <div class="bg-amber-50 p-3 rounded-lg flex gap-0 items-center overflow-hidden">
                        <div class="text-sm flex-grow-1 flex-shrink-0 overflow-hidden">
                            <div class="default_text-color font-bold flex py-1">
                            <p class="text-xl border-b-2 py-0 text-md">{{ calculator.guess_monthly_amortization }}++</p>
                            <p class="font-normal">/ month</p>
                            </div>
                            <p class="py-1 text-sm">{{ calculator.loan_term }} years monthly <br />starting
                                on the <br />14th month</p>
                        </div>
                        <div>
                            <RoundedButton @click="showBtnDetails('balance')">
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

                                <!-- <div class="w-full h-4 bg-gray-200 rounded-lg relative z-10"> -->
                                    <!-- <div class="absolute -top-3 w-8 h-8 bg-gray-500 rounded-full z-20 left-1/2 transform -translate-x-1/2">
                                    </div> -->
                                <!-- </div> -->
                                 <div>
                                    <SliderRange v-model="form.age" :min="0" :max="60" />
                                 </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex justify-between mb-6">
                                    <div class="text-left">
                                        <p class="default_text-color font-bold">
                                            {{ formatCurrency(form.gross_monthly_income) }}
                                        </p>
                                        <p>Gross Monthly Income</p>
                                    </div>
                                    <div class="">
                                        <div class="flex gap-2">
                                            <button @click="subSliderValue('gross_monthly_income')" class="default_text-color font-bold text-3xl border border-amber-400 p-1 w-12 rounded-full">-</button>
                                            <button @click="addSliderValue('gross_monthly_income')" class="default_text-color font-bold text-3xl border border-amber-400 p-1 w-12 rounded-full">+</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="w-full h-4 bg-gray-200 rounded-lg relative z-10"> -->
                                    <!-- <div class="absolute -top-3 w-8 h-8 bg-gray-500 rounded-full z-20 left-1/2 transform -translate-x-1/2">
                                    </div> -->
                                <!-- </div> -->
                                 <div>
                                    <SliderRange v-model="form.gross_monthly_income" :min="0" :max="200000" />
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
                                            {{ form.loan_term }} years to pay
                                        </p>
                                        <p>Terms</p>
                                    </div>
                                    <div class="">
                                        <div class="flex gap-2">
                                            <button @click="subSliderValue('loan_term')" class="default_text-color font-bold text-3xl border border-amber-400 p-1 w-12 rounded-full">-</button>
                                            <button @click="addSliderValue('loan_term')" class="default_text-color font-bold text-3xl border border-amber-400 p-1 w-12 rounded-full">+</button>
                                        </div>
                                    </div>
                                </div>



                                <!-- <label for="default-range" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Default range</label> -->

                                <div>
                                    <!-- <label for="large-range" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Large range</label> -->
                                   <SliderRange v-model="form.loan_term" :min="1" :max="50" />
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
                            <p class="text-gray-500">{{ calculator.balance_down_payment }}% Balance Downpayment</p>
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

<!-- MyModal -->
 <MyModal
 :modal-show="btnDetails"
@updatemodalShow="updateBtnDetails"
 >
    <template #content_noborder>
        <div
        v-if="detailsContent === 'downpayment'"
        >
            <div class="grid grid-cols-2 gap-2 items-center">
                <div class="">
                    <p class="font-bold">{{ calculator.downpayment }}</p>
                    <p class="text-gray-500">5% Downpayment</p>
                </div>
                <div class="">
                    <div class="bg-amber-50 p-1 rounded-lg ">
                        <div class="default_text-color font-bold flex gap-2">
                            <p class=" text-xl border-b-2 py-1">₱10,417++</p>
                            <p class="font-normal">/ month</p>
                        </div>
                        <p class="py-1">Payable in 12 months</p>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <div class="grid grid-cols-3 gap-3">
                    <div class="col-span-2 text-gray-400">
                        <div>
                            <p>DP Amount</p>
                            <p>DP Percentage</p>
                            <p>Terms</p>
                            <p>Downypayment Monthly Amortization</p>
                            <p>Miscellaneous Fee(Pay on 13th month)</p>
                        </div>
                    </div>
                    <div class="col-span-1 font-bold">
                        <p>{{ calculator.downpayment }}</p>
                        <p>{{ calculator.dpPercentage }}</p>
                        <p>{{ calculator.monthsToPay }}</p>
                        <p class="default_text-color">{{ calculator.monthlyAmort }}</p>
                        <p class="default_text-color">{{ calculator.miscfee }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="detailsContent === 'balance'">
            <div class="grid grid-cols-2 gap-2 items-center">
                <div class="">
                    <p class="font-bold text-xl">{{ calculator.balDP }}</p>
                    <p class="text-gray-500">5% Balance Downpayment</p>
                </div>
                <div class="">
                    <div class="bg-amber-50 p-3 rounded-lg ">
                        <div class="default_text-color font-bold flex gap-2">
                            <p class=" text-2xl border-b-2 py-1">17,144</p>
                            <p class="font-normal">/ month</p>
                        </div>
                        <p class="py-1">Payable in {{ calculator.terms}} months</p>
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
                        <p>{{ calculator.balDP }}</p>
                        <p>{{ calculator.miscfee }}</p>
                        <p>{{ calculator.monthsToPay }}</p>
                        <p class="">{{ calculator.terms }} years</p>
                        <p class="default_text-color">₱17,144</p>
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
