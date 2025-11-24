<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '~/store/auth';

const auth = useAuthStore();
const router = useRouter();

const isMobileMenuOpen = ref(false);

const handleLogout = async () => {
    await auth.logout();
    await router.push({ name: 'login' });
    isMobileMenuOpen.value = false;
};
</script>

<template>
    <nav class="sticky top-0 z-50 w-full bg-white dark:bg-gray-900 border-b dark:border-gray-950">
        <!-- desktop -->
        <div class="flex h-[66px] items-center justify-between px-8">
            <div class="w-48 h-full flex items-center">
                <router-link
                    class="h-full inline-flex items-center font-semibold text-lg"
                    :to="{ name: auth.isAuthenticated ? 'home' : 'home' }"
                    active-class="border-b-2 border-indigo-600 dark:border-indigo-400 mt-0.5 text-indigo-600 dark:text-indigo-400"
                >
                    AGM
                </router-link>
            </div>

            <div class="hidden md:flex h-full items-center gap-4">
                <router-link
                    :to="{ name: 'about' }"
                    class="h-full inline-flex items-center font-semibold text-gray-700 hover:text-indigo-600 dark:text-indigo-400 active:text-indigo-700"
                    active-class="border-b-2 border-indigo-600 dark:border-indigo-400 mt-0.5 text-indigo-600 dark:text-indigo-400"
                >
                    About Me
                </router-link>

                <router-link
                    :to="{ name: 'public.examples' }"
                    class="h-full inline-flex items-center font-semibold text-gray-700 hover:text-indigo-600 dark:text-indigo-400 active:text-indigo-700"
                    active-class="border-b-2 border-indigo-600 dark:border-indigo-400 mt-0.5 text-indigo-600 dark:text-indigo-400"
                >
                    Examples
                </router-link>

                <router-link
                    :to="{ name: 'admin' }"
                    class="h-full inline-flex items-center font-semibold text-gray-700 hover:text-indigo-600 dark:text-indigo-400 active:text-indigo-700"
                    active-class="border-b-2 border-indigo-600 dark:border-indigo-400 mt-0.5 text-indigo-600 dark:text-indigo-400"
                >
                    Admin
                </router-link>

                <router-link
                    :to="{ name: 'design' }"
                    class="h-full inline-flex items-center font-semibold text-gray-700 hover:text-indigo-600 dark:text-indigo-400 active:text-indigo-700"
                    active-class="border-b-2 border-indigo-600 dark:border-indigo-400 mt-0.5 text-indigo-600 dark:text-indigo-400"
                >
                    Design System
                </router-link>

                <router-link
                    :to="{ name: 'contact' }"
                    class="h-full inline-flex items-center font-semibold text-gray-700 hover:text-indigo-600 dark:text-indigo-400 active:text-indigo-700"
                    active-class="border-b-2 border-indigo-600 dark:border-indigo-400 mt-0.5 text-indigo-600 dark:text-indigo-400"
                >
                    Contact Me
                </router-link>
            </div>

            <div class="hidden w-48 h-full md:flex items-center justify-end gap-4">
                <dark-mode-selector></dark-mode-selector>

                <Button
                    type="button"
                    icon="pi pi-moon"
                    outlined
                    rounded
                    @click="toggleDarkMode"
                />

                <user-menu v-if="auth.isAuthenticated" />

                <template v-else>
                    <router-link
                        :to="{ name: 'register' }"
                        class="h-full inline-flex items-center font-semibold text-gray-700 hover:text-indigo-600 dark:text-indigo-400 active:text-indigo-700"
                        active-class="border-b-2 border-indigo-600 dark:border-indigo-400 mt-0.5 text-indigo-600 dark:text-indigo-400"
                    >
                        Register
                    </router-link>

                    <router-link
                        :to="{ name: 'login' }"
                        class="h-full inline-flex items-center font-semibold text-gray-700 hover:text-indigo-600 dark:text-indigo-400 active:text-indigo-700"
                        active-class="border-b-2 border-indigo-600 dark:border-indigo-400 mt-0.5 text-indigo-600 dark:text-indigo-400"
                    >
                        Login
                    </router-link>
                </template>
            </div>

            <!-- mobile -->
            <div class="flex items-center md:hidden -mr-3">
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-900"
                    :aria-expanded="isMobileMenuOpen"
                    aria-controls="primary-navigation"
                    @click="isMobileMenuOpen = !isMobileMenuOpen"
                >
                    <span class="sr-only">Toggle navigation</span>

                    <svg
                        v-if="!isMobileMenuOpen"
                        class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                    </svg>

                    <svg
                        v-else
                        class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div
            v-show="isMobileMenuOpen"
            id="primary-navigation"
            class="md:hidden border-t border-gray-200 bg-white"
        >
            <div class="p-4">
                <router-link
                    :to="{ name: 'about' }"
                    class="block rounded-md text-gray-700 hover:bg-gray-50 p-2"
                    active-class="bg-gray-100 text-gray-900"
                    @click="isMobileMenuOpen = false"
                >
                    About Me
                </router-link>

                <router-link
                    :to="{ name: 'public.examples' }"
                    class="block rounded-md text-gray-700 hover:bg-gray-50 p-2"
                    active-class="bg-gray-100 text-gray-900"
                    @click="isMobileMenuOpen = false"
                >
                    Examples
                </router-link>

                <router-link
                    :to="{ name: 'admin' }"
                    class="block rounded-md text-gray-700 hover:bg-gray-50 p-2"
                    active-class="bg-gray-100 text-gray-900"
                    @click="isMobileMenuOpen = false"
                >
                    Admin
                </router-link>

                <router-link
                    :to="{ name: 'design' }"
                    class="block rounded-md text-gray-700 hover:bg-gray-50 p-2"
                    active-class="bg-gray-100 text-gray-900"
                    @click="isMobileMenuOpen = false"
                >
                    Design System
                </router-link>

                <router-link
                    :to="{ name: 'contact' }"
                    class="block rounded-md text-gray-700 hover:bg-gray-50 p-2"
                    active-class="bg-gray-100 text-gray-900"
                    @click="isMobileMenuOpen = false"
                >
                    Contact Me
                </router-link>
            </div>

            <div class="border-t border-gray-200 p-4">
                <template v-if="auth.isAuthenticated">
                    <p class="text-gray-700 p-2">
                        Signed in as
                        <span class="font-semibold">
                            {{ auth.user.name }}
                        </span>
                    </p>
                    <div class="">
                        <router-link
                            :to="{ name: 'settings.profile' }"
                            class="block rounded-md text-gray-700 hover:bg-gray-50 p-2"
                            active-class="bg-gray-100 text-gray-900"
                            @click="isMobileMenuOpen = false"
                        >
                            View profile
                        </router-link>

                        <button
                            type="button"
                            class="block w-full rounded-md text-left text-gray-700 hover:bg-gray-50 p-2"
                            @click="handleLogout"
                        >
                            Logout
                        </button>
                    </div>
                </template>

                <!-- Guest -->
                <template v-else>
                    <div class="flex flex-col gap-1">
                        <router-link
                            :to="{ name: 'register' }"
                            class="block rounded-md p-2 text-base font-medium text-gray-700 hover:bg-gray-50"
                            active-class="bg-gray-100 text-gray-900"
                            @click="isMobileMenuOpen = false"
                        >
                            Register
                        </router-link>

                            <router-link
                            :to="{ name: 'login' }"
                            class="block rounded-md p-2 text-base font-medium text-gray-700 hover:bg-gray-50"
                            active-class="bg-gray-100 text-gray-900"
                            @click="isMobileMenuOpen = false"
                        >
                            Login
                        </router-link>
                    </div>
                </template>
            </div>
        </div>
    </nav>
</template>
