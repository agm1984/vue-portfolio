<script setup>
import { ref } from 'vue';
import Button from 'primevue/button';
import Drawer from 'primevue/drawer';

defineProps({
    navItems: {
        type: Array,
        required: true,
    },
});

const isMenuOpen = ref(false);
</script>

<template>
    <div class="md:hidden sticky top-[67px] z-10 w-20 bg-gray-50 dark:bg-gray-800 border border-transparent dark:border-gray-700 rounded-md p-4 transition-colors duration-300 ml-4 mt-4 shadow-sm">
        <Button
            type="button"
            severity="secondary"
            icon="pi pi-bars"
            aria-label="Menu"
            text
            @click="isMenuOpen = true"
            class="!p-0 w-full h-full flex justify-center items-center dark:text-white"
        />
    </div>

    <aside class="w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 shrink-0 hidden md:flex flex-col fixed h-full z-10 transition-colors duration-300">
        <nav class="flex-1 overflow-y-auto p-4">
            <div class="flex flex-col gap-1">
                <side-nav-link
                    v-for="item in navItems"
                    :key="`side-nav-link-${item.route}`"
                    :item="item"
                ></side-nav-link>
            </div>
        </nav>
    </aside>

    <Drawer v-model:visible="isMenuOpen" class="w-64">
        <template #header>
            <span class="font-bold text-gray-900 dark:text-white">Menu</span>
        </template>

        <div class="flex flex-col gap-1">
            <side-nav-link
                v-for="item in navItems"
                :key="item.route"
                :item="item"
                @click="isMenuOpen = false"
            ></side-nav-link>
        </div>
    </Drawer>
</template>
