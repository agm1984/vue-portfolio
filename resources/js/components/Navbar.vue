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
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="w-full flex justify-between">
            <router-link :to="{ name: auth.isLoggedIn ? 'home' : 'home' }" class="navbar-brand">
                {{ appName }}
            </router-link>

            <div>
                <router-link
                    :to="{ name: 'about' }"
                    class="nav-link inline-block mr-4 text-dark"
                    active-class="active"
                >
                    About Me
                </router-link>
            </div>

            <!-- Authenticated -->
            <div v-if="auth.isLoggedIn" class="nav-item dropdown">
                <a
                    class="nav-link dropdown-toggle text-dark"
                    href="#"
                    role="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    <img :src="auth.user.photo_url" class="mr-1 rounded-circle profile-photo">
                    {{ auth.user.name }}
                </a>
                <div>
                    <router-link :to="{ name: 'settings.profile' }" class="pl-3 dropdown-item">
                        <!-- <fa icon="cog" fixed-width /> -->
                        Settings
                    </router-link>

                    <div class="dropdown-divider"></div>
                    <a href="#" class="pl-3 dropdown-item" @click.prevent="logout">
                        <!-- <fa icon="sign-out-alt" fixed-width /> -->
                        Logout
                    </a>
                </div>
            </div>

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
