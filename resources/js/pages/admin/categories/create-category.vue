<script setup>
import { useHead } from '@unhead/vue';
import { useRouter } from 'vue-router';

useHead({
    title: 'Admin Create Category',
});

const router = useRouter();

const goBack = () => router.push({ name: 'admin.categories.list' });
</script>

<template>
    <div class="flex-1 flex flex-col">
        <a-page-title
            title="Add Category"
            description="Create a new category for organizing portfolio examples."
            has-back
            @on-back="goBack"
        ></a-page-title>

        <a-card class="p-8">
            <edit-category
                mode="create"
            />
        </a-card>
    </div>
</template>
