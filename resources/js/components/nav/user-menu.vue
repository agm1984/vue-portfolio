<script setup>
import { ref, reactive, computed } from 'vue';
import Menu from 'primevue/menu';
import Button from 'primevue/button';
import { useAuthStore } from '~/store/auth';

const auth = useAuthStore();

const userMenu = ref();

const menuItems = computed(() => ([
    reactive({
        label: 'View profile',
        icon: 'pi pi-cog',
        route: { name: 'settings.profile' },
    }),
    reactive({
        label: 'Logout',
        icon: 'pi pi-sign-out',
        command: auth.logout,
    }),
]));

const toggleMenu = (event) => {
    userMenu.value.toggle(event);
};
</script>

<template>
    <div class="w-48 h-full flex items-center justify-end gap-4">
        <button
            type="button"
            severity="secondary"
            aria-haspopup="true"
            aria-controls="overlay_menu"
            @click="toggleMenu"
        >
            <a-avatar :size="32" :user="auth.user" />
            <!-- <span class="font-semibold">{{ auth.user.name }}</span> -->
        </button>
    </div>

    <Menu ref="userMenu" :model="menuItems" popup>
        <template #item="{ item, props }">
            <a-menu-item :item="item" :props="props" />
        </template>
    </Menu>
</template>