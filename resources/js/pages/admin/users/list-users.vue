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
import { useAdminUsersStore } from '~/store/adminUsers';

useHead({
    title: 'Admin List Users',
});

const router = useRouter();
const toast = useToast();
const adminUsers = useAdminUsersStore();

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
        admin: 'contrast',
        standard: 'secondary',
    };

    return map[role.toLowerCase()] || 'secondary';
};

const fetchAllUsers = () => {
    if (!adminUsers.allUsers.length) {
        adminUsers.getAllUsers();
    }
};

onMounted(fetchAllUsers);

const goBack = () => router.push({ name: 'admin' });
</script>

<template>
    <a-page>
        <div class="flex flex-col md:flex-row items-center md:justify-between gap-4 mb-4 md:mb-0">
            <a-page-title
                title="Users"
                description="Manage system access and roles."
                has-back
                @on-back="goBack"
            ></a-page-title>

            <div class="flex gap-2"></div>
        </div>

        <a-card class="p-8">
            <div class="flex justify-end pb-4">
                <a-input-search
                    v-model="filters['global'].value"
                    placeholder="Search users..."
                />
            </div>

            <DataTable
                v-model:filters="filters"
                :value="adminUsers.allUsers"
                :loading="adminUsers.isFetchingUsers"
                paginator
                :rows="10"
                :rowsPerPageOptions="[5, 10, 25, 50]"
                :globalFilterFields="['name', 'email', 'roles_list']"
                removableSort
                stripedRows
            >
                <template #empty>
                    <div class="text-center py-8">
                        <i class="pi pi-folder-open text-gray-300 dark:text-gray-600 mb-4" style="font-size: 64px;"></i>
                        <p v-if="adminUsers.isFetchingUsers" class="text-gray-600 dark:text-gray-400">Loading...</p>
                        <p v-else class="text-gray-600 dark:text-gray-400">No users found matching your criteria.</p>
                    </div>
                </template>

                <Column field="name" header="User" sortable>
                    <template #body="{ data }">
                        <div class="flex items-center gap-3">
                            <a-avatar :size="32" :user="data" class="shrink-0"></a-avatar>
                            <div class="flex flex-col">
                                <router-link
                                    :to="{ name: 'admin.users.show', params: { user: data.id } }"
                                    class="font-semibold text-gray-800 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 active:text-indigo-700"
                                >
                                    {{ data.name }}
                                </router-link>
                                <span class="text-xs text-gray-600 dark:text-gray-400">ID: {{ data.id }}</span>
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
                        <span class="text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap">{{ data.created_at_diff }}</span>
                    </template>
                </Column>

                <Column style="width: 3rem; text-align: center">
                    <template #body="{ data }">
                        <router-link
                            v-tooltip.bottom="'View'"
                            :to="{
                                name: 'admin.users.show',
                                params: {
                                    user: data.id,
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
