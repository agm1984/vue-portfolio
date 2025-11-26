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
    <div class="w-full max-w-2xl mx-auto flex-1 flex flex-col items-center justify-center p-8 transition-colors duration-300">
        <a-page-title
            title="Settings"
            description="Manage your account settings and profile information."
            centered
        ></a-page-title>

        <div class="w-full bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 p-8 transition-colors duration-300">
            <div class="h-10 flex items-center justify-center gap-8 mb-8 border-b border-gray-300 dark:border-gray-700">
                <router-link
                    v-for="link in links"
                    :key="`link-${link.name}`"
                    :to="{ name: link.to }"
                    class="h-full inline-flex items-center font-semibold px-2 transition-colors duration-200"
                    :class="[
                        'text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 border-b-2 border-transparent'
                    ]"
                    active-class="!text-indigo-600 dark:!text-indigo-400 border-indigo-600! dark:border-indigo-400"
                >
                    {{ link.name }}
                </router-link>
            </div>

            <router-view></router-view>
        </div>
    </div>
</template>
