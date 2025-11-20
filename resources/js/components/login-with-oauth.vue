<script setup>
import { computed, onMounted, onUnmounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Button from 'primevue/button';
import { useAuthStore } from '~/store/auth';

const props = defineProps({
    provider: {
        type: String,
        required: true,
    },
});

const route = useRoute();
const router = useRouter();
const auth = useAuthStore();

const hasClientId = computed(() => {
    return window.config[props.provider].client_id;
});

const iconStyles = computed(() => {
    return `pi pi-${props.provider} mr-1`;
});

const providerName = computed(() => {
    return window.config[props.provider].provider_name;
});

const buttonLabel = computed(() => {
    if (route.name === 'register') return `Register via ${providerName.value}`;
    return `Login via ${providerName.value}`;
});

/**
 * Upon successful authentication, `onMessage` will be called by `./resources/views/oauth/callback.blade.php`,
 * so any extra parameters can be added there.
 * Note for PKCE: https://dev.to/stefant123/pkce-authenticaton-for-nuxt-spa-with-laravel-as-backend-170n
 *
 * @param {MessageEvent} e
 * @return {Void}
 */
const onMessage = async (e) => {
    const hasUser = (e.data.user && (Object.keys(e.data.user).length > 0));

    if ((e.origin !== window.origin) || !hasUser) {
        return undefined;
    }

    auth.updateUser(e.data.user);

    await router.push(route.query.redirect ? route.query.redirect : { name: 'home' });
};

/**
 * Load the OAuth window.
 *
 * @param {String} url
 * @param {String} title
 * @param {Object} options
 * @return {Window}
 */
const openWindow = (url, title, options = {}) => {
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
};

/**
 * Initiate register or login via OAuth.
 *
 * @return {Void}
 */
const login = async () => {
    try {
        const newWindow = openWindow('', 'Login');

        const url = await auth.fetchOauthUrl({
            provider: props.provider,
        });

        newWindow.location.href = url;
    } catch (err) {
        throw new Error(`login-with-oauth# Problem authenticating via '${props.provider}': ${err}.`);
    }
};

onMounted(() => {
    return window.addEventListener('message', onMessage, false);
});

onUnmounted(() => {
    return window.removeEventListener('message', onMessage);
});
</script>

<template>
    <Button
        v-if="hasClientId"
        type="button"
        severity="secondary"
        :class="buttonStyles"
        @click="login"
    >
        <i :class="iconStyles"></i>

        {{ buttonLabel }}
    </Button>
</template>
