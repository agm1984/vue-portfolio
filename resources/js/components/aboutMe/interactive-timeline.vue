<script setup>
import { ref, computed } from 'vue';

// 1. THE DATA (Source of Truth)
// In a real app, this might come from a prop or an API call.
// We treat this data as immutable.
const rawEvents = [
    {
        id: 1,
        year: '2024',
        title: 'Full Stack Architect',
        description: 'Led the migration of legacy monolithic apps to microservices using Laravel 11.',
        category: 'Work',
        color: 'bg-blue-500',
    },
    {
        id: 2,
        year: '2023',
        title: 'Vue 3 Mastery',
        description: 'Completed advanced certification in Composition API and Pinia state management.',
        category: 'Education',
        color: 'bg-green-500',
    },
    {
        id: 3,
        year: '2022',
        title: 'First Open Source Contribution',
        description: 'Contributed a bug fix to a major PHP package, learning the value of community code.',
        category: 'Community',
        color: 'bg-purple-500',
    },
    {
        id: 4,
        year: '2021',
        title: 'Junior Developer',
        description: 'Started my journey building simple CRUD apps and discovering the joy of clean code.',
        category: 'Work',
        color: 'bg-blue-500',
    },
];

// 2. REACTIVE STATE
// These control the "view" of our data, but don't change the data itself.
const selectedCategory = ref('All');
const sortOrder = ref('desc'); // 'asc' or 'desc'

// Unique categories for the filter buttons
const categories = ['All', ...new Set(rawEvents.map((e) => e.category))];

// 3. PURE TRANSFORMATIONS (Functional Core)
// We use a computed property to pipeline our data: Source -> Filter -> Sort -> View
const displayEvents = computed(() => {
    // Step A: Filter (Pure function)
    let filtered = selectedCategory.value === 'All'
        ? rawEvents
        : rawEvents.filter((e) => e.category === selectedCategory.value);

    // Step B: Sort (Pure function)
    // Crucial: .sort() mutates arrays in place in JS!
    // We use [...filtered] to create a shallow copy first to preserve immutability.
    return [...filtered].sort((a, b) => {
        return sortOrder.value === 'asc'
            ? a.year.localeCompare(b.year)
            : b.year.localeCompare(a.year);
    });
});

// Helper for toggling sort (declarative state change)
const toggleSort = () => {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
};
</script>

<template>
    <div class="mt-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">
                    My Journey
                </h2>
                <p class="text-gray-500 dark:text-gray-400 mt-1">
                    A quick look at my history.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <button
                    v-for="category in categories"
                    :key="category"
                    @click="selectedCategory = category"
                    :class="[
                        'px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200',
                        selectedCategory === category
                            ? 'bg-indigo-600 text-white shadow-md scale-105'
                            : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300',
                    ]"
                >
                    {{ category }}
                </button>

                <button
                    @click="toggleSort"
                    class="px-4 py-2 rounded-full bg-gray-800 text-white text-sm font-semibold flex items-center gap-2 hover:bg-gray-900 transition-colors"
                >
                    <span>{{ sortOrder === 'asc' ? 'Oldest First' : 'Newest First' }}</span>
                    <svg
                        v-if="sortOrder === 'desc'"
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    <svg
                        v-else
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="relative border-l-4 border-gray-200 dark:border-gray-700 ml-3 md:ml-6 space-y-8">
            <TransitionGroup name="list">
                <div
                    v-for="event in displayEvents"
                    :key="event.id"
                    class="relative pl-8 md:pl-12"
                >
                    <span
                        class="absolute -left-2.5 top-6 h-5 w-5 rounded-full border-4 border-white dark:border-gray-900 shadow-sm transition-colors duration-300"
                        :class="event.color"
                    ></span>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md hover:-translate-y-1 transition-all duration-300 cursor-pointer group">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-indigo-600 transition-colors">
                                {{ event.title }}
                            </h3>
                            <span class="text-xs font-bold uppercase px-2 py-1 rounded bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-300 mt-2 sm:mt-0 w-fit">
                                {{ event.year }}
                            </span>
                        </div>

                        <p class="text-gray-600 dark:text-gray-300 mb-3">
                            {{ event.description }}
                        </p>

                        <span class="text-xs font-medium text-indigo-500 uppercase tracking-wider">
                            #{{ event.category }}
                        </span>
                    </div>
                </div>
            </TransitionGroup>

            <div v-if="displayEvents.length === 0" class="pl-8">
                <p class="text-gray-500 italic">No events found for this category.</p>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Vue Transitions for the List */
.list-move, /* apply transition to moving elements */
.list-enter-active,
.list-leave-active {
    transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateX(30px);
}

/* ensure leaving items are taken out of layout flow so others can move up smoothly */
.list-leave-active {
    position: absolute;
    width: 100%;
}
</style>
