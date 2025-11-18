<script setup>
import { useHead } from '@unhead/vue';

useHead({
    title: 'Admin Create Category',
});
</script>

<template>
    <a-card class="p-8">
        <h2>Create Category</h2>

        <edit-category
            mode="create"
        />
    </a-card>
</template>
