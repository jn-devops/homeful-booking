<script setup>
import { ref } from 'vue';
import MyModal from "@/MyComponents/MyModal.vue";

const props = defineProps({
    modelValue: Boolean,
    agreement: Object,
    agreementType: String,
    shorterModal: Boolean
});

const emit = defineEmits([
    'update:modelValue',
]);

const isPrivacyPolicyShow = ref(false);
const isTermOfUseShow = ref(false);
const isTermOfServicesShow = ref(false);

const updatePrivacyPolicyModal = (newVal) =>{
    isPrivacyPolicyShow.value = newVal;
}
const showModalPrivacyPolicy = () =>{
    isPrivacyPolicyShow.value = !isPrivacyPolicyShow.value;
}

const updateTermOfUseModal = (newVal) =>{
    isTermOfUseShow.value = newVal;
}
const showModalTermOfUseModal = () =>{
    isTermOfUseShow.value = !isTermOfUseShow.value;
}

const updateTermOfServicesModal = () =>{
    isTermOfServicesShow.value = !isTermOfServicesShow.value;
}
const showModalTermOfServicesModal = () =>{
    isTermOfServicesShow.value = !isTermOfServicesShow.value;
}

function handleInput(event) {
    emit('update:modelValue', event.target.checked);
}

</script>
<template>
    <div class="flex gap-2 p-3 justify-center">
        <div>
            <input type="checkbox"
                   :checked="modelValue"
                   class="text-[#CC035C] focus-visible:ring-1 rounded-sm focus:ring-[#FCB115]"
                   @input="handleInput"
            />
        </div>
        <div class="">
            <p>
            <span v-if="$slots.agreement_context">
                <slot name="agreement_context" />
            </span>
            <span v-if="(agreementType == 'TermOfServices')">
                <span class="font-bold" @click="showModalTermOfServicesModal">
                    Term of Services
                </span>
            </span>
            <span v-else-if="(agreementType == 'Other')">
                <span class="font-bold" @click="showModalTermOfServicesModal">
                    Term of Services
                </span>
            </span>
            
            <span v-else>
                <span class="font-bold" @click="showModalPrivacyPolicy">
                        Privacy Policy
                </span>
                and
                <span class="font-bold" @click="showModalTermOfUseModal">
                        Terms of Use.
                </span>
            </span>
            </p>
        </div>
    </div>


    <!-- PRIVACY POLICY  -->
    <MyModal
        :modal-show="isPrivacyPolicyShow"
        @updatemodalShow="updatePrivacyPolicyModal"
    >
        <template #title>
            Privacy Policy
        </template>
        <template #content_noborder>
            <div :class="['h-[700px] overflow-y-scroll', {'h-[483px]': shorterModal}]" v-html="agreement.privacy_policy">
            </div>
        </template>
    </MyModal>

    <!-- TERM OF USE  -->
    <MyModal
        :modal-show="isTermOfUseShow"
        @updatemodalShow="updateTermOfUseModal"
    >
        <template #title>
            Term of Use
        </template>
        <template #content_noborder>
            <div class="h-fit overflow-y-scroll" v-html="agreement.term_of_use">
            </div>
        </template>
    </MyModal>

    <!-- TERM OF SERVICES  -->
    <MyModal
        :modal-show="isTermOfServicesShow"
        @updatemodalShow="updateTermOfServicesModal"
    >
        <template #title>
            Term of Services
        </template>
        <template #content_noborder>
            <div class="h-fit overflow-y-scroll px-6" v-html="agreement.term_of_services">
            </div>
        </template>
    </MyModal>
</template>
