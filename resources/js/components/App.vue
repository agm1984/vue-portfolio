<script setup>
import { useHead } from '@unhead/vue';
import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';

useHead({
    titleTemplate: title => `${title} | Adam Mackintosh's Portfolio`,
});
</script>

<template>
    <div class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <app-top-nav-bar />

        <div class="flex-1 flex flex-col">
            <router-view></router-view>
        </div>

        <app-footer />
    </div>

    <Toast />
    <ConfirmDialog />
</template>
