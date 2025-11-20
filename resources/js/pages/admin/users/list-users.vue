<script setup>
import { ref, onMounted, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { FilterMatchMode } from '@primevue/core/api'; // Check imports based on your PrimeVue version
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

useHead({
    title: 'Admin List Users',
});

const toast = useToast();

// --- STATE ---
const loading = ref(true);
const users = ref([]);
const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

// --- PURE HELPERS ---
/**
 * Maps integer status to visual representation.
 * This keeps logic out of the template.
 */
const statusMap = {
    0: { label: 'Inactive', severity: 'danger', icon: 'pi pi-times-circle' },
    1: { label: 'Active', severity: 'success', icon: 'pi pi-check-circle' },
};

const getStatusConfig = (status) => statusMap[status] || { label: 'Unknown', severity: 'info', icon: 'pi pi-question' };

const getRoleSeverity = (role) => {
    const map = {
        'admin': 'contrast', // Dark/Black tag for admins
        'editor': 'info',
        'user': 'secondary',
    };
    return map[role.toLowerCase()] || 'secondary';
};

// --- ACTIONS ---
const fetchAllUsers = async () => {
    try {
        loading.value = true;
        // Assuming your API returns { users: [...] }
        const { data } = await axios.get(route('admin.users.list'));
        users.value = data.users;
    } catch (err) {
        console.error(err);
        toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to load users', life: 3000 });
    } finally {
        loading.value = false;
    }
};

const exportCSV = () => {
    // PrimeVue DataTable has a built-in exportCSV method, 
    // accessed via Template ref if needed, or we can just map data here.
    // For brevity, we'll just log it, but this is where you'd handle CSV export.
    console.log('Exporting data...');
};

onMounted(fetchAllUsers);
</script>

<template>
    <div class="w-full max-w-7xl mx-auto p-6">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Users</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Manage system access and roles.</p>
            </div>
            <div class="flex gap-2">
                <Button 
                    label="Export" 
                    icon="pi pi-download" 
                    severity="secondary" 
                    outlined 
                    @click="exportCSV" 
                />
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            
            <DataTable 
                :value="users" 
                :loading="loading"
                paginator 
                :rows="10" 
                :rowsPerPageOptions="[5, 10, 25, 50]"
                v-model:filters="filters"
                :globalFilterFields="['name', 'email', 'roles_list']"
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
                                placeholder="Search users..." 
                                class="w-full md:w-64"
                            />
                        </IconField>
                    </div>
                </template>

                <template #empty>
                    <div class="text-center py-8">
                        <p class="text-gray-500">No users found matching your criteria.</p>
                    </div>
                </template>

                <Column field="name" header="User" sortable>
                    <template #body="{ data }">
                        <div class="flex items-center gap-3">
                            <a-avatar :size="32" :user="data" class="shrink-0"></a-avatar>
                            <div class="flex flex-col">
                                <router-link
                                    :to="{ name: 'admin.users.show', params: { user: data.id } }"
                                    class="font-bold text-gray-800 dark:text-white hover:text-indigo-600 transition-colors"
                                >
                                    {{ data.name }}
                                </router-link>
                                <span class="text-xs text-gray-500 dark:text-gray-400">ID: {{ data.id }}</span>
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
                                class="uppercase text-[10px] font-bold tracking-wider px-2"
                            />
                        </div>
                    </template>
                </Column>

                <Column field="status" header="Status" sortable>
                    <template #body="{ data }">
                        <Tag 
                            :value="getStatusConfig(data.status).label" 
                            :severity="getStatusConfig(data.status).severity"
                            :icon="getStatusConfig(data.status).icon"
                            rounded
                        />
                    </template>
                </Column>

                <Column field="created_at_diff" header="Joined" sortable>
                    <template #body="{ data }">
                        <span class="text-sm text-gray-500 whitespace-nowrap">{{ data.created_at_diff }}</span>
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
        </div>
    </div>
</template>
