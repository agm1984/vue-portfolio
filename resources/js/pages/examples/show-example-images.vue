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

const fetchExample = async () => {
    try {
        const { example, filename } = currentRoute.params;

        // Ensure we have the params before fetching
        if (!example || !filename) throw new Error("Missing route parameters");

        const response = await axios.get(route('public.examples.images', [example, filename]));

        image.value = response.data.image;
        imageUrl.value = response.data.image_url;
        state.value = IS_LOADED;
    } catch (err) {
        console.error(`show-example-image# Error: ${err}`);
        state.value = HAS_ERROR;
    }
};

// Pure helper to force download
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
    router.push({
        name: 'public.examples.show',
        params: {
            category: currentRoute.params.category,
            example: currentRoute.params.example,
        },
    });
};

onMounted(fetchExample);
</script>

<template>
    <div class="fixed inset-0 z-50 bg-gray-900 flex flex-col overflow-hidden">
        
        <div class="relative z-20 flex items-center justify-between px-6 py-4 bg-black/50 backdrop-blur-md border-b border-white/10 text-white">
            <div class="flex items-center gap-4">
                <Button 
                    icon="pi pi-arrow-left" 
                    text 
                    rounded 
                    class="text-white! hover:bg-white/20!" 
                    @click="goBack"
                    aria-label="Go Back"
                />
                <div class="flex flex-col">
                    <h1 class="text-base font-bold truncate max-w-[200px] md:max-w-md">
                        {{ image.filename || 'Loading...' }}
                    </h1>
                    <span class="text-xs text-gray-400" v-if="isLoaded">
                        Original Size
                    </span>
                </div>
            </div>

            <div class="flex gap-2">
                <Button 
                    label="Download" 
                    icon="pi pi-download" 
                    size="small"
                    severity="secondary" 
                    class="!bg-white/10 !border-white/10 !text-white hover:!bg-white/20"
                    @click="downloadImage"
                    v-if="isLoaded"
                />
                <Button 
                    icon="pi pi-times" 
                    text 
                    rounded 
                    class="text-white! hover:bg-white/20!" 
                    @click="goBack"
                    aria-label="Close"
                />
            </div>
        </div>

        <div class="relative flex-1 w-full h-full flex items-center justify-center bg-gray-900">
            
            <div v-if="isLoading" class="z-30 flex flex-col items-center gap-4">
                <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="4" />
                <span class="text-gray-400 text-sm">Loading high-res image...</span>
            </div>

            <div v-else-if="hasError" class="z-30 text-center">
                <i class="pi pi-image text-6xl text-gray-700 mb-4"></i>
                <p class="text-gray-400">Failed to load image.</p>
                <Button label="Go Back" text class="mt-2" @click="goBack" />
            </div>

            <template v-else>
                <div 
                    class="absolute inset-0 opacity-30 blur-3xl scale-110 pointer-events-none"
                    :style="{ backgroundImage: `url(${imageUrl})`, backgroundPosition: 'center', backgroundSize: 'cover' }"
                ></div>

                <img 
                    :src="imageUrl" 
                    class="relative z-10 max-w-full max-h-[85vh] object-contain shadow-2xl rounded-lg transition-transform duration-300 ease-out hover:scale-[1.01]" 
                    alt="Full screen example" 
                />
            </template>
        </div>
    </div>
</template>
