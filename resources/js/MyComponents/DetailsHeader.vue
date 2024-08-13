<script setup>
import {watch} from 'vue';
const props = defineProps({
    employmentDetails: Boolean
});

// watch(props.employmentDetailsPage, (oldVal, NewVal) =>{
//     console.log('oldVal:', oldVal);
//     console.log('NewVal:', NewVal);
// })
console.log('header employmentDetailsPage: ', props.employmentDetails);
</script>
<template>
    <div class="block md:hidden bg-blue-50 pt-10 pb-4 px-4">
        <div class="flex gap-2 justify-around items-center">
            <div 
            v-if="!employmentDetails"
            class="bg-top-right-green w-16 h-16 rounded-full relative flex justify-center items-center">
                <div
                class="bg-white rounded-full w-14 h-14 flex items-center justify-center">
                    1 of 3
                </div>
            </div>
            <div 
                v-if="employmentDetails"
                class="bg-top-left-green w-16 h-16 rounded-full relative flex justify-center items-center">
                <div
                    class="bg-white rounded-full w-14 h-14 flex items-center justify-center">
                    2 of 3
                </div>
            </div>
            <div class="text-right">
               <div v-if="!employmentDetails">
                    <h1 class="font-bold">Personal Information</h1>
                    <p class="text-xs/relaxed">Next Emplyoment Information</p>
               </div>
               <div v-if="employmentDetails">
                    <h1 class="font-bold">Employment Information</h1>
                    <p class="text-xs/relaxed">Next Payment</p>
               </div>
            </div>
        </div>
    </div>
    <div class="hidden md:block bg-gray-50 pt-10 pb-4 px-4">
        <div class="flex justify-between">
            <div class="flex gap-4 items-center">
                <div 
                v-if="!employmentDetails"
                class="bg-top-right-green w-16 h-16 rounded-full relative flex justify-center items-center">
                    <div
                    class="bg-gray-100 rounded-full w-14 h-14 flex items-center justify-center">
                        1 of 3
                    </div>
                </div>
                <div 
                    v-if="employmentDetails"
                    class="bg-top-left-green w-16 h-16 rounded-full relative flex justify-center items-center">
                    <div
                        class="bg-white rounded-full w-14 h-14 flex items-center justify-center">
                        2 of 3
                    </div>
                </div>
                <div class="">
                   <div v-if="!employmentDetails">
                        <h1 class="font-bold">Personal Information</h1>
                        <p class="text-xs/relaxed">Next Emplyoment Information</p>
                   </div>
                   <div v-if="employmentDetails">
                        <h1 class="font-bold">Employment Information</h1>
                        <p class="text-xs/relaxed">Next Payment</p>
                   </div>
                </div>
            </div>
            <div 
            v-if="$slots.btnNavigation"
            class="">
                <slot name="btnNavigation"/>
            </div>
        </div>
    </div>
</template>

<style>
.bg-top-right-green {
    background: linear-gradient(to bottom left, #68D391 30%, transparent 30%);
}
.bg-top-left-green {
    background: linear-gradient(to bottom right, #68D391 50%, transparent 50%);
}
</style>