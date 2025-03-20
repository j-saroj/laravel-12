<template>
  <TransitionRoot as="template" :show="open" class="w-96">
    <Dialog class="relative z-10" @close="closeDialog">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 bg-gray-500/75 transition-opacity" />
      </TransitionChild>
      <div class="fixed inset-0 z-10 w-screen overflow-y-auto ">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <DialogPanel class="relative transform overflow-hidden rounded-lg bg-gray-300 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
              <div class="bg-white dark:bg-gray-700 text-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 ">
                <div class="sm:flex sm:items-start">
                    <form @submit.prevent="createBlog">
                    <div class="space-y-12 ">
                        <div class="border-b pb-12">
                        <h2 class="text-base font-semibold text-gray-700 dark:text-gray-300">Profile</h2>
                        <p class="mt-1 text-sm text-gray-700 dark:text-gray-400">This information will be displayed publicly so be careful what you share.</p>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                            <div class="mt-2">
                                <div class="flex items-center rounded-md bg-gray-100 pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                                <div class="shrink-0 text-base text-gray-500 dark:text-gray-400 select-none sm:text-sm">business.com/</div>
                                <input v-model="newBlog.title" required type="text" name="title" id="title" class="block bg-gray-100 grow py-1.5 pr-3 pl-1 text-base text-gray-700 dark:text-gray-500 placeholder:text-gray-400 focus:outline-none sm:text-sm" placeholder="janesmith" />
                                </div>
                            </div>
                            </div>

                            <div class="col-span-full">
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <div class="mt-2">
                             <div class="mt-2">
                                <textarea
                                    name="content"
                                    id="content"
                                    class="w-full h-48 rounded text-gray-600 p-4"
                                    v-model="newBlog.content"
                                    placeholder="Write Content Here......"></textarea>
                            </div>
                            </div>
                            </div>

                            <div class="col-span-full">
                            <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Published Date</label>
                            <input v-model="newBlog.published_at" required type="date" id="published_at" name="published_at" class="block w-full rounded-md bg-gray-100 px-3 py-1.5 text-base text-gray-700 dark:text-gray-800 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm" />
                            </div>

                        </div>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <button type="button" class="text-sm font-semibold text-gray-700 dark:text-gray-300" @click="closeDialog">Cancel</button>
                        <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
                    </div>
                    </form>
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
import { ref, onMounted, watch } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';
import { useBlogStore } from '@/stores/blogStore'; // Import the store
// import Editor from '@/components/Editor.vue'; // Import the Editor component


const toast = useToast();
const props = defineProps({
  open: {
    type: Boolean,
    required: true,
    },
    close: {
        type : Boolean,
    }
});
const passwordElementToggle = ref('Show');

const showPassword = () => {
    const passwordElement = document.getElementById('password');
    passwordElement.type = passwordElement.type === 'password' ? 'text' : 'password';
    passwordElement.type == 'password' ? passwordElementToggle.value = "password" : 'text';
    passwordElementToggle.value = passwordElement.type === 'password' ? 'Show' : 'Hide';
};

const emit = defineEmits(['close','fetchBlogs']);

const closeDialog = () => {
  emit('close');
};


const blogs = ref([]);
const newBlog = ref({
  title: '',
  content: '',
  published_at: '',
    status: false,
  user_id: null,
});

const getUser = async () => {
  try {
    const response = await axios.get('/admin/user'); // Ensure this API route exists to return the authenticated user's info
    newBlog.value.user_id = response.data.user.id; // Set the user_id to the authenticated user's ID
  } catch (error) {
    console.error("Error fetching user", error);
  }
};

onMounted(() => {
    getUser(); // Fetch the user on component mount

});

const blogStore = useBlogStore(); // Use the store

const createBlog = async () => {
       await blogStore.createBlog(newBlog.value); // Use the store to create a new blog
        newBlog.value = { title: '', content: '', published_at: '', status: false, user_id: null };
    closeDialog();
    getUser(); // Fetch the user on component mount

};





</script>
