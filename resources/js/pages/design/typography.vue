<script setup>
import { ref, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { useToast } from 'primevue/usetoast';
import InputText from 'primevue/inputtext';
import Divider from 'primevue/divider';
import Tag from 'primevue/tag';

useHead({
    title: 'Design System Typography',
});

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
</script>

<template>
    <div class="w-full flex flex-col">
        <h2 class="text-3xl font-bold">Typography</h2>

        <p class="text-gray-600 mt-2">
            The system uses <a href="https://fonts.google.com/specimen/Lato" target="_blank" class="text-indigo-500 hover:underline font-bold">Lato</a> as the primary typeface for optimal readability and modern aesthetics.
        </p>

        <a-card class="p-8 mt-4">
            <div class="flex flex-col">
                <h6>Type Tester</h6>
                <InputText v-model="previewText" class="w-full mt-2" placeholder="Type something to preview..." />
                <span class="text-xs text-gray-500 mt-1">Change the text to update the examples below.</span>
            </div>
        </a-card>

        <a-card class="p-8 mt-8">
            <div class="flex justify-between items-center">
                <h3>Brand Typeface</h3>
                <Tag value="Display Only" severity="warn" rounded />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center relative z-10">
                <div>
                    <p class="text-7xl font-aroly text-indigo-600 leading-none tracking-wide mt-4">
                        Aa
                    </p>
                    <p class="text-4xl font-aroly mt-4 text-gray-800">
                        {{ previewText }}
                    </p>
                </div>
                <div class="">
                    <p>
                        <strong>Aroly</strong> is a polygonal heading font used sparingly for high-impact branding, usually on the Home page hero section.
                    </p>
                    <div
                        class="mt-4 inline-flex items-center gap-2 px-3 py-2 bg-gray-100 rounded cursor-pointer hover:bg-gray-200 transition-colors"
                        @click="copyClass('font-aroly')"
                    >
                        <code class="text-indigo-600 font-mono">font-aroly</code>
                        <i class="pi pi-copy text-xs text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="absolute -right-10 -bottom-20 text-[12rem] font-aroly text-gray-50 pointer-events-none opacity-50 select-none">
                Aa
            </div>
        </a-card>

        <a-card class="p-8 mt-8">
            <h3>Primary Typeface (Lato)</h3>

            <div class="mt-4">
                <div class="space-y-8">
                    <div
                        v-for="(item, index) in headings"
                        :key="`heading-${index}`"
                        class="group grid grid-cols-1 md:grid-cols-12 gap-4 items-baseline border-b last:border-0 pb-6 last:pb-0"
                    >
                        <div class="md:col-span-8">
                            <component :is="item.tag" :class="item.class">
                                {{ previewText }}
                            </component>
                        </div>

                        <div class="md:col-span-4 flex flex-col items-start md:items-end gap-1">
                            <h3 class="text-indigo-500!">{{ item.label }}</h3>
                            <span class="text-xs text-gray-400">{{ item.desc }}</span>
                        </div>
                    </div>
                </div>

                <Divider />

                <div>
                    <h3>Weights</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                        <div
                            v-for="weight in weights"
                            :key="weight.name"
                            class="flex flex-col gap-2 p-4 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer group"
                            @click="copyClass(weight.class)"
                        >
                            <div class="text-4xl" :class="weight.class">Aa</div>
                            <div class="mt-auto">
                                <div class="font-bold text-sm group-hover:text-indigo-600 transition-colors">{{ weight.name }}</div>
                                <div class="font-mono text-xs text-gray-400">{{ weight.weight }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a-card>
    </div>
</template>
