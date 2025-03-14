<template>
    <div class="bg-dark">
        <HeaderComponent />

        <div class="relative isolate px-6 pt-14 lg:px-8">
            <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
                <blockquote class="text-center text-2xl font-semibold italic text-gray-900 dark:text-white">
                    When you look
                    <span class="relative inline-block before:absolute before:-inset-1 before:block before:-skew-y-3 before:bg-pink-500">
                        <span class="relative text-white dark:text-gray-950">annoyed</span>
                    </span>
                    all the time, people think that you're busy.
                </blockquote>
            </div>
            <div
                class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]"
                aria-hidden="true"
            ></div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import HeaderComponent from '@/components/HeaderComponent.vue';

const mobileMenuOpen = ref(false);
</script>
