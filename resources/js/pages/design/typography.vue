<script setup>
import { ref, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { useRouter } from 'vue-router';
import { useToast } from 'primevue/usetoast';
import InputText from 'primevue/inputtext';
import Divider from 'primevue/divider';
import Tag from 'primevue/tag';

useHead({
    title: 'Design System Typography',
});

const router = useRouter();
const toast = useToast();
const previewText = ref('The quick brown fox jumps over the lazy dog');

const headings = [
    { tag: 'h1', label: 'H1', desc: 'Page Titles' },
    { tag: 'h2', label: 'H2', desc: 'Section Headers' },
    { tag: 'h3', label: 'H3', desc: 'Section Titles' },
    { tag: 'h4', label: 'H4', desc: 'Sub-sections' },
    { tag: 'h5', label: 'H5', desc: 'Minor Headings' },
    { tag: 'h6', label: 'H6', desc: 'Field Headings' },
];

const weights = [
    { name: 'Regular', class: 'font-normal', weight: 400 },
    { name: 'Semibold', class: 'font-semibold', weight: 600 },
];

const copyClass = async (text) => {
    try {
        await navigator.clipboard.writeText(text);
        toast.add({ severity: 'success', summary: 'Copied', detail: text, life: 2000 });
    } catch (e) {
        console.error('Copy failed', e);
    }
};

const goBack = () => router.push({ name: 'design' });
</script>

<template>
    <div class="w-full flex flex-col transition-colors duration-300">
        <a-page-title
            title="Typography"
            has-back
            @on-back="goBack"
        >
            <template #description>
                <p class="text-gray-600 dark:text-gray-400">
                    The system uses <a href="https://fonts.google.com/specimen/Lato" target="_blank" class="text-indigo-500 dark:text-indigo-400 hover:underline font-bold transition-colors">Lato</a> as the primary typeface for optimal readability and modern aesthetics.
                </p>
            </template>
        </a-page-title>

        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Typography</h2>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 mt-4 transition-colors duration-300">
            <div class="flex flex-col">
                <h6 class="text-gray-900 dark:text-white">Type Tester</h6>
                <InputText v-model="previewText" class="w-full mt-2" placeholder="Type something to preview..." />
                <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">Change the text to update the examples below.</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 mt-8 relative overflow-hidden transition-colors duration-300">
            <div class="flex justify-between items-center">
                <h3 class="text-gray-900 dark:text-white">Brand Typeface</h3>
                <Tag value="Display Only" severity="warn" rounded />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center relative z-10">
                <div>
                    <p class="text-7xl font-aroly text-indigo-600 dark:text-indigo-400 leading-none tracking-wide mt-4 transition-colors">
                        Aa
                    </p>
                    <p class="text-4xl font-aroly mt-4 text-gray-800 dark:text-white transition-colors">
                        {{ previewText }}
                    </p>
                </div>
                <div class="">
                    <p class="text-gray-600 dark:text-gray-300">
                        <strong class="text-gray-900 dark:text-white">Aroly</strong> is a polygonal heading font used sparingly for high-impact branding, usually on the Home page hero section.
                    </p>
                    <div
                        class="mt-4 inline-flex items-center gap-2 px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                        @click="copyClass('font-aroly')"
                    >
                        <code class="text-indigo-600 dark:text-indigo-300 font-mono">font-aroly</code>
                        <i class="pi pi-copy text-xs text-gray-400 dark:text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="absolute -right-10 -bottom-20 text-[12rem] font-aroly text-gray-50 dark:text-gray-700 pointer-events-none opacity-50 dark:opacity-20 select-none transition-colors">
                Aa
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 mt-8 transition-colors duration-300">
            <h3 class="text-gray-900 dark:text-white">Primary Typeface (Lato)</h3>

            <div class="mt-4">
                <div class="space-y-8">
                    <div
                        v-for="(item, index) in headings"
                        :key="`heading-${index}`"
                        class="group grid grid-cols-1 md:grid-cols-12 gap-4 items-baseline border-b border-gray-100 dark:border-gray-700 last:border-0 pb-6 last:pb-0 transition-colors"
                    >
                        <div class="md:col-span-8">
                            <component :is="item.tag" :class="item.class">
                                {{ previewText }}
                            </component>
                        </div>

                        <div class="md:col-span-4 flex flex-col items-start md:items-end gap-1">
                            <h3 class="text-indigo-500! dark:text-indigo-400! transition-colors">{{ item.label }}</h3>
                            <span class="text-xs text-gray-400 dark:text-gray-500">{{ item.desc }}</span>
                        </div>
                    </div>
                </div>

                <Divider />

                <div>
                    <h3 class="text-gray-900 dark:text-white">Weights</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                        <div
                            v-for="weight in weights"
                            :key="weight.name"
                            class="flex flex-col gap-2 p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors cursor-pointer group"
                            @click="copyClass(weight.class)"
                        >
                            <div class="text-4xl text-gray-900 dark:text-white" :class="weight.class">Aa</div>
                            <div class="mt-auto">
                                <div class="font-bold text-sm text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ weight.name }}</div>
                                <div class="font-mono text-xs text-gray-400 dark:text-gray-500">{{ weight.weight }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
