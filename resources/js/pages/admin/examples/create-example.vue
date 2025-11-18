<script setup>
import { useHead } from '@unhead/vue';

useHead({
    title: 'Admin Create Example',
});
</script>

<template>
    <a-card class="p-8">
        <h2>Create Example</h2>

        <edit-example
            mode="create"
        />
    </a-card>
</template>
