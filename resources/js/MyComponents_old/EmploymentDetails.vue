<script setup>
import InputLabel from '@/Components/InputLabel.vue';

</script>
<template>
    <form>
        <div>
            <h1 class="text_primary-color font-bold text-lg">Employment Details</h1>
        </div>
        <div class="mt-4">
            <div class="mt-3">
                <InputLabel for="employment_type" value="Employment Type" />
                <select id="employment_type" name="employment_type" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                >
                    <option value="Locally Employed">Locally Employed</option>
                    <option value="Internationally Employed">Internationally Employed</option>
                </select>
            </div>
            <div class="mt-3">
                <InputLabel for="employment_status" value="Employment / Businessmen Status" />
                <select id="employment_status" name="employment_status" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                >
                    <option value="Regular">Regular</option>
                    <option value="Contractual">Contractual</option>
                    <option value="Project Base">Project Base</option>
                </select>
            </div>
            <p class="font-bold text-sm mt-2">Employer Contact Details</p>
            <div class="mt-3">
                <InputLabel for="employer_name" value="Employer / Business Name" class="font-bold" />
                <input 
                    id="employer_name"
                    type="text"
                    class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                    >
            </div>
            <div class="mt-3">
                <InputLabel for="work_industry" value="Work Industry" />
                <select id="work_industry" name="work_industry" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                >
                    <option value="Accounting">Accounting</option>
                    <option value="Real Estate">Real Estate</option>
                </select>
            </div>
            <div class="mt-3">
                <InputLabel for="work_industry" value="Work Industry" />
                <select id="work_industry" name="work_industry" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                >
                    <option value="Accounting">Accounting</option>
                    <option value="Real Estate">Real Estate</option>
                </select>
            </div>
            <div class="mt-3">
                <InputLabel for="current_position" value="Current Position" />
                <select id="current_position" name="current_position" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                >
                    <option value="Accounting">Accounting</option>
                    <option value="Real Estate">Real Estate</option>
                </select>
            </div>
            <div class="mt-3">
                <InputLabel for="tenure" value="Tenure" class="font-bold" />
                <input 
                    id="tenure"
                    type="text"
                    class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                    >
            </div>
            <div class="mt-3">
                <InputLabel for="monthly_gross_income" value="Monthly Gross Income" />
                <select id="monthly_gross_income" name="monthly_gross_income" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                >
                    <option value="Accounting">Accounting</option>
                    <option value="Real Estate">Real Estate</option>
                </select>
            </div>
            <div class="mt-3">
                <InputLabel for="employer_contact_person" value="Employer Contact Person" />
                <select id="employer_contact_person" name="employer_contact_person" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                >
                    <option value="Accounting">Accounting</option>
                    <option value="Real Estate">Real Estate</option>
                </select>
            </div>
            <div class="mt-3">
                <InputLabel for="employer_email" value="Employer Email" class="font-bold" />
                <input 
                    id="employer_email"
                    type="text"
                    class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                    >
            </div>
            <div class="mt-3">
                <InputLabel for="employer_email" value="Employer Email" class="font-bold" />
                <input 
                    id="employer_email"
                    type="text"
                    class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                    >
            </div>
            <div class="mt-3">
                <InputLabel for="employer_contact" value="Employer / Business Contact No" class="font-bold" />
                <input 
                    id="employer_contact"
                    type="text"
                    class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                    >
            </div>
            <div class="mt-3">
                <InputLabel for="years_stayed_present_address" value="Years Stayed in Present Address" class="font-bold" />
                <input 
                    id="years_stayed_present_address"
                    type="text"
                    class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                    >
            </div>
            <div class="mt-3">
                <InputLabel for="years_stayed_present_address" value="Years Stayed in Present Address" class="font-bold" />
                <input 
                    id="years_stayed_present_address"
                    type="text"
                    class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                    >
            </div>
            <div class="mt-3">
                <InputLabel for="years_operation" value="Years of Operation" />
                <select id="years_operation" name="years_operation" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                >
                    <option value="1 - 3 years">1 - 3 years</option>
                    <option value="3 - 5 years">3 - 5 years</option>
                </select>
            </div>
            <p class="font-bold text-sm mt-2">Employer Contact Details</p>
            <div>
                <div class="mt-3">
                    <input 
                        id="employer_house_no"
                        type="text"
                        placeholder="House No/Unit Floor/Block Lot"
                        class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                        >
                </div>
                <div class="mt-3">
                    <input 
                        id="employer_building"
                        type="text"
                        placeholder="Building/Street/Barangay"
                        class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                        >
                </div>
                <div class="flex mt-2 gap-2">
                    <div class="grow w-1/2">
                        <input 
                        id="employer_city"
                        type="text"
                        placeholder="City"
                        class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                        >
                    </div>
                    <div class="grow w-1/2">
                        <input 
                        id="employer_state"
                        type="text"
                        placeholder="State/Province"
                        class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                        >
                    </div>
                </div>
                <div class="flex mt-2 gap-2">
                    <div class="grow w-1/2">
                        <input 
                        id="employer_zipcode"
                        type="text"
                        placeholder="Zip Code"
                        class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                        >
                    </div>
                    <div class="grow w-1/2">
                        <select 
                        
                        id="employer_country" name="employer_country" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                        >
                            <option value="Philippines" selected>Philippines</option>
                            <option value="Japan">Japan</option>
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <InputLabel for="tax_identification_no" value="Tax Identification Number" class="font-bold" />
                    <input 
                        id="tax_identification_no"
                        type="text"
                        class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                        >
                </div>
                <div class="mt-3">
                    <InputLabel for="pag_ibig_no" value="Pag-IBIG Number" class="font-bold" />
                    <input 
                        id="pag_ibig_no"
                        type="text"
                        class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                        >
                </div>
                <div class="mt-3">
                    <InputLabel for="sss_gsis_no" value="SSS/GSIS Number" class="font-bold" />
                    <input 
                        id="sss_gsis_no"
                        type="text"
                        class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" 
                        >
                </div>
            </div>
        </div>
    </form>
</template>