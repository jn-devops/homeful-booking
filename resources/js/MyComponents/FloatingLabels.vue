<template>
    <div class="input-container w-full">
      <div class="input-wrapper">
        <input 
        class="block w-full rounded-full border-0 py-3 pl-5 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 font-bold"
          type="text" 
          v-model="inputValue" 
          @focus="inputFocused = true" 
          @blur="handleBlur"
        />
        <label v-if="$slots.label" :class="{ 'floating-label': inputFocused || inputValue !== '' }">
            <slot name="label"/>
        </label>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const inputFocused = ref(false);
  const inputValue = ref('');
  
  const handleBlur = () => {
    if (inputValue.value === '') {
      inputFocused.value = false;
    }
  };
  </script>
  
  <style>
  .input-container {
    position: relative;
    display: inline-block;
  }
  
  .input-wrapper {
    position: relative;
  }
  
  input {
    width: 200px;
    padding: 8px;
    font-size: 16px;
    position: relative;
    z-index: 1;
  }
  
  label {
    position: absolute;
    top: 30%;
    left: 20px;
    transform: translateY(-10%);
    transition: all 0.2s ease;
    pointer-events: none;
    font-size: 16px;
    color: grey;
    z-index: 2;
  }
  
  .floating-label {
    top: 0;
    font-size: 15px;
    color: blue;
  }
  </style>
  