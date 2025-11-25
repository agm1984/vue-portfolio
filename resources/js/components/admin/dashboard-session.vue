<script setup>
import { useAuthStore } from '~/store/auth';

const auth = useAuthStore();
</script>

<template>
    <div class="bg-linear-to-br from-indigo-600 to-purple-700 dark:from-indigo-900 dark:to-purple-950 rounded-xl p-6 text-white shadow-md flex flex-col justify-center transition-all duration-300 border border-transparent dark:border-indigo-700/50">
        <h3 v-if="auth.isAuthenticated && auth.isAdmin" class="text-xl font-semibold text-indigo-200! dark:text-indigo-300! mb-2">Admin Access</h3>
        <h3 v-else-if="auth.isAuthenticated && auth.isStandard" class="text-xl font-semibold text-indigo-200! dark:text-indigo-300! mb-2">Standard Access</h3>
        <h3 v-else class="text-xl font-semibold text-indigo-200! dark:text-indigo-300! mb-2">Guest Access</h3>

        <p v-if="auth.isAuthenticated" class="text-indigo-100 dark:text-indigo-200 text-sm mb-6 transition-colors">
            You are currently logged in with {{ auth.isAdmin ? 'full admin' : 'standard' }} privileges.
        </p>
        <p v-else class="text-indigo-100 dark:text-indigo-200 text-sm mb-6 transition-colors">
            Please <router-link class="font-semibold hover:underline text-white" :to="{ name: 'login' }">Login</router-link>
            or <router-link class="font-semibold hover:underline text-white" :to="{ name: 'register' }">Register</router-link>
            to access more features.
        </p>

        <div class="bg-white/10 dark:bg-black/20 backdrop-blur-sm rounded-lg p-4 border border-white/20 dark:border-white/10 transition-colors">
            <div class="flex items-center gap-3 mb-2">
                <div v-if="auth.isAuthenticated" class="w-2 h-2 rounded-full bg-green-400 animate-pulse shadow-[0_0_8px_rgba(74,222,128,0.6)]"></div>
                <div v-else class="w-2 h-2 rounded-full bg-red-400 animate-pulse shadow-[0_0_8px_rgba(248,113,113,0.6)]"></div>
                <span class="font-mono text-sm text-indigo-50 dark:text-indigo-300">Session</span>
            </div>

            <template v-if="auth.isAuthenticated">
                <div class="text-sm text-indigo-100 dark:text-indigo-200 transition-colors">
                    <span class="font-semibold text-white">User:</span> {{ auth.user?.name }}
                </div>
                <div class="text-sm text-indigo-100 dark:text-indigo-200 truncate transition-colors">
                    <span class="font-semibold text-white">Email:</span> {{ auth.user?.email }}
                </div>
            </template>
        </div>
    </div>
</template>
