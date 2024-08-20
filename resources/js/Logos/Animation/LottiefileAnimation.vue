<template>
    <div ref="lottieContainer" v-bind="$attrs" class="lottie-animation"></div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { useAttrs } from 'vue';
  import lottie from 'lottie-web';
  import { colorify } from 'lottie-colorify';
  
  const props = defineProps({
    animationData: {
      type: Object,
      required: true,
    },
    loop: {
      type: Boolean,
      default: true,
    },
    autoplay: {
      type: Boolean,
      default: true,
    },
  });
  
  const attrs = useAttrs();
  const lottieContainer = ref(null);
  
  onMounted(() => {
    lottie.loadAnimation({
      container: lottieContainer.value,
      renderer: 'svg',
      loop: props.loop,
      autoplay: props.autoplay,
      animationData: colorify(['#FFFFFF', [255, 255, 255], '#FFFFFF'], props.animationData),
    });
  });
  </script>
  
  <style scoped>
  .lottie-animation {
    width: 100%;
    height: 100%;
  }
  </style>
  