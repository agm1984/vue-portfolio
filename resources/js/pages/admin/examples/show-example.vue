<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useHead } from '@unhead/vue';
import axios from 'axios';

// PrimeVue Imports
import Button from 'primevue/button';
import Tag from 'primevue/tag';
import Card from 'primevue/card';
import Skeleton from 'primevue/skeleton';
import Divider from 'primevue/divider';

useHead({
    title: 'Admin: Example Details',
});

const route = useRoute();
const router = useRouter();

// --- STATE ---
const LOADING = 'LOADING';
const SHOWING = 'SHOWING';
const EDITING = 'EDITING';

const state = ref(LOADING);
const example = ref({
    id: null,
    name: '',
    slug: '',
    status: 0, // Assuming int status based on previous code
    status_nice: '',
    summary: '',
    conclusion: '',
    created_at_nice: '',
    created_at_diff: '',
    updated_at_nice: '',
    updated_at_diff: '',
    category: {},
    links: [],
    tags: [],
    images: [],
});

// --- COMPUTED ---
const isLoading = computed(() => state.value === LOADING);
const isShowing = computed(() => state.value === SHOWING);
const isEditing = computed(() => state.value === EDITING);

// --- HELPERS ---
const getStatusConfig = (status) => {
    // Fallback logic if status int isn't available, use string
    if (status === 1) return { severity: 'success', icon: 'pi pi-check-circle', label: 'Active' };
    if (status === 0) return { severity: 'danger', icon: 'pi pi-ban', label: 'Inactive' };
    return { severity: 'info', icon: 'pi pi-info-circle', label: 'Unknown' };
};

// --- ACTIONS ---
const fetchExample = async () => {
    try {
        // Only set loading on initial fetch
        if (state.value === LOADING) state.value = LOADING;
        
        const { data } = await axios.get(window.route('admin.examples.show', route.params.example));
        example.value = data.example;
        
        state.value = SHOWING;
    } catch (err) {
        console.error(`show-example# Problem fetching example: ${err}.`);
    }
};

const handleReset = async () => {
    state.value = LOADING;
    await fetchExample();
};

const handleExampleSaved = (updatedExample) => {
    example.value = updatedExample;
    state.value = SHOWING;
};

const goBack = () => router.push({ name: 'admin.examples.list' });

onMounted(fetchExample);
</script>

