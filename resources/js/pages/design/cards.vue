<script setup>
import { ref, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { useToast } from 'primevue/usetoast';
import Card from 'primevue/card';
import Button from 'primevue/button';
import Slider from 'primevue/slider';
import Skeleton from 'primevue/skeleton';
import Badge from 'primevue/badge';


useHead({
    title: 'Design System Cards',
});

const toast = useToast();

const shadowLevel = ref(2);
const shadowClasses = ['shadow-none', 'shadow-sm', 'shadow-md', 'shadow-lg', 'shadow-xl', 'shadow-2xl'];
const currentShadow = computed(() => shadowClasses[shadowLevel.value]);

const shadows = [
    { name: 'None', class: 'shadow-none', use: 'Flat surfaces / Inner panels' },
    { name: 'Small', class: 'shadow-sm', use: 'Lists, Tables, Subtle cards' },
    { name: 'Medium', class: 'shadow-md', use: 'Standard Cards, Dropdowns' },
    { name: 'Large', class: 'shadow-lg', use: 'Hover states, Sticky headers' },
    { name: 'X-Large', class: 'shadow-xl', use: 'Modals, Dialogs' },
    { name: '2X-Large', class: 'shadow-2xl', use: 'Major alerts, Popovers' },
];

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
    <div class="flex-1 w-full flex flex-col">
        <div class="mb-4">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Cards & Containers</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-2">
                The foundational surfaces of the interface. This system relies on a "Card on Canvas" metaphor.
            </p>
        </div>

        <a-card class="p-8">
            <div class="flex justify-between items-center">
                <h3>Elevation & Depth</h3>
                <Badge :value="currentShadow" severity="info" class="font-mono" />
            </div>

            <p class="text-sm text-gray-500 font-normal mt-1">Adjust the slider to see how shadow depth affects the hierarchy.</p>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 mt-8 items-center">
                <div class="lg:col-span-7 flex justify-center py-12 bg-gray-50 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden relative">
                    <div class="absolute inset-0 opacity-[0.05]" style="background-image: linear-gradient(#000 1px, transparent 1px), linear-gradient(90deg, #000 1px, transparent 1px); background-size: 20px 20px;"></div>

                    <div
                        class="w-64 h-40 bg-white dark:bg-gray-800 rounded-2xl border flex items-center justify-center transition-shadow duration-500 ease-out"
                        :class="currentShadow"
                    >
                        <div class="text-center">
                            <i class="pi pi-box text-indigo-500 mb-2" style="font-size: 32px;"></i>
                            <p class="font-bold text-gray-900 dark:text-white">Card Surface</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 space-y-8">
                    <div>
                        <h6 class="mb-4 block">Shadow Intensity</h6>
                        <Slider v-model="shadowLevel" :min="0" :max="5" :step="1" class="w-full" />
                        <div class="flex justify-between mt-2 text-xs text-gray-400 font-mono">
                            <span>Flat</span>
                            <span>Floating</span>
                        </div>
                    </div>

                    <div class="bg-gray-900 rounded-lg p-4">
                        <a-code 
                            language="html" 
                            :code="`<a-card class=&quot;${currentShadow}!&quot;>\n  \n</a-card>`"
                        />
                    </div>
                </div>
            </div>
        </a-card>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mt-8">
            <div
                v-for="shadow in shadows"
                :key="shadow.name"
                class="flex flex-col gap-3 group cursor-pointer"
                @click="copyClass(shadow.class)"
            >
                <div
                    class="h-24 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 flex items-center justify-center transition-transform group-hover:-translate-y-1"
                    :class="shadow.class"
                >
                    <span class="text-xs font-mono text-gray-400 group-hover:text-indigo-500 transition-colors">{{ shadow.class }}</span>
                </div>
                <div class="text-center">
                    <p class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ shadow.name }}</p>
                    <p class="text-[10px] text-gray-500 leading-tight mt-1">{{ shadow.use }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
            <Card class="p-0 overflow-hidden border-0 shadow-lg">
                <template #header>
                    <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-100 dark:border-indigo-800">
                        <h4 class="text-indigo-700 font-bold">Header Slot</h4>
                    </div>
                </template>
                <template #content>
                    <div class="p-6 text-sm text-gray-600 space-y-2">
                        <p>This is the <strong>Body</strong> content.</p>
                        <p>Standard cards use <code>p-6</code> or <code>p-8</code> padding depending on density.</p>
                    </div>
                </template>
                <template #footer>
                    <div class="bg-gray-50 px-6 py-3 border-t flex justify-between items-center">
                        <span class="text-xs text-gray-400 font-mono">Footer Slot</span>
                        <Button label="Action" size="small" text />
                    </div>
                </template>
            </Card>

            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                <div class="absolute top-4 right-4 text-gray-300 group-hover:text-indigo-500 transition-colors">
                    <i class="pi pi-external-link"></i>
                </div>
                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="pi pi-star-fill"></i>
                </div>
                <h4 class="font-bold text-lg text-gray-900 dark:text-white mb-2 group-hover:text-indigo-600 transition-colors">Interactive Card</h4>
                <p class="text-sm text-gray-500">
                    Used for project galleries and navigation. Features lift-on-hover and color shifts.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center gap-4 mb-6">
                    <Skeleton shape="circle" size="3rem" />
                    <div class="flex-1">
                        <Skeleton width="60%" class="mb-2" />
                        <Skeleton width="40%" />
                    </div>
                </div>
                <div class="space-y-3">
                    <Skeleton width="100%" height="1rem" />
                    <Skeleton width="100%" height="1rem" />
                    <Skeleton width="80%" height="1rem" />
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                    <Skeleton width="4rem" height="2rem" />
                </div>
            </div>
        </div>
    </div>
</template>
