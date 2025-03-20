

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl bg-white p-4 dark:bg-gray-800">
            <AdminViewComponent :open="isViewOpen" :blog="selectedBlog" @fetchBlogs="blogStore.fetchBlogs" @close="closeView" />
            <AdminCreateComponent :open="isCreateOpen" @close="closeAdd" />
            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <button
                    type="button"
                    class="mb-2 me-2 rounded-lg bg-gradient-to-br from-purple-700 to-blue-500 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-gradient-to-bl focus:outline-none dark:focus:ring-blue-800"
                    @click="showAdd()"
                >
                    Add Blog
                </button>
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Search blogs..."
                    class="p-2 border text-gray-700 dark:text-gray-700 rounded-md mb-4"
                />
                <!-- Skeleton loader for the initial loading -->
                <div v-if="loading" class="space-y-4">
                    <div v-for="i in 5" :key="i" class="animate-pulse">
                        <div class="h-8 bg-gray-200 dark:bg-gray-700 rounded"></div>
                    </div>
                </div>

                <!-- Table with Loading Line for Adding/Deleting Blogs -->
                <table v-else class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">S.N.</th>
                            <th scope="col" class="px-6 py-3">Blog Title</th>
                            <th scope="col" class="px-6 py-3">Author</th>
                            <th scope="col" class="px-6 py-3">Published At</th>
                            <th scope="col" class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody v-if="filteredBlogs?.length">
                        <tr v-for="blog in blogs" :key="blog?.id" class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">{{ blog.id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ blog.title }}</td>
                            <td class="px-6 py-4">saroj joshi</td>
                            <td class="px-6 py-4">{{ blog.published_at }}</td>
                            <td class="px-6 py-4">
                                <button class="mr-2 text-blue-600 hover:underline dark:text-green-500" @click="openView(blog)">view</button>
                                <button class="mr-2 text-blue-600 hover:underline dark:text-blue-500">Edit</button>
                                <button class="text-red-600 hover:underline dark:text-red-500" @click="deleteBlog(blog.id)">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- The loading line that appears when adding or deleting a blog -->
                <div v-if="loadingLine" class="loading-line"></div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AdminCreateComponent from '@/components/ui/admin/AdminCreateComponent.vue';
import AdminViewComponent from '@/components/ui/admin/AdminViewComponent.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';
import { useBlogStore } from '@/stores/blogStore'; // Import the store

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Blogs',
        href: '/admin/blogs',
    },
];
const loading = ref(true); // Loading state for skeleton loader
const loadingLine = ref(false); // Loading state for the moving line
const filteredBlogs = ref([]); // Reactive filtered blogs
const searchQuery = ref(''); // Reactive search query
const isViewOpen = ref(false);
const isCreateOpen = ref(false);
const selectedBlog = ref(null);
const blogStore = useBlogStore();

const openView = (blog) => {
    selectedBlog.value = blog; // Store the selected blog data
    isViewOpen.value = true;
};

const blogs = computed(() => blogStore.blogs);
onMounted(async () => {
    loading.value = true; // Start loading
    await blogStore.fetchBlogs();
    filteredBlogs.value = blogStore.blogs; // Update filtered blogs
    loading.value = false; // Stop loading
});

const closeView = () => {
    isViewOpen.value = false;
    selectedBlog.value = null; // Clear data when closing
};

const showAdd = () => {
    isCreateOpen.value = true;
    console.log("clicked");
};

const closeAdd = () => {
    isCreateOpen.value = false;
};

const deleteBlog = async (blogId) => {
    loadingLine.value = true; // Show the loading line
    await blogStore.deleteBlog(blogId); // Use the store to delete the blog
    loadingLine.value = false; // Hide the loading line
};
</script>
<style scoped>
.loading-line {
    position: absolute;
    width: 100%;
    height: 4px;
    background: linear-gradient(to right, #dfe1e4, #292b2f);
    animation: move 2s infinite;
    top: 60px; /* Position the line above the table */
}

@keyframes move {
    0% {
        transform: translateX(-100%);
    }
    100% {
        transform: translateX(100%);
    }
}
</style>
