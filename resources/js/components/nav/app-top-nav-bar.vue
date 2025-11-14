<script setup>
import { useRouter } from 'vue-router';
import { useAuthStore } from '~/store/auth';

const router = useRouter();
const auth = useAuthStore();

const appName = window.config.appName;

const logout = async () => {
    await auth.logout();
    await router.push({ name: 'login' });
};
</script>

<template>
    <nav class="sticky top-0 z-10 w-full h-[66px] flex items-center justify-between gap-4 bg-white px-8">
        <div class="w-48 h-full flex items-center">
            <router-link :to="{ name: auth.isAuthenticated ? 'home' : 'home' }" class="navbar-brand">
                {{ appName }}
            </router-link>
        </div>

        <div class="h-full inline-flex items-center gap-4">
            <router-link
                :to="{ name: 'about' }"
                class="h-full inline-flex items-center font-semibold"
                active-class="border-b-2 mt-0.5"
            >
                About Me
            </router-link>

            <router-link
                :to="{ name: 'skills' }"
                class="h-full inline-flex items-center font-semibold"
                active-class="border-b-2 mt-0.5"
            >
                Skills
            </router-link>

            <router-link
                :to="{ name: 'public.examples' }"
                class="h-full inline-flex items-center font-semibold"
                active-class="border-b-2 mt-0.5"
            >
                Examples
            </router-link>

            <router-link
                :to="{ name: 'admin' }"
                class="h-full inline-flex items-center font-semibold"
                active-class="border-b-2 mt-0.5"
            >
                Admin
            </router-link>

            <router-link
                :to="{ name: 'contact' }"
                class="h-full inline-flex items-center font-semibold"
                active-class="border-b-2 mt-0.5"
            >
                Contact Me
            </router-link>
        </div>

        <!-- Authenticated -->
        <user-menu v-if="auth.isAuthenticated" />

        <!-- Guest -->
        <div v-else class="h-full flex items-center gap-4">
            <router-link
                :to="{ name: 'register' }"
                class="h-full inline-flex items-center font-semibold"
                active-class="border-b-2 mt-0.5"
            >
                Register
            </router-link>

            <router-link
                :to="{ name: 'login' }"
                class="h-full inline-flex items-center font-semibold"
                active-class="border-b-2 mt-0.5"
            >
                Login
            </router-link>
        </div>
    </nav>
</template>
