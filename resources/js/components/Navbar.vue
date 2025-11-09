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
    <nav class="sticky top-0 z-10 bg-white">
        <div class="w-full flex justify-between">
            <router-link :to="{ name: auth.isAuthenticated ? 'home' : 'home' }" class="navbar-brand">
                {{ appName }}
            </router-link>

            <div>
                <router-link
                    :to="{ name: 'about' }"
                    class="nav-link inline-block text-dark"
                    active-class="active"
                >
                    About Me
                </router-link>

                <router-link
                    :to="{ name: 'skills' }"
                    class="nav-link inline-block ml-4 text-dark"
                    active-class="active"
                >
                    Skills
                </router-link>

                <router-link
                    :to="{ name: 'public.examples.list' }"
                    class="nav-link inline-block ml-4 text-dark"
                    active-class="active"
                >
                    Examples
                </router-link>
            </div>

            <!-- Authenticated -->
            <ul v-if="auth.isAuthenticated" class="flex flex-col">
                <li class="min-w-8 max-w-8 min-h-8 max-h-8 flex">
                    <img :src="auth.user.avatar_url" class="object-cover rounded-full" alt="User avatar">
                    <span class="">{{ auth.user.name }}</span>
                </li>

                <li>
                    <router-link :to="{ name: 'settings.profile' }" class="">
                        <!-- <fa icon="cog" fixed-width /> -->
                        Settings
                    </router-link>
                </li>

                <li>
                    <a href="#" class="" @click.prevent="logout">
                        <!-- <fa icon="sign-out-alt" fixed-width /> -->
                        Logout
                    </a>
                </li>
            </ul>

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

<style scoped>
  .profile-photo {
      width: 2rem;
      height: 2rem;
      margin: -.375rem 0;
  }
</style>
