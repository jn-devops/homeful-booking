<script setup>
import HomefulLogo from '@/Logos/HomefulLogo.vue';
import BiometricLogo from '@/Logos/BiometricLogo.vue'
import MyPrimaryButton from '../MyComponents/MyPrimaryButton.vue';
import Timeline from '@/MyComponents/Timeline.vue';
import Agreement from '@/MyComponents/Agreement.vue';
import {ref} from 'vue';
import ConsultingHeaderImg from '@/Logos/ConsultingHeaderImg.vue';
import CircularProgress from '@/MyComponents/CircularProgress.vue';

const chkbox = ref(false);

const myFunc = () =>{
    console.log('click me..')
}
</script>
<template>
    <div class="bg_layout p-0">
        <div class="w-full bg-green-200">
            <ConsultingHeaderImg class="w-full" />
        </div>
        <div class="container mx-auto px-2 py-1">
            <div class="flex flex-row p-5">
                <CircularProgress :currentProgress="1" />
                <div class="ps-5 flex flex-col justify-center">
                    <div class="text-md font-semibold text-[#CC035C]">
                        Step 1:
                    </div>
                    <div class="text-3xl font-extrabold">
                        Register
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-2">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl px-3 py-8">
                    <!-- <Welcome /> -->
                     <!-- <LandingPage /> -->
                      <!-- <Agreement
                      :checkbox="chkbox"
                      
                      >
                        <template #agreement_context>
                            I hereby acknowledge that I have read and understood the
                        </template>
                      </Agreement> -->

                     <!-- <div class="flex">
                        <div class="  grow w-8 flex justify-center py-2">
                            
                            <input type="checkbox" v-model="chkbox">
                        </div>
                        <div class="  grow w-52 text-sm md:text-md">
                            I hereby acknowledge that I have read and understood the <a href="#" class="font-bold">terms and conditions</a>, as well as the <a href="#" class="font-bold">data privacy policy</a>, outlined by Homeful.ph.
                        </div>
                     </div> -->
                     <div class="pt-4 md:w-1/2 md:mx-auto">
                        <a
                        href="/details"
                        >
                            <!-- <MyPrimaryButton 
                            :disabled="!chkbox"
                            :class="{'opacity-50': !chkbox}"
                            class="py-3 rounded-full w-full">
                                I Agree & Continue
                            </MyPrimaryButton> -->
                            <MyPrimaryButton 
                            class="py-3 rounded-full w-full">
                                I Agree & Continue
                            </MyPrimaryButton>
                        </a>
                     </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-2">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl px-3 py-4">
                    <!-- <Welcome /> -->
                     <!-- <LandingPage /> -->
                     <Timeline>
                        <template #success>
                            <p>Register and Verify your Identity</p>
                        </template>
                        <template #pending>
                            <p>Complete Data Form</p>
                        </template>
                        <template #inprogress>
                            <p>Pay Consulting Fee</p>
                        </template>
                    </Timeline>
                    <Timeline>
                        <template #inprogress>
                            <p>Get Qualified</p>
                        </template>
                    </Timeline>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.bg_layout{
    background-size: cover;
    z-index: 1;
}

.custom-checkbox {
  appearance: none;
  width: 1.25rem; /* 20px */
  height: 1.25rem; /* 20px */
  border: 2px solid #ccc;
  border-radius: 0.25rem; /* 4px */
  cursor: pointer;
  display: inline-block;
  vertical-align: middle;
  transition: background-color 0.3s ease;
}

.custom-checkbox:checked {
  border-color: transparent;
}

.bg-rose {
  background-color: #ff007f;
}
</style>