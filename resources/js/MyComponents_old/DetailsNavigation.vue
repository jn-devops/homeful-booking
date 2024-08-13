<template>
    <div class="bg-blue-50 fixed w-full bottom-0 p-4 block md:hidden">
        <slot />
    </div>
    <div class="w-96 p-4 hidden md:block">
        <slot />
    </div>
</template>