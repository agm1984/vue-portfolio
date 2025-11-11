<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';

defineOptions({ name: 'show-user' });

const INITIAL = 'INITIAL';
const SHOWING = 'SHOWING';

const state = ref(INITIAL);
const user = ref({});

const isInitializing = computed(() => state.value === INITIAL);
const isShowing = computed(() => state.value === SHOWING);

const currentRoute = useRoute()

async function fetchUser() {
    try {
        state.value = INITIAL;

        const { data } = await axios.get(route('admin.users.show', currentRoute.params.user))

        user.value = data.user
        state.value = SHOWING
    } catch (err) {
        console.error(`show-user# Problem fetching user: ${err}.`)
    }
}

onMounted(fetchUser)
</script>

<template>
    <a-card class="p-8">
        <div class="relative flex items-center gap-8">
            <a-avatar :size="64" :user="user"></a-avatar>
            <h2>{{ user.name }}</h2>
        </div>

        <div v-if="isShowing" class="w-full grid grid-cols-[100px_1fr] gap-4 mt-8">
            <a-input-field title="ID"></a-input-field>
            <span>{{ user.id }}</span>

            <a-input-field title="Status"></a-input-field>
            <a-status-tag v-if="user.status === 0" severity="danger" label="Inactive"></a-status-tag>
            <a-status-tag v-if="user.status === 1" severity="success" label="Active"></a-status-tag>

            <a-input-field title="Name"></a-input-field>
            <span>{{ user.name }}</span>

            <a-input-field title="Email"></a-input-field>
            <div class="flex items-center gap-2">
                <span>{{ user.email }}</span>
                <i
                    v-if="user.email_verified_at"
                    class="pi pi-check-circle text-green-600 ml-2"
                    title="Verified"
                ></i>
            </div>

            <a-input-field title="Created at"></a-input-field>
            <span>{{ user.created_at_nice }} ({{ user.created_at_diff }})</span>

            <a-input-field title="Updated at"></a-input-field>
            <span>{{ user.updated_at_nice }} ({{ user.updated_at_diff }})</span>
        </div>
  </a-card>
</template>
