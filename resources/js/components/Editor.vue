<script setup>
import { ref } from 'vue';
import { QuillEditor } from 'vue3-quill';

const editorData = ref('');
</script>

<template>
    <QuillEditor v-model:content="editorData" contentType="html" theme="snow" />
</template>
