<script setup>
const props = defineProps({
    sku: String,
    fee: Number
})
</script>

<template>
<div>
    <div>
        {{ sku }}
    </div>
    <div>
        {{ fee }}
    </div>
</div>
</template>

<style scoped>

</style>
