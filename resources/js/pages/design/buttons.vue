<script setup>
import { ref, computed } from 'vue';
import { useHead } from '@unhead/vue';
import Button from 'primevue/button';

useHead({
    title: 'Design System Buttons',
});

const label = ref('Click Me');
const selectedSeverity = ref(null); // null = primary default
const selectedSize = ref(null);
const isOutlined = ref(false);
const isRounded = ref(false);
const isText = ref(false);
const isLoading = ref(false);
const isDisabled = ref(false);
const iconOption = ref('none'); // none, left, right

const severities = [
    { label: 'Primary', value: null },
    { label: 'Secondary', value: 'secondary' },
    { label: 'Success', value: 'success' },
    { label: 'Info', value: 'info' },
    { label: 'Warn', value: 'warn' },
    { label: 'Help', value: 'help' },
    { label: 'Danger', value: 'danger' },
    { label: 'Contrast', value: 'contrast' },
];

const sizes = [
    { label: 'Small', value: 'small' },
    { label: 'Normal', value: null },
    { label: 'Large', value: 'large' },
];

const generatedCode = computed(() => {
    const props = [];

    if (label.value) props.push(`label="${label.value}"`);
    if (selectedSeverity.value) props.push(`severity="${selectedSeverity.value}"`);
    if (isOutlined.value) props.push('outlined');
    if (isText.value) props.push('text');
    if (isRounded.value) props.push('rounded');
    if (selectedSize.value) props.push(`size="${selectedSize.value}"`);
    if (isLoading.value) props.push('loading');
    if (isDisabled.value) props.push('disabled');

    if (iconOption.value === 'left') props.push('icon="pi pi-check"');
    if (iconOption.value === 'right') props.push('icon="pi pi-arrow-right" iconPos="right"');

    return `<Button ${props.join(' ')} />`;
});
</script>

<template>
    <div class="flex-1 flex flex-col gap-8 transition-colors duration-300">
        <div class="">
            <div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-6">
                <div>
                    <h2 class="text-gray-900 dark:text-white">Buttons</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Configure props to generate your button code.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-7 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl flex items-center justify-center min-h-[200px] relative overflow-hidden transition-colors duration-300">
                    <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.1]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 20px 20px;"></div>
                    <div class="absolute inset-0 opacity-[0] dark:opacity-[0.1]" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>

                    <Button
                        :label="label"
                        :severity="selectedSeverity"
                        :outlined="isOutlined"
                        :rounded="isRounded"
                        :text="isText"
                        :size="selectedSize"
                        :loading="isLoading"
                        :disabled="isDisabled"
                        :icon="iconOption === 'left' ? 'pi pi-check' : (iconOption === 'right' ? 'pi pi-arrow-right' : null)"
                        :iconPos="iconOption === 'right' ? 'right' : 'left'"
                    />
                </div>

                <div class="lg:col-span-5 space-y-6">
                    <div>
                        <h6 class="text-gray-900 dark:text-white">Style</h6>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <Button label="Rounded" :severity="isRounded ? 'primary' : 'secondary'" @click="isRounded = !isRounded" size="small" />
                            <Button label="Outlined" :severity="isOutlined ? 'primary' : 'secondary'" @click="isOutlined = !isOutlined; isText = false" size="small" />
                            <Button label="Text" :severity="isText ? 'primary' : 'secondary'" @click="isText = !isText; isOutlined = false" size="small" />
                        </div>
                    </div>

                    <div>
                        <h6 class="text-gray-900 dark:text-white">State</h6>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <Button label="Loading" :severity="isLoading ? 'primary' : 'secondary'" @click="isLoading = !isLoading" size="small" />
                            <Button label="Disabled" :severity="isDisabled ? 'primary' : 'secondary'" @click="isDisabled = !isDisabled" size="small" />
                        </div>
                    </div>

                    <div>
                        <h6 class="text-gray-900 dark:text-white">Size</h6>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <Button
                                v-for="size in sizes"
                                :key="size.label"
                                :severity="selectedSize === size.value ? 'primary' : 'secondary'"
                                :label="size.label"
                                @click="selectedSize = size.value"
                                size="small"
                            />
                        </div>
                    </div>

                    <div>
                        <h6 class="text-gray-900 dark:text-white">Severity</h6>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <button
                                v-for="sev in severities"
                                :key="sev.label"
                                type="button"
                                @click="selectedSeverity = sev.value"
                                class="w-6 h-6 rounded-full border-2 transition-transform hover:scale-110 focus:outline-none"
                                :class="[
                                    selectedSeverity === sev.value ? 'ring-2 ring-offset-2 ring-gray-400 dark:ring-gray-500 scale-110' : 'border-transparent',
                                    sev.value === null ? 'bg-indigo-600' : 
                                    sev.value === 'secondary' ? 'bg-gray-500' :
                                    sev.value === 'success' ? 'bg-green-500' :
                                    sev.value === 'info' ? 'bg-blue-500' :
                                    sev.value === 'warn' ? 'bg-orange-500' :
                                    sev.value === 'help' ? 'bg-purple-500' :
                                    sev.value === 'danger' ? 'bg-red-500' :
                                    'bg-black dark:bg-white' // Contrast swaps in dark mode
                                ]"
                                :title="sev.label"
                            ></button>
                            <span class="text-sm text-gray-600 dark:text-gray-400 ml-2 self-center">{{ severities.find(s => s.value === selectedSeverity)?.label }}</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-8">
                <a-code
                    language="html"
                    :code="generatedCode"
                />
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 transition-colors duration-300">
            <div class="mb-6">
                <h2 class="text-gray-900 dark:text-white">Semantic Palette</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Standard communication colors used across the application.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-4">
                    <h3 class="text-gray-900 dark:text-white">Actions</h3>
                    <div class="flex flex-col gap-3 items-start">
                        <Button label="Primary Action" class="w-full" />
                        <Button label="Secondary Action" severity="secondary" class="w-full" />
                        <Button label="Outline" outlined class="w-full" />
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-gray-900 dark:text-white">Feedback</h3>
                    <div class="flex flex-col gap-3 items-start">
                        <Button label="Confirm Success" severity="success" icon="pi pi-check" class="w-full" />
                        <Button label="Delete Item" severity="danger" icon="pi pi-trash" class="w-full" />
                        <Button label="Alert Warning" severity="warn" icon="pi pi-exclamation-triangle" class="w-full" />
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-gray-900 dark:text-white">Information</h3>
                    <div class="flex flex-col gap-3 items-start">
                        <Button label="View Details" severity="info" icon="pi pi-info-circle" outlined class="w-full" />
                        <Button label="Documentation" severity="help" icon="pi pi-book" text class="w-full" />
                        <Button label="Download" severity="contrast" icon="pi pi-download" class="w-full" />
                    </div>
                </div>
            </div>

            <p class="mt-8 text-sm text-gray-500 dark:text-gray-400">
                For advanced usage, configuration, and pass-through props, refer to the
                <a class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline" href="https://primevue.org/button/" target="_blank">PrimeVue Button Documentation</a>.
            </p>
        </div>
    </div>
</template>
