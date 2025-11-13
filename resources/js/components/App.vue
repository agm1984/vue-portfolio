<script setup>
import { useHead } from '@unhead/vue';

useHead({
    titleTemplate: title => `${title} | Adam Mackintosh's Portfolio`,
});
</script>

<template>
    <div class="min-h-screen flex flex-col bg-gray-100">
        <app-top-nav-bar />
        <router-view></router-view>
        <app-footer />
    </div>
</template>
