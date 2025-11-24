<script setup>
import { ref, onMounted } from 'vue';
import { useHead } from '@unhead/vue';
import { FilterMatchMode } from '@primevue/core/api';
import { useToast } from 'primevue/usetoast';
import axios from 'axios';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Tag from 'primevue/tag';
import InputText from 'primevue/inputtext';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import Button from 'primevue/button';

useHead({
    title: 'Admin List Users',
});

const toast = useToast();

const loading = ref(true);
const users = ref([]);
const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const statusMap = {
    0: { label: 'Inactive', severity: 'danger', icon: 'pi pi-times-circle' },
    1: { label: 'Active', severity: 'success', icon: 'pi pi-check-circle' },
};

const getStatusConfig = (status) => statusMap[status] || { label: 'Unknown', severity: 'info', icon: 'pi pi-question' };

const getRoleSeverity = (role) => {
    const map = {
        'admin': 'contrast',
        'standard': 'secondary',
    };

    return map[role.toLowerCase()] || 'secondary';
};

const fetchAllUsers = async () => {
    try {
        loading.value = true;

        const { data } = await axios.get(route('admin.users.list'));

        users.value = data.users;
    } catch (error) {
        console.error(error);
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Failed to load users',
            life: 5000,
        });
    } finally {
        loading.value = false;
    }
};

onMounted(fetchAllUsers);

const exportCSV = () => {
    console.log('Exporting data...');
};
</script>

<template>
    <div class="flex-1 w-full flex flex-col">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
            <div>
                <h1>Users</h1>
                <p class="text-gray-600 mt-2">Manage system access and roles.</p>
            </div>

            <div class="flex gap-2">
                <Button
                    type="button"
                    icon="pi pi-download"
                    label="Export"
                    outlined
                    @click="exportCSV"
                />
            </div>
        </div>

        <a-card class="p-8">
            <div class="flex justify-end pb-4">
                <IconField iconPosition="left">
                    <InputIcon>
                        <i class="pi pi-search" />
                    </InputIcon>
                    <InputText
                        v-model="filters['global'].value"
                        placeholder="Search users..."
                        class="w-full md:w-64"
                    />
                </IconField>
            </div>

            <DataTable
                v-model:filters="filters"
                :value="users"
                :loading="loading"
                paginator
                :rows="10"
                :rowsPerPageOptions="[5, 10, 25, 50]"
                :globalFilterFields="['name', 'email', 'roles_list']"
                removableSort
                stripedRows
            >
                <template #empty>
                    <div class="text-center py-8">
                        <p class="text-gray-600">No users found matching your criteria.</p>
                    </div>
                </template>

                <Column field="name" header="User" sortable>
                    <template #body="{ data }">
                        <div class="flex items-center gap-3">
                            <a-avatar :size="32" :user="data" class="shrink-0"></a-avatar>
                            <div class="flex flex-col">
                                <router-link
                                    :to="{ name: 'admin.users.show', params: { user: data.id } }"
                                    class="font-semibold text-gray-800 dark:text-white hover:text-indigo-600 active:text-indigo-700 transition-colors"
                                >
                                    {{ data.name }}
                                </router-link>
                                <span class="text-xs text-gray-600 dark:text-gray-500">ID: {{ data.id }}</span>
                            </div>
                        </div>
                    </template>
                </Column>

                <Column field="email" header="Email" sortable>
                    <template #body="{ data }">
                        <span class="text-gray-600 dark:text-gray-300">{{ data.email }}</span>
                    </template>
                </Column>

                <Column field="roles_list" header="Roles" sortable>
                    <template #body="{ data }">
                        <div class="flex flex-wrap gap-1">
                            <Tag
                                v-for="role in data.roles_list"
                                :key="`user-${data.id}-role-${role}`"
                                :value="role"
                                :severity="getRoleSeverity(role)"
                                rounded
                                class="uppercase text-[10px] font-semibold tracking-wider px-2"
                            />
                        </div>
                    </template>
                </Column>

                <Column field="status" header="Status" sortable>
                    <template #body="{ data }">
                        <Tag
                            :severity="getStatusConfig(data.status).severity"
                            :icon="getStatusConfig(data.status).icon"
                            :value="getStatusConfig(data.status).label"
                            rounded
                        />
                    </template>
                </Column>

                <Column field="created_at_diff" header="Joined" sortable>
                    <template #body="{ data }">
                        <span class="text-sm text-gray-600 whitespace-nowrap">{{ data.created_at_diff }}</span>
                    </template>
                </Column>

                <Column style="width: 3rem; text-align: center">
                    <template #body="{ data }">
                        <router-link :to="{ name: 'admin.users.show', params: { user: data.id } }">
                            <Button icon="pi pi-chevron-right" text rounded severity="secondary" />
                        </router-link>
                    </template>
                </Column>
            </DataTable>
        </a-card>
    </div>
</template>
