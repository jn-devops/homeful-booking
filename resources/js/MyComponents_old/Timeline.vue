<template>
    <div class="">
    <div class="">
        <div v-if="$slots.success" class="flex items-center">
            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-green-500 rounded-full">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div  class="ml-4 text-gray-700 font-medium">
                <slot name="success"/>
            </div>
        </div>
        <div  v-if="$slots.pending" class="flex items-center mt-4">
            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-yellow-500 rounded-full">
                <!-- <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path>
                </svg> -->
            </div>
            <div class="ml-4 text-gray-700 font-medium">
                <slot name="pending"/>
            </div>
        </div>
        <div v-if="$slots.inprogress" class="flex items-center mt-4">
            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-gray-300 rounded-full">
                <div class="w-6 h-6 text-gray-500"></div>
            </div>
            <div  class="ml-4 text-gray-400">
                <slot name="inprogress" />
            </div>
        </div>
        <!-- <div class="flex items-center mt-4">
            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-gray-300 rounded-full">
                <div class="w-6 h-6 text-gray-500"></div>
            </div>
            <div class="ml-4 text-gray-400">Get Qualified</div>
        </div> -->
    </div>
</div>
</template>