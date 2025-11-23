<script setup>
</script>

<template>
    <footer class="w-full flex flex-col bg-gray-200 text-gray-200 border-t px-8 pb-8">
        <!-- <a-testimonials
            class="mt-8"
            :testimonials="undefined"
            :interval="5000"
            auto-play
        ></a-testimonials> -->

        <div class="flex flex-wrap items-center justify-center gap-2 text-gray-900 text-center mt-8">
            <p>&copy; {{ new Date().getFullYear() }} Adam Mackintosh. All rights reserved.</p>
            <router-link :to="{ name: 'privacy.policy' }" class="underline hover:text-indigo-600 transition-colors">Privacy Policy</router-link>
            <router-link :to="{ name: 'terms.of.use' }" class="underline hover:text-indigo-600 transition-colors">Terms of Use</router-link>
        </div>
    </footer>
</template>
