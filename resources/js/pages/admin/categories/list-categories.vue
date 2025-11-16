<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Tag from 'primevue/tag';

const LOADING = 'is-loading';
const LOADED = 'is-loaded';

const state = ref(LOADING);
const categories = ref([]);

const isLoading = computed(() => state.value === LOADING);
// const isLoaded = computed(() => state.value === LOADED);

const fetchAllCategories = async () => {
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
        <div class="w-full flex items-center justify-between gap-4">
            <h2>Categories</h2>

            <Button as-child v-slot="slotProps">
                <router-link
                    :to="{ name: 'admin.categories.create' }"
                    :class="slotProps.class"
                ><i class="pi pi-plus"></i>Add Category</router-link>
            </Button>
        </div>

        <DataTable class="mt-4" :value="categories" :loading="isLoading">
            <Column field="name" header="Name">
                <template #body="{ data }">
                    <router-link
                        class="font-semibold hover:underline"
                        :to="{
                            name: 'admin.categories.show',
                            params: { category: data.slug },
                        }"
                    >{{ data.name }}</router-link>
                </template>
            </Column>

            <Column field="slug" header="Slug"></Column>

            <Column field="created_at_diff" header="Created"></Column>

            <Column field="updated_at_diff" header="Last Updated"></Column>

            <Column field="status_nice" header="Status">
                <template #body="{ data }">
                    <Tag v-if="data.status === 0" severity="danger" value="Inactive" />
                    <Tag v-if="data.status === 1" severity="success" value="Active" />
                </template>
            </Column>

            <template #footer>
                <span>{{ categories.length === 1 ? '1 category' : `${categories.length} categories` }}</span>
            </template>
        </DataTable>
    </a-card>
</template>
