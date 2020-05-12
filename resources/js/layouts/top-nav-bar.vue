<template>
    <div class="Nav" role="navigation">
        <div class="flex items-center flex-0">
            <router-link :to="{ name: 'home' }" class="flex items-center" title="View home" role="banner">
                <div class="w-20 h-20 mr-4 adam-logo"></div>
                <span id="Nav_brand-adam">ADAM</span>
                <span id="Nav_brand-mackintosh">MACKINTOSH</span>
            </router-link>
        </div>

        <div class="flex items-center justify-center flex-1">
            <router-link :to="{ name: 'about' }" class="nav-link-white">About me</router-link>
            <router-link :to="{ name: 'examples' }" class="ml-16 nav-link-white">Examples</router-link>
            <router-link :to="{ name: 'contact' }" class="ml-16 nav-link-white">Contact</router-link>
            <router-link :to="{ name: 'admin' }" class="ml-16 nav-link-white">Admin</router-link>
            <router-link :to="{ name: 'design' }" class="ml-16 nav-link-white">Design</router-link>
        </div>

        <div class="flex items-center flex-0">
            <template v-if="isAuthenticated">
                <b-dropdown aria-role="menu" position="is-bottom-left" class="flex justify-end min-w-320">
                    <div slot="trigger" class="flex items-center justify-center w-32 h-32 text-orange-400 bg-no-repeat bg-cover rounded-full">
                        BELL
                    </div>

                    <b-dropdown-item
                        v-for="notification in notifications"
                        :key="`notification-${notification.id}`"
                        aria-role="menuitem"
                        custom
                    >
                        <div class="flex w-full">
                            <div class="w-32 h-32 bg-no-repeat bg-cover rounded-full">
                                <img :src="user.photo_url">
                            </div>

                            <div class="flex-1">
                                {{ notification.title }}
                            </div>

                            <div class="w-64">
                                {{ notification.created_at }}
                            </div>
                        </div>
                    </b-dropdown-item>
                </b-dropdown>

                <b-dropdown aria-role="menu">
                    <div slot="trigger" class="w-32 h-32 bg-no-repeat bg-cover rounded-full">
                        <img :src="user.photo_url">
                    </div>

                    <b-dropdown-item custom aria-role="menuitem">
                        Logged as <b>{{ user.name }}</b>
                    </b-dropdown-item>

                    <b-dropdown-item aria-role="listitem" has-link>
                        <router-link :to="{ name: 'profile' }">Profile</router-link>
                    </b-dropdown-item>

                    <b-dropdown-item aria-role="listitem" has-link>
                        <router-link :to="{ name: 'design' }">Design system</router-link>
                    </b-dropdown-item>

                    <b-dropdown-item aria-role="listitem" has-link>
                        <router-link :to="{ name: 'admin' }">Admin</router-link>
                    </b-dropdown-item>

                    <b-dropdown-item aria-role="listitem" @click="logout">
                        Logout
                    </b-dropdown-item>
                </b-dropdown>
            </template>

            <div v-else class="flex items-center">
                <router-link :to="{ name: 'register' }" class="nav-link-white">
                    Register
                </router-link>
                <router-link :to="{ name: 'login' }" class="ml-16 nav-link-white">
                    Login
                </router-link>
            </div>

        </div>
        <!-- <Notifications
        notifications={this.props.notifications}
        removeFunc={this.props.removeNotification}
        /> -->
    </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
    name: 'top-nav-bar',

    props: {},

    data() {
        return {
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

        ...mapState('auth', ['user']),
    },

    mounted() {},

    methods: {
        async logout() {
            try {
                await this.$store.dispatch('auth/logout');

                return this.$router.push({ name: 'login' });
            } catch (err) {
                throw new Error(`top-nav-bar# Problem logging user out: ${err}.`);
            }
        },
    },

};
</script>

