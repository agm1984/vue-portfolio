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
    title: 'Admin: Category Details',
});

const route = useRoute();
const router = useRouter();

// --- STATE ---
const LOADING = 'LOADING';
const SHOWING = 'SHOWING';
const EDITING = 'EDITING';

const state = ref(LOADING);
const category = ref({
    id: null,
    name: '',
    slug: '',
    status: 0,
    examples_count: 0,
    created_at_nice: '',
    updated_at_nice: '',
    examples: [],
});

// --- COMPUTED ---
const isLoading = computed(() => state.value === LOADING);
const isShowing = computed(() => state.value === SHOWING);
const isEditing = computed(() => state.value === EDITING);

// --- PURE HELPERS ---
const getStatusConfig = (status) => {
    return status === 1
        ? { label: 'Active', severity: 'success', icon: 'pi pi-check-circle' }
        : { label: 'Inactive', severity: 'danger', icon: 'pi pi-ban' };
};

// --- ACTIONS ---
const fetchCategory = async () => {
    try {
        const { data } = await axios.get(window.route('admin.categories.show', route.params.category));
        category.value = data.category;
        
        // If we were loading, now we show
        if (state.value === LOADING) state.value = SHOWING;
    } catch (err) {
        console.error(`show-category# Problem fetching category: ${err}.`);
    }
};

const handleReset = async () => {
    state.value = LOADING; // brief loading state to reset UI
    await fetchCategory();
    state.value = SHOWING;
};

const handleCategorySaved = (updatedCategory) => {
    category.value = updatedCategory;
    state.value = SHOWING;
};

const goBack = () => router.push({ name: 'admin.categories.list' });

onMounted(fetchCategory);
</script>

<template>
    <div class="flex-1 w-full flex flex-col">
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <Button
                    type="button"
                    icon="pi pi-arrow-left"
                    severity="secondary"
                    aria-label="Go Back"
                    text
                    rounded
                    @click="goBack"
                />

                <div>
                    <h1>Category Details</h1>
                    <p class="text-gray-600 mt-2">Manage Example classification.</p>
                </div>
            </div>

            <div v-if="!isLoading">
                <Button
                    v-if="isShowing"
                    type="button"
                    severity="secondary"
                    icon="pi pi-pencil"
                    label="Edit Category"
                    outlined
                    @click="state = EDITING"
                />

                <Button
                    v-if="isEditing"
                    type="button"
                    severity="secondary"
                    icon="pi pi-times"
                    label="Cancel Editing"
                    text
                    @click="state = SHOWING"
                />
            </div>
        </div>

        <div v-if="isLoading" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <Skeleton height="300px" borderRadius="1rem" class="lg:col-span-1" />
            <Skeleton height="300px" borderRadius="1rem" class="lg:col-span-2" />
        </div>

        <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <div class="lg:col-span-1">
                <a-card v-if="isShowing" class="flex flex-col relative overflow-hidden p-8">
                    <div class="absolute top-0 left-0 w-full h-2 bg-indigo-500"></div>

                    <div>
                        <h6>Category Name</h6>

                        <h2 class="mt-1">{{ category.name }}</h2>
                    </div>

                    <div class="mt-6">
                        <h6>URL Slug</h6>

                        <div class="bg-gray-100 rounded font-mono text-sm text-indigo-600 break-all p-2 mt-1">
                            /{{ category.slug }}
                        </div>
                    </div>

                    <div class="mt-6">
                         <h6>Status</h6>

                         <Tag
                            class="w-full py-2 text-sm uppercase tracking-widest mt-1"
                            :severity="getStatusConfig(category.status).severity"
                            :icon="getStatusConfig(category.status).icon"
                            :value="getStatusConfig(category.status).label"
                        />
                    </div>

                    <div class="mt-auto border-t border-gray-100 dark:border-gray-700 flex justify-between items-center text-sm pt-6">
                        <span class="text-gray-600">ID</span>
                        <span class="font-mono font-bold text-gray-700">#{{ category.id }}</span>
                    </div>
                </a-card>

                <a-card v-if="isEditing" class="border-indigo-200 ring-4 ring-indigo-50 p-8">
                    <div class="flex items-center gap-2 text-indigo-600 font-bold border-b border-gray-100 pb-2 mb-8">
                        <i class="pi pi-file-edit"></i>
                        <span>Editing Mode</span>
                    </div>

                    <edit-category
                        mode="edit"
                        :initial-category="category"
                        @reset="handleReset"
                        @save="handleCategorySaved"
                    />
                </a-card>
            </div>

            <div class="lg:col-span-2 space-y-8">
                <a-card class="flex flex-col sm:flex-row gap-4 p-8">
                    <div class="flex-1">
                         <h6 class="mb-1">Created</h6>
                         <p class="text-gray-800 dark:text-white font-medium">{{ category.created_at_nice }}</p>
                         <p class="text-xs text-gray-600 mt-1">{{ category.created_at_diff }}</p>
                    </div>
                    <div class="w-px bg-gray-100 dark:bg-gray-700 hidden sm:block"></div>
                    <div class="flex-1">
                         <h6 class="mb-1">Last Updated</h6>
                         <p class="text-gray-800 dark:text-white font-medium">{{ category.updated_at_nice }}</p>
                         <p class="text-xs text-gray-600 mt-1">{{ category.updated_at_diff }}</p>
                    </div>
                    <div class="w-px bg-gray-100 dark:bg-gray-700 hidden sm:block"></div>
                     <div class="flex-1">
                         <h6 class="mb-1">Total Projects</h6>
                         <p class="text-2xl font-bold text-indigo-600">{{ category.examples_count }}</p>
                    </div>
                </a-card>

                <div>
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="pi pi-images text-gray-400"></i>
                            Associated Examples
                        </h3>
                    </div>

                    <div v-if="category.examples.length" class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                        <router-link
                            v-for="example in category.examples"
                            :key="example.slug"
                            :to="{ name: 'admin.examples.show', params: { example: example.slug } }"
                            class="group relative block bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-all hover:-translate-y-1"
                        >
                            <div class="aspect-video bg-gray-100 dark:bg-gray-900 relative overflow-hidden">
                                <a-image
                                    v-if="example.images && example.images.length > 0"
                                    :src="`/storage/examples/${example.slug}/${example.images[0].filename}`" 
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                    alt="Project Thumbnail"
                                    background="#ffffff"
                                />
                                <div v-else class="w-full h-full flex items-center justify-center text-gray-300">
                                    <i class="pi pi-image" style="font-size: 48px;"></i>
                                </div>

                                <div class="absolute top-2 right-2">
                                    <Tag
                                        v-if="example.status === 1"
                                        class="shadow-sm"
                                        severity="success"
                                        value="Active"
                                        rounded
                                    />
                                    <Tag
                                        v-else
                                        class="shadow-sm"
                                        severity="danger"
                                        value="Inactive"
                                        rounded
                                    />
                                </div>
                            </div>

                            <div class="p-4">
                                <h4 class="group-hover:text-indigo-600 transition-colors truncate">
                                    {{ example.name }}
                                </h4>
                                <p class="text-gray-600 mt-1 flex items-center gap-1">
                                    View <i class="pi pi-arrow-right"></i>
                                </p>
                            </div>
                        </router-link>
                    </div>

                    <a-area-empty v-else class="mt-8">
                        No examples have been assigned to this category yet.
                    </a-area-empty>
                </div>

            </div>
        </div>
    </div>
</template>
