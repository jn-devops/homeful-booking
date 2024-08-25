<template>
    <nav class="fixed top-0 left-0 w-full bg-transparent z-10 ">
        <div class=" h-32 flex justify-between items-center">
            <div class="text-lg font-bold">
                <button class="flex items-center gap-2 px-4 py-2 text-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left text-[#FCB115]">
                        <path d="m12 19-7-7 7-7"/>
                        <path d="M19 12H5"/>
                    </svg>
                    <slot />
                </button>
            </div>
        </div>
    </nav>

</template>
  
<script setup>
</script> 
  