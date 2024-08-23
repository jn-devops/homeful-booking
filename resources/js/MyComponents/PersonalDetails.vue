<script setup>
import InputLabel from '@/Components/InputLabel.vue';


</script>
<template>
    <form class="h-auto block md:hidden">
        <div>
            <h1 class="text_primary-color font-bold text-lg">Personal Details</h1>
        </div>
        <div class="mt-4">
            <div class="mt-3">
                <InputLabel for="first_name" value="First Name" class="font-bold" />
                <input
                    id="first_name"
                    type="text"
                    class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
            </div>
            <div class="mt-3">
                <InputLabel for="middle_name" value="Middle Name" class="font-bold" />
                <input
                    id="first_name"
                    type="text"
                    class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
            </div>
            <div class="mt-3 flex gap-2 items-center">
                <input
                    id="middle_name"
                    type="checkbox"
                    class="rounded-full border-0 p-3 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
                <p class="text-sm font-bold">I have no middle name</p>
            </div>
            <div class="mt-3">
                <InputLabel for="last_name" value="Last Name" class="font-bold" />
                <input
                    id="last_name"
                    type="text"
                    class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
            </div>
            <div class="mt-3">
                <InputLabel for="civil_status" value="Civil Status" />
                <select id="civil_status" name="civil_status" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                >
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Widowed">Widowed</option>
                </select>
            </div>
            <div class="mt-3">
                <InputLabel for="sex" value="Sex" />
                <div class="flex gap-2">
                <div class="border py-2 px-4 rounded-full">
                    Male
                </div>
                <div class="border py-2 px-4 rounded-full">
                    Female
                </div>
                </div>
            </div>
            <div class="mt-3">
                <InputLabel for="date_birth" value="Date of Birth" />
                <input
                    id="last_name"
                    type="date"
                    class="mt-2 block w-full rounded-full border-0  text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
            </div>
            <div class="mt-3">
                <InputLabel for="nationality" value="Nationality" />
                <select id="nationality" name="nationality" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                >
                    <option value="Filipino">Filipino</option>
                    <option value="Others">Others</option>
                    <!-- <option value="Widowed">Widowed</option> -->
                </select>
            </div>
        </div>
        <div class="mt-2">
            <h1 class="text_primary-color font-bold text-lg">Contact Details</h1>
        </div>
        <div class="mt-4">
            <div class="mt-3">
                <InputLabel for="email" value="Email" class="font-bold" />
                <input
                    id="email"
                    type="text"
                    class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
            </div>
            <div class="mt-3">
                <InputLabel for="mobile_number" value="Mobile Number" class="font-bold" />
                <input
                    id="mobile_number"
                    type="number"
                    class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
            </div>
            <p class="font-bold text-sm mt-2">Present Address</p>
            <div class="mt-3">
                <InputLabel for="country" value="Country" />
                <select id="country" name="country" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                >
                    <option value="Philippines">Philippines</option>
                    <option value="Others">Others</option>
                    <!-- <option value="Widowed">Widowed</option> -->
                </select>
            </div>
            <div class="mt-3">
                <InputLabel for="province" value="Province" />
                <select id="province" name="province" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                >
                    <option value="Philippines">Philippines</option>
                    <option value="Others">Others</option>
                    <!-- <option value="Widowed">Widowed</option> -->
                </select>
            </div>
            <div class="mt-3">
                <InputLabel for="municipality" value="Municipality" />
                <select id="municipality" name="municipality" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                >
                    <option value="Philippines">Philippines</option>
                    <option value="Others">Others</option>
                    <!-- <option value="Widowed">Widowed</option> -->
                </select>
            </div>
            <div class="mt-3">
                <InputLabel for="barangay" value="Barangay" />
                <select id="barangay" name="barangay" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                >
                    <option value="Philippines">Philippines</option>
                    <option value="Others">Others</option>
                    <!-- <option value="Widowed">Widowed</option> -->
                </select>
            </div>
            <div class="mt-3">
                <InputLabel for="zip_code" value="Zip Code" class="font-bold" />
                <input
                    id="zip_code"
                    type="number"
                    class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
            </div>
            <div class="mt-3">
                <InputLabel for="address" value="Address" class="font-bold" />
                <input
                    id="address"
                    type="text"
                    class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
            </div>
            <div class="mt-3 flex gap-2 items-center">
                <input
                    id="middle_name"
                    type="checkbox"
                    class="rounded-full border-0 p-3 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
                <p class="text-sm font-bold">Permanent Address?</p>
            </div>
            <div class="mt-3">
                <InputLabel for="province1" value="Province" />
                <select id="province1" name="province1" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                >
                    <option value="Philippines">Philippines</option>
                    <option value="Others">Others</option>
                    <!-- <option value="Widowed">Widowed</option> -->
                </select>
            </div>
            <div class="mt-3">
                <InputLabel for="municipality1" value="Municipality" />
                <select id="municipality1" name="municipality1" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                >
                    <option value="Philippines">Philippines</option>
                    <option value="Others">Others</option>
                    <!-- <option value="Widowed">Widowed</option> -->
                </select>
            </div>
            <div class="mt-3">
                <InputLabel for="barangay1" value="Barangay" />
                <select id="barangay1" name="barangay1" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                >
                    <option value="Philippines">Philippines</option>
                    <option value="Others">Others</option>
                    <!-- <option value="Widowed">Widowed</option> -->
                </select>
            </div>
            <div class="mt-3">
                <InputLabel for="home_ownership" value="Home Ownership" />
                <select id="home_ownership" name="home_ownership" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                >
                    <option value="Philippines">Philippines</option>
                    <option value="Others">Others</option>
                    <!-- <option value="Widowed">Widowed</option> -->
                </select>
            </div>
            <div class="mt-3">
                <InputLabel for="stayed" value="Years Stayed in Present Address" class="font-bold" />
                <input
                    id="stayed"
                    type="number"
                    class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
            </div>
            <div class="mt-3 text-transparent">
                <InputLabel for="stayed" value="Years Stayed in Present Address" class="font-bold" />
                <input
                    id="stayed"
                    type="number"
                    class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
            </div>
        </div>
    </form>
    <div class="hidden md:block p-6">
        <!-- <div class="bg-gray-100 flex justify-between">
            <div class="bg-red-100 flex gap-4">
                <div class="py-3">sample</div>
                <div class="py-3">sample2</div>
            </div>
            <div class="bg-green-100 h-auto py-3">sample3</div>
        </div> -->
        <div class="grid grid-cols-3 gap-6">
            <div class="mt-4">
                <div>
                    <h1 class="text_primary-color font-bold text-lg">Personal Details</h1>
                </div>
                <div class="mt-3">
                    <InputLabel for="first_name" value="First Name" class="font-bold" />
                    <input
                        id="first_name"
                        type="text"
                        class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                </div>
                <div class="mt-3">
                    <InputLabel for="middle_name" value="Middle Name" class="font-bold" />
                    <input
                        id="first_name"
                        type="text"
                        class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                </div>
                <div class="mt-3 flex gap-2 items-center">
                    <input
                        id="middle_name"
                        type="checkbox"
                        class="rounded-full border-0 p-3 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                    <p class="text-sm font-bold">I have no middle name</p>
                </div>
                <div class="mt-3">
                    <InputLabel for="last_name" value="Last Name" class="font-bold" />
                    <input
                        id="last_name"
                        type="text"
                        class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                </div>
                <div class="mt-3">
                    <InputLabel for="civil_status" value="Civil Status" />
                    <select id="civil_status" name="civil_status" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                </div>
                <div class="mt-3">
                    <InputLabel for="sex" value="Sex" />
                    <div class="flex gap-2">
                    <div class="border py-2 px-4 rounded-full">
                        Male
                    </div>
                    <div class="border py-2 px-4 rounded-full">
                        Female
                    </div>
                    </div>
                </div>
                <div class="mt-3">
                    <InputLabel for="date_birth" value="Date of Birth" />
                    <input
                        id="last_name"
                        type="date"
                        class="mt-2 block w-full rounded-full border-0  text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                </div>
                <div class="mt-3">
                    <InputLabel for="nationality" value="Nationality" />
                    <select id="nationality" name="nationality" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
                        <option value="Filipino">Filipino</option>
                        <option value="Others">Others</option>
                        <!-- <option value="Widowed">Widowed</option> -->
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <div class="mt-2">
                    <h1 class="text_primary-color font-bold text-lg">Contact Details</h1>
                </div>
                <div class="mt-3">
                    <InputLabel for="email" value="Email" class="font-bold" />
                    <input
                        id="email"
                        type="text"
                        class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                </div>
                <div class="mt-3">
                    <InputLabel for="mobile_number" value="Mobile Number" class="font-bold" />
                    <input
                        id="mobile_number"
                        type="number"
                        class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                </div>
                <p class="font-bold text-sm mt-2">Present Address</p>
                <div class="mt-3">
                    <InputLabel for="country" value="Country" />
                    <select id="country" name="country" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
                        <option value="Philippines">Philippines</option>
                        <option value="Others">Others</option>
                        <!-- <option value="Widowed">Widowed</option> -->
                    </select>
                </div>
                <div class="mt-3">
                    <InputLabel for="province" value="Province" />
                    <select id="province" name="province" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
                        <option value="Philippines">Philippines</option>
                        <option value="Others">Others</option>
                        <!-- <option value="Widowed">Widowed</option> -->
                    </select>
                </div>
                <div class="mt-3">
                    <InputLabel for="municipality" value="Municipality" />
                    <select id="municipality" name="municipality" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
                        <option value="Philippines">Philippines</option>
                        <option value="Others">Others</option>
                        <!-- <option value="Widowed">Widowed</option> -->
                    </select>
                </div>
                <div class="mt-3">
                    <InputLabel for="barangay" value="Barangay" />
                    <select id="barangay" name="barangay" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
                        <option value="Philippines">Philippines</option>
                        <option value="Others">Others</option>
                        <!-- <option value="Widowed">Widowed</option> -->
                    </select>
                </div>
                <div class="mt-3">
                    <InputLabel for="zip_code" value="Zip Code" class="font-bold" />
                    <input
                        id="zip_code"
                        type="number"
                        class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                </div>
            </div>
            <div class="mt-4">
                <div class="mt-3">
                    <InputLabel for="address" value="Address" class="font-bold" />
                    <input
                        id="address"
                        type="text"
                        class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                </div>
                <div class="mt-3 flex gap-2 items-center">
                    <input
                        id="middle_name"
                        type="checkbox"
                        class="rounded-full border-0 p-3 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                    <p class="text-sm font-bold">Permanent Address?</p>
                </div>
                <div class="mt-3">
                    <InputLabel for="province1" value="Province" />
                    <select id="province1" name="province1" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
                        <option value="Philippines">Philippines</option>
                        <option value="Others">Others</option>
                        <!-- <option value="Widowed">Widowed</option> -->
                    </select>
                </div>
                <div class="mt-3">
                    <InputLabel for="municipality1" value="Municipality" />
                    <select id="municipality1" name="municipality1" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
                        <option value="Philippines">Philippines</option>
                        <option value="Others">Others</option>
                        <!-- <option value="Widowed">Widowed</option> -->
                    </select>
                </div>
                <div class="mt-3">
                    <InputLabel for="barangay1" value="Barangay" />
                    <select id="barangay1" name="barangay1" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
                        <option value="Philippines">Philippines</option>
                        <option value="Others">Others</option>
                        <!-- <option value="Widowed">Widowed</option> -->
                    </select>
                </div>
                <div class="mt-3">
                    <InputLabel for="home_ownership" value="Home Ownership" />
                    <select id="home_ownership" name="home_ownership" class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    >
                        <option value="Philippines">Philippines</option>
                        <option value="Others">Others</option>
                        <!-- <option value="Widowed">Widowed</option> -->
                    </select>
                </div>
                <div class="mt-3">
                    <InputLabel for="stayed" value="Years Stayed in Present Address" class="font-bold" />
                    <input
                        id="stayed"
                        type="number"
                        class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                </div>
                <div class="mt-3 text-transparent">
                    <InputLabel for="stayed" value="Years Stayed in Present Address" class="font-bold" />
                    <input
                        id="stayed"
                        type="number"
                        class="mt-2 block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                </div>
            </div>
        </div>
    </div>
</template>
