<template>
    <div class="mb-64 Nav" role="navigation">
        <div class="flex items-center w-256">
            <router-link :to="{ name: 'home' }" class="flex items-center" title="View home" role="banner">
                <div class="w-20 h-20 mr-4 adam-logo"></div>
                <span id="Nav_brand-adam">ADAM</span>
                <span id="Nav_brand-mackintosh">MACKINTOSH</span>
            </router-link>
        </div>

        <div class="flex items-center justify-center flex-1">
            <top-nav-link :to="{ name: 'about' }">
                About me
            </top-nav-link>
            <top-nav-link :to="{ name: 'examples' }" class="mx-16">
                Examples
            </top-nav-link>
            <top-nav-link :to="{ name: 'contact' }" class="mx-16">
                Contact
            </top-nav-link>
            <top-nav-link :to="{ name: 'admin' }" class="mx-16">
                Admin
            </top-nav-link>
            <top-nav-link :to="{ name: 'design' }">
                Design
            </top-nav-link>
        </div>

        <div class="flex items-center w-256">
            <!-- https://stackoverflow.com/questions/22735740/how-to-add-badge-on-top-of-font-awesome-symbol -->
            <template v-if="isAuthenticated">
                <b-dropdown id="notifications" aria-role="menu" position="is-bottom-left" class="flex justify-end">
                    <div slot="trigger" class="flex items-center justify-center w-32 h-32 text-orange-400 bg-no-repeat bg-cover rounded-full">
                        <i class="fas fa-bell"></i>
                    </div>

                    <b-dropdown-item
                        v-for="notification in notifications"
                        :key="`notification-${notification.id}`"
                        aria-role="menuitem"
                        custom
                    >
                        <div class="flex w-full w-384">
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

                <b-dropdown aria-role="menu" position="is-bottom-left">
                    <div slot="trigger" class="w-32 h-32 bg-no-repeat bg-cover rounded-full">
                        <img :src="user.photo_url">
                    </div>

                    <b-dropdown-item custom aria-role="menuitem">
                        <span class="whitespace-no-wrap min-w-384">Logged in as <strong>{{ user.name }}</strong></span>
                    </b-dropdown-item>

                    <hr class="m-8 bg-accent">

                    <b-dropdown-item aria-role="listitem" has-link>
                        <router-link :to="{ name: 'profile' }">Profile</router-link>
                    </b-dropdown-item>

                    <b-dropdown-item aria-role="listitem" has-link>
                        <router-link :to="{ name: 'design' }">Design system</router-link>
                    </b-dropdown-item>

                    <b-dropdown-item aria-role="listitem" has-link>
                        <router-link :to="{ name: 'admin' }">Admin</router-link>
                    </b-dropdown-item>

                    <hr class="m-8 bg-accent">

                    <b-dropdown-item aria-role="listitem" @click="logout">
                        Logout
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
        <!-- <Notifications
        notifications={this.props.notifications}
        removeFunc={this.props.removeNotification}
        /> -->
    </div>
</template>

<script>
import TopNavLink from './top-nav-link.vue';

export default {
    name: 'top-nav-bar',

    components: {
        TopNavLink,
    },

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
    color: #339999;
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
    color: #339999; }

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
    color: #339999;
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
    color: #339999;
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
