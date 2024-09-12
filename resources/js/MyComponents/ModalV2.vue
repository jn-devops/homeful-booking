<template>
    <transition name="slide-up">
      <div v-if="isVisible" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-end md:items-center">
        <div class="bg-white w-full max-w-md mx-auto rounded-t-lg overflow-hidden shadow-lg">
          <!-- Modal Header -->
          <div class="bg-gray-900 text-white p-4 flex justify-between items-center">
            <h2 class="text-lg font-semibold">{{ title }}</h2>
            <button @click="close" class="text-white hover:text-gray-400">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
  
          <!-- Modal Body -->
          <div class="p-4 overflow-auto max-h-[calc(100vh-160px)]">
            <slot></slot>
          </div>
  
          <!-- Modal Footer -->
          <div class="bg-gray-100 p-4 flex justify-end">
            <button @click="close" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Close</button>
          </div>
        </div>
      </div>
    </transition>
  </template>
  
  <script setup>
  import { defineProps, defineEmits } from 'vue';
  
  const props = defineProps({
    isVisible: Boolean,
    title: {
      type: String,
      default: 'Modal Title'
    }
  });
  
  const emit = defineEmits(['update:isVisible']);
  
  const close = () => {
    emit('update:isVisible', false);
  };
  </script>
  
  <style>
  /* Fix transition for both opening and closing */
  .slide-up-enter-active, .slide-up-leave-active {
    transition: transform 0.3s ease, opacity 0.3s ease;
  }
  
  .slide-up-enter, .slide-up-leave-to {
    transform: translateY(100%);
    opacity: 0;
  }
  
  .slide-up-enter-to, .slide-up-leave {
    transform: translateY(0);
    opacity: 1;
  }
  </style>
  