<template>
    <!-- <div class="bg-red-100 fixed bottom-24 right-2 p-2">Arrow Down</div> -->
    <button
    v-if="$slots.btnName"
    class="bg-red-100 fixed bottom-24 right-2 p-2"
    >
        <slot name="btnName" />
    </button>
</template>