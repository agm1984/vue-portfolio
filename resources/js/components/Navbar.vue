<template>
    <nav class="bg-white navbar navbar-expand-lg navbar-light">
        <div class="container">
            <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
                {{ appName }}
            </router-link>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="navbarToggler" class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <!-- <locale-dropdown /> -->
                    <!-- <li class="nav-item">
                      <a class="nav-link" href="#">Link</a>
                    </li> -->
                </ul>

                <div class="ml-auto navbar-nav">
                    <!-- Authenticated -->
                    <div v-if="user" class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle text-dark"
                            href="#"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            <img :src="user.photo_url" class="mr-1 rounded-circle profile-photo">
                            {{ user.name }}
                        </a>
                        <div class="ok">
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
                    <template v-else>
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
                    </template>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    data: () => ({
        appName: window.config.appName,
    }),
    computed: mapGetters({
        user: 'auth/user',
    }),
    methods: {
        async logout() {
            // Log out the user.
            await this.$store.dispatch('auth/logout');
            // Redirect to login.
            this.$router.push({ name: 'login' });
        },
    },
};
</script>

<style scoped>
  .profile-photo {
      width: 2rem;
      height: 2rem;
      margin: -.375rem 0;
  }
</style>
