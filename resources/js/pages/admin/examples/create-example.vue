<script setup>
import { useHead } from '@unhead/vue';
import { useRouter } from 'vue-router';

useHead({
    title: 'Admin Create Example',
});

const router = useRouter();

const goBack = () => router.push({ name: 'admin.examples.list' });
</script>

<template>
    <div class="flex-1 flex flex-col">
        <a-page-title
            title="Add Example"
            description="Create a new example"
            has-back
            @on-back="goBack"
        ></a-page-title>

        <a-card class="p-8">
            <edit-example
                mode="create"
            />
        </a-card>
    </div>
</template>
