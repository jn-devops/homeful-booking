<script setup>
import HomefulBookingLogo from '@/Logos/HomefulBookingLogo.vue';
import MyPrimaryButton from '@/MyComponents/MyPrimaryButton.vue';
import SuccessModal from '@/MyComponents/SuccessModal.vue';
import { ref } from 'vue';

const props = defineProps({
    calculator: Object,
    reference_code: String,
    sku:String,
    code:String,
});

const phoneNumber = ref('');
const phoneNumberErrors = ref([]);
const emailAddress = ref('');
const emailAddressErrors = ref(true);
const params = ref('');
const successRefModal = ref(false);

const filterPhoneNum = () => {
    phoneNumber.value = phoneNumber.value.replace(/\D/g, '');
    if (phoneNumber.value.length > 10) {
        phoneNumber.value = phoneNumber.value.slice(0, 10);
    }
};

const validateEmail = () => {
    emailAddressErrors.value = [];
    if(emailAddress.value == '' || emailAddress.value == null){
        emailAddressErrors.value.push("Email Address is required");
        return false;
    }else if(!/^[^@]+@\w+(\.\w+)+\w$/.test(emailAddress.value)){
        emailAddressErrors.value.push("Invalid Email");
        return false;
    }
    return true;
}
const validatePhoneNum = () => {
    phoneNumberErrors.value = [];
    if(phoneNumber.value == '' || phoneNumber.value == null){
        phoneNumberErrors.value.push("Phone Number is required");
        return false;
    }
    if(phoneNumber.value.length != 10){
        phoneNumberErrors.value.push("Invalid phone number");
        return false;
    }
    return true;
}

const createAccount = () => {
    // Check if valid input
    if(validatePhoneNum() && validateEmail()){
        const kwycData = {
            kwyc_data: {
                phone_number: phoneNumber.value,
                email: emailAddress.value
            },
        };
        const data = Object.assign({}, props.calculator, kwycData);
        // TODO: call controller to create an account
        params.value = new URLSearchParams({
            calculator: JSON.stringify(data),
        });
        console.log(params.value);
        successRefModal.value.openSuccessModal();
    }
}

const submit = () => {
    console.log('submit');
    const params = new URLSearchParams({
        calculator: JSON.stringify(props.calculator),
        mobile:phoneNumber.value,
        email:emailAddress.value
    });
    window.location.href = `/kwyc-verify/${props.sku}/${props.code}?${params.toString()}`;

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
                            <div tabindex="0" class="w-full border border-2 rounded-full text-base px-6 flex flex-row items-center mt-3 focus-within:ring-2 focus-within:ring-orange-300">
                                <div class="w-14 border-r-2 text-gray-400">+63</div>
                                <input
                                    type="text"
                                    id="phone_number"
                                    class=" w-full px-3 py-2 focus:outline-none"
                                    v-model="phoneNumber"
                                    required
                                    @input="filterPhoneNum" />
                            </div>
                            <p v-if="phoneNumberErrors.length > 0" class="text-red-500 italic">
                                {{ phoneNumberErrors[0] }}
                            </p>
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
                            <p v-if="emailAddressErrors.length > 0" class="text-red-500 italic">
                                {{ emailAddressErrors[0] }}
                            </p>
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
