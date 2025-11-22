<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useHead } from '@unhead/vue';
import axios from 'axios';

// PrimeVue Imports
import Card from 'primevue/card';
import Tag from 'primevue/tag';
import Button from 'primevue/button';
import Skeleton from 'primevue/skeleton';
import Divider from 'primevue/divider';

useHead({
    title: 'Admin: User Details',
});

const route = useRoute();
const router = useRouter();

const LOADING = 'LOADING';
const LOADED = 'LOADED';
const ERROR = 'ERROR';

const state = ref(LOADING);
const user = ref({});

const isLoading = computed(() => state.value === LOADING);
const isLoaded = computed(() => state.value === LOADED);

// --- PURE HELPERS ---
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
    <div class="w-full max-w-7xl mx-auto p-6 md:p-12">
        
        <div class="mb-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <Button 
                    icon="pi pi-arrow-left" 
                    text 
                    rounded 
                    severity="secondary" 
                    @click="goBack"
                    aria-label="Go Back"
                />
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">User Profile</h1>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Manage account details and permissions.</p>
                </div>
            </div>
            
            <div class="flex gap-2" v-if="isLoaded">
                <Button label="Edit User" icon="pi pi-pencil" severity="secondary" outlined />
            </div>
        </div>

        <div v-if="isLoading" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1"><Skeleton height="300px" borderRadius="1rem" /></div>
            <div class="lg:col-span-2"><Skeleton height="300px" borderRadius="1rem" /></div>
        </div>

        <div v-else-if="isLoaded" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 flex flex-col items-center text-center">
                    <div class="mb-6 relative">
                        <a-avatar :size="128" :user="user" class="shadow-lg"></a-avatar>
                        <div class="absolute bottom-0 right-0 bg-white dark:bg-gray-800 rounded-full p-1">
                            <i v-if="user.email_verified_at" class="pi pi-check-circle text-green-500 text-2xl bg-white rounded-full" title="Verified Account"></i>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ user.name }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 break-all">{{ user.email }}</p>

                    <div class="mt-6 w-full">
                        <Tag 
                            :value="getStatusConfig(user.status).label" 
                            :severity="getStatusConfig(user.status).severity"
                            :icon="getStatusConfig(user.status).icon"
                            class="w-full py-2 text-sm uppercase tracking-widest"
                        />
                    </div>

                    <div class="mt-6 w-full pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-between text-sm">
                        <span class="text-gray-600">User ID</span>
                        <span class="font-mono font-bold text-gray-700 dark:text-gray-300">#{{ user.id }}</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">Account Information</h3>
                    </div>
                    
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-4">
                        
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-1">Email Address</label>
                            <div class="flex items-center gap-2 text-gray-800 dark:text-gray-200 font-medium">
                                <i class="pi pi-envelope text-indigo-500"></i>
                                <span>{{ user.email }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-1">Verification</label>
                            <div v-if="user.email_verified_at" class="flex items-center gap-2 text-green-600 font-medium">
                                <i class="pi pi-verified"></i>
                                <span>Verified on {{ new Date(user.email_verified_at).toLocaleDateString() }}</span>
                            </div>
                            <div v-else class="flex items-center gap-2 text-orange-500 font-medium">
                                <i class="pi pi-exclamation-circle"></i>
                                <span>Unverified</span>
                            </div>
                        </div>

                        <div class="md:col-span-2" v-if="user.roles_list && user.roles_list.length">
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Assigned Roles</label>
                            <div class="flex gap-2">
                                <Tag 
                                    v-for="role in user.roles_list" 
                                    :key="role" 
                                    :value="role" 
                                    severity="secondary" 
                                    class="capitalize"
                                />
                            </div>
                        </div>

                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                     <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">System Activity</h3>
                    </div>

                    <div class="p-8">
                        <div class="flex flex-col md:flex-row gap-8">
                            <div class="flex-1">
                                <label class="block text-xs font-bold uppercase text-gray-400 mb-1">Member Since</label>
                                <p class="text-gray-800 dark:text-white font-medium">{{ user.created_at_nice }}</p>
                                <p class="text-xs text-gray-600 mt-1">{{ user.created_at_diff }}</p>
                            </div>
                            
                            <div class="hidden md:block w-px bg-gray-100 dark:bg-gray-700"></div>

                            <div class="flex-1">
                                <label class="block text-xs font-bold uppercase text-gray-400 mb-1">Last Profile Update</label>
                                <p class="text-gray-800 dark:text-white font-medium">{{ user.updated_at_nice }}</p>
                                <p class="text-xs text-gray-600 mt-1">{{ user.updated_at_diff }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div v-else class="p-12 text-center">
            <i class="pi pi-exclamation-triangle text-4xl text-orange-500 mb-4"></i>
            <h3>User not found</h3>
            <Button label="Go Back" text @click="goBack" />
        </div>
    </div>
</template>