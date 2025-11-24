<script setup>
import { useHead } from '@unhead/vue';

useHead({
    title: 'Admin Create Category',
});
</script>

<template>
    <div class="flex-1 flex flex-col">
        <h2>Create Category</h2>

        <a-card class="p-8 mt-4">
            <edit-category
                mode="create"
            />
        </a-card>
    </div>
</template>
