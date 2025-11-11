<script setup>
import { ref, computed, onMounted } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import axios from 'axios';

const LOADING = 'is-loading';
const LOADED = 'is-loaded';

const state = ref(LOADING);
const users = ref([]);

const isLoading = computed(() => state.value === LOADING);
// const isLoaded = computed(() => state.value === LOADED);

const fetchAllUsers = async () => {
    try {
        state.value = LOADING;

        const { data } = await axios.get(route('admin.users.list'));

        users.value = data.users;
        state.value = LOADED;
    } catch (err) {
        throw new Error(`list-users# Problem fetching all users: ${err}.`);
    }
}

onMounted(fetchAllUsers);

// todo: hide email address for non-admin users
</script>

<template>
    <a-card class="p-8">
        <h2>Users</h2>

        <DataTable class="mt-8" :value="users" :loading="isLoading">
            <Column field="name" header="Name">
                <template #body="{ data }">
                    <div class="flex items-center gap-2">
                        <a-avatar :size="32" :user="data"></a-avatar>
                        <router-link
                            class="font-semibold hover:underline"
                            :to="{
                                name: 'admin.users.show',
                                params: { user: data.id },
                            }"
                        >{{ data.name }}</router-link>
                    </div>
                </template>
            </Column>

            <Column field="email" header="Email"></Column>

            <Column field="created_at_diff" header="Created"></Column>

            <Column field="updated_at_diff" header="Last Updated"></Column>

            <Column field="status_nice" header="Status">
                <template #body="{ data }">
                    <a-status-tag v-if="data.status === 0" severity="danger" label="Inactive"></a-status-tag>
                    <a-status-tag v-if="data.status === 1" severity="success" label="Active"></a-status-tag>
                </template>
            </Column>

            <template #footer>
                <span>{{ users.length === 1 ? '1 user' : `${users.length} users` }}</span>
            </template>
        </DataTable>
    </a-card>
</template>
