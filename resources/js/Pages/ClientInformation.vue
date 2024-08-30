<script setup>
import DetailsHeader from '@/MyComponents/DetailsHeader.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/Choices.vue';
import DatePicker from '@/Components/DatePicker.vue';
import RadioInput from '@/Components/RadioInput.vue';
import { ref, watch,reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import MobileInput from '@/Components/MobileInput.vue';

const props = defineProps({
    name_suffixes: Object,
    genders: Object,
    nationalities: Object,
    civil_statuses: Object,
    regions: Object,
    provinces: Object,
    cities: Object,
    barangays: Object,
    home_ownerships: Object,
});

const currentStep = ref(0);
const buyer = reactive({
    first_name: '',
    last_name: '',
    middle_name: '',
    name_suffix: '',
    civil_status: '',
    gender: '',
    date_of_birth: new Date().toISOString().slice(0, 10),
    nationality: '',
    email: '',
    mobile:'',
    spouse:{
        first_name: '',
        last_name: '',
        middle_name: '',
        name_suffix: '',
        gender: '',
        date_of_birth: new Date().toISOString().slice(0, 10),
        nationality: '',
        email: '',
        mobile:'',
        address_same_as_buyer:'No'
    },
});


const presentAddress = reactive({
    region: '',
    province: '',
    city: '',
    barangay: '',
    zip_code: '',
    home_ownership: '',
    years_at_present_address: '',
    address: '',
    same_as_permanent_address: 'No',
    provinces:({}),
    cities:({}),
    barangays:({}),
});

const spousePresentAddress = reactive({
    region: '',
    province: '',
    city: '',
    barangay: '',
    zip_code: '',
    home_ownership: '',
    years_at_present_address: '',
    address: '',
    same_as_permanent_address: 'No',
    provinces:({}),
    cities:({}),
    barangays:({}),
});



const errors = ref({});



const submit = async () => {
    errors.value = {}; // Reset errors
    try {
        router.post('/client-information/store', buyer.value);
    } catch (error) {
        if (error.response.status === 422) {
            errors.value = error.response.data.errors;
        }
    }
};

const nextStep = () => {
    if (currentStep.value < 2) {
        currentStep.value++;
    }
};

const previousStep = () => {
    if (currentStep.value > 0) {
        currentStep.value--;
    }
};

const onSelectChange = (value) => {
    console.log('Selected Value:', value);
    // You can update the buyer object here if needed
    // buyer.value.someField = value;
};

watch(
  () => buyer.civil_status,
  (value) => {
    console.log(`Civil Status is: ${value}`)

  }
)


const updatePresentAddressRegion = (newValue, oldValue) => {
    if (newValue !== oldValue) {
        const filteredProvinces = props.provinces.filter(province => province.region_code === newValue);
        presentAddress.provinces = filteredProvinces.reduce((acc, province) => {
            acc[province.province_code] = province.province_description;
            return acc;
        }, {});
        presentAddress.region = newValue;
        presentAddress.province = '';
        presentAddress.city = '';
        presentAddress.barangay = '';
        presentAddress.cities = ({});
        presentAddress.barangays = ({});
    }
};

const updatePresentAddressProvince = (newValue, oldValue) => {
    if (newValue !== oldValue) {
        const filteredCities = props.cities.filter(city => city.province_code === newValue);
        presentAddress.cities = filteredCities.reduce((acc, city) => {
            acc[city.city_municipality_code] = city.city_municipality_description;
            return acc;
        }, {});
        presentAddress.province = newValue;
        presentAddress.city = '';
        presentAddress.barangay = '';
        presentAddress.barangays = ({});
        console.log(filteredCities);
    }
};

const updatePresentAddressCity = (newValue, oldValue) => {
    if (newValue !== oldValue) {
        const filteredBarangays = props.barangays.filter(barangay => barangay.city_municipality_code === newValue);
        presentAddress.barangays = filteredBarangays.reduce((acc, barangay) => {
            acc[barangay.barangay_code] = barangay.barangay_description;
            return acc;
        }, {});
        presentAddress.city = newValue;
        presentAddress.barangay = '';
    }
};

// Spouse Address
const updateSpousePresentAddressRegion = (newValue, oldValue) => {
    if (newValue !== oldValue) {
        const filteredProvinces = props.provinces.filter(province => province.region_code === newValue);
        spousePresentAddress.provinces = filteredProvinces.reduce((acc, province) => {
            acc[province.province_code] = province.province_description;
            return acc;
        }, {});
        spousePresentAddress.region = newValue;
        spousePresentAddress.province = '';
        spousePresentAddress.city = '';
        spousePresentAddress.barangay = '';
        spousePresentAddress.cities = ({});
        spousePresentAddress.barangays = ({});
    }
};

const updateSpousePresentAddressProvince = (newValue, oldValue) => {
    if (newValue !== oldValue) {
        const filteredCities = props.cities.filter(city => city.province_code === newValue);
        spousePresentAddress.cities = filteredCities.reduce((acc, city) => {
            acc[city.city_municipality_code] = city.city_municipality_description;
            return acc;
        }, {});
        spousePresentAddress.province = newValue;
        spousePresentAddress.city = '';
        spousePresentAddress.barangay = '';
        spousePresentAddress.barangays = ({});
    }
};

const updateSpousePresentAddressCity = (newValue, oldValue) => {
    if (newValue !== oldValue) {
        const filteredBarangays = props.barangays.filter(barangay => barangay.city_municipality_code === newValue);
        spousePresentAddress.barangays = filteredBarangays.reduce((acc, barangay) => {
            acc[barangay.barangay_code] = barangay.barangay_description;
            return acc;
        }, {});
        spousePresentAddress.city = newValue;
        spousePresentAddress.barangay = '';
    }
};

</script>

<template>
    <header class="block md:hidden">
        <DetailsHeader :currentStep="currentStep" />
    </header>

    <section class="flex flex-col items-start px-6 w-full text-sm font-semibold text-black">

        <form id="form" name="form" @submit.prevent="submit" class="h-auto block w-full">
            <div class="mt-4 w-full">
                <h2 class="text-base text-pink-700 uppercase">Personal Details:</h2>
                <div class="mt-3 w-full">
                    <TextInput
                        id="buyer.first_name"
                        label="First Name"
                        type="text"
                        v-model="buyer.first_name"
                        :errorMessage="errors?.value?.first_name"
                        :required="true"
                    />
                </div>
                <div class="mt-3 w-full">
                    <TextInput
                        id="buyer.middle_name"
                        label="Middle Name"
                        type="text"
                        v-model="buyer.middle_name"
                        :errorMessage="errors?.value?.middle_name"
                    />
                </div>
                <div class="mt-3 w-full">
                    <TextInput
                        id="buyer.last_name"
                        label="Last Name"
                        type="text"
                        v-model="buyer.last_name"
                        :errorMessage="errors?.value?.last_name"
                        :required="true"
                    />
                </div>
                <div class="mt-3 w-full">
                    <SelectInput
                    id="buyer.name_suffix"
                    :label="'Name Suffix'"
                    :options="props.name_suffixes"
                    v-model="buyer.name_suffix"
                    placeholder=""
                    helperText=""
                    :required="true"
                    :errorMessage="errors?.value?.name_suffix"
                    />
                </div>
                <div class="mt-3 w-full">
                    <SelectInput
                    id="buyer.civil_status"
                    label="Civil Status"
                    :options="props.civil_statuses"
                    v-model="buyer.civil_status"
                    placeholder=""
                    helperText=""
                    :required="true"
                    :errorMessage="errors?.value?.civil_status"
                    />
                </div>
                <div class="mt-3 w-full">
                    <SelectInput
                    id="buyer.gender"
                    label="Gender"
                    :options="props.genders"
                    v-model="buyer.gender"
                    placeholder=""
                    helperText=""
                    :required="true"
                    :errorMessage="errors?.value?.name_suffix"
                    />
                </div>
                <div class="mt-3 w-full">
                    <DatePicker
                    id="buyer.date_of_birth"
                    label="Date of Birth"
                    v-model="buyer.date_of_birth"
                    format="yyyy-MM-dd"
                    :errorMessage="errors?.value?.date_of_birth"
                    :required="true"
                    />
                </div>
                <div class="mt-3 w-full">
                    <SelectInput
                    id="buyer.nationality"
                    label="Nationality"
                    :options="props.nationalities"
                    v-model="buyer.nationality"
                    placeholder=""
                    helperText=""
                    :required="true"
                    :errorMessage="errors?.value?.name_suffix"
                    :searchable="true"
                    />
                </div>
            </div>
            <div class="mt-4 w-full">
                <h2 class="text-base text-pink-700 uppercase">Contact Information</h2>
                <div class="mt-3 w-full">
                    <TextInput
                        id="buyer.email"
                        label="E-Mail"
                        type="email"
                        v-model="buyer.email"
                        :errorMessage="errors?.value?.email"
                        :required="true"
                    />
                </div>
                <div class="mt-4 w-full">
                    <MobileInput
                        id="buyer.mobile"
                        label="Mobile"
                        v-model="buyer.mobile"
                        :errorMessage="errors?.value?.mobile"
                        :required="true"
                    />
                </div>
            </div>
            <!-- Present Address -->
            <div class="mt-4 w-full">
                <h2 class="text-base text-pink-700 uppercase">PRESENT ADDRESS</h2>
                <div class="mt-3 w-full">
                    <SelectInput
                    id="presentAddress.region"
                    label="Region"
                    :options="props.regions"
                    v-model="presentAddress.region"
                    placeholder=""
                    helperText=""
                    :required="true"
                    :errorMessage="errors?.value?.presentAddress.region"
                    @update:modelValue="updatePresentAddressRegion"
                    />
                </div>
                <div class="mt-3 w-full">
                    <SelectInput
                    id="presentAddress.province"
                    label="Province"
                    :options="presentAddress.provinces"
                    v-model="presentAddress.province"
                    placeholder=""
                    helperText=""
                    :required="true"
                    :errorMessage="errors?.value?.presentAddress.province"
                    @update:modelValue="updatePresentAddressProvince"
                    />
                </div>
                <div class="mt-3 w-full">
                    <SelectInput
                    id="presentAddress.city"
                    label="City"
                    :options="presentAddress.cities"
                    v-model="presentAddress.city"
                    placeholder=""
                    helperText=""
                    :required="true"
                    :errorMessage="errors?.value?.presentAddress.city"
                    :searchable="true"
                    @update:modelValue="updatePresentAddressCity"
                    />
                </div>
                <div class="mt-3 w-full">
                    <SelectInput
                    id="presentAddress.barangay"
                    label="Barangay"
                    :options="presentAddress.barangays"
                    v-model="presentAddress.barangay"
                    placeholder=""
                    helperText=""
                    :required="true"
                    :errorMessage="errors?.value?.presentAddress.barangay"
                    :searchable="true"
                    />
                </div>
                <div class="mt-3 w-full">
                    <TextInput
                        id="presentAddress.zip_code"
                        label="Zip Code"
                        type="text"
                        v-model="presentAddress.zip_code"
                        :errorMessage="errors?.value?.presentAddress.zip_code"
                        :required="true"
                    />
                </div>
                <div class="mt-3 w-full">
                    <SelectInput
                    id="presentAddress.home_ownership"
                    label="Home Ownership"
                    :options="props.home_ownerships"
                    v-model="presentAddress.home_ownership"
                    placeholder=""
                    helperText=""
                    :required="true"
                    :errorMessage="errors?.value?.presentAddress.home_ownership"
                    />
                </div>
                <div class="mt-3 w-full">
                    <TextInput
                        id="presentAddress.years_at_present_address"
                        label="Years at Present Address"
                        type="number"
                        v-model="presentAddress.years_at_present_address"
                        :errorMessage="errors?.value?.presentAddress.years_at_present_address"
                        :required="true"
                    />
                </div>
                <div class="mt-3 w-full">
                    <TextInput
                        id="presentAddress.address"
                        label="Address"
                        type="text"
                        v-model="presentAddress.address"
                        :errorMessage="errors?.value?.presentAddress.address"
                        :required="true"
                        placeholder="Unit Number, House Number/Building/Street No. Street Name"
                    />
                </div>
                <div class="mt-3 w-full">
                    <RadioInput
                    id="presentAddress.same_as_permanent_address"
                    label="Same as Permanent Address"
                    name="presentAddress.same_as_permanent_address"
                    v-model="presentAddress.same_as_permanent_address"
                    :options="[
                    { label: 'Yes', value: 'Yes' },
                    { label: 'No', value: 'No' }
                    ]"
                    :required="true"
                    />
                </div>
            </div>
            <!-- Spouse Details -->
            <div class="mt-4 w-full" :class="{
                    'hidden': buyer.civil_status!= props.civil_statuses['Married'],
                }">
                <h2 class="text-base text-pink-700 uppercase">SPOUSE PERSONAL DETAILS:</h2>
                <div class="mt-3 w-full">
                    <TextInput
                        id="buyer.spouse.first_name"
                        label="First Name"
                        type="text"
                        v-model="buyer.spouse.first_name"
                        :errorMessage="errors?.value?.spouse.first_name"
                        :required="true"
                    />
                </div>
                <div class="mt-3 w-full">
                    <TextInput id="buyer.spouse.middle_name" label="Middle Name" type="text" v-model="buyer.spouse.middle_name" />
                </div>
                <div class="mt-3 w-full">
                    <TextInput
                        id="buyer.spouse.last_name"
                        label="Last Name"
                        type="text"
                        v-model="buyer.spouse.last_name"
                        :errorMessage="errors?.value?.spouse.last_name"
                        :required="true"
                    />
                </div>
                <div class="mt-3 w-full">
                    <SelectInput
                    id="buyer.spouse.name_suffix"
                    :label="'Name Suffix'"
                    :options="props.name_suffixes"
                    v-model="buyer.spouse.name_suffix"
                    placeholder=""
                    helperText=""
                    :required="true"
                    :errorMessage="errors?.value?.spouse.name_suffix"
                    />
                </div>
               <div class="mt-3 w-full">
                    <SelectInput
                    id="buyer.spouse.gender"
                    label="Gender"
                    :options="props.genders"
                    v-model="buyer.spouse.gender"
                    placeholder=""
                    helperText=""
                    :required="true"
                    :errorMessage="errors?.value?.spouse.gender"
                    />
               </div>
                <div class="mt-3 w-full">
                    <DatePicker
                    id="buyer.spouse.date_of_birth"
                    label="Date of Birth"
                    v-model="buyer.spouse.date_of_birth"
                    format="yyyy-MM-dd"
                    :errorMessage="errors?.value?.spouse.date_of_birth"
                    :required="true"
                    />
                </div>
                <div class="mt-3 w-full">
                    <SelectInput
                    id="buyer.spouse.nationality"
                    label="Nationality"
                    :options="props.nationalities"
                    v-model="buyer.spouse.nationality"
                    placeholder=""
                    helperText=""
                    :required="true"
                    :errorMessage="errors?.value?.spouse.nationality">
                    </SelectInput>
                </div>
            </div>
            <!-- Spouse Contact Information -->
            <div  class="mt-4 w-full" :class="{
                    'hidden': buyer.civil_status!= props.civil_statuses['Married'],
                }">
                <h2 class="text-base text-pink-700 uppercase">SPOUSE CONATCT INFORMATION:</h2>
                <div class="mt-3 w-full">
                    <TextInput id="buyer.spouse.email" label="E-Mail" type="email" v-model="buyer.spouse.email" :errorMessage="errors?.value?.spouse.email" :required="true" />
                </div>
                <div class="mt-3 w-full">
                    <MobileInput id="buyer.spouse.mobile" label="Mobile" v-model="buyer.spouse.mobile" :errorMessage="errors?.value?.spouse.mobile" :required="true" />
                </div>
            </div>
            <!-- Spouse Present Address -->
             <div class="mt-4 w-full" :class="{
                    'hidden': buyer.civil_status!= props.civil_statuses['Married'],
                }">
                <h2 class="text-base text-pink-700 uppercase">SPOUSE PRESENT ADDRESS</h2>
                <div class="mt-3 w-full">
                    <div :class="{
                        'hidden': spousePresentAddress.same_as_permanent_address == 'Yes'
                    }">
                        
                        <div class="mt-3 w-full">
                            <SelectInput
                            id="spousePresentAddress.region"
                            label="Region"
                            :options="props.regions"
                            v-model="spousePresentAddress.region"
                            placeholder=""
                            helperText=""
                            :required="true"
                            :errorMessage="errors?.value?.spousePresentAddress.region"
                            @update:modelValue="updateSpousePresentAddressRegion"
                            />
                        </div>
                        <div class="mt-3 w-full">
                            <SelectInput
                            id="spousePresentAddress.province"
                            label="Province"
                            :options="spousePresentAddress.provinces"
                            v-model="spousePresentAddress.province"
                            placeholder=""
                            helperText=""
                            :required="true"
                            :errorMessage="errors?.value?.spousePresentAddress.province"
                            @update:modelValue="updateSpousePresentAddressProvince"
                            />
                        </div>
                        <div class="mt-3 w-full">
                            <SelectInput
                            id="spousePresentAddress.city"
                            label="City"
                            :options="spousePresentAddress.cities"
                            v-model="spousePresentAddress.city"
                            placeholder=""
                            helperText=""
                            :required="true"
                            :errorMessage="errors?.value?.spousePresentAddress.city"
                            :searchable="true"
                            @update:modelValue="updateSpousePresentAddressCity"
                            />
                        </div>
                        <div class="mt-3 w-full">
                            <SelectInput
                            id="spousePresentAddress.barangay"
                            label="Barangay"
                            :options="spousePresentAddress.barangays"
                            v-model="spousePresentAddress.barangay"
                            placeholder=""
                            helperText=""
                            :required="true"
                            :errorMessage="errors?.value?.spousePresentAddress.barangay"
                            :searchable="true"
                            />
                        </div>
                        <div class="mt-3 w-full">
                            <TextInput
                                id="spousePresentAddress.zip_code"
                                label="Zip Code"
                                type="text"
                                v-model="spousePresentAddress.zip_code"
                                :errorMessage="errors?.value?.spousePresentAddress.zip_code"
                                :required="true"
                            />
                        </div>
                        <div class="mt-3 w-full">
                            <SelectInput
                            id="spousePresentAddress.home_ownership"
                            label="Home Ownership"
                            :options="props.home_ownerships"
                            v-model="spousePresentAddress.home_ownership"
                            placeholder=""
                            helperText=""
                            :required="true"
                            :errorMessage="errors?.value?.spousePresentAddress.home_ownership"
                            />
                        </div>
                        <div class="mt-3 w-full">
                            <TextInput
                                id="spousePresentAddress.years_at_present_address"
                                label="Years at Present Address"
                                type="number"
                                v-model="spousePresentAddress.years_at_present_address"
                                :errorMessage="errors?.value?.spousePresentAddress.years_at_present_address"
                                :required="true"
                            />
                        </div>
                        <div class="mt-3 w-full">
                            <TextInput
                                id="spousePresentAddress.address"
                                label="Address"
                                type="text"
                                v-model="spousePresentAddress.address"
                                :errorMessage="errors?.value?.spousePresentAddress.address"
                                :required="true"
                                placeholder="Unit Number, House Number/Building/Street No. Street Name"
                            />
                        </div>

                    </div>
                    {{ spousePresentAddress.same_as_permanent_address }}
                    <RadioInput
                    id="spousePresentAddress.same_as_permanent_address"
                    label="Same as Permanent Address"
                    name="spousePresentAddress.same_as_permanent_address"
                    v-model="spousePresentAddress.same_as_permanent_address"
                    :options="[
                    { label: 'Yes', value: 'Yes' },
                    { label: 'No', value: 'No' }
                    ]"
                    :required="true"
                    />
                </div>
             </div>
            <button type="submit">Submit</button>
        </form>
    </section>

    <button @click="previousStep">Previous</button>
    <button @click="nextStep">Next</button>
</template>
