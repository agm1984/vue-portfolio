<script setup>
import { ref, computed, onMounted } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import axios from 'axios';

const LOADING = 'is-loading';
const LOADED = 'is-loaded';

const state = ref(LOADING);
const categories = ref([]);

const isLoading = computed(() => state.value === LOADING);
// const isLoaded = computed(() => state.value === LOADED);

async function fetchAllCategories() {
    try {
        state.value = LOADING;

        const { data } = await axios.get(route('admin.categories.list'));

        categories.value = data.categories;
        state.value = LOADED;
    } catch (err) {
        throw new Error(`list-categories# Problem fetching all categories: ${err}.`);
    }
}

onMounted(fetchAllCategories);
</script>

<template>
    <a-card class="p-8">
        <DataTable :value="categories" :loading="isLoading">
            <template #header>
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <span class="text-3xl font-bold">Categories</span>
                </div>
            </template>
            <Column field="name" header="Name">
                <template #body="slotProps">
                    <router-link
                        class="font-semibold hover:underline"
                        :to="{
                            name: 'admin.categories.show',
                            params: { category: slotProps.data.slug },
                        }"
                    >{{ slotProps.data.name }}</router-link>
                </template>
            </Column>
            <Column field="slug" header="Slug"></Column>
            <Column field="created_at_diff" header="Created"></Column>
            <Column field="updated_at_diff" header="Last Updated"></Column>
            <Column field="status_nice" header="Status">
                <template #body="slotProps">
                    <a-status-tag :status="slotProps.data.status_nice"></a-status-tag>
                </template>
            </Column>
            <template #footer>{{ categories ? categories.length : 0 }} categories total</template>
        </DataTable>
    </a-card>
</template>
