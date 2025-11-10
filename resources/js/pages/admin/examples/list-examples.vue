<script setup>
import { ref, computed, onMounted } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import axios from 'axios';

const LOADING = 'is-loading';
const LOADED = 'is-loaded';

const state = ref(LOADING);
const examples = ref([]);

const isLoading = computed(() => state.value === LOADING);
// const isLoaded = computed(() => state.value === LOADED);

async function fetchAllExamples() {
    try {
        state.value = LOADING;

        const { data } = await axios.get(route('admin.examples.list'));

        examples.value = data.examples;
        state.value = LOADED;
    } catch (err) {
        throw new Error(`list-examples# Problem fetching all examples: ${err}.`);
    }
}

onMounted(fetchAllExamples);
</script>

<template>
    <a-card class="p-8">
        <DataTable :value="examples" :loading="isLoading">
            <template #header>
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <span class="text-3xl font-bold">Examples</span>
                </div>
            </template>
            <Column field="name" header="Name">
                <template #body="slotProps">
                    <router-link class="font-semibold hover:underline" :to="{ name: 'admin.examples.show', params: { example: slotProps.data.slug } }">
                        {{ slotProps.data.name }}
                    </router-link>
                </template>
            </Column>
            <Column field="slug" header="Slug"></Column>
            <Column field="category.name" header="Category"></Column>
            <Column field="created_at_diff" header="Created"></Column>
            <Column field="updated_at_diff" header="Last Updated"></Column>
            <Column field="status_nice" header="Status">
                <template #body="slotProps">
                    <a-status-tag :status="slotProps.data.status_nice"></a-status-tag>
                </template>
            </Column>
            <template #footer>{{ examples ? examples.length : 0 }} examples total</template>
        </DataTable>
    </a-card>
</template>
