<script setup>
</script>

<template>
    <footer class="w-full flex flex-col px-8 pb-8 pt-8 transition-colors duration-300 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
        <div class="flex flex-wrap items-center justify-center gap-2 text-center text-sm font-medium text-gray-600 dark:text-gray-400 transition-colors">
            <p>&copy; {{ new Date().getFullYear() }} Adam Mackintosh. All rights reserved.</p>

            <span class="mx-2 text-gray-300 dark:text-gray-700">|</span>

            <router-link
                :to="{ name: 'privacy.policy' }"
                class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors underline"
            >
                Privacy Policy
            </router-link>

            <span class="mx-2 text-gray-300 dark:text-gray-700">|</span>

            <router-link
                :to="{ name: 'terms.of.use' }"
                class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors underline"
            >
                Terms of Use
            </router-link>
        </div>
    </footer>
</template>
