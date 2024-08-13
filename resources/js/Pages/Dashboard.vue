<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import LandingPage from '@/MyComponents/LandingPage.vue';
import { ref } from 'vue';

defineProps({
    property_details: Object,
    calculator: Object
})
</script>

<template>
    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- <Welcome /> -->
                     <LandingPage :property-detail="property_details" :calculator="calculator" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
