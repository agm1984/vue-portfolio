<script setup>
import { ref, computed, onMounted } from 'vue';
import Button from 'primevue/button';
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
        <div class="w-full flex items-center justify-between gap-4">
            <h2>Examples</h2>

            <Button as-child v-slot="slotProps">
                <router-link
                    :to="{ name: 'admin.examples.create' }"
                    :class="slotProps.class"
                ><i class="pi pi-plus"></i>Add Example</router-link>
            </Button>
        </div>

        <DataTable class="mt-4" :value="examples" :loading="isLoading">
            <Column field="name" header="Name">
                <template #body="{ data }">
                    <router-link
                        class="font-semibold hover:underline"
                        :to="{ name: 'admin.examples.show', params: { example: data.slug } }"
                    >{{ data.name }}</router-link>
                </template>
            </Column>

            <Column field="slug" header="Slug"></Column>

            <Column field="category.name" header="Category"></Column>

            <Column field="created_at_diff" header="Created"></Column>

            <Column field="updated_at_diff" header="Last Updated"></Column>

            <Column field="status_nice" header="Status">
                <template #body="{ data }">
                    <a-status-tag v-if="data.status === 0" severity="danger" label="Inactive"></a-status-tag>
                    <a-status-tag v-if="data.status === 1" severity="success" label="Active"></a-status-tag>
                </template>
            </Column>

            <template #footer>
                <span>{{ examples.length === 1 ? '1 example' : `${examples.length} examples` }}</span>
            </template>
        </DataTable>
    </a-card>
</template>
