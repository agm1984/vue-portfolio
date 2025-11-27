<script setup>
import { ref, onMounted } from 'vue';
import { useHead } from '@unhead/vue';
import { useRouter } from 'vue-router';
import { FilterMatchMode } from '@primevue/core/api';
import { useToast } from 'primevue/usetoast';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Tag from 'primevue/tag';
import Button from 'primevue/button';
import { useAuthStore } from '~/store/auth';
import { useAdminExamplesStore } from '~/store/adminExamples';

useHead({
    title: 'Admin List Examples',
});

const router = useRouter();
const toast = useToast();
const auth = useAuthStore();
const adminExamples = useAdminExamplesStore();

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const statusMap = {
    0: { label: 'Inactive', severity: 'danger', icon: 'pi pi-times-circle' },
    1: { label: 'Active', severity: 'success', icon: 'pi pi-check-circle' },
};

const getStatusConfig = (status) => statusMap[status] || { label: 'Unknown', severity: 'info', icon: 'pi pi-question' };

const fetchAllExamples = () => {
    if (!adminExamples.allExamples.length) {
        adminExamples.getAllExamples();
    }
};

onMounted(fetchAllExamples);

const goBack = () => router.push({ name: 'admin' });
</script>

<template>
    <a-page>
        <div class="flex flex-col md:flex-row items-center md:justify-between gap-4 mb-4 md:mb-0">
            <a-page-title
                title="Examples"
                description="Manage portfolio experience examples."
                has-back
                @on-back="goBack"
            ></a-page-title>

            <div v-if="auth.isAdmin">
                <router-link :to="{ name: 'admin.examples.create' }">
                    <Button
                        type="button"
                        severity="primary"
                        icon="pi pi-plus"
                        label="Add Example"
                        raised
                    />
                </router-link>
            </div>
        </div>

        <a-card class="p-8">
            <div class="flex justify-end pb-4">
                <a-input-search
                    v-model="filters['global'].value"
                    placeholder="Search examples..."
                />
            </div>

            <DataTable
                v-model:filters="filters"
                :value="adminExamples.allExamples"
                :loading="adminExamples.isFetchingExamples"
                paginator
                :rows="10"
                :rowsPerPageOptions="[5, 10, 25, 50]"
                :globalFilterFields="['name', 'slug', 'category.name']"
                removableSort
                stripedRows
            >
                <template #empty>
                    <div class="text-center py-8">
                        <i class="pi pi-folder-open text-gray-300 dark:text-gray-600 mb-4" style="font-size: 64px;"></i>
                        <p v-if="adminExamples.isFetchingExamples" class="text-gray-600 dark:text-gray-400">Loading...</p>
                        <p v-if="!adminExamples.isFetchingExamples" class="text-gray-600 dark:text-gray-400">No examples found matching your criteria.</p>
                    </div>
                </template>

                <Column field="name" header="Name" sortable>
                    <template #body="{ data }">
                        <router-link
                            class="font-semibold text-gray-800 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 text-base"
                            :to="{ name: 'admin.examples.show', params: { example: data.slug } }"
                        >
                            {{ data.name }}
                        </router-link>
                    </template>
                </Column>

                <Column field="slug" header="Slug" sortable>
                    <template #body="{ data }">
                         <span class="font-mono text-sm text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-1 rounded">
                            {{ data.slug }}
                        </span>
                    </template>
                </Column>

                <Column field="category.name" header="Category" sortable>
                    <template #body="{ data }">
                        <Tag
                            class="!bg-gray-100 dark:!bg-gray-700 !text-gray-600 dark:!text-gray-300 border border-gray-200 dark:border-gray-600"
                            severity="info"
                            :value="data.category?.name || 'Uncategorized'"
                            rounded
                        />
                    </template>
                </Column>

                <Column field="status" header="Status" sortable>
                    <template #body="{ data }">
                        <Tag
                            class="uppercase text-[10px] font-semibold tracking-wider px-2"
                            :severity="getStatusConfig(data.status).severity"
                            :icon="getStatusConfig(data.status).icon"
                            :value="getStatusConfig(data.status).label"
                            rounded
                        />
                    </template>
                </Column>

                <Column field="created_at_diff" header="Created" sortable>
                    <template #body="{ data }">
                        <span class="text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap">{{ data.created_at_diff }}</span>
                    </template>
                </Column>

                <Column field="updated_at_diff" header="Updated" sortable>
                    <template #body="{ data }">
                        <span class="text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap">{{ data.updated_at_diff }}</span>
                    </template>
                </Column>

                <Column style="width: 3rem; text-align: center">
                    <template #body="{ data }">
                        <router-link
                            v-tooltip.bottom="'View'"
                            :to="{
                                name: 'admin.examples.show',
                                params: {
                                    example: data.slug,
                                }
                            }"
                        >
                            <Button type="button" icon="pi pi-chevron-right" text rounded severity="secondary" />
                        </router-link>
                    </template>
                </Column>
            </DataTable>
        </a-card>
    </a-page>
</template>
