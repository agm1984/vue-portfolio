<template>
    <button
        v-if="hasClientId"
        :class="buttonStyles"
        type="button"
        @click="login"
    >
        <i :class="iconStyles"></i>

        {{ buttonLabel }}
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

        buttonStyles() {
            const styles = ['h-40 text-white'];

            styles.push(`bg-${this.provider} hover:bg-${this.provider}-hover active:bg-${this.provider}-active`);

            return styles;
        },

        iconStyles() {
            return `fab fa-${this.provider} mr-4`;
        },

        providerName() {
            return window.config[this.provider].provider_name;
        },

        buttonLabel() {
            if (this.$route.name === 'register') return `Register via ${this.providerName}`;
            return `Login via ${this.providerName}`;
        },

        hasIntendedUrl() {
            return (this.$store.getters['auth/intendedUrl'].length > 0);
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
         * Note for PKCE: https://dev.to/stefant123/pkce-authenticaton-for-nuxt-spa-with-laravel-as-backend-170n
         *
         * @param {MessageEvent} e
         * @return {Void}
         */
        onMessage(e) {
            const hasUser = (e.data.user && (Object.keys(e.data.user).length > 0));

            if ((e.origin !== window.origin) || !hasUser) {
                return undefined;
            }

            this.$store.dispatch('auth/updateUser', { user: e.data.user });

            if (this.hasIntendedUrl) {
                return this.$router.push(this.$store.getters['auth/intendedUrl'])
                    .then(() => this.$store.dispatch('auth/clearIntendedUrl'))
                    .catch(() => {});
            }

            return this.$router.push({ name: 'home' }).catch(() => {});
        },

        /**
         * Load the OAuth window.
         *
         * @param {String} url
         * @param {String} title
         * @param {Object} options
         * @return {Window}
         */
        openWindow(url, title, options = {}) {
            if (typeof url === 'object') {
                options = url;
                url = '';
            }

            const dualScreenLeft = (window.screenLeft !== undefined) ? window.screenLeft : window.screen.left;
            const dualScreenTop = (window.screenTop !== undefined) ? window.screenTop : window.screen.top;
            const width = (window.innerWidth || document.documentElement.clientWidth || window.screen.width);
            const height = (window.innerHeight || document.documentElement.clientHeight || window.screen.height);

            options = { url, title, width: 600, height: 720, ...options };
            options.left = (((width / 2) - (options.width / 2)) + dualScreenLeft);
            options.top = (((height / 2) - (options.height / 2)) + dualScreenTop);

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
                throw new Error(`login-with-oauth# Problem authenticating via '${this.provider}': ${err}.`);
            }
        },

    },

};
</script>
