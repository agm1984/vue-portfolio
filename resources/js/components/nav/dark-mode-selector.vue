<script setup>
import Button from 'primevue/button';
import { useDarkMode } from '~/composables/useDarkMode';

const { isDark, toggleTheme } = useDarkMode();
</script>

<template>
    <Button
        severity="secondary"
        aria-label="Toggle Dark Mode"
        rounded
        outlined
        @click="toggleTheme"
    >
        <i class="pi" :class="isDark ? 'pi-moon' : 'pi-sun'"></i>
    </Button>
</template>
