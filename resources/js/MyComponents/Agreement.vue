<script setup>
import {reactive, ref, watch} from 'vue';

const props = defineProps({
    modelValue: Boolean
});


const emit = defineEmits(['update:modelValue']);

// Watch for changes in props.chkbox and update local isChecked
// watch(() => form.checkBox, (newValue) => {
//   isChecked.value = newValue;
//   console.log('status:', props.checkbox);
// });

function handleInput(event) {
    emit('update:modelValue', event.target.checked);
}

// Todo: udate ui when button disable
// const computedClass = computed(() => ({
//     'active-class': props.modelValue,
// }))

</script>
<template>
    <div class="flex gap-2 p-3 justify-center">
        <div>
            <input type="checkbox"
                   :checked="modelValue"
                   @input="handleInput"
            />
        </div>
        <div class="">
            <p>
            <span v-if="$slots.agreement_context">
                <slot name="agreement_context" />
            </span>
                <span class="font-bold">
                    <a
                    href="#"
                    >
                        Privacy Policy
                    </a>
                </span>
                and
                <span class="font-bold">
                    <a
                    href="#"
                    >
                        Terms of Use.
                    </a>
                </span>
            </p>
        </div>
    </div>
</template>
