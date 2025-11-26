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
    <a-page>
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
    </a-page>
</template>
