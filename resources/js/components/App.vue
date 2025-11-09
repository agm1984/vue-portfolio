<script setup>
import { useHead } from '@unhead/vue';

useHead({
    titleTemplate: title => `${title} | Adam Mackintosh's Portfolio`,
});
</script>

<template>
    <Navbar />
    <router-view></router-view>
</template>
