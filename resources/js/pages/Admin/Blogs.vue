<script setup lang="ts">
import AdminCreateComponent from '@/components/ui/admin/AdminCreateComponent.vue';
import AdminViewComponent from '@/components/ui/admin/AdminViewComponent.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';



const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Blogs',
        href: '/admin/blogs',
    },
];


const isViewOpen = ref(false);
const isCreateOpen = ref(false);
const selectedBlog = ref(null);
const toast = useToast();

const openView = (blog) => {
    selectedBlog.value = blog; // Store the selected blog data
    isViewOpen.value = true;
};
const blogs = ref([]);

const fetchBlogs = async () => {
    try {
        const response = await axios.get('/admin/blogs');
        blogs.value = response.data.blogs;
        console.log(respoinse.data.blogs);
    } catch (error) {
        console.error("Error fetching blogs", error);
    }
};
onMounted(() => {
    fetchBlogs();
});
const closeView = () => {
    isViewOpen.value = false;
    selectedBlog.value = null; // Clear data when closing
};

const showAdd = () => {
    isCreateOpen.value = true;
    console.log("clicked")
};
const closeAdd = () => {
    isCreateOpen.value = false;
};

const deleteBlog = async (blog) => {
    try {
        const response = await axios.delete(`/admin/blogs/${blog.id}`);
    
        toast.success('Blog deleted successfully');
    } catch (error) {
        console.error('Error deleting blog', error);
        toast.error('Error deleting blog');
    }
}

const props = defineProps({
    blogs: Array
});
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl bg-white p-4 dark:bg-gray-800">
            <AdminViewComponent :open="isViewOpen" :blog="selectedBlog" @fetchBlogs="fetchBlogs" @close="closeView" />
            <AdminCreateComponent :open="isCreateOpen" @close="closeAdd" />

            <!-- <AdminViewComponent :open="isViewOpen" @close="closeView" /> -->
            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <button
                    type="button"
                    class="mb-2 me-2 rounded-lg bg-gradient-to-br from-purple-700 to-blue-500 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-gradient-to-bl focus:outline-none dark:focus:ring-blue-800"
                    @click="showAdd()"
                >
                    Add Blog
                </button>
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <!-- Table Header -->
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">S.N.</th>
                            <th scope="col" class="px-6 py-3">Blog Title</th>
                            <th scope="col" class="px-6 py-3">Author</th>
                            <th scope="col" class="px-6 py-3">Published At</th>
                            <th scope="col" class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody v-if="props.blogs?.length">
                        <tr v-for="blog in props.blogs" :key="blog?.id" class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">{{ blog.id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ blog.title }}</td>
                            <td class="px-6 py-4">saroj joshi</td>
                            <td class="px-6 py-4">{{ blog.published_at }}</td>
                            <td class="px-6 py-4">
                                <button class="mr-2 text-blue-600 hover:underline dark:text-green-500" @click="openView(blog)">view</button>
                                <button class="mr-2 text-blue-600 hover:underline dark:text-blue-500">Edit</button>
                                <button class="text-red-600 hover:underline dark:text-red-500" @click="deleteBlog(blog)" >Delete</button>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
