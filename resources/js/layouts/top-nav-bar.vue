<template>
    <div class="flex flex-row items-center w-full px-16 pt-32 mb-64 lg:px-32 z-1" role="navigation">
        <div class="flex items-center w-256">
            <router-link :to="{ name: 'home' }" title="View home" role="banner">
                <adam-mackintosh-logo></adam-mackintosh-logo>
            </router-link>
        </div>

        <div class="flex flex-col items-center justify-center flex-1 lg:flex-row">
            <top-nav-link :to="{ name: 'about' }">
                About me
            </top-nav-link>
            <top-nav-link :to="{ name: 'public.examples.list' }" class="mt-16 lg:mt-0">
                Examples
            </top-nav-link>
            <top-nav-link :to="{ name: 'contact' }" class="mt-16 lg:mt-0">
                Contact
            </top-nav-link>
        </div>

        <div class="flex items-center justify-end w-256">
            <!-- https://stackoverflow.com/questions/22735740/how-to-add-badge-on-top-of-font-awesome-symbol -->
            <template v-if="isAuthenticated">
                <b-dropdown id="notifications" aria-role="menu" position="is-bottom-left" class="flex justify-end">
                    <div slot="trigger" class="flex items-center justify-center w-32 h-32" @click="hasRead = true">
                        <i
                            :class="['fas fa-bell', {
                                'text-orange-400': !hasRead,
                                'text-grey-400': hasRead,
                            }]"
                        ></i>
                    </div>

                    <b-dropdown-item
                        v-for="notification in notifications"
                        :key="`notification-${notification.id}`"
                        aria-role="menuitem"
                        custom
                    >
                        <div class="flex w-384">
                            <div class="w-32 h-32 bg-no-repeat bg-cover rounded-full border-1 border-primary">
                                <img :src="user.photo_url">
                            </div>

                            <div class="flex-1 text-sm">
                                {{ notification.title }}
                            </div>

                            <div class="w-64">
                                {{ notification.created_at }}
                            </div>
                        </div>
                    </b-dropdown-item>
                </b-dropdown>

                <b-dropdown aria-role="menu" position="is-bottom-left">
                    <div slot="trigger" class="w-32 h-32 bg-no-repeat bg-cover rounded-full">
                        <a-avatar :user="user"></a-avatar>
                    </div>

                    <b-dropdown-item custom aria-role="menuitem">
                        <span class="text-sm font-bold whitespace-no-wrap min-w-384">
                            {{ user.name }}
                        </span>
                    </b-dropdown-item>

                    <hr class="mx-8 mb-8 bg-accent">

                    <b-dropdown-item aria-role="listitem" has-link>
                        <router-link :to="{ name: 'settings.profile' }">
                            <span class="text-base font-bold">Profile</span>
                        </router-link>
                    </b-dropdown-item>

                    <b-dropdown-item aria-role="listitem" has-link>
                        <router-link :to="{ name: 'design' }">
                            <span class="text-base font-bold">Design system</span>
                        </router-link>
                    </b-dropdown-item>

                    <b-dropdown-item aria-role="listitem" has-link>
                        <router-link :to="{ name: 'admin' }">
                            <span class="text-base font-bold">Admin</span>
                        </router-link>
                    </b-dropdown-item>

                    <hr class="m-8 bg-accent">

                    <b-dropdown-item aria-role="listitem" @click="logout">
                        <span class="text-base font-bold">Logout</span>
                    </b-dropdown-item>
                </b-dropdown>
            </template>

            <div v-else class="flex items-center">
                <top-nav-link :to="{ name: 'register' }">
                    Register
                </top-nav-link>
                <top-nav-link :to="{ name: 'login' }" class="ml-16">
                    Login
                </top-nav-link>
            </div>

        </div>
    </div>
</template>

<script>
import AdamMackintoshLogo from './adam-mackintosh-logo.vue';
import TopNavLink from './top-nav-link.vue';

export default {
    name: 'top-nav-bar',

    components: {
        AdamMackintoshLogo,
        TopNavLink,
    },

    props: {},

    data() {
        return {
            hasRead: false,
            notifications: [
                { id: 1, title: 'You\'ve reached level 2!', created_at: '2020-05-10 23:47:04', updated_at: '2020-05-10 23:47:04' },
                { id: 2, title: 'You unlocked a new section: Design System.', created_at: '2020-05-10 23:47:04', updated_at: '2020-05-10 23:47:04' },
                { id: 3, title: 'You performed a rare action!', created_at: '2020-05-10 23:47:04', updated_at: '2020-05-10 23:47:04' },
                { id: 4, title: 'Achievement unlocked! You cleared out your notifications tray', created_at: '2020-05-10 23:47:04', updated_at: '2020-05-10 23:47:04' },
            ],
        };
    },

    computed: {
        isAuthenticated() {
            return this.$store.getters['auth/check'];
        },

        user() {
            return this.$store.getters['auth/user'];
        },
    },

    mounted() {},

    methods: {
        async logout() {
            try {
                await this.$store.dispatch('auth/logout');

                return this.$router.go(0);
            } catch (err) {
                throw new Error(`top-nav-bar# Problem logging user out: ${err}.`);
            }
        },

    },

};
</script>