<style>
    .Nav {
    /* position: fixed;
    top: 0; */
    display: flex;
    flex-direction: row;
    align-content: center;
    width: 100%;
    z-index: 1; }

    .isScrolling {
    background: rgba(0, 0, 0, 0.85); }

    #Nav_brand {
    flex: 0;
    width: 19.2rem;
    padding: 3.2rem 9.6rem 3.2rem 3.2rem; }

    .Nav_brand-skillsPageOnly {
    margin-left: 6.4rem; }

    .Nav_brand-logo:link {
    display: flex;
    flex-direction: row;
    align-items: center;
    color: #fff;
    text-decoration: none;
    white-space: nowrap;
    cursor: pointer;
    transition: all 250ms ease-in-out; }

    .Nav_brand-logo:visited {
    color: #fff;
    transition: all 250ms ease-in-out; }

    .Nav_brand-logo:hover {
    color: #66FCF1; }

    .Nav_brand-logo:active {
    color: #45A29E;
    font-size: 2.0rem; }

    #Nav_brand-adam {
    font-family: 'Oswald', sans-serif;
    font-weight: 200;
    font-size: 2.0rem;
    line-height: 2.0rem;
    letter-spacing: 0.001em;
    color: #fff; }

    #Nav_brand-mackintosh {
    font-family: 'Oswald', sans-serif;
    font-weight: 400;
    font-size: 2.0rem;
    line-height: 2.0rem;
    letter-spacing: 0.001em;
    color: #45A29E; }

    #Nav_pages {
    flex: 1;
    display: flex;
    flex-direction: row;
    align-content: center;
    justify-content: center;
    max-width: 100%;
    transition: all 250ms ease-in-out; }

    .Nav_link:link {
    display: flex;
    flex-direction: row;
    align-content: center;
    justify-content: center;
    color: #fff;
    padding: 3.2rem 1.6rem 0 1.6rem;
    font-family: 'AROLY', sans-serif;
    font-size: 1.6rem;
    line-height: 1.6rem;
    letter-spacing: 0.1em;
    text-decoration: none;
    transition: all 250ms ease-in-out; }

    .Nav_link:visited {
    color: #fff;
    transition: all 250ms ease-in-out; }

    .Nav_link:hover {
    color: #66FCF1; }

    .Nav_link:active {
    color: #45A29E;
    font-size: 2.0rem; }

    .activeRoute {
    cursor: default; }

    .Nav_link-isContact:link {
    display: flex;
    flex-direction: row;
    align-content: center;
    justify-content: center;
    color: #F7C53E;
    padding: 3.2rem 1.6rem 0 1.6rem;
    font-family: 'AROLY', sans-serif;
    font-size: 1.6rem;
    line-height: 1.6rem;
    letter-spacing: 0.1em;
    text-decoration: none;
    transition: all 250ms ease-in-out; }

    .Nav_link-isContact:visited {
    color: #F7C53E;
    transition: all 250ms ease-in-out; }

    .Nav_link-isContact:hover {
    color: #FF5043; }

    .Nav_link-isContact:active {
    color: #45A29E;
    font-size: 2.0rem; }

    .isScrolling .activeRoute {
    border-bottom: 0.4rem solid #fff; }

    @media (max-width: 1024px) {
    .Nav {
    position: absolute;
    flex-direction: column;
    align-items: center;
    padding-bottom: 3.2rem; }
    .isScrolling {
    background: none; }
    #Nav_brand {
    width: auto;
    padding: 3.2rem 0 0 0; }
    .Nav_brand-skillsPageOnly {
    display: none; }
    #Nav_social {
    padding: 3.2rem 0 0 0;
    display: flex;
    justify-content: center; }
    .Nav_icon {
    padding: 0 1.6rem 0 1.6rem; }
    .isScrolling .activeRoute {
    border-bottom: none; } }

    @media (max-width: 600px) {
    #Nav_pages {
    width: 400px;
    flex-wrap: wrap; } }
</style>
