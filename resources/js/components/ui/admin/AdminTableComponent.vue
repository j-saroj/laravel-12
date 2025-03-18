<script setup lang="ts">
import { ref, defineProps, defineEmits } from 'vue';
import AdminCreateComponent from '@/components/ui/admin/AdminCreateComponent.vue';

const isCreateOpen = ref(false);

// Open and close modal functions
const showAdd = () => {
    isCreateOpen.value = true;
};
const closeAdd = () => {
    isCreateOpen.value = false;
};

// Props
const props = defineProps<{
    blogs: {
        id: number;
        title: string;
        author: string;
        published_at: string | null;
    }[];
}>();

// Emit events
const emit = defineEmits(['view', 'edit', 'delete']);
</script>

<template>
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <!-- Modal for Creating Blog -->
        <AdminCreateComponent :open="isCreateOpen" @close="closeAdd" />

        <!-- Add Blog Button -->
        <button
            type="button"
            class="mb-2 me-2 rounded-lg bg-gradient-to-br from-purple-600 to-blue-500 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-gradient-to-bl focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800"
            @click="showAdd()"
        >
            Add Blog
        </button>

        <!-- Blog Table -->
        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">S.N.</th>
                    <th scope="col" class="px-6 py-3">Blog Title</th>
                    <th scope="col" class="px-6 py-3">Author</th>
                    <th scope="col" class="px-6 py-3">Published At</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(blog, index) in blogs" :key="blog.id" class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">{{ index + 1 }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ blog.title }}</td>
                    <td class="px-6 py-4">{{ blog.author }}</td>
                    <td class="px-6 py-4">{{ blog.published_at ?? 'Not Published' }}</td>
                    <td class="px-6 py-4">
                        <button class="mr-2 text-blue-600 hover:underline dark:text-green-500" @click="emit('view', blog)">View</button>
                        <button class="mr-2 text-blue-600 hover:underline dark:text-blue-500" @click="emit('edit', blog)">Edit</button>
                        <button class="text-red-600 hover:underline dark:text-red-500" @click="emit('delete', blog.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
