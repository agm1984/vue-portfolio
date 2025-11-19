<script setup>
import { computed } from 'vue';
import Message from 'primevue/message';

const props = defineProps({
    metrics: {
        type: Object,
        required: true,
    },
});

const getSystemStatus = (failedJobs) => {
    if (failedJobs === 0) {
        return { severity: 'success', icon: 'pi pi-check-circle', text: 'All Systems Operational' };
    }
    if (failedJobs < 5) {
        return { severity: 'warn', icon: 'pi pi-exclamation-triangle', text: 'Minor Queue Issues Detected' };
    }
    return { severity: 'error', icon: 'pi pi-times-circle', text: 'Critical: Queue Failures Detected' };
};

const systemStatus = computed(() => getSystemStatus(props.metrics.activity.failed_jobs));
</script>

<template>
    <Message :severity="systemStatus.severity" :closable="false" class="w-full shadow-sm mb-6" :icon="systemStatus.icon">
        <div class="flex flex-col sm:flex-row sm:items-center gap-2">
            <span class="font-bold text-lg">{{ systemStatus.text }}</span>
            <span v-if="metrics.activity.failed_jobs > 0" class="text-sm opacity-90">
                ({{ metrics.activity.failed_jobs }} failed jobs pending retry)
            </span>
            <span v-else class="text-sm opacity-90 ml-2">
                - Queue workers are processing normally.
            </span>
        </div>
    </Message>
</template>