<template>
    <div class="w-full max-w-7xl mx-auto p-6 md:p-12">

        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <Button 
                    icon="pi pi-arrow-left" 
                    text 
                    rounded 
                    severity="secondary" 
                    @click="goBack"
                    aria-label="Go Back"
                />
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ example.name }}</h1>
                    <div class="mt-2 flex items-center gap-2">
                            <span class="text-xs font-bold uppercase text-gray-400">Slug:</span>
                            <span class="font-mono text-xs text-indigo-600 bg-gray-100 px-2 py-1 rounded">/{{ example.slug }}</span>
                    </div>
                </div>
            </div>

            <div v-if="!isLoading">
                <Button 
                    v-if="isShowing" 
                    label="Edit Project" 
                    icon="pi pi-pencil" 
                    severity="secondary" 
                    outlined 
                    @click="state = EDITING" 
                />
                <Button 
                    v-if="isEditing" 
                    label="Cancel Editing" 
                    icon="pi pi-times" 
                    severity="secondary" 
                    text 
                    @click="state = SHOWING" 
                />
            </div>
        </div>

        <div v-if="isLoading" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <Skeleton height="200px" borderRadius="1rem" />
                <Skeleton height="400px" borderRadius="1rem" />
            </div>
            <div class="lg:col-span-1 space-y-8">
                <Skeleton height="300px" borderRadius="1rem" />
                <Skeleton height="200px" borderRadius="1rem" />
            </div>
        </div>

        <div v-else-if="isEditing" class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-indigo-200 dark:border-indigo-900 p-6 ring-4 ring-indigo-50 dark:ring-indigo-900/20">
            <div class="mb-6 flex items-center gap-2 text-indigo-600 font-bold border-b border-gray-100 pb-2">
                <i class="pi pi-file-edit"></i>
                <span>Editing Mode</span>
            </div>
            <edit-example
                mode="edit"
                :initial-example="example"
                @reset="handleReset"
                @save="handleExampleSaved"
            />
        </div>

        <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            <div class="lg:col-span-2 space-y-8">
                
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8">
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-sm font-bold uppercase text-gray-600 mb-2">Summary</h3>
                            <p class="text-gray-800 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">{{ example.summary }}</p>
                        </div>

                        <div v-if="example.conclusion" class="bg-indigo-50 dark:bg-indigo-900/20 p-6 rounded-xl">
                            <h3 class="text-sm font-bold uppercase text-indigo-600 mb-2">Conclusion</h3>
                            <p class="text-gray-800 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">{{ example.conclusion }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="pi pi-images text-gray-400"></i> Gallery
                        </h3>
                        <span class="text-xs text-gray-600">{{ example.images.length }} images</span>
                    </div>

                    <div v-if="example.images.length" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <router-link
                            v-for="image in example.images"
                            :key="`example-image-${image.id}`"
                            :to="{
                                name: 'admin.examples.image',
                                params: {
                                    category: example.category.slug,
                                    example: example.slug,
                                    filename: image.filename,
                                },
                            }"
                            class="group relative aspect-video rounded-lg overflow-hidden border border-gray-100 dark:border-gray-700 cursor-zoom-in"
                        >
                            <img 
                                :src="`/storage/examples/${example.slug}/${image.filename}`" 
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                alt="Project Screenshot"
                            />
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                <i class="pi pi-search-plus text-white opacity-0 group-hover:opacity-100 transition-opacity text-2xl drop-shadow-md"></i>
                            </div>
                        </router-link>
                    </div>
                    <a-area-empty v-else>No images uploaded yet.</a-area-empty>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold uppercase text-gray-400">Status</span>
                        <span class="font-mono text-xs text-gray-300">#{{ example.id }}</span>
                    </div>
                    
                    <div class="mb-6">
                        <Tag 
                            :value="getStatusConfig(example.status).label" 
                            :severity="getStatusConfig(example.status).severity"
                            :icon="getStatusConfig(example.status).icon"
                            class="w-full py-2 text-sm uppercase tracking-widest"
                        />
                    </div>

                    <div class="mb-6">
                         <span class="text-xs font-bold uppercase text-gray-400 block mb-2">Category</span>
                         <div class="flex items-center gap-2">
                             <i class="pi pi-folder text-indigo-500"></i>
                             <span class="font-bold text-gray-800 dark:text-white">{{ example.category.name }}</span>
                         </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700 space-y-3">
                        <div>
                            <span class="text-xs text-gray-400 block">Created</span>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ example.created_at_nice }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 block">Last Update</span>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ example.updated_at_nice }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-sm font-bold uppercase text-gray-400 mb-4 flex items-center gap-2">
                        <i class="pi pi-link"></i> Resources
                    </h3>
                    
                    <div v-if="example.links.length" class="flex flex-col gap-2">
                        <a
                            v-for="link in example.links"
                            :key="link.url"
                            :href="link.url"
                            target="_blank"
                            class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors group"
                        >
                            <span class="text-sm font-semibold">{{ link.name }}</span>
                            <i class="pi pi-external-link text-xs text-gray-400 group-hover:text-indigo-500"></i>
                        </a>
                    </div>
                    <div v-else class="text-sm text-gray-400 italic">No external links.</div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-sm font-bold uppercase text-gray-400 mb-4 flex items-center gap-2">
                        <i class="pi pi-tags"></i> Tags
                    </h3>
                    
                    <div v-if="example.tags.length" class="flex flex-wrap gap-2">
                        <Tag
                            v-for="(tag, index) in example.tags"
                            :key="`tag-${index}`"
                            :value="tag"
                            severity="secondary"
                            rounded
                            class="!font-normal"
                        />
                    </div>
                    <div v-else class="text-sm text-gray-400 italic">No tags assigned.</div>
                </div>

            </div>

        </div>
    </div>
</template>
