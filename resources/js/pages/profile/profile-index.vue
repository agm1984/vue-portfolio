<script setup>
import { computed } from 'vue';

const links = computed(() => [
    {
        name: 'Profile',
        to: 'settings.profile',
    },
    {
        name: 'Password',
        to: 'settings.password',
    },
]);
</script>

<template>
    <div class="w-full max-w-2xl mx-auto flex-1 flex flex-col items-center justify-center p-8">
        <h1>Settings</h1>
        <p class="text-gray-600 mt-2 text-center">
            Manage your account settings and profile information.
        </p>

        <a-card class="w-full p-8 mt-4">
            <div class="h-10 flex items-center justify-center gap-4">
                <router-link
                    v-for="link in links"
                    :key="`link-${link.name}`"
                    :to="{ name: link.to }"
                    class="h-full inline-flex items-center font-semibold text-gray-700"
                    active-class="text-indigo-600 border-b-2 border-indigo-600 mt-0.5"
                >
                    {{ link.name }}
                </router-link>
            </div>

            <router-view></router-view>
        </a-card>
    </div>
</template>
