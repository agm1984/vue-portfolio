<script setup>
import { ref, onMounted } from 'vue';
import { useHead } from '@unhead/vue';
import { FilterMatchMode } from '@primevue/core/api'; // Ensure correct import for your version
import axios from 'axios';

// PrimeVue Components
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Tag from 'primevue/tag';
import InputText from 'primevue/inputtext';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import Button from 'primevue/button';
import { useToast } from 'primevue/usetoast';

// Store
import { useAuthStore } from '~/store/auth';

useHead({
    title: 'Admin List Examples',
});

const auth = useAuthStore();
const toast = useToast();

// --- STATE ---
const loading = ref(true);
const examples = ref([]);
const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

// --- PURE HELPERS ---
const getStatusConfig = (status) => {
    return status === 1
        ? { label: 'Active', severity: 'success', icon: 'pi pi-check-circle' }
        : { label: 'Inactive', severity: 'danger', icon: 'pi pi-ban' };
};

// --- ACTIONS ---
const fetchAllExamples = async () => {
    try {
        loading.value = true;
        const { data } = await axios.get(route('admin.examples.list'));
        examples.value = data.examples;
    } catch (err) {
        console.error(err);
        toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to load examples', life: 3000 });
    } finally {
        loading.value = false;
    }
};

onMounted(fetchAllExamples);
</script>

<template>
    <div class="w-full max-w-7xl mx-auto p-6">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Examples</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Manage your portfolio projects.</p>
            </div>

            <div v-if="auth.isAdmin">
                <router-link :to="{ name: 'admin.examples.create' }">
                    <Button 
                        label="Add Example" 
                        icon="pi pi-plus" 
                        severity="primary" 
                        raised
                    />
                </router-link>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            
            <DataTable 
                :value="examples" 
                :loading="loading"
                paginator 
                :rows="10" 
                :rowsPerPageOptions="[5, 10, 25, 50]"
                v-model:filters="filters"
                :globalFilterFields="['name', 'slug', 'category.name']"
                tableStyle="min-width: 50rem"
                removableSort
                stripedRows
            >

                <template #header>
                    <div class="flex justify-end">
                        <IconField iconPosition="left">
                            <InputIcon>
                                <i class="pi pi-search" />
                            </InputIcon>
                            <InputText 
                                v-model="filters['global'].value" 
                                placeholder="Search projects..." 
                                class="w-full md:w-64"
                            />
                        </IconField>
                    </div>
                </template>

                <template #empty>
                    <div class="text-center py-8">
                        <i class="pi pi-briefcase text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-600">No examples found.</p>
                    </div>
                </template>

                <Column field="name" header="Name" sortable>
                    <template #body="{ data }">
                        <router-link
                            class="font-bold text-gray-800 dark:text-white hover:text-indigo-600 transition-colors text-base"
                            :to="{ name: 'admin.examples.show', params: { example: data.slug } }"
                        >
                            {{ data.name }}
                        </router-link>
                    </template>
                </Column>

                <Column field="slug" header="Slug" sortable>
                    <template #body="{ data }">
                         <span class="font-mono text-sm text-indigo-600 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-1 rounded">
                            {{ data.slug }}
                        </span>
                    </template>
                </Column>

                <Column field="category.name" header="Category" sortable>
                    <template #body="{ data }">
                        <Tag 
                            :value="data.category?.name || 'Uncategorized'" 
                            severity="info" 
                            rounded 
                            class="!bg-gray-100 !text-gray-600 dark:!bg-gray-700 dark:!text-gray-300 border border-gray-200 dark:border-gray-600"
                        />
                    </template>
                </Column>

                <Column field="status" header="Status" sortable>
                    <template #body="{ data }">
                        <Tag 
                            :value="getStatusConfig(data.status).label" 
                            :severity="getStatusConfig(data.status).severity"
                            :icon="getStatusConfig(data.status).icon"
                            rounded
                            class="uppercase text-[10px] font-bold tracking-wider px-2"
                        />
                    </template>
                </Column>

                <Column field="created_at_diff" header="Created" sortable>
                    <template #body="{ data }">
                        <span class="text-sm text-gray-600 whitespace-nowrap">{{ data.created_at_diff }}</span>
                    </template>
                </Column>

                <Column field="updated_at_diff" header="Updated" sortable>
                    <template #body="{ data }">
                        <span class="text-sm text-gray-600 whitespace-nowrap">{{ data.updated_at_diff }}</span>
                    </template>
                </Column>

                <Column style="width: 3rem; text-align: center">
                    <template #body="{ data }">
                        <router-link :to="{ name: 'admin.examples.show', params: { example: data.slug } }">
                            <Button icon="pi pi-chevron-right" text rounded severity="secondary" />
                        </router-link>
                    </template>
                </Column>

            </DataTable>
        </div>
    </div>
</template>
