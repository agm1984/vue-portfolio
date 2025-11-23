<script setup>
import { ref, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { useToast } from 'primevue/usetoast';

useHead({
    title: 'Design System Sizing',
});

const toast = useToast();

const scaleSteps = [64, 48, 32, 16, 8, 4, 2, 1];

const sizingScale = computed(() => {
    return scaleSteps.map(step => {
        const rem = step * 0.25;
        const px = step * 4;
        return {
            step,
            class: `w-${step}`,
            hClass: `h-${step}`,
            label: `${step}`,
            rem: `${rem}rem`,
            px: `${px}px`,
            // Use a distinct color for "Major" breakpoints (multiples of 16)
            isMajor: step % 16 === 0
        };
    });
});

const copyClass = async (text) => {
    try {
        await navigator.clipboard.writeText(text);
        toast.add({ severity: 'success', summary: 'Copied', detail: text, life: 2000 });
    } catch (e) {
        console.error('Copy failed', e);
    }
};
</script>

<template>
    <div class="w-full flex flex-col">
        <h2>Space & Size</h2>
        <p class="text-gray-600 mt-2">This section covers the spacing and sizing scale used throughout the design system.</p>

        <a-card class="p-8 mt-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="prose text-gray-600">
                    <p>
                        This system relies on a geometric progression based on the number <span class="font-bold text-indigo-600">4</span>. 
                        Because the default browser font size is usually 16px, this scale allows for perfect alignment with typography 
                        and creates a predictable rhythm.
                    </p>
                    <ul class="mt-4 space-y-1 text-sm font-mono bg-gray-50 p-4 rounded-lg border border-gray-100 dark:border-gray-700">
                        <li>1 unit  = 0.25rem = 4px</li>
                        <li>4 units = 1rem    = 16px (Base)</li>
                        <li>8 units = 2rem   = 32px</li>
                        <li>16 units = 4rem   = 64px</li>
                    </ul>
                </div>

                <div class="relative flex items-center justify-center bg-gray-50 rounded-xl border border-dashed">
                    <div class="flex items-end gap-1">
                        <div class="w-2 h-2 bg-indigo-100 rounded-sm"></div>
                        <div class="w-4 h-4 bg-indigo-200 rounded-sm"></div>
                        <div class="w-8 h-8 bg-indigo-300 rounded-sm"></div>
                        <div class="w-16 h-16 bg-indigo-400 rounded-sm flex items-center justify-center text-white font-bold text-xs">16</div>
                        <div class="w-32 h-32 bg-indigo-500 rounded-md flex items-center justify-center text-white font-bold">32</div>
                    </div>
                </div>
            </div>
        </a-card>

        <a-card class="p-8 mt-8">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Spacing & Padding</h3>
                <p class="text-sm text-gray-500 font-normal mt-1">The same scale applies to padding (p-*) and margins (m-*).</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <div
                    v-for="size in sizingScale.slice(4)"
                    :key="`pad-${size.step}`"
                    class="flex flex-col items-center"
                >
                    <div
                        class="bg-indigo-100 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-800 rounded-lg flex items-center justify-center transition-all hover:scale-105"
                        :class="`p-${size.step}`"
                    >
                        <div class="w-8 h-8 bg-indigo-500 rounded shadow-sm"></div>
                    </div>
                    <code class="mt-2 text-xs text-gray-500">p-{{ size.step }}</code>
                </div>
            </div>
        </a-card>
    </div>
</template>
