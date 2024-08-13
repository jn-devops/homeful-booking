<script setup>
import { ref, watch} from 'vue';

const props = defineProps({
    checkbox: Boolean
});

// Create a local reactive variable to handle checkbox state
const isChecked = ref(props.checkbox);

// Watch for changes in props.chkbox and update local isChecked
watch(() => props.checkbox, (newValue) => {
  isChecked.value = newValue;
});

console.log('status:', props.checkbox);
</script>
<template>
    <div class="flex gap-2 p-3 justify-center">
        <div>
            <input type="checkbox" v-model="isChecked">
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