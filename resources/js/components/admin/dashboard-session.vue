<script setup>
import { useAuthStore } from '~/store/auth';

const auth = useAuthStore();
</script>

<template>
    <div class="bg-linear-to-br from-indigo-600 to-purple-700 rounded-xl p-6 text-white shadow-md flex flex-col justify-center">
        <h3 v-if="auth.isAuthenticated && auth.isAdmin" class="text-xl font-bold mb-2">Admin Access</h3>
        <h3 v-else-if="auth.isAuthenticated && auth.isStandard" class="text-xl font-bold mb-2">Standard Access</h3>
        <h3 v-else class="text-xl font-bold mb-2">Guest Access</h3>
        <p v-if="auth.isAuthenticated" class="text-indigo-100 text-sm mb-6">
            You are currently logged in with {{ auth.isAdmin ? 'full administrative' : 'standard' }} privileges.
        </p>
        <p v-else class="text-indigo-100 text-sm mb-6">
            You are not logged in. Please log in to access more features.
        </p>

        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                <span class="font-mono text-sm">Session</span>
            </div>
            <div class="text-sm text-indigo-100">
                <span class="font-bold">User:</span> {{ auth.user?.name }}
            </div>
            <div class="text-sm text-indigo-100 truncate">
                <span class="font-bold">Email:</span> {{ auth.user?.email }}
            </div>
        </div>
    </div>
</template>