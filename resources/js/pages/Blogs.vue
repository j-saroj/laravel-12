<template>
    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] dark:bg-[#0a0a0a] lg:justify-center lg:p-8">
        <Homepage />

        <div class="h-14.5 hidden lg:block"></div>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import Homepage from './Homepage.vue';
</script>
