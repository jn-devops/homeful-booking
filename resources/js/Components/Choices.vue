<template>
    <div class="mb-4 w-full">
      <label :for="id" class="block text-sm font-medium mb-2 dark:text-white">
        <span v-if="required" class="text-red-600">*</span>
        {{ label }}
      </label>
      <div class="relative">
        <select
          ref="selectElement"
          :id="id"
          :required="required"
          :disabled="disabled"
          :data-hs-select="computedSelectOptions"
          :value="modelValue"
          @change="onInputChange"
          class="hidden">
          <option value="">{{ placeholder }}</option>
          <option
            v-for="internalOptions in Object.keys(internalOptions).map(key => ({ id: internalOptions[key], name: key }))"
            :key="internalOptions.id"
            :value="internalOptions.id">{{ internalOptions.name }}
          </option>

        </select>
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
import { ref, watch } from 'vue';

export default {
  name: "CustomSelect",
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
    placeholder: {
      type: String,
      default() {
        return ``;
      }
    },
    options: {
      type: Object,
      default: () => ({}),
    },
    required: {
      type: Boolean,
      default: false
    },
    searchable: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      hsSelectInstance: null,
      uniqueKey: 0,
      inputValue: ref(this.modelValue),
      internalOptions: ref(this.options)
    };
  },
  computed: {
    computedSelectOptions() {
      return JSON.stringify({
        "hasSearch": this.searchable,
        "searchPlaceholder": this.placeholder,
        "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
        "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",
        "placeholder": this.placeholder,
        "toggleTag": "<button type=\"button\" aria-expanded=\"false\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-300 dark:text-neutral-200 \" data-title></span></button>",
        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-stone-300 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600",
        "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-stone-300 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
        "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
        "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 dark:text-neutral-200 \" data-title></div></div></div>",
        "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
      });
    }
  },
  watch: {
    options: {
      handler(newOptions,oldOptions) {

        this.internalOptions = newOptions;

        // const checkExist = setInterval(() => {
        //     try {
        //         const escapedId = this.escapeForQuerySelector(this.id);
        //         const selectElement = document.querySelector(`#${escapedId}`);
        //         const select = window.HSSelect.getInstance(selectElement);

        //         if (selectElement && select) {
        //             if (select.selectOptions && select.selectOptions.length > 0) {
        //                 const currentOptions = select.selectOptions.map(option => option.val);
        //                 select.removeOption(currentOptions);
        //             }
        //             const optionsArray = Object.keys(this.internalOptions).map(key => ({
        //                 title: this.internalOptions[key],
        //                 val: key
        //             }));
        //             select.addOption(optionsArray);
        //             clearInterval(checkExist); // Stop checking once the element is found
        //         }
        //     } catch (error) {
        //         console.error(error);
        //         clearInterval(checkExist); // Stop checking if an error occurs
        //     }
        // }, 300); // Check every 300ms
        try {
            const escapedId = this.escapeForQuerySelector(this.id);
            const selectElement = document.querySelector(`#${escapedId}`);
            const select = window.HSSelect.getInstance(selectElement);

            if (selectElement && select) {
                try {
                    if (select.selectOptions && select.selectOptions.length > 0) {
                        try {
                            while (select.selectOptions.length > 0) {
                                const currentOptions = select.selectOptions.map(option => option.val);
                                console.log('currentOptions', currentOptions);
                                select.removeOption(currentOptions);
                            }
                        } catch (removeError) {
                            // console.error("Error removing options, continuing to add new options...", removeError);
                        }
                    }

                    if (newOptions && Object.keys(newOptions).length > 0) {
                        const optionsArray = Object.keys(newOptions).map(key => ({
                            title: newOptions[key],
                            val: key
                        }));

                        let addedSuccessfully = false;
                        while (!addedSuccessfully) {
                            try {
                                select.addOption(optionsArray);

                                // Validate if the new options have been added successfully
                                const currentSelections = select.selectOptions.map(option => option.val);
                                if (currentSelections.length === optionsArray.length && currentSelections.every(val => optionsArray.some(option => option.val === val))) {
                                    addedSuccessfully = true; // Set to true only if validation passes
                                }
                            } catch (e) {
                                // console.error("Error adding options, retrying...", e);
                            }
                        }
                    }
                } catch (error) {
                    // console.error("Error processing options:", error);
                }
            }
        } catch (error) {
            // console.error(error);
        }
      },
      deep: true,
      immediate: true,
    },
    modelValue(newValue) {
      this.inputValue = newValue;
    },
    inputValue(newValue) {
    //   this.$emit('update:modelValue', newValue);
    }
  },
  mounted() {
    // this.initializeSelect();

  },
  methods: {
    escapeForQuerySelector(id) {
      return id.replace(/([#;&,.+*~':"!^$[\]()=>|\/\\])/g, '\\$1');
    },
    initializeSelect() {
    //   this.destroySelect();
    //   this.$nextTick(() => {
    //     const escapedId = this.escapeForQuerySelector(this.id);
    //     const selectElement = document.querySelector(`#${escapedId}`);
    //     if (selectElement) {
    //         this.hsSelectInstance = new HSSelect(selectElement);
    //         console.log(this.hsSelectInstance);
    //         this.hsSelectInstance.on('change', this.onInputChange);
    //         this.hsSelectInstance.refresh();
    //     }
    //   });
    },
    destroySelect() {
      if (this.hsSelectInstance) {
        this.hsSelectInstance.destroy();
        this.hsSelectInstance = null;
      }
    },
    reinitializeSelect() {
      this.uniqueKey += 1;
      this.$nextTick(() => {
        this.initializeSelect();
      });
    },
    onInputChange(event) {
        this.$emit('update:modelValue', event.target.value);
    },

  },
};
</script>

<style scoped>
</style>
