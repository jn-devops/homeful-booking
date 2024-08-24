<template>
    <div class="mb-4 w-full">
      <label :for="id" class="block text-sm font-medium mb-2 dark:text-white">
          {{ label }}
          <span v-if="required" class="text-red-600">*</span>
      </label>
      <div class="relative">
        <div class="flex">
          <span class="inline-flex items-center px-3 py-3 text-sm text-gray-500 bg-gray-200 border border-r-0 border-stone-300 rounded-l-md dark:bg-neutral-700 dark:text-neutral-400">
            +63
          </span>
          <input
            ref="mobileInput"
            :id="id"
            type="text"
            :required="required"
            :disabled="disabled"
            v-model="formattedValue"
            @input="onInput"
            @keypress="validateInput"
            @paste="validateInput"
            maxlength="10"
            class="py-3 block w-full text-sm border-stone-300 rounded-r-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500"
          />
        </div>
      </div>
      <p v-if="errorMessage" class="mt-2 text-sm text-red-600" :id="`${id}-helper`">
        {{ errorMessage }}
      </p>
      <p v-if="helperText && !errorMessage" class="mt-2 text-sm text-gray-300 dark:text-neutral-400" :id="`${id}-helper`">
        {{ helperText }}
      </p>
    </div>
  </template>

  <script>
  export default {
    name: "MobileNumberInput",
    props: {
      id: {
        type: String,
        required: true
      },
      label: {
        type: String,
        required: true
      },
      modelValue: {
        type: String,
        default: ''
      },
      errorMessage: {
        type: String,
        default: ''
      },
      helperText: {
        type: String,
        default: ''
      },
      required: {
        type: Boolean,
        default: false
      },
      disabled: {
        type: Boolean,
        default: false
      }
    },
    computed: {
        formattedValue() {
        return this.modelValue.slice(3); // Remove the +639 prefix for display
        }
    },
    methods: {
        onInput(event) {
            let value = event.target.value.replace(/\D/g, ''); // Remove non-numeric characters
            if (value.length > 10) {
                value = value.slice(0, 10); // Limit to 10 digits
            }
            this.$emit('update:modelValue', `+63${value}`);
        },
        validateInput(event) {
            var theEvent = event || window.event;

            if (theEvent.type === 'paste') {
                var key = event.clipboardData.getData('text/plain');
            } else {
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }

            var regex = /[0-9]/;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault) theEvent.preventDefault();
            }
        }
    }
  };
  </script>

  <style scoped>
  </style>
