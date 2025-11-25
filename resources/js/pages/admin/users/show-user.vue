<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useHead } from '@unhead/vue';
import axios from 'axios';
import Tag from 'primevue/tag';
import Button from 'primevue/button';
import Skeleton from 'primevue/skeleton';

useHead({
    title: 'Admin: User Details',
});

const route = useRoute();
const router = useRouter();

const LOADING = 'LOADING';
const LOADED = 'LOADED';
const ERROR = 'ERROR';
const isLoading = computed(() => state.value === LOADING);
const isLoaded = computed(() => state.value === LOADED);
const state = ref(LOADING);
const user = ref({});

const getStatusConfig = (status) => {
    return status === 1
        ? { label: 'Active', severity: 'success', icon: 'pi pi-check-circle' }
        : { label: 'Inactive', severity: 'danger', icon: 'pi pi-ban' };
};

const fetchUser = async () => {
    try {
        state.value = LOADING;

        const { data } = await axios.get(window.route('admin.users.show', route.params.user));

        user.value = data.user;

        state.value = LOADED;
    } catch (err) {
        console.error(`show-user# Problem fetching user: ${err}.`);
        state.value = ERROR;
    }
};

const goBack = () => router.push({ name: 'admin.users.list' });

onMounted(fetchUser);
</script>

<template>
    <div class="flex-1 w-full flex flex-col transition-colors duration-300">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <Button
                    type="button"
                    severity="secondary"
                    icon="pi pi-arrow-left"
                    aria-label="Go Back"
                    text
                    rounded
                    @click="goBack"
                />

                <div>
                    <h1 class="text-gray-900 dark:text-white">User Profile</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Manage account details and permissions.</p>
                </div>
            </div>

            <div v-if="isLoaded" class="flex gap-2">
                <Button
                    type="button"
                    icon="pi pi-pencil"
                    label="Edit User"
                    disabled
                />
            </div>
        </div>

        <div v-if="isLoading" class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4">
            <div class="lg:col-span-1"><Skeleton height="300px" borderRadius="1rem" /></div>
            <div class="lg:col-span-2"><Skeleton height="300px" borderRadius="1rem" /></div>
        </div>

        <div v-else-if="isLoaded" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start mt-4">
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col items-center text-center p-8 transition-colors duration-300">
                    <div class="mb-6 relative">
                        <a-avatar :size="128" :user="user" class="shadow-lg"></a-avatar>

                        <div class="absolute bottom-0 right-0 w-8 h-8 flex items-center justify-center bg-white dark:bg-gray-700 rounded-full border dark:border-gray-600 transition-colors">
                            <i
                                v-if="user.email_verified_at"
                                class="pi pi-verified text-green-500 bg-white dark:bg-gray-700 rounded-full"
                                title="Verified Account"
                            ></i>
                        </div>
                    </div>

                    <h2 class="text-gray-900 dark:text-white">{{ user.name }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1 break-all">{{ user.email }}</p>

                    <div class="mt-4 w-full">
                        <Tag
                            class="w-full uppercase"
                            :severity="getStatusConfig(user.status).severity"
                            :icon="getStatusConfig(user.status).icon"
                            :value="getStatusConfig(user.status).label"
                        />
                    </div>

                    <div class="mt-6 w-full pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-between text-sm transition-colors">
                        <span class="text-gray-600 dark:text-gray-400">ID</span>
                        <span class="font-mono font-semibold text-gray-700 dark:text-gray-300">#{{ user.id }}</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 transition-colors">
                        <h3 class="text-gray-900 dark:text-white">Account Information</h3>
                    </div>

                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-4">
                        <div>
                            <h6 class="text-gray-900 dark:text-white">Email Address</h6>

                            <div class="flex items-center gap-2 text-gray-800 dark:text-gray-200 font-medium mt-1">
                                <i class="pi pi-envelope text-indigo-500 dark:text-indigo-400"></i>
                                <span>{{ user.email }}</span>
                            </div>
                        </div>

                        <div>
                            <h6 class="text-gray-900 dark:text-white">Verification</h6>

                            <div v-if="user.email_verified_at" class="flex items-center gap-2 text-green-600 dark:text-green-400 font-medium mt-1">
                                <i class="pi pi-verified"></i>
                                <span>Verified on {{ new Date(user.email_verified_at).toLocaleDateString() }}</span>
                            </div>

                            <div v-else class="flex items-center gap-2 text-orange-500 dark:text-orange-400 font-medium mt-1">
                                <i class="pi pi-exclamation-circle"></i>
                                <span>Unverified</span>
                            </div>
                        </div>

                        <div class="md:col-span-2" v-if="user.roles_list && user.roles_list.length">
                            <h6 class="text-gray-900 dark:text-white">Assigned Roles</h6>

                            <div class="flex gap-2 mt-1">
                                <Tag
                                    v-for="role in user.roles_list"
                                    :key="`assigned-role-${role}`"
                                    class="capitalize"
                                    severity="secondary"
                                    :value="role"
                                />
                            </div>
                        </div>

                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                     <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 transition-colors">
                        <h3 class="text-gray-900 dark:text-white">System Activity</h3>
                    </div>

                    <div class="p-8">
                        <div class="flex flex-col md:flex-row gap-8">
                            <div class="flex-1">
                                <h6 class="text-gray-900 dark:text-white">Member Since</h6>

                                <p class="text-gray-800 dark:text-white font-medium mt-1">{{ user.created_at_nice }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ user.created_at_diff }}</p>
                            </div>

                            <div class="hidden md:block w-px bg-gray-100 dark:bg-gray-700 transition-colors"></div>

                            <div class="flex-1">
                                <h6 class="text-gray-900 dark:text-white">Last Profile Update</h6>

                                <p class="text-gray-800 dark:text-white font-medium mt-1">{{ user.updated_at_nice }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ user.updated_at_diff }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div v-else class="p-12 text-center mt-4">
            <i class="pi pi-exclamation-triangle text-orange-500 dark:text-orange-400 mb-4" style="font-size: 48px;"></i>
            <h3 class="text-gray-900 dark:text-white">User not found</h3>
            <Button
                type="button"
                class="mt-4"
                label="Go Back"
                outlined
                @click="goBack"
            />
        </div>
    </div>
</template>
