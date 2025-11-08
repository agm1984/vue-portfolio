<script setup>
import { useHead } from '@unhead/vue';

useHead({
    titleTemplate: title => `${title} | Adam Mackintosh's Portfolio`,
});
</script>

<template>
    <router-view></router-view>
</template>
