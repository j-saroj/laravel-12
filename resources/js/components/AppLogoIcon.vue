<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
   <img src="https://static.vecteezy.com/system/resources/thumbnails/019/514/650/small/letter-s-logo-design-for-business-and-company-identity-with-luxury-concept-free-vector.jpg" alt="">
</template>
