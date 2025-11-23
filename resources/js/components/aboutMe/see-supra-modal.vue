<script setup>
import Dialog from 'primevue/dialog';

const emit = defineEmits([
    'close',
]);

const closeModal = () => {
    emit('close');
};
</script>

<template>
    <Dialog
        visible
        modal
        :breakpoints="{ '768px': 'calc(100vw - 32px)' }"
        :style="{ width: '1024px' }"
        @update:visible="closeModal"
    >
        <template #header>
            <div class="flex items-center gap-2">
                <i class="pi pi-car" style="font-size: 24px;"></i>
                <h3>1993 Toyota Supra 6-speed Hardtop</h3>
            </div>
        </template>

        <div>
            <img class="w-full h-full object-cover rounded-lg aspect-video border" src="/supra1.jpg" alt="1993 Toyota Supra">
        </div>
    </Dialog>
</template>
