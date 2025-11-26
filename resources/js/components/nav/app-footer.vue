<script setup>
import { computed } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();

const isAdminOrDesignSystem = computed(() => {
    return route.name?.startsWith('admin.') || route.name?.startsWith('design.');
});
</script>

<template>
    <footer class="w-full flex flex-col p-8 bg-gray-50 dark:bg-gray-900 border-t border-gray-300 dark:border-gray-700">
        <div class="flex flex-wrap items-center justify-center gap-2 text-center text-sm font-medium text-gray-600 dark:text-gray-400">
            <p>&copy; {{ new Date().getFullYear() }} Adam Mackintosh. All rights reserved.</p>

            <div class="whitespace-nowrap">
                <router-link
                    :to="{ name: 'privacy.policy' }"
                    class="hover:text-indigo-600 dark:hover:text-indigo-400 underline"
                >
                    Privacy Policy
                </router-link>

                <span class="mx-2 text-gray-300 dark:text-gray-700">|</span>

                <router-link
                    :to="{ name: 'terms.of.use' }"
                    class="hover:text-indigo-600 dark:hover:text-indigo-400 underline"
                >
                    Terms of Use
                </router-link>
            </div>
        </div>
    </footer>
</template>
