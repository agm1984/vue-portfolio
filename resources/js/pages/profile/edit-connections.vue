<script setup>
import { ref, onMounted, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { useConfirm } from 'primevue/useconfirm';
import Message from 'primevue/message';
import Button from 'primevue/button';
import Skeleton from 'primevue/skeleton';

useHead({
    title: 'OAuth Connections',
});

const confirm = useConfirm();

const linkedProviders = ref([]);
const loading = ref(true);

const availableProviders = ['github', 'twitter'];

const getProviderStyle = (provider) => {
    const map = {
        github: 'text-gray-900 dark:text-white',
        twitter: 'text-blue-400',
    };
    return map[provider] || 'text-gray-500';
};

const isProviderLinked = (provider) => {
    return linkedProviders.value.some(p => p.provider === provider);
};

const hasAnyLinkedProvider = computed(() => {
    return linkedProviders.value.length > 0;
});

const providerInfo = computed(() => {
    return availableProviders.map(provider => ({
        name: provider,
        displayName: window.config[provider]?.provider_name || provider,
        isLinked: isProviderLinked(provider),
        linkedAt: linkedProviders.value.find(p => p.provider === provider)?.created_at,
        isDisabled: hasAnyLinkedProvider.value && !isProviderLinked(provider),
    }));
});

const fetchLinkedProviders = async () => {
    try {
        loading.value = true;
        const { data } = await api.get(route('user.oauth.providers'));
        linkedProviders.value = data;
    } catch (error) {
        console.error('Error fetching linked providers:', error);
    } finally {
        loading.value = false;
    }
};

const unlinkProvider = async (provider) => {
    confirm.require({
        message: `Are you sure you want to unlink your ${window.config[provider]?.provider_name || provider} account?`,
        header: 'Unlink Account',
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Delete'
        },
        accept: async () => {
             try {
                loading.value = true;
                await api.delete(route('oauth.unlink', { driver: provider }));
                await fetchLinkedProviders();
            } catch (error) {
                console.error('Error unlinking provider:', error);
                alert(error.response?.data?.error || 'An error occurred while unlinking the provider.');
            } finally {
                loading.value = false;
            }
        },
        reject: () => {}
    });
};

const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};

onMounted(fetchLinkedProviders);
</script>

<template>
    <div>
        <Message severity="info" :closable="false" class="mb-4">
            Link an account to enable one-click login.
        </Message>

        <div v-if="loading" class="space-y-4">
            <div v-for="i in 2" :key="`loading-loader-${i}`" class="flex items-center justify-between p-4 border rounded-xl dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <Skeleton shape="circle" size="3rem" />
                    <div>
                        <Skeleton width="8rem" class="mb-2" />
                        <Skeleton width="5rem" height="0.8rem" />
                    </div>
                </div>
                <Skeleton width="6rem" height="2rem" borderRadius="2rem" />
            </div>
        </div>

        <div v-else class="flex flex-col gap-4">
            <div
                v-for="provider in providerInfo"
                :key="provider.name"
                class="group flex flex-col md:flex-row items-start md:items-center justify-between gap-4 p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-gray-300 dark:hover:border-gray-600 transition-all duration-200"
            >
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="w-12 h-12 rounded-full bg-gray-50 dark:bg-gray-700/50 flex items-center justify-center transition-colors shrink-0">
                        <i :class="[`pi pi-${provider.name} text-xl`, getProviderStyle(provider.name)]"></i>
                    </div>

                    <div class="min-w-0">
                        <h4 class="font-bold text-gray-900 dark:text-white capitalize truncate">
                            {{ provider.displayName }}
                        </h4>
                        <p v-if="provider.isLinked" class="text-xs text-green-600 dark:text-green-400 font-medium flex items-center gap-1">
                            <i class="pi pi-check-circle text-xs"></i>
                            Linked on {{ formatDate(provider.linkedAt) }}
                        </p>
                        <p v-else class="text-xs text-gray-500 dark:text-gray-400">
                            Not connected
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-end w-full md:w-auto">
                    <div v-if="provider.isLinked" class="flex items-center gap-2">
                        <span class="hidden sm:inline-flex px-3 py-1 rounded-full bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 text-xs font-bold uppercase tracking-wide border border-green-100 dark:border-green-800">
                            Active
                        </span>

                        <Button
                            v-tooltip.bottom="'Unlink Account'"
                            type="button"
                            severity="danger"
                            icon="pi pi-trash"
                            text
                            rounded
                            aria-label="Unlink"
                            @click="unlinkProvider(provider.name)"
                        />
                    </div>

                    <link-oauth-provider
                        v-else
                        :provider="provider.name"
                        :is-linked="provider.isLinked"
                        :disabled="provider.isDisabled"
                        @linked="fetchLinkedProviders"
                    ></link-oauth-provider>
                </div>
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-gray-300 dark:border-gray-700">
            <div class="flex gap-3 text-sm text-gray-600 dark:text-gray-400 bg-orange-50 dark:bg-orange-900/10 p-4 rounded-lg border border-orange-100 dark:border-orange-900/30">
                <i class="pi pi-exclamation-triangle text-orange-500 mt-0.5"></i>
                <p>
                    <strong class="text-orange-700 dark:text-orange-400">Security Note:</strong>
                    If you have no password set, ensure you keep at least one provider connected to maintain access to your account.
                </p>
            </div>
        </div>
    </div>
</template>
