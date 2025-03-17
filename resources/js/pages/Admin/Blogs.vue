<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Blogs',
        href: '/admin/blogs',
    },
];

defineProps<{
    name?: string;
}>();
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 bg-white dark:bg-gray-800">
            <!-- Table Container -->
            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <!-- Table Header -->
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">S.N.</th>
                            <th scope="col" class="px-6 py-3">Blog Title</th>
                            <th scope="col" class="px-6 py-3">Author</th>
                            <th scope="col" class="px-6 py-3">Published At</th>
                            <th scope="col" class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">1</td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">First Blog</td>
                            <td class="px-6 py-4">Saroj Joshi</td>
                            <td class="px-6 py-4">2025/04/04</td>
                            <td class="px-6 py-4">
                                <button class="text-blue-600 dark:text-blue-500 hover:underline mr-2">Edit</button>
                                <button class="text-red-600 dark:text-red-500 hover:underline">Delete</button>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
