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
    <div class="md:hidden sticky top-[67px] z-10 w-20 bg-gray-50 rounded-md p-4">
        <Button
            type="button"
            severity="secondary"
            icon="pi pi-bars"
            aria-label="Menu"
            text
            @click="isMenuOpen = true"
        />
    </div>

    <aside class="w-64 bg-white border-r shrink-0 hidden md:flex flex-col fixed h-full z-10">
        <nav class="flex-1 overflow-y-auto p-4">
            <side-nav-link
                v-for="item in navItems"
                :key="item.route"
                :item="item"
            ></side-nav-link>
        </nav>
    </aside>

    <Drawer v-model:visible="isMenuOpen" class="w-64" :showCloseIcon="true">
        <div class="flex flex-col h-full">
            <nav class="flex-1 p-4">
                <side-nav-link
                    v-for="item in navItems"
                    :key="item.route"
                    :item="item"
                ></side-nav-link>
            </nav>
        </div>
    </Drawer>
</template>
