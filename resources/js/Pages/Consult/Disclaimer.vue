<script setup>

import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    agree: true,
});

const submit = () => {
    form.post(route('disclaimer.store'), {
        onFinish: () => {
            form.reset();
        },
    });

};
</script>

<template>
<div>Disclaimer</div>
    <form @submit.prevent="submit">

        <PrimaryButton>Submit</PrimaryButton>
    </form>
</template>

<style scoped>

</style>
