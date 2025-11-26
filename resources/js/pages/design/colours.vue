<script setup>
import { useHead } from '@unhead/vue';
import { useRouter } from 'vue-router';
import { useToast } from 'primevue/usetoast';

useHead({
    title: 'Design System Colours',
});

const router = useRouter();
const toast = useToast();

/**
 * Tailwind colours must be defined somewhere in the app
 * in order to be included in the final CSS build.
 */

// bg-gray-50  bg-red-50  bg-orange-50  bg-yellow-50  bg-green-50
// bg-gray-100 bg-red-100 bg-orange-100 bg-yellow-100 bg-green-100
// bg-gray-200 bg-red-200 bg-orange-200 bg-yellow-200 bg-green-200
// bg-gray-300 bg-red-300 bg-orange-300 bg-yellow-300 bg-green-300
// bg-gray-400 bg-red-400 bg-orange-400 bg-yellow-400 bg-green-400
// bg-gray-500 bg-red-500 bg-orange-500 bg-yellow-500 bg-green-500
// bg-gray-600 bg-red-600 bg-orange-600 bg-yellow-600 bg-green-600
// bg-gray-700 bg-red-700 bg-orange-700 bg-yellow-700 bg-green-700
// bg-gray-800 bg-red-800 bg-orange-800 bg-yellow-800 bg-green-800
// bg-gray-900 bg-red-900 bg-orange-900 bg-yellow-900 bg-green-900
// bg-gray-950 bg-red-950 bg-orange-950 bg-yellow-950 bg-green-950

// bg-teal-50  bg-blue-50  bg-indigo-50  bg-purple-50  bg-pink-50
// bg-teal-100 bg-blue-100 bg-indigo-100 bg-purple-100 bg-pink-100
// bg-teal-200 bg-blue-200 bg-indigo-200 bg-purple-200 bg-pink-200
// bg-teal-300 bg-blue-300 bg-indigo-300 bg-purple-300 bg-pink-300
// bg-teal-400 bg-blue-400 bg-indigo-400 bg-purple-400 bg-pink-400
// bg-teal-500 bg-blue-500 bg-indigo-500 bg-purple-500 bg-pink-500
// bg-teal-600 bg-blue-600 bg-indigo-600 bg-purple-600 bg-pink-600
// bg-teal-700 bg-blue-700 bg-indigo-700 bg-purple-700 bg-pink-700
// bg-teal-800 bg-blue-800 bg-indigo-800 bg-purple-800 bg-pink-800
// bg-teal-900 bg-blue-900 bg-indigo-900 bg-purple-900 bg-pink-900
// bg-teal-950 bg-blue-950 bg-indigo-950 bg-purple-950 bg-pink-950

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
        toast.add({ severity: 'success', summary: 'Copied', detail: `.${className}`, life: 5000 });
    } catch (e) {
        console.error('Copy failed', e);
    }
};

const goBack = () => router.push({ name: 'design' });
</script>

<template>
    <a-page>
        <a-page-title
            title="Colours"
            description="This design system leverages the standard Tailwind CSS color palette. Click any swatch to copy its utility class to your clipboard."
            has-back
            @on-back="goBack"
        ></a-page-title>

        <a-card class="p-8">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div
                    v-for="color in colors"
                    :key="`design-colour-${color}`"
                    class="flex flex-col gap-2"
                >
                    <h3>{{ color }}</h3>

                    <div class="flex flex-col rounded-lg overflow-hidden shadow-sm border border-gray-300 dark:border-gray-700 mt-2">
                        <button
                            v-for="step in steps"
                            :key="`${color}-${step}`"
                            class="flex items-center justify-between px-4 py-3 text-sm font-medium transition-transform active:scale-[0.98] focus:outline-none hover:z-10 hover:ring-2 ring-inset ring-white/50 cursor-pointer"
                            :class="[
                                `bg-${color}-${step}`,
                                getTextColor(step),
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
    </a-page>
</template>
