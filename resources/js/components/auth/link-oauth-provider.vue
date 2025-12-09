<script setup>
import { computed, onMounted, onUnmounted } from 'vue';
import Button from 'primevue/button';
import { useAuthStore } from '~/store/auth';
import { openWindow } from '~/utils/oauth';
import { api } from '~/services/api';

const props = defineProps({
    provider: {
        type: String,
        required: true,
    },
    isLinked: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['linked']);

const auth = useAuthStore();

const hasClientId = computed(() => {
    return window.config[props.provider]?.client_id;
});

const iconStyles = computed(() => {
    return `pi pi-${props.provider} mr-1`;
});

const providerName = computed(() => {
    return window.config[props.provider]?.provider_name || props.provider;
});

const buttonLabel = computed(() => {
    if (props.isLinked) return `Connected`;
    return `Link ${providerName.value.replace('Twitter', 'X')}`;
});

/**
 * Upon successful authentication, `onMessage` will be called by `./resources/views/oauth/callback.blade.php`.
 *
 * @param {MessageEvent} e
 * @return {Void}
 */
const onMessage = async (e) => {
    const hasUser = (e.data.user && (Object.keys(e.data.user).length > 0));
    const isLinked = e.data.linked;

    if ((e.origin !== window.origin) || !hasUser) {
        return undefined;
    }

    auth.updateUser(e.data.user);

    if (isLinked) {
        emit('linked', props.provider);
    }
};

/**
 * Initiate linking via OAuth.
 *
 * @return {Void}
 */
const linkProvider = async () => {
    try {
        const newWindow = openWindow('', `Link ${providerName.value}`);

        const { data } = await api.post(route('oauth.link', { driver: props.provider }));

        newWindow.location.href = data.url;
    } catch (err) {
        console.error(`link-oauth-provider# Problem linking '${props.provider}': ${err}.`);
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
        :severity="isLinked ? 'success' : 'secondary'"
        :disabled="isLinked || disabled"
        @click="linkProvider"
    >
        <i :class="iconStyles"></i>

        {{ buttonLabel }}
    </Button>
</template>
