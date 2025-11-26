<script setup>
import { ref } from 'vue';
import { useHead } from '@unhead/vue';
import { useRouter } from 'vue-router';
import { useToast } from 'primevue/usetoast';
import Button from 'primevue/button';
import Message from 'primevue/message';
import InputText from 'primevue/inputtext';
import Divider from 'primevue/divider';
import Avatar from 'primevue/avatar'; // Using PrimeVue Avatar for the custom slot example

useHead({
    title: 'Design System Feedback',
});

const router = useRouter();
const toast = useToast();

const customDetail = ref('Operation completed successfully.');

const severities = [
    { label: 'Success', value: 'success', icon: 'pi pi-check' },
    { label: 'Info', value: 'info', icon: 'pi pi-info-circle' },
    { label: 'Warn', value: 'warn', icon: 'pi pi-exclamation-triangle' },
    { label: 'Error', value: 'error', icon: 'pi pi-times' },
    { label: 'Secondary', value: 'secondary', icon: 'pi pi-comment' },
    { label: 'Contrast', value: 'contrast', icon: 'pi pi-star' },
];

const triggerToast = (severity) => {
    toast.add({
        severity: severity.value,
        summary: severity.label,
        detail: customDetail.value,
        life: 5000,
    });
};

const messageExamples = [
    { severity: 'success', content: 'Your changes have been saved.' },
    { severity: 'info', content: 'A new software update is available.' },
    { severity: 'warn', content: 'Your session will expire in 5 minutes.' },
    { severity: 'error', content: 'Failed to connect to the database.' },
];

const goBack = () => router.push({ name: 'design' });
</script>

<template>
    <div class="w-full flex flex-col transition-colors duration-300">
        <a-page-title
            title="Feedback & Alerts"
            description="Components used to communicate status, errors, and successful actions to the user."
            has-back
            @on-back="goBack"
        ></a-page-title>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 transition-colors duration-300">
            <h3 class="text-gray-900 dark:text-white">Toast Notifications</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-normal mt-1">
                Ephemeral messages that appear in the top-right corner. Managed via <code>useToast()</code>.
            </p>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mt-4">
                <div class="lg:col-span-5 space-y-6">
                    <div class="space-y-2">
                        <h6 class="text-gray-900 dark:text-white">Message Content</h6>
                        <InputText v-model="customDetail" class="w-full" placeholder="Type a message..." />
                    </div>

                    <div class="space-y-2">
                        <h6 class="text-gray-900 dark:text-white">Trigger Severity</h6>
                        <div class="grid grid-cols-2 gap-3">
                            <Button
                                v-for="sev in severities"
                                :key="sev.value"
                                :label="sev.label"
                                :severity="sev.value"
                                :icon="sev.icon"
                                size="small"
                                @click="triggerToast(sev)"
                            />
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7 bg-gray-900 rounded-xl p-6 flex flex-col justify-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-50 pointer-events-none">
                        <i class="pi pi-bell text-4xl text-gray-700"></i>
                    </div>

                    <h3 class="text-gray-300! mb-2 text-sm font-bold uppercase tracking-wider">Usage Example</h3>
                    <a-code
                        language="html"
                        :code="`import { useToast } from 'primevue/usetoast';\n\nconst toast = useToast();\n\ntoast.add({\n    severity: 'success',\n    summary: 'Success',\n    detail: '${customDetail}',\n    life: 5000\n});`"
                    />
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 h-full transition-colors duration-300">
                <h3 class="text-gray-900 dark:text-white">Inline Alerts</h3>

                <div class="space-y-4 mt-2">
                    <Message
                        v-for="msg in messageExamples"
                        :key="msg.severity"
                        :severity="msg.severity"
                        closable
                    >
                        {{ msg.content }}
                    </Message>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 h-full transition-colors duration-300">
                <h3 class="text-gray-900 dark:text-white">Field Feedback</h3>
                <div class="space-y-6 mt-2">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Use <code>variant="simple"</code> for validation text below inputs.
                    </p>

                    <div class="space-y-1">
                        <InputText invalid placeholder="Invalid input..." class="w-full" />
                        <Message severity="error" size="small" variant="simple">Username is already taken.</Message>
                    </div>

                    <div class="space-y-1">
                        <InputText placeholder="Valid input..." class="w-full" />
                        <Message severity="secondary" size="small" variant="simple">Password must be 8 characters.</Message>
                    </div>

                    <Divider />

                    <div>
                        <Message severity="warn">
                            <div class="flex items-center gap-2">
                                <Avatar
                                    size="small"
                                    class="bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 font-bold"
                                    label="!"
                                />
                                <span class="font-bold text-gray-900 dark:text-white">Custom Slot Content</span>
                            </div>
                            <div class="ml-8 mt-1 text-sm text-gray-700 dark:text-gray-300">
                                You can pass any HTML into the default slot.
                            </div>
                        </Message>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
