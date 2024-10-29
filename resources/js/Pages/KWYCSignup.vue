<script setup>
import HomefulBookingLogo from '@/Logos/HomefulBookingLogo.vue';
import MyPrimaryButton from '@/MyComponents/MyPrimaryButton.vue';
import SuccessModal from '@/MyComponents/SuccessModal.vue';
import { ref } from 'vue';

const props = defineProps({
    calculator: Object,
    sku:String,
    code:String,
    contract_id:String,
    reference_code:String,
    mobile:String,
    email:String
});

const phoneNumber = ref('');
const emailAddress = ref('');
const successRefModal = ref(false);

const filterPhoneNum = () => {
    phoneNumber.value = phoneNumber.value.replace(/\D/g, '');
    if (phoneNumber.value.length > 10) {
        phoneNumber.value = phoneNumber.value.slice(0, 10);
    }
};

const createAccount = () => {
    // TODO: call controller to create an account
    successRefModal.value.openSuccessModal();
}

const submit = () => {
    console.log('submit');
    const params = new URLSearchParams({
        calculator: JSON.stringify(props.calculator),
        mobile:phoneNumber.value,
        email:emailAddress.value,
        contract_id:props.contract_id,
        reference_code:props.reference_code
    });
    window.location.href = `/kwyc-verify/${props.contract_id}/${props.reference_code}?${params.toString()}`;

}



</script>

<template>
    <div class="bg-[#F9FBFD] h-screen w-screen">
        <div class="flex flex-col justify-center items-center">
            <div class="w-full md:w-[450px] ">
                <div class="w-5/12 mx-auto mt-40 text-center">
                    <HomefulBookingLogo />
                    <span class="text-xl font-bold">Sign-up</span>
                </div>
                <div class="bg-white mx-2 mt-4 p-5 px-7 flex flex-col justify-center rounded-lg shadow-lg">
                    <form>
                        <div class="mt-5">
                            <label for="phone_number" class="font-semibold text-base">Philippine Mobile Number (10 digits)</label>
                            <div tabindex="0" class="w-full border border-2 rounded-full text-base px-6 flex flex-row items-center my-3 focus-within:ring-2 focus-within:ring-orange-300">
                                <div class="w-14 border-r-2 text-gray-400">+63</div>
                                <input
                                    type="text"
                                    id="phone_number"
                                    class=" w-full px-3 py-2 focus:outline-none"
                                    v-model="phoneNumber"
                                    @input="filterPhoneNum" />
                            </div>
                        </div>
                        <div class="mt-5">
                            <label for="email_address" class="font-semibold text-base">Email Address</label>
                            <div tabindex="0" class="w-full border border-2 rounded-full text-base px-6 flex flex-row items-center my-3 focus-within:ring-2 focus-within:ring-orange-300">
                                <input
                                    type="email"
                                    id="email_address"
                                    class=" w-full px-3 py-2 focus:outline-none"
                                    v-model="emailAddress" />
                            </div>
                        </div>
                    </form>
                    <MyPrimaryButton
                        class="rounded-full p-4 mt-4 w-full text-sm md:text-md"
                        @click="createAccount"
                    >
                    Continue
                    </MyPrimaryButton>
                </div>
            </div>
        </div>

    </div>

    <SuccessModal
        ref="successRefModal"
        :afterFunction="submit"
    >
    Registration Successful</SuccessModal>

</template>
