<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import PersonalDetails from '@/MyComponents/PersonalDetails.vue';
import EmploymentDetails from '@/MyComponents/EmploymentDetails.vue';
import ScrollDown from '@/MyComponents/ScrollDown.vue';
// import PaymentDetails from '@/MyComponents/PaymentDetails.vue';

const props = defineProps({
    employmentDetails: Boolean,
    payment: Boolean
});


const arrowDownFunc = (e) =>{
    console.log(e.target);
}
console.log('props', props.employmentDetails);
</script>

<template>
    <div class="block md:hidden container mx-auto p-4 relative h-auto ">
        <!-- <PersonalDetails :class="payment ? 'hidden' : (employmentDetails ? 'hidden' : 'block')" /> -->
         <!-- <div>sample</div> -->
        <PersonalDetails :class="employmentDetails ? 'hidden' : 'block'" />
        <EmploymentDetails :class="employmentDetails ? 'block' : 'hidden'" />
        <!-- <PaymentDetails :class="payment ? 'block' : 'hidden'" /> -->


         <!-- Smooth Scrolldown -->
        <!-- <ScrollDown
        @click="arrowDownFunc"
        >
        <template #btnName>
            Arrow Down
        </template>
        </ScrollDown> -->
    </div>
    <div class="hidden md:block max-w-7xl mx-auto sm:px-6 lg:px-8 py-2">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl p-3">
            <div v-if="$slots.head">
                <slot name="head" />
            </div>
            <div v-if="$slots.btns">
                <slot name="btns" />
            </div>
            <PersonalDetails :class="employmentDetails ? 'hidden' : 'block'" />
            <EmploymentDetails :class="employmentDetails ? 'block' : 'hidden'" />
        </div>
    </div>
</template>

<style>
.text_primary-color{
    color: #CC035C;
}
</style>