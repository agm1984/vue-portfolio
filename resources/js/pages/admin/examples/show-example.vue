<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useHead } from '@unhead/vue';
import axios from 'axios';
import Button from 'primevue/button';
import Tag from 'primevue/tag';
import Skeleton from 'primevue/skeleton';

useHead({
    title: 'Admin: Example Details',
});

const route = useRoute();
const router = useRouter();

const LOADING = 'LOADING';
const SHOWING = 'SHOWING';
const EDITING = 'EDITING';

const state = ref(LOADING);
const example = ref({
    id: null,
    name: '',
    slug: '',
    status: 0,
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

const isLoading = computed(() => state.value === LOADING);
const isShowing = computed(() => state.value === SHOWING);
const isEditing = computed(() => state.value === EDITING);

const getStatusConfig = (status) => {
    if (status === 1) return { severity: 'success', icon: 'pi pi-check-circle', label: 'Active' };
    if (status === 0) return { severity: 'danger', icon: 'pi pi-ban', label: 'Inactive' };
    return { severity: 'info', icon: 'pi pi-info-circle', label: 'Unknown' };
};

const fetchExample = async () => {
    try {
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
    <div class="flex-1 w-full flex flex-col transition-colors duration-300">
        <div class="flex flex-col md:flex-row items-center md:justify-between gap-4 mb-4 md:mb-0">
            <a-page-title
                :title="example.name"
                has-back
                @on-back="goBack"
            >
                <template #description>
                    <div class="flex items-center gap-2">
                        <h6>Slug</h6>
                        <span class="font-mono text-xs text-indigo-600 dark:text-indigo-400 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded transition-colors">/{{ example.slug }}</span>
                    </div>
                </template>
            </a-page-title>

            <div v-if="!isLoading">
                <Button
                    v-if="isShowing"
                    type="button"
                    class="whitespace-nowrap"
                    icon="pi pi-pencil"
                    label="Edit Example"
                    @click="state = EDITING"
                />

                <Button
                    v-if="isEditing"
                    type="button"
                    class="whitespace-nowrap"
                    severity="secondary"
                    icon="pi pi-times"
                    label="Cancel Editing"
                    outlined
                    @click="state = SHOWING"
                />
            </div>
        </div>

        <div v-if="isLoading" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <Skeleton height="200px" border-radius="1rem" />
                <Skeleton height="400px" border-radius="1rem" />
            </div>
            <div class="lg:col-span-1 space-y-8">
                <Skeleton height="300px" border-radius="1rem" />
                <Skeleton height="200px" border-radius="1rem" />
            </div>
        </div>

        <div v-else-if="isEditing" class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-indigo-200 dark:border-indigo-900 ring-4 ring-indigo-50 dark:ring-indigo-900/20 p-8 transition-colors duration-300">
            <div class="flex items-center gap-2 text-indigo-600 dark:text-indigo-400 font-semibold border-b border-gray-100 dark:border-gray-700 pb-2 mb-8">
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
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 transition-colors duration-300">
                    <div class="space-y-8">
                        <div>
                            <h3 class="text-sm font-semibold uppercase text-gray-600 dark:text-gray-400">Summary</h3>
                            <p class="text-gray-800 dark:text-gray-300 leading-relaxed whitespace-pre-wrap mt-2">{{ example.summary }}</p>
                        </div>

                        <div v-if="example.conclusion" class="bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl border-l-4 border-indigo-500 dark:border-indigo-400 p-8 transition-colors">
                            <h3 class="text-sm font-semibold uppercase text-indigo-600 dark:text-indigo-400">Final Thoughts</h3>
                            <p class="text-gray-800 dark:text-gray-300 leading-relaxed whitespace-pre-wrap mt-2">{{ example.conclusion }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 transition-colors duration-300">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="pi pi-images text-gray-500 dark:text-gray-400"></i> Gallery
                        </h3>
                        <span class="text-xs text-gray-600 dark:text-gray-400">{{ example.images.length }} images</span>
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
                            <a-image
                                :src="`/storage/examples/${example.slug}/${image.filename}`"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                alt="Project Screenshot"
                                background="#ffffff"
                            />
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                <i class="pi pi-search-plus text-white opacity-0 group-hover:opacity-100 transition-opacity drop-shadow-md" style="font-size: 24px;"></i>
                            </div>
                        </router-link>
                    </div>
                    <a-area-empty v-else>No images uploaded yet.</a-area-empty>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-8">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 transition-colors duration-300">
                    <div class="flex items-center justify-between mb-2">
                        <h6 class="text-gray-900 dark:text-white">Status</h6>
                        <span class="font-mono text-xs text-gray-300 dark:text-gray-600">#{{ example.id }}</span>
                    </div>
                    <div class="mb-6">
                        <Tag
                            :severity="getStatusConfig(example.status).severity"
                            :icon="getStatusConfig(example.status).icon"
                            :value="getStatusConfig(example.status).label"
                        />
                    </div>

                    <div class="mb-4">
                         <h6 class="text-gray-900 dark:text-white">Category</h6>

                         <div class="flex items-center gap-2 mt-1">
                             <i class="pi pi-folder text-indigo-500 dark:text-indigo-400"></i>
                             <span class="font-semibold text-gray-800 dark:text-white">{{ example.category.name }}</span>
                         </div>
                    </div>

                    <div class="border-t border-gray-100 dark:border-gray-700 space-y-4 pt-4 transition-colors">
                        <div>
                            <h6 class="text-gray-900 dark:text-white">Created</h6>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ example.created_at_nice }}</span>
                        </div>
                        <div>
                            <h6 class="text-gray-900 dark:text-white">Last Update</h6>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ example.updated_at_nice }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 transition-colors duration-300">
                    <h3 class="flex items-center gap-2 text-gray-900 dark:text-white">
                        <i class="pi pi-link"></i> Resources
                    </h3>
                    <div v-if="example.links.length" class="flex flex-col gap-2 mt-4">
                        <a
                            v-for="link in example.links"
                            :key="link.url"
                            :href="link.url"
                            target="_blank"
                            class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors group"
                        >
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ link.name }}</span>
                            <i class="pi pi-external-link text-xs text-gray-500 dark:text-gray-400 group-hover:text-indigo-500 dark:group-hover:text-indigo-400"></i>
                        </a>
                    </div>
                    <div v-else class="text-sm text-gray-500 dark:text-gray-400 italic">No external links.</div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 transition-colors duration-300">
                    <h3 class="text-sm font-semibold uppercase text-gray-500 dark:text-gray-400 flex items-center gap-2">
                        <i class="pi pi-tags"></i> Tags
                    </h3>

                    <div v-if="example.tags.length" class="flex flex-wrap gap-2 mt-4">
                        <Tag
                            v-for="(tag, index) in example.tags"
                            :key="`tag-${index}`"
                            severity="secondary"
                            :value="tag"
                            rounded
                        />
                    </div>
                    <div v-else class="text-sm text-gray-500 dark:text-gray-400 italic">No tags assigned.</div>
                </div>
            </div>
        </div>
    </div>
</template>
