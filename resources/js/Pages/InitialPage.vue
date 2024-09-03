<script setup>
import EntryPointImg from '@/Logos/EntryPointImg.vue';
import ReturnToPagev2 from '@/MyComponents/ReturnToPagev2.vue';
import {ref, onMounted} from 'vue';

const props = defineProps({
    homefulBookingUrl: String
});

console.log(props.homefulBookingUrl);

const loading = ref(false);
const lottieJson = ref(null);
const homefulAnimation = ref(null);

onMounted(async () => {
    // setTimeout(() => {
    //     loading.value = false;
    // }, 3000);

//   const response = await fetch('/animation/proceed.json');

//   lottieJson.value = await response.json();
//   homefulAnimation.value = await homefulMainAnimation.json();

});

</script>
<template>
    <div v-if="loading" class="flex items-center justify-center h-screen"> <!-- If -->
        <div class="w-2/6">
            <img :src="homefulBookingUrl" class="shimmer w-full" />
        </div>
    </div>
    <div v-else class="md:w-[415px] md:mx-auto mt-28"> <!-- Else -->
        <ReturnToPagev2 :icon="homefulBookingUrl"> Home Loan Calculation </ReturnToPagev2>
        <div class="flex justify-center">
            <div class="w-64 text-center">
                <EntryPointImg />
            </div>
        </div>
        <div class="text-center py-3">
            <span class="text-[#135DBD] text-2xl font-semibold">Home Loan Calculation</span>
        </div>
    </div>
</template>

<style scoped>
.shimmer {
  color: grey;
  display: inline-block;
  mask: linear-gradient(-60deg, #000 30%, #0005, #000 70%) right/350% 100%;
  animation: shimmer 2.5s infinite;
  font-size: 50px;
  max-width: 200px;
}

@keyframes shimmer {
  100% {
    mask-position: left
  }
}
</style>