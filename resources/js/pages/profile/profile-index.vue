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
    <div class="max-w-xl mx-auto flex-1 flex flex-col p-8">
        <h1>Settings</h1>

        <a-card class="w-full p-8 mt-4">
            <div class="h-10 flex items-center justify-center gap-4">
                <router-link
                    v-for="link in links"
                    :key="`link-${link.name}`"
                    :to="{ name: link.to }"
                    class="h-full inline-flex items-center font-semibold"
                    active-class="border-b-2 mt-0.5"
                >
                    {{ link.name }}
                </router-link>
            </div>

            <router-view></router-view>
        </a-card>
    </div>
</template>
