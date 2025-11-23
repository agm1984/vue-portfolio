<script setup>
import { useHead } from '@unhead/vue';
import { useToast } from 'primevue/usetoast';

useHead({
    title: 'Design System Colours',
});

const toast = useToast();

const colors = [
    'gray', 'red', 'orange', 'yellow', 'green',
    'teal', 'blue', 'indigo', 'purple', 'pink',
];

const steps = [50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950];

const getTextColor = (step) => {
    return step >= 500 ? 'text-white' : 'text-gray-900';
};

const copyClass = async (color, step) => {
    const className = `bg-${color}-${step}`;
    try {
        await navigator.clipboard.writeText(className);
        toast.add({ severity: 'success', summary: 'Copied', detail: `.${className}`, life: 2000 });
    } catch (e) {
        console.error('Copy failed', e);
    }
};
</script>

<template>
    <div class="w-full">
        <div class="mb-8">
            <h2>Color Palette</h2>
            <p class="text-gray-600 mt-2 max-w-2xl">
                This design system leverages the standard Tailwind CSS color palette. 
                Click any swatch to copy its utility class to your clipboard.
            </p>
        </div>

        <a-card class="p-8">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">

                <div v-for="color in colors" :key="color" class="flex flex-col gap-2">
                    <h3>{{ color }}</h3>

                    <div class="flex flex-col rounded-lg overflow-hidden shadow-sm border border-gray-100 mt-2">
                        <button
                            v-for="step in steps"
                            :key="`${color}-${step}`"
                            class="flex items-center justify-between px-4 py-3 text-sm font-medium transition-transform active:scale-[0.98] focus:outline-none hover:z-10 hover:ring-2 ring-inset ring-white/50 cursor-pointer"
                            :class="[
                                `bg-${color}-${step}`,
                                getTextColor(step)
                            ]"
                            @click="copyClass(color, step)"
                            title="Click to copy class"
                        >
                            <span>{{ step }}</span>
                            <span class="opacity-0 hover:opacity-100 transition-opacity text-xs uppercase">Copy</span>
                        </button>
                    </div>
                </div>
            </div>
        </a-card>
    </div>
</template>
