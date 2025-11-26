<script setup>
import { ref, onMounted, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

// PrimeVue Imports
import Button from 'primevue/button';
import ProgressSpinner from 'primevue/progressspinner';

useHead({
    title: 'Viewing Image',
});

const IS_LOADING = 0;
const IS_LOADED = 1;
const HAS_ERROR = 2;

const state = ref(IS_LOADING);
const image = ref({});
const imageUrl = ref('');

const currentRoute = useRoute();
const router = useRouter();

const isLoading = computed(() => state.value === IS_LOADING);
const isLoaded = computed(() => state.value === IS_LOADED);
const hasError = computed(() => state.value === HAS_ERROR);

const isAdmin = computed(() => currentRoute.name?.startsWith('admin.'));

const fetchExample = async () => {
    try {
        const { example, filename } = currentRoute.params;

        if (!example || !filename) throw new Error("Missing route parameters");

        const response = await axios.get(route('public.examples.image', {
            example: example,
            exampleImage: filename,
        }));

        image.value = response.data.image;
        imageUrl.value = response.data.image_url;

        state.value = IS_LOADED;
    } catch (err) {
        console.error(`show-example-image# Error: ${err}`);
        state.value = HAS_ERROR;
    }
};

const downloadImage = async () => {
    if (!imageUrl.value) return;

    try {
        const response = await fetch(imageUrl.value);
        const blob = await response.blob();
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = image.value.filename || 'download.png';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } catch (e) {
        console.error('Download failed', e);
    }
};

const goBack = () => {
    if (isAdmin.value) {
        router.push({
            name: 'admin.examples.show',
            params: { example: currentRoute.params.example },
        });
    } else {
        router.push({
            name: 'public.examples.show',
            params: {
                category: currentRoute.params.category,
                example: currentRoute.params.example,
            },
        });
    }
};

onMounted(fetchExample);
</script>

<template>
    <div class="fixed inset-0 z-50 bg-gray-900 flex flex-col overflow-hidden">
        <div class="relative z-20 flex items-center justify-between px-6 py-4 bg-black/50 backdrop-blur-md border-b border-white/10 text-white shrink-0">
            <div class="flex items-center gap-4">
                <Button
                    type="button"
                    class="text-white! hover:bg-white/20!"
                    icon="pi pi-arrow-left"
                    text
                    rounded
                    aria-label="Go Back"
                    @click="goBack"
                />

                <div class="flex flex-col">
                    <h1 class="truncate max-w-[200px] md:max-w-md text-white!">
                        {{ image.filename || 'Loading...' }}
                    </h1>
                    <span v-if="isLoaded" class="text-xs text-gray-400 mt-1">
                        {{ isAdmin ? 'Admin View' : 'Original Size' }}
                    </span>
                </div>
            </div>

            <div class="flex gap-2">
                <Button
                    v-if="isLoaded"
                    type="button"
                    class="bg-white/10! border-white/10! text-white! hover:bg-white/20!"
                    severity="secondary"
                    icon="pi pi-download"
                    label="Download"
                    size="small"
                    @click="downloadImage"
                />

                <Button
                    type="button"
                    class="text-white! hover:bg-white/20!"
                    icon="pi pi-times"
                    aria-label="Close"
                    text
                    rounded
                    @click="goBack"
                />
            </div>
        </div>

        <div class="relative flex-1 w-full h-full flex items-center justify-center bg-gray-900 overflow-hidden p-4">
            <div v-if="isLoading" class="z-30 flex flex-col items-center gap-4">
                <ProgressSpinner style="width: 64px; height: 64px" strokeWidth="4" />

                <span class="text-gray-300 text-sm">Loading high-res image...</span>
            </div>

            <div v-else-if="hasError" class="z-30 text-center">
                <i class="pi pi-image text-gray-600 mb-4" style="font-size: 64px;"></i>
                <p class="text-gray-300">Failed to load image.</p>
                <Button
                    type="button"
                    class="text-white! hover:bg-white/20! mt-2"
                    label="Go Back"
                    text
                    @click="goBack"
                />
            </div>

            <template v-else>
                <div
                    class="absolute inset-0 opacity-30 blur-3xl scale-110 pointer-events-none"
                    :style="{
                        backgroundImage: `url(${imageUrl})`,
                        backgroundPosition: 'center',
                        backgroundSize: 'cover',
                    }"
                ></div>

                <img
                    class="relative z-10 w-full h-full object-contain shadow-2xl drop-shadow-2xl"
                    :src="imageUrl"
                    alt="Full screen example"
                />
            </template>
        </div>
    </div>
</template>