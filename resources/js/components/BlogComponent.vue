<template>
    <div v-for="blog in props.blogs" :key="blog?.id" class="flex flex-col items-center gap-6 rounded-2xl p-7 md:gap-8 md:flex-row bg-gray-200 dark:bg-gray-700">
        <div>
            <img class="size-48 rounded-md shadow-xl" alt="" src="https://thumbs.dreamstime.com/b/beautiful-sunset-evening-over-sea-clouds-225768281.jpg" />
        </div>
        <div class="flex items-center md:flex-col md:gap-2 md:items-start">
            <span class="text-2xl font-medium text-gray-900 dark:text-gray-200">{{blog.title}}</span>
            <span class="font-medium text-gray-800 dark:text-gray-400">{{ blog.content }}</span>
            <span class="flex gap-2 font-medium text-gray-600 dark:text-gray-400">
                <span>{{ blog.published_at }}</span>
                
            </span>
        </div>
    </div>
</template>
<script setup>
import { ref, defineProps } from 'vue';


const props = defineProps({
    blogs: Array
});
</script>
