<template>
    <button v-if="hasClientId" class="ml-auto btn btn-dark" type="button" @click="login">
        {{ actionLabel }} {{ providerName }}
        <!-- <fa :icon="['fab', 'github']" /> -->
    </button>
</template>

<script>
export default {
    name: 'login-with-oauth',

    props: {
        provider: {
            type: String,
            required: true,
        },

        intendedUrl: {
            type: String,
            required: false,
            default: () => '',
        },

    },

    computed: {
        hasClientId() {
            return window.config[this.provider].client_id;
        },

        url() {
            return route('oauth.redirect', this.provider);
        },

        actionLabel() {
            if (this.$route.name === 'register') return 'Register using';
            return 'Login with';
        },

        providerName() {
            return window.config[this.provider].provider_name;
        },

    },

    mounted() {
        return window.addEventListener('message', this.onMessage, false);
    },

    beforeDestroy() {
        return window.removeEventListener('message', this.onMessage);
    },

    methods: {
        /**
         * Upon successful authentication, `onMessage` will be called by `./resources/views/oauth/callback.blade.php`,
         * so any extra parameters can be added there.
         *
         * @param {MessageEvent} e
         * @return {Void}
         */
        onMessage(e) {
            if ((e.origin !== window.origin) || !e.data.token) {
                return undefined;
            }

            this.$store.dispatch('auth/saveToken', {
                token: e.data.token,
            });

            if (this.intendedUrl) {
                return this.$router.push(this.intendedUrl);
            }

            return this.$router.push({ name: 'home' });
        },

        /**
         * Load the OAuth window.
         *
         * @param {Object} options
         * @return {Window}
         */
        openWindow(url, title, options = {}) {
            if (typeof url === 'object') {
                options = url;
                url = '';
            }

            options = { url, title, width: 600, height: 720, ...options };
            const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screen.left;
            const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screen.top;
            const width = window.innerWidth || document.documentElement.clientWidth || window.screen.width;
            const height = window.innerHeight || document.documentElement.clientHeight || window.screen.height;
            options.left = ((width / 2) - (options.width / 2)) + dualScreenLeft;
            options.top = ((height / 2) - (options.height / 2)) + dualScreenTop;

            const optionsStr = Object.keys(options).reduce((acc, key) => {
                acc.push(`${key}=${options[key]}`);
                return acc;
            }, []).join(',');

            const newWindow = window.open(url, title, optionsStr);

            if (window.focus) {
                newWindow.focus();
            }

            return newWindow;
        },

        /**
         * Initiate register or login via OAuth.
         *
         * @return {Void}
         */
        async login() {
            try {
                const newWindow = this.openWindow('', 'Login');

                const url = await this.$store.dispatch('auth/fetchOauthUrl', {
                    provider: this.provider,
                });

                newWindow.location.href = url;
            } catch (err) {
                throw new Error(`login-with-oauth# Problem logging in via OAuth through '${this.provider}': ${err}.`);
            }
        },

    },

};
</script>
