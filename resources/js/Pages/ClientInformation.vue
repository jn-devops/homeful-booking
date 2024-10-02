<script setup>
import DetailsHeader from '@/MyComponents/DetailsHeader.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/Choices.vue';
import DatePicker from '@/Components/DatePicker.vue';
import RadioInput from '@/Components/RadioInput.vue';
import { ref, watch,reactive, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import MobileInput from '@/Components/MobileInput.vue';
import vueFilePond, {setOptions} from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import SignaturePad from '@/Components/SignaturePad.vue';
import CenterModal from '@/MyComponents/CenterModal.vue';
import SuccessModal from '@/MyComponents/SuccessModal.vue';
import country from 'country-list-js';

const props = defineProps({
    name_suffixes: Object,
    genders: Object,
    nationalities: Object,
    civil_statuses: Object,
    regions: Object,
    employmement_types: Object,
    employmement_statuses: Object,
    current_positions: Object,
    work_industries: Object,
    countries: Object,
    provinces: Object,
    cities: Object,
    barangays: Object,
    home_ownerships: Object,
    contact: Object,
    fieldsExtracted : Object,
    reference_code: String,
});

const currentStep = ref(0);
const buyer = reactive({
    first_name: '',
    last_name: '',
    middle_name: '',
    noMiddleName: false,
    name_suffix: '',
    civil_status: '',
    gender: '',
    date_of_birth: new Date().toISOString().slice(0, 10),
    nationality: '',
    email: '',
    mobile:'',
    facebook_link:'',
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
    signature: '',
});

const employment = reactive({
    employment_type: '', // All
    employment_status: '', // Locally Employed & OFW
    tenure: '', // Locally Employed & OFW
    current_position: '', // Locally Employed & OFW
    rank: '', // Locally Employed & OFW
    work_industry: '', // All
    gross_monthly_income: '', // All
    tax_identification_no: '', // All
    pagibig_no: '', // All
    sss_gsis_no: '', // All
    employer_details: {
        employer_name: '', // All
        years_of_operation: '',// All //TODO: Change to years established
        contact_person: '', // Locally Employed & OFW
        email: '', // Locally Employed & OFW
        contact_no: '', // Locally Employed & OFW
        country: '', // OFW & Self Employed with Business
        employer_complete_address: '', // For locally employed
        region: '', // OFW
        province: '', // OFW
        city: '', // OFW
        barangay: '', // OFW
    },
    character_reference: {
        name: '',
        mobile: '',
    }
});

const presentAddress = reactive({
    country: '',
    region: '',
    province: '',
    city: '',
    barangay: '',
    zip_code: '',
    home_ownership: '',
    home_ownership_rental_amount: '',
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

const country_list = ref(country.names());
const countries = ref(country_list.value.reduce((acc, country) => {
  acc[country] = country;
  return acc;
}, {}));

// Signature
const isSignaturePadOpen = ref(false);
const toggleSignaturePad = () => {
    isSignaturePadOpen.value = !isSignaturePadOpen.value;
}

const updateSignature = ([signatureVal, signaturePad]) => {
    buyer.signature = signatureVal;
    isSignaturePadOpen.value = signaturePad;
};

const clearSignature = () => {
    buyer.signature = '';
}

const successRefModal = ref(false);

//Attachments
const company_id = ref([]);
const government_id = ref([]);
const bir_certificate = ref([]);

// setOptions({
//     server: {
//         process: '/file-pond/upload',
//         revert: '/file-pond/revert',
//         headers: {
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//         }
//     },
//     maxFileSize: '5MB',
//     acceptedFileTypes: ['image/*', 'application/pdf'],
// });

const companyIdFileUpdate = (fileItems) => {
    company_id.value = fileItems.map(fileItem => fileItem.file);    
}
const governmentIdFileUpdate = (fileItems) => {
    government_id.value = fileItems.map(fileItem => fileItem.file);
}
const birCertificateFileUpdate = (fileItems) => {
    bir_certificate.value = fileItems.map(fileItem => fileItem.file);
}

const errors = ref({});

const formData = new FormData();
const appendFormData = (data, prefix = '') => {
    for (const [key, value] of Object.entries(data)) {
        if (typeof value === 'object' && value !== null) {
            appendFormData(value, `${prefix}${key}.`);
        } else {
            formData.append(`${prefix}${key}`, value);
        }
    }
}


const submit = async () => {
    errors.value = {}; // Reset errors
    
    try {
        appendFormData(buyer);
        appendFormData(employment);
        appendFormData(presentAddress, 'present_address_');
        appendFormData(spousePresentAddress, 'spouse_present_address_');
        
        if (company_id.value.length > 0) {
            formData.append('company_id', company_id.value[0]); 
        }
        if (government_id.value.length > 0) {
            formData.append('government_id', government_id.value[0]); 
        }
        if (bir_certificate.value.length > 0) {
            formData.append('bir_certificate', bir_certificate.value[0]); 
        }
        console.log('Sample', formData);
        router.post(`/client-information/store/${props.reference_code}`, formData, {
            onError: (error) => {
                if (error.response.status === 422) {
                    errors.value = error.response.data.errors;
                }
            }
        });
    } catch (error) {
        console.error("An error occurred during submission:", error);
    }
};

let buttonText = ref('Go to Employment Information');
let showButton = ref(false); 
const setButtonText = (step) => {
    switch (step + 1){
        case 1:
            buttonText = "Go to Employment Information";
            break;
        case 2:
            buttonText = "Go to Attachment";
            break;
        case 3:
            buttonText = "Submit & Proceed to Payment";
            break;
    }
}

const toggleDisplayButton = () =>{
    showButton.value = !showButton.value;
}

const nextStep = () => {
    if (currentStep.value == 2){
        successRefModal.value.openSuccessModal();
    }
    if (currentStep.value < 2) {
        currentStep.value++;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    setButtonText(currentStep.value);
    toggleDisplayButton();
};

const previousStep = () => {
    if (currentStep.value > 0) {
        currentStep.value--;
    }
    setButtonText(currentStep.value);
};

const onSelectChange = (value) => {
    console.log('Selected Value:', value);
    // You can update the buyer object here if needed
    // buyer.value.someField = value;
};

// File Uploader:
const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
);

function handleFilePondInit() {
  console.log("FilePond has initialized");

  // Access FilePond instance methods via `pondRef`
  // Example: pondRef.value.someMethod();
}

const pondRef = ref(null); // Replace `this.$refs.pond`

onMounted(() => {
  if (pondRef.value) {
    handleFilePondInit();
  }
});

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

// Employment Address
const updateEmploymentAddressRegion = (newValue, oldValue) => {
    if (newValue !== oldValue) {
        const filteredProvinces = props.provinces.filter(province => province.region_code === newValue);
        employment.employer_details.provinces = filteredProvinces.reduce((acc, province) => {
            acc[province.province_code] = province.province_description;
            return acc;
        }, {});
        employment.employer_details.region = newValue;
        employment.employer_details.province = '';
        employment.employer_details.city = '';
        employment.employer_details.barangay = '';
        employment.employer_details.cities = ({});
        employment.employer_details.barangays = ({});
    }
};

const updateEmploymentAddressProvince = (newValue, oldValue) => {
    if (newValue !== oldValue) {
        const filteredCities = props.cities.filter(city => city.province_code === newValue);
        employment.employer_details.cities = filteredCities.reduce((acc, city) => {
            acc[city.city_municipality_code] = city.city_municipality_description;
            return acc;
        }, {});
        employment.employer_details.province = newValue;
        employment.employer_details.city = '';
        employment.employer_details.barangay = '';
        employment.employer_details.barangays = ({});
        console.log(filteredCities);
    }
};

const updateEmploymentAddressCity = (newValue, oldValue) => {
    if (newValue !== oldValue) {
        const filteredBarangays = props.barangays.filter(barangay => barangay.city_municipality_code === newValue);
        employment.employer_details.barangays = filteredBarangays.reduce((acc, barangay) => {
            acc[barangay.barangay_code] = barangay.barangay_description;
            return acc;
        }, {});
        employment.employer_details.city = newValue;
        employment.employer_details.barangay = '';
    }
};

</script>

<template>
    <header class="block md:hidden">
        <DetailsHeader :currentStep="currentStep" />
    </header>

    <section class="flex flex-col items-start px-6 w-full text-sm font-semibold text-black mb-32">

        <form id="form" name="form" @submit.prevent="submit" class="h-auto block w-full">
            <!-- Step 1 -->
            <div :class="{
                'hidden': (currentStep + 1) != 1
            }">
                <div class="mt-4 w-full">
                    <h2 class="text-base text-pink-700 uppercase">Personal Details:</h2>
                    <div class="mt-3 w-full">
                        <TextInput
                            id="buyer.first_name"
                            label="First Name"
                            placeholder="Enter First Name"
                            type="text"
                            v-model="buyer.first_name"
                            :errorMessage="errors?.value?.first_name"
                            :required="true"
                        />
                    </div>
                    <div class="mt-3 w-full">
                        <div :class="{'hidden':buyer.hasNoMiddleName}">
                            <TextInput
                                id="buyer.middle_name"
                                label="Middle Name"
                                placeholder="Enter Mdddle Name"
                                type="text"
                                v-model="buyer.middle_name"
                                :errorMessage="errors?.value?.middle_name"
                            />
                        </div>
                        <label for="hasNoMiddleName">
                            <input type="checkbox" id="hasNoMiddleName" v-model="buyer.hasNoMiddleName" value="hasNoMiddleName">
                            I have no middle name
                        </label>
                    </div>
                    <div class="mt-3 w-full">
                        <TextInput
                            id="buyer.last_name"
                            label="Last Name"
                            placeholder="Enter Last Name"
                            type="text"
                            v-model="buyer.last_name"
                            :errorMessage="errors?.value?.last_name"
                            :required="true"
                        />
                    </div>
                    <!-- <div class="mt-3 w-full">
                        <SelectInput
                        id="buyer.name_suffix"
                        :label="'Name Suffix'"
                        :options="props.name_suffixes"
                        v-model="buyer.name_suffix"
                        placeholder=""
                        helperText=""
                        :required="false"
                        :errorMessage="errors?.value?.name_suffix"
                        />
                    </div> -->
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
                        label="Sex"
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
                    <h2 class="text-base text-pink-700 uppercase">Contact Details:</h2>
                    <div class="mt-3 w-full">
                        <TextInput
                            id="buyer.email"
                            label="Email"
                            type="email"
                            v-model="buyer.email"
                            :errorMessage="errors?.value?.email"
                            :required="true"
                        />
                    </div>
                    <div class="mt-4 w-full">
                        <MobileInput
                            id="buyer.mobile"
                            label="Mobile Number"
                            v-model="buyer.mobile"
                            :errorMessage="errors?.value?.mobile"
                            :required="true"
                        />
                    </div>
                    <!-- <div class="mt-3 w-full">
                        <TextInput
                            id="buyer.facebook_link"
                            label="Facebook Link"
                            type="text"
                            v-model="buyer.facebook_link"
                            :errorMessage="errors?.value?.facebook_link"
                            placeholder="Enter your FB Link"
                            :required="false"
                        />
                    </div> -->
                </div>
                <!-- Present Address -->
                <div class="mt-4 w-full">
                    <h2 class="text-base font-normal text-gray-700">Present Address</h2>
                    
                    <div class="mt-3 w-full">
                        <SelectInput
                            id="presentAddress.country"
                            :label="'Country'"
                            :options="countries"
                            v-model="presentAddress.country"
                            placeholder="Select Country"
                            helperText=""
                            :searchable="true"
                            :required="true"
                            :errorMessage="errors?.value?.presentAddress.country"
                        />
                    </div>
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
                    <div :class="{'hidden':presentAddress.home_ownership != '003' }">
                        <div class="mt-3 w-full">
                            <TextInput
                            id="presentAddress.home_ownership_rental_amount"
                            label="Rental Amount"
                            type="number"
                            v-model="presentAddress.home_ownership_rental_amount"
                            placeholder="Enter Amount"
                            :required="false"
                            :errorMessage="errors?.value?.presentAddress.home_ownership_rental_amount"
                            />
                        </div>
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
            </div>
            <!-- Step 2 -->
            <div :class="{
                'hidden': (currentStep + 1) != 2
            }">
                <div class="mt-4 w-full">
                    <!-- Employment -->
                    <h2 class="text-base text-pink-700 uppercase">EMPLOYMENT</h2>
                    <div class="mt-3 w-full">
                        <SelectInput
                            id="employment.employment_type"
                            :label="'Employment Type'"
                            :options="props.employmement_types"
                            v-model="employment.employment_type"
                            placeholder="Select Employment Type"
                            helperText=""
                            :required="true"
                            :errorMessage="errors?.value?.employment_type"
                        />
                        <div :class="{
                            'hidden': employment.employment_type != props.employmement_types['Locally Employed'] && employment.employment_type != props.employmement_types['Overseas Filipino Worker (OFW)']
                        }">
                            <SelectInput
                                id="employment.employment_status"
                                :label="'Employment Status'"
                                :options="props.employmement_statuses"
                                v-model="employment.employment_status"
                                placeholder="Select Employment Status"
                                helperText=""
                                :required="true"
                                :errorMessage="errors?.value?.employment_status"
                            />
                            <TextInput
                                id="employment.tenure"
                                label="Tenure (years)"
                                placeholder="Enter Number of Years"
                                type="number"
                                v-model="employment.tenure"
                                :errorMessage="errors?.value?.tenure"
                                :required="true"
                            />
                            <SelectInput
                                id="employment.current_position"
                                :label="'Current Position'"
                                :options="props.current_positions"
                                v-model="employment.current_position"
                                placeholder="Select Current Position"
                                helperText=""
                                :required="true"
                                :errorMessage="errors?.value?.current_position"
                            />
                            <TextInput
                                id="employment.rank"
                                label="Rank"
                                placeholder="Enter Rank"
                                type="text"
                                v-model="employment.rank"
                                :errorMessage="errors?.value?.rank"
                                :required="true"
                            />
                        </div>
                        <SelectInput
                            id="employment.work_industry"
                            :label="'Work Industry'"
                            :options="props.work_industries"
                            v-model="employment.work_industry"
                            placeholder="Select Work Industry"
                            helperText=""
                            :required="true"
                            :errorMessage="errors?.value?.work_industry"
                        />
                        <TextInput
                            id="employment.gross_monthly_income"
                            label="Gross Monthly Income"
                            prefix="PHP"
                            placeholder="Enter Gross Monthly Income"
                            type="text"
                            v-model="employment.gross_monthly_income"
                            :errorMessage="errors?.value?.gross_monthly_income"
                            :required="true"
                        />
                        <TextInput
                            id="employment.tax_identification_no"
                            label="Tax Identification Number"
                            placeholder="Enter Tax Identification Number"
                            type="text"
                            v-model="employment.tax_identification_no"
                            :errorMessage="errors?.value?.tax_identification_no"
                            :required="true"
                        />
                        <TextInput
                            id="employment.pagibig_no"
                            label="PAG-BIG Number"
                            placeholder="Enter PAG-BIG Number"
                            type="text"
                            v-model="employment.pagibig_no"
                            :errorMessage="errors?.value?.pagibig_no"
                            :required="true"
                        />
                        <TextInput
                            id="employment.sss_gsis_no"
                            label="SSS/GSIS Number"
                            placeholder="Enter SSS/GSIS Number"
                            type="text"
                            v-model="employment.sss_gsis_no"
                            :errorMessage="errors?.value?.sss_gsis_no"
                            :required="true"
                        />
                    </div>
                    <!-- Employer Details -->
                    <h2 class="text-base text-pink-700 uppercase">EMPLOYMENT DETAILS</h2>
                    <div class="mt-3 w-full">
                        <TextInput
                            id="employment.employer_details.employer_name"
                            label="Employer/Business Name"
                            placeholder="Enter Employer/Business Name"
                            type="text"
                            v-model="employment.employer_details.employer_name"
                            :errorMessage="errors?.value?.employer_name"
                            :required="true"
                        />
                        <TextInput
                            id="employment.employer_details.years_of_operation"
                            label="Years of Operation"
                            placeholder="Enter Years of Operation"
                            type="text"
                            v-model="employment.employer_details.years_of_operation"
                            :errorMessage="errors?.value?.years_of_operation"
                            :required="true"
                        />
                        <div :class="{
                            'hidden': employment.employment_type != props.employmement_types['Locally Employed'] && employment.employment_type != props.employmement_types['Overseas Filipino Worker (OFW)']
                        }">
                            <TextInput
                                id="employment.employer_details.contact_person"
                                label="Contact Person"
                                placeholder="Enter Contact Person"
                                type="text"
                                v-model="employment.employer_details.contact_person"
                                :errorMessage="errors?.value?.contact_person"
                                :required="true"
                            />
                            <TextInput
                                id="employment.employer_details.email"
                                label="Email Address"
                                placeholder="Enter Email Address"
                                type="text"
                                v-model="employment.employer_details.email"
                                :errorMessage="errors?.value?.email"
                                :required="true"
                            />
                            <MobileInput
                                id="employment.employer_details.contact_no"
                                label="Enter its Mobile"
                                v-model="employment.employer_details.contact_no"
                                :errorMessage="errors?.value?.contact_no"
                                :required="true"
                            />
                        </div>
                        <div :class="{
                            'hidden': employment.employment_type != props.employmement_types['Self-Employed with Business'] && employment.employment_type != props.employmement_types['Overseas Filipino Worker (OFW)']
                        }">
                            <SelectInput
                                id="employment.country"
                                :label="'Country'"
                                :options="countries"
                                v-model="employment.country"
                                placeholder="Select Country"
                                helperText=""
                                :searchable="true"
                                :required="true"
                                :errorMessage="errors?.value?.country"
                            />
                        </div>
                        <div :class="{
                            'hidden': employment.employment_type != props.employmement_types['Locally Employed'] 
                        }">
                            <div class="mt-3 w-full">
                            <SelectInput
                                id="employment.employer_details.region"
                                label="Region"
                                :options="props.regions"
                                v-model="employment.employer_details.region"
                                placeholder=""
                                helperText=""
                                :required="true"
                                :errorMessage="errors?.value?.employment.employer_details.region"
                                @update:modelValue="updateEmploymentAddressRegion"
                                />
                            </div>
                            <div class="mt-3 w-full">
                                <SelectInput
                                id="employment.employer_details.province"
                                label="Province"
                                :options="employment.employer_details.provinces"
                                v-model="employment.employer_details.province"
                                placeholder="" 
                                helperText=""
                                :required="true"
                                :errorMessage="errors?.value?.employment.employer_details.province"
                                @update:modelValue="updateEmploymentAddressProvince"
                                />
                            </div>
                            <div class="mt-3 w-full">
                                <SelectInput
                                id="employment.employer_details.city"
                                label="City"
                                :options="employment.employer_details.cities"
                                v-model="employment.employer_details.city"
                                placeholder=""
                                helperText=""
                                :required="true"
                                :errorMessage="errors?.value?.employment.employer_details.city"
                                :searchable="true"
                                @update:modelValue="updateEmploymentAddressCity"
                                />
                            </div>
                            <div class="mt-3 w-full">
                                <SelectInput
                                id="employment.employer_details.barangay"
                                label="Barangay"
                                :options="employment.employer_details.barangays"
                                v-model="employment.employer_details.barangay"
                                placeholder=""
                                helperText=""
                                :required="true"
                                :errorMessage="errors?.value?.employment.employer_details.barangay"
                                :searchable="true"
                                />
                            </div>
                        </div>
                        <div :class="{
                            'hidden': employment.employment_type != props.employmement_types['Overseas Filipino Worker (OFW)'] 
                        }">
                            <TextInput
                                id="employment.employer_details.employer_complete_address"
                                label="Employer Complete Address"
                                placeholder="Enter Employer Complete Address"
                                type="text"
                                v-model="employment.employer_details.employer_complete_address"
                                :errorMessage="errors?.value?.employer_complete_address"
                                :required="true"
                            />
                        </div>
                    </div>
                    <h2 class="text-base text-pink-700 uppercase">Character Reference</h2>
                    <div class="mt-3 w-full">
                        <TextInput
                            id="employment.character_reference.name"
                            label="Name"
                            placeholder="Enter Character Reference Name"
                            type="text"
                            v-model="employment.character_reference.name"
                            :errorMessage="errors?.value?.character_reference_name"
                            :required="true"
                        />
                        <MobileInput
                            id="employment.character_reference.mobile"
                            label="Enter its Mobile"
                            v-model="employment.character_reference.mobile"
                            :errorMessage="errors?.value?.character_reference_mobile"
                            :required="true"
                        />
                    </div>
                </div>
            </div>
            <!-- Step 3 -->
            <div :class="{
                'hidden': (currentStep + 1) != 3
            }">
                <h2 class="text-base text-pink-700 uppercase">ATTACHMENTS</h2>
                <!-- Attachments for Locally Employed and OFW -->
                <div class="mt-3 w-full" :class="{
                    'hidden': employment.employment_type != props.employmement_types['Locally Employed'] && employment.employment_type != props.employmement_types['Overseas Filipino Worker (OFW)']
                }">
                    <div class="my-3">
                        <div class="text-sm font-medium mb-2">
                            Company ID <span class="text-red-500"> * </span>
                        </div>
                        <file-pond
                            name="filepond"
                            ref="company_id"
                            label-idle="Drop files here..."
                            v-on:init="handleFilePondInit"
                            @updatefiles="companyIdFileUpdate"
                        />
                    </div>
                    <div class="my-3">
                        <div class="text-sm font-medium mb-2">
                            Government ID <span class="text-red-500"> * </span>
                        </div>
                        <file-pond
                            name="filepond"
                            ref="government_id"
                            label-idle="Drop files here..."
                            v-on:init="handleFilePondInit"
                            @updatefiles="governmentIdFileUpdate"
                        />
                    </div>
                </div>
                <!-- Self-Employed with Business -->
                <div class="mt-3 w-full" :class="{
                    'hidden': employment.employment_type != props.employmement_types['Self-Employed with Business']
                }">
                    <div class="text-sm font-medium mb-2">
                            BIR Certificate <span class="text-red-500"> * </span>
                        </div>
                        <file-pond
                            name="filepond"
                            ref="bir_certificate"
                            label-idle="Drop files here..."
                            v-on:init="handleFilePondInit"
                            @updatefiles="birCertificateFileUpdate"
                        />
                </div>
                <p class="mb-3">Signature <span class="text-red-500">*</span></p>
                <div @click="toggleSignaturePad" :class="['px-20 mx-auto border rounded-xl']">
                    <div :class=" {
                        'hidden': buyer.signature == ''
                    }">
                        <img :src="buyer.signature" alt="Base64 Image" />
                    </div>
                    <div :class="['text-center py-10', {
                        'hidden': buyer.signature != ''
                    }]">
                        Click to add signature
                    </div>
                </div>
                <p class="text-[#B4173A] underline underline-offset-4 mt-1" @click="clearSignature">
                    Clear Signature
                </p>
            </div>
        </form>
    </section>

    <div class="fixed bottom-0 left-0 w-full bg-[#E1ECF8] text-white p-5">
        <div :class="{
                'hidden': showButton
            }">
            <div class="w-full rounded-full bg-white text-black">
                <div class="bg-gradient-to-r from-[#FCB115] to-[#CC035C] rounded-full w-fit h-full py-4 px-6 text-center text-white font-semibold flex item-center">
                    <button @click="toggleDisplayButton" class="cursor-pointer font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5714285714285716" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg>
                    </button>
                </div>
            </div>
        </div>
        <div :class="{
                'hidden': !showButton
            }">
            <div class="w-full flex item-center rounded-full bg-white text-black">
                <button @click="previousStep" class="px-4 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-left text-[#CC035C]">
                        <path d="M6 8L2 12L6 16"/><path d="M2 12H22"/>
                    </svg>
                </button>
                <div @click="nextStep" class="bg-gradient-to-r from-[#FCB115] to-[#CC035C] rounded-full w-full h-full p-4 text-center text-white font-semibold">
                    <button class="cursor-pointer">{{ buttonText }}</button>
                </div>
            </div>
        </div>
    </div>

    <CenterModal :isOpen="isSignaturePadOpen" @update:isOpen="isSignaturePadOpen = $event">
        <div>
            <SignaturePad 
                :signatureVal="buyer.signature" 
                :isSignaturePadOpen="isSignaturePadOpen" 
                @update="updateSignature"  
            />
        </div>
    </CenterModal>

    <SuccessModal ref="successRefModal" :afterFunction="submit">
        Customer Information Form Completed
    </SuccessModal>
</template>
