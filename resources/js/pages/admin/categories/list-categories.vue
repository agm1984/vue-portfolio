<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue';
import { useHead } from '@unhead/vue';
import { useRouter } from 'vue-router';
import { FilterMatchMode } from '@primevue/core/api';
import { useToast } from 'primevue/usetoast';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Tag from 'primevue/tag';
import Button from 'primevue/button';
import { useAuthStore } from '~/store/auth';
import { useAdminCategoriesStore } from '~/store/adminCategories';

useHead({
    title: 'Admin List Categories',
});

const router = useRouter();
const toast = useToast();
const auth = useAuthStore();
const adminCategories = useAdminCategoriesStore();

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const statusMap = {
    0: { label: 'Inactive', severity: 'danger', icon: 'pi pi-times-circle' },
    1: { label: 'Active', severity: 'success', icon: 'pi pi-check-circle' },
};

const getStatusConfig = (status) => statusMap[status] || { label: 'Unknown', severity: 'info', icon: 'pi pi-question' };

const fetchAllCategories = () => {
    if (!adminCategories.allCategories.length) {
        adminCategories.getAllCategories();
    }
};

onMounted(fetchAllCategories);

const goBack = () => router.push({ name: 'admin' });
</script>

<template>
    <a-page>
        <div class="flex flex-col md:flex-row items-center md:justify-between gap-4 mb-4 md:mb-0">
            <a-page-title
                title="Categories"
                description="Manage and organize categories for portfolio examples."
                has-back
                @on-back="goBack"
            ></a-page-title>

            <div v-if="auth.isAdmin">
                <router-link :to="{ name: 'admin.categories.create' }">
                    <Button
                        type="button"
                        severity="primary"
                        icon="pi pi-plus"
                        label="Add Category"
                        raised
                    />
                </router-link>
            </div>
        </div>

        <a-card class="p-8">
            <div class="flex justify-end pb-4">
                <a-input-search
                    v-model="filters['global'].value"
                    placeholder="Search categories..."
                />
            </div>

            <DataTable
                v-model:filters="filters"
                :value="adminCategories.allCategories"
                :loading="adminCategories.isFetchingCategories"
                paginator
                :rows="10"
                :rowsPerPageOptions="[5, 10, 25, 50]"
                :globalFilterFields="['name', 'slug']"
                removableSort
                stripedRows
            >
                <template #empty>
                    <div class="text-center py-8">
                        <i class="pi pi-folder-open text-gray-300 dark:text-gray-600 mb-4" style="font-size: 64px;"></i>
                        <p v-if="adminCategories.isFetchingCategories" class="text-gray-600 dark:text-gray-400">Loading...</p>
                        <p v-if="!adminCategories.isFetchingCategories" class="text-gray-600 dark:text-gray-400">No categories found matching your criteria.</p>
                    </div>
                </template>

                <Column field="name" header="Name" sortable>
                    <template #body="{ data }">
                        <div class="flex flex-col">
                            <router-link
                                :to="{ name: 'admin.categories.show', params: { category: data.slug } }"
                                class="font-semibold text-gray-800 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 text-base"
                            >
                                {{ data.name }}
                            </router-link>
                        </div>
                    </template>
                </Column>

                <Column field="slug" header="Slug" sortable>
                    <template #body="{ data }">
                        <span class="font-mono text-sm text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-1 rounded">
                            {{ data.slug }}
                        </span>
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

                <Column field="updated_at_diff" header="Last Updated" sortable>
                    <template #body="{ data }">
                        <span class="text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap">{{ data.updated_at_diff }}</span>
                    </template>
                </Column>

                <Column style="width: 3rem; text-align: center">
                    <template #body="{ data }">
                        <router-link
                            v-tooltip.bottom="'View'"
                            :to="{
                                name: 'admin.categories.show',
                                params: {
                                    category: data.slug,
                                },
                            }"
                        >
                            <Button icon="pi pi-chevron-right" text rounded severity="secondary" />
                        </router-link>
                    </template>
                </Column>
            </DataTable>
        </a-card>
    </a-page>
</template>
