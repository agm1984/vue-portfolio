<script setup>
import { useHead } from '@unhead/vue';

useHead({
    title: 'Admin Create Example',
});
</script>

<template>
    <div class="flex-1 flex flex-col">
        <h2>Create Example</h2>

        <a-card class="p-8 mt-4">
            <edit-example
                mode="create"
            />
        </a-card>
    </div>
</template>
