<script setup>
import Button from 'primevue/button';
import { useDarkMode } from '~/composables/useDarkMode';

const { isDark, toggleTheme } = useDarkMode();
</script>

<template>
    <Button
        severity="secondary"
        aria-label="Toggle Dark Mode"
        :icon="isDark ? 'pi pi-moon' : 'pi pi-sun'"
        rounded
        outlined
        @click="toggleTheme"
    />
</template>
