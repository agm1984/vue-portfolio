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

async function fetchAllUsers() {
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
</script>

<template>
    <a-card with-geometry class="p-8">
        <DataTable :value="users" :loading="isLoading">
            <template #header>
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <span class="text-3xl font-bold">Users</span>
                </div>
            </template>
            <Column field="name" header="Name">
                <template #body="slotProps">
                    <div class="flex items-center gap-2">
                        <a-avatar :size="32" :user="slotProps.data"></a-avatar>
                        <router-link
                            class="font-semibold hover:underline"
                            :to="{
                                name: 'admin.users.show',
                                params: { user: slotProps.data.id },
                            }"
                        >{{ slotProps.data.name }}</router-link>
                    </div>
                </template>
            </Column>
            <Column field="email" header="Email"></Column>
            <Column field="created_at_diff" header="Created"></Column>
            <Column field="updated_at_diff" header="Last Updated"></Column>
            <Column field="status_nice" header="Status">
                <template #body="slotProps">
                    <a-status-tag :status="slotProps.data.status_nice"></a-status-tag>
                </template>
            </Column>
            <template #footer>{{ users ? users.length : 0 }} users total</template>
        </DataTable>
    </a-card>
</template>
