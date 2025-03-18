<template>
  <TransitionRoot as="template" :show="open">
    <Dialog class="relative z-10" @close="closeDialog">
      <TransitionChild as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0">
        <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
      </TransitionChild>
      <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <TransitionChild as="template"
            enter="ease-out duration-300"
            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to="opacity-100 translate-y-0 sm:scale-100"
            leave="ease-in duration-200"
            leave-from="opacity-100 translate-y-0 sm:scale-100"
            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-700 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
              <div class="bg-white dark:bg-gray-700 p-6">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300">{{ blog?.title }}</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">{{ blog?.content }}</p>
                <p class="mt-2 text-sm text-gray-500">Published: {{ blog?.published_at }}</p>
                <div class="mt-4 flex justify-end">
                  <button class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-md hover:bg-indigo-500" @click="closeDialog">Close</button>
                </div>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { ref, watch } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';


const props = defineProps({
  open: {
    type: Boolean,
    required: true,
    },
    close: {
        type : Boolean,
    },
    blog: Object, // Accept the blog object
});
const passwordElementToggle = ref('Show');

const showPassword = () => {
    const passwordElement = document.getElementById('password');
    passwordElement.type = passwordElement.type === 'password' ? 'text' : 'password';
    passwordElement.type == 'password' ? passwordElementToggle.value = "password" : 'text';
    passwordElementToggle.value = passwordElement.type === 'password' ? 'Show' : 'Hide';
};

const emit = defineEmits(['close']);

const closeDialog = () => {
  emit('close');
};
</script>
