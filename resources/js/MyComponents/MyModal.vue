<script setup>
import {ref} from 'vue';

const props = defineProps({
  modalShow: Boolean
});

const emit = defineEmits(['updatemodalShow'])

console.log('modalSiteVisit:', props.modalShow);
const closeModal = (param) =>{
    
    emit('updatemodalShow', param)
    // console.log('newSiteVisitVal:', newSiteVisitVal);
    // newSiteVisitVal = false;
    // console.log('newSiteVisitVal:', newSiteVisitVal);
}


</script>
<template>
    <div v-show="modalShow"
    @click.self="closeModal(false)"
    class="md:hidden fixed inset-0 bg-black bg-opacity-30 top-0 left-0 flex justify-center z-10 overflow-y-auto">
    <transition name="modal-fade" appear>
      <div v-if="modalShow" 
           class="bg-white self-end w-full rounded-t-xl p-4 transform transition-transform duration-300 ease-in-out">
        <div class="">
          <div v-if="$slots.logo">
            <slot name="logo" />
          </div>
          <div v-if="$slots.title" class="w-full p-2 text-right flex justify-between gap-3 items-center border-b-2">
            <div>
                <h1 class="text-2xl font-bold">
                  <slot name="title" />
                </h1>
            </div>
            <button
              @click.self="closeModal(false)"
              class="bg-gray-50 text-gray-400 px-3 py-1 rounded-full text-xl text-right">&times;</button>
          </div>
          <div v-if="$slots.titleNoBtn" class="w-full p-2 text-right flex justify-center gap-3 items-center border-b-2">
            <div class="text-center">
              <h1 class="text-2xl font-bold">
                  <slot name="titleNoBtn" />
                </h1>
            </div>
          </div>
          <div v-if="$slots.titeNoBorder" class="w-full p-2 flex gap-3 items-center">
            <div class="text-center">
              <h1 class="text-2xl font-bold">
                  <slot name="titeNoBorder" />
                </h1>
            </div>
          </div>
          <div 
          v-if="$slots.img || $slots.modalcontent"
          class="grid grid-rows-1 md:grid-cols-2 py-4 gap-4 px-0 border-b-2">
            <div v-if="$slots.img"  class="px-2">
                <slot name="img" />
              <!-- <img :src="viewDetailed.url_links.facade" class="object-fit w-full h-full" alt="Detail Image" srcset=""> -->
            </div>
            <div class="">
            
              <div v-if="$slots.modalcontent"class="">
                <slot name="modalcontent" />
              </div>
            
            </div>
          </div>
          <div
          v-else
          class="grid grid-rows-1 md:grid-cols-2 pt-6 pb-6 gap-4 px-0 md:px-6"
          >
            <slot name="content_noborder" />
          </div>
          <div class="">
            <div  v-if="$slots.policy_terms" class="mt-2">
                <slot name="policy_terms" />
              </div>
          </div>
          <div v-if="$slots.buttons">
              <slot name="buttons" />
          </div>
        </div>
      </div>
      <!-- <div v-if="modalShow" 
           class="bg-white md:self-center max-w-screen-xl rounded-t-xl p-4 transform transition-transform duration-300 ease-in-out">
        <div class="">
          <div class="w-full p-2 text-right flex justify-between gap-3 items-center border-b-2">
            <div v-if="$slots.title">
                <h1 class="text-2xl font-bold">
                  <slot name="title" />
                </h1>
            </div>
            <button 
              @click.self="closeModal(false)"
              class="bg-gray-50 text-gray-400 px-3 py-1 rounded-full text-xl text-right">&times;</button>
          </div>
          <div class="grid grid-rows-1 md:grid-cols-2 pt-6 pb-6 gap-4 px-6 border-b-2">
            <div v-if="$slots.img"  class="px-2">
                <slot name="img" />
            </div>
            <div class="">
            
              <div v-if="$slots.modalcontent"class="">
                <slot name="modalcontent" />
              </div>
            
            </div>
          </div>
          <div class="">
            <div  v-if="$slots.policy_terms" class="mt-2">
                <slot name="policy_terms" />
              </div>
          </div>
          <div v-if="$slots.buttons">
              <slot name="buttons" />
          </div>
        </div>
      </div> -->
    </transition>
    </div>


    <!-- Desktop View -->
    <div v-show="modalShow"
    @click.self="closeModal(false)"
    class="hidden fixed inset-0 bg-black bg-opacity-30 top-0 left-0 md:flex justify-center z-10 overflow-y-auto">
    <transition name="modal-fade" appear>
      <div v-if="modalShow" 
           class="bg-white self-center max-w-screen-md rounded-t-xl p-4 transform transition-transform duration-300 ease-in-out max-h[80vh]">
        <div class="">
          <div v-if="$slots.logo">
            <slot name="logo" />
          </div>
          <div v-if="$slots.title" class="w-full p-2 text-right flex justify-between gap-3 items-center border-b-2">
            <div>
                <h1 class="text-2xl font-bold">
                  <slot name="title" />
                </h1>
            </div>
            <button
              @click.self="closeModal(false)"
              class="bg-gray-50 text-gray-400 px-3 py-1 rounded-full text-xl text-right">&times;</button>
          </div>
          <div v-if="$slots.titleNoBtn" class="w-full p-2 text-right flex justify-center gap-3 items-center border-b-2">
            <div class="text-center">
              <h1 class="text-2xl font-bold">
                  <slot name="titleNoBtn" />
                </h1>
            </div>
          </div>
          <div v-if="$slots.titeNoBorder" class="w-full p-2 flex gap-3 items-center">
            <div class="text-center">
              <h1 class="text-2xl font-bold">
                  <slot name="titeNoBorder" />
                </h1>
            </div>
          </div>
          <div 
          v-if="$slots.img || $slots.modalcontent"
          class="grid grid-rows-1 pt-6 pb-6 gap-4 px-4 border-b-2">
            <div v-if="$slots.img"  class="px-2">
                <slot name="img" />
              <!-- <img :src="viewDetailed.url_links.facade" class="object-fit w-full h-full" alt="Detail Image" srcset=""> -->
            </div>
            <div class="">
            
              <div v-if="$slots.modalcontent"class="">
                <slot name="modalcontent" />
              </div>
            
            </div>
          </div>
          <div
          v-else
          class="grid grid-rows-1 pt-6 pb-6 gap-4 px-0 md:px-6"
          >
            <slot name="content_noborder" />
          </div>
          <div class="">
            <div  v-if="$slots.policy_terms" class="mt-2">
                <slot name="policy_terms" />
              </div>
          </div>
          <div v-if="$slots.buttons">
              <slot name="buttons" />
          </div>
        </div>
      </div>
    </transition>
    </div>
</template>

<style scoped>
.modal-fade-enter-active, .modal-fade-leave-active {
  transition: opacity 0.5s, transform 0.5s;
}
.modal-fade-enter-from, .modal-fade-leave-to {
  opacity: 0;
  transform: translateY(100%);
}
.modal-fade-enter-to, .modal-fade-leave-from {
  opacity: 1;
  transform: translateY(0);
}
</style>