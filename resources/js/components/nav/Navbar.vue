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
    <nav class="sticky top-0 z-10 bg-white py-2 px-8">
        <div class="w-full flex items-center justify-between">
            <router-link :to="{ name: auth.isAuthenticated ? 'admin' : 'home' }" class="navbar-brand">
                {{ appName }}
            </router-link>

            <div class="flex items-center gap-4">
                <router-link
                    :to="{ name: 'about' }"
                    class="nav-link inline-block text-dark"
                    active-class="active"
                >
                    About Me
                </router-link>

                <router-link
                    :to="{ name: 'skills' }"
                    class="nav-link inline-block text-dark"
                    active-class="active"
                >
                    Skills
                </router-link>

                <router-link
                    :to="{ name: 'public.examples.list' }"
                    class="nav-link inline-block text-dark"
                    active-class="active"
                >
                    Examples
                </router-link>

                <router-link
                    :to="{ name: 'admin' }"
                    class="nav-link inline-block text-dark"
                    active-class="active"
                >
                    Admin
                </router-link>
            </div>

            <!-- Authenticated -->
            <user-menu v-if="auth.isAuthenticated" />

            <!-- Guest -->
            <ul v-else>
                <li class="nav-item">
                    <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
                        Login
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{ name: 'register' }" class="nav-link" active-class="active">
                        Register
                    </router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>
