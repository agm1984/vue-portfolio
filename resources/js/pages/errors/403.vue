<script setup>
import { useHead } from '@unhead/vue';

useHead({
    title: '403',
});
</script>

<template>
    <div class="flex-1 w-full max-w-xl mx-auto flex flex-col items-center justify-center gap-4 p-8">
        <span class="text-6xl">403</span>

        <h1>Forbidden</h1>

        <router-link class="font-semibold hover:underline" :to="{ name: 'home' }">Go home</router-link>
    </div>
</template>
