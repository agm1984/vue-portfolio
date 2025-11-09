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
    <a-card class="p-8" with-geometry>
        <div class="relative flex items-center mb-16">
            <a-avatar :size="64" :user="user"></a-avatar>
            <h2 level="2" class="ml-8">
                {{ user.name }}
            </h2>
        </div>

        <div v-if="isShowing">
            <a-input-row type="is-wider-right" heading="ID">
                <span>{{ user.id }}</span>
            </a-input-row>

            <a-input-row class="pt-8" type="is-wider-right" heading="Status">
                <a-status-tag v-if="user.status === 1" status="Active"></a-status-tag>
            </a-input-row>

            <a-input-row class="pt-8" type="is-wider-right" heading="Name">
                <span>{{ user.name }}</span>
            </a-input-row>

            <a-input-row class="pt-8" type="is-wider-right" heading="Email">
                <span>{{ user.email }}</span>
                <i
                    v-if="user.email_verified_at"
                    class="pi pi-check-circle text-green-600 ml-2"
                    title="Verified"
                ></i>
            </a-input-row>

            <a-input-row class="pt-8" type="is-wider-right" heading="Created at">
                <span>{{ user.created_at_nice }} ({{ user.created_at_diff }})</span>
            </a-input-row>

            <a-input-row class="pt-8" type="is-wider-right" heading="Updated at">
                <span>{{ user.updated_at_nice }} ({{ user.updated_at_diff }})</span>
            </a-input-row>
        </div>
  </a-card>
</template>
