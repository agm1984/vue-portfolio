<script setup>
import { ref, computed } from 'vue';

const rawEvents = [
    {
        id: 1,
        year: '2025',
        title: 'Nevvon',
        description: 'Tech Lead role for numerous high-profile projects using Vue.js and Tailwind CSS.',
        category: 'Work',
        color: 'bg-teal-500',
    },
    {
        id: 2,
        year: '2022',
        title: 'Coldsnake Digital',
        description: 'Frontend Developer role focusing on building responsive web applications with Laravel, Vue.js, and Tailwind CSS.',
        category: 'Work',
        color: 'bg-blue-500',
    },
    {
        id: 3,
        year: '2020',
        title: 'Whitespark',
        description: 'Frontend Developer role focusing on an internal tool using Laravel, Vue.js, and Tailwind CSS.',
        category: 'Work',
        color: 'bg-red-500',
    },
    {
        id: 4,
        year: '2017',
        title: 'Self Employed',
        description: 'Fullstack Developer role building apps in mostly node.js and React.js.',
        category: 'Work',
        color: 'bg-green-500',
    },
    {
        id: 5,
        year: '2014',
        title: 'Verified Network',
        description: 'Quality Assurance role testing camera-based web applications and mobile apps.',
        category: 'Work',
        color: 'bg-purple-500',
    },
    {
        id: 6,
        year: '2013',
        title: 'Vancouver Island University',
        description: 'BSc Physics major - Completed one year prior to dropping out to pursue web development full-time.',
        category: 'Education',
        color: 'bg-yellow-500',
    },
];

const selectedCategory = ref('All');
const sortOrder = ref('desc');

const categories = ['All', ...new Set(rawEvents.map(e => e.category))];

const filteredEvents = computed(() => {
    let filtered = selectedCategory.value === 'All'
        ? rawEvents
        : rawEvents.filter((e) => e.category === selectedCategory.value);

    return [...filtered].sort((a, b) => {
        return sortOrder.value === 'asc'
            ? a.year.localeCompare(b.year)
            : b.year.localeCompare(a.year);
    });
});

const toggleSort = () => {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
};
</script>

<template>
    <div class="mt-8">
        <div class="flex flex-col md:flex-row items-center justify-between mb-4 gap-4">
            <div class="flex flex-wrap md:pl-10">
                <button
                    v-for="category in categories"
                    :key="`timeline-category-${category}`"
                    type="button"
                    @click="selectedCategory = category"
                    :class="[
                        'cursor-pointer px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200',
                        selectedCategory === category
                            ? 'bg-indigo-600 text-white shadow-md scale-105'
                            : 'bg-gray-100 text-gray-700 hover:bg-gray-200',
                    ]"
                >
                    {{ category }}
                </button>
            </div>

            <div class="flex gap-2">
                <button
                    type="button"
                    class="cursor-pointer px-4 py-2 rounded-full bg-gray-800 text-white text-sm font-semibold flex items-center gap-2 hover:bg-gray-900 transition-colors"
                    @click="toggleSort"
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

        <div class="relative border-l-4 space-y-8">
            <TransitionGroup name="list">
                <div
                    v-for="event in filteredEvents"
                    :key="`filtered-event-${event.id}`"
                    class="relative pl-8"
                >
                    <span
                        class="absolute -left-2.5 top-8 h-5 w-5 rounded-full border-4 border-white shadow-sm transition-colors duration-300"
                        :class="event.color"
                    ></span>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300 cursor-pointer group">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2">
                            <h3 class="group-hover:text-indigo-600! transition-colors">
                                {{ event.title }}
                            </h3>
                            <span class="text-sm font-semibold uppercase px-2 py-1 rounded bg-gray-100 text-gray-600 mt-2 sm:mt-0 w-fit">
                                {{ event.year }}
                            </span>
                        </div>

                        <p class="text-gray-600 mb-3">
                            {{ event.description }}
                        </p>

                        <span class="text-xs font-medium text-indigo-500 uppercase tracking-wider">
                            #{{ event.category }}
                        </span>
                    </div>
                </div>
            </TransitionGroup>

            <div v-if="filteredEvents.length === 0" class="pl-8">
                <p class="text-gray-600 italic">No events found for this category.</p>
            </div>
        </div>
    </div>
</template>

<style scoped>
.list-move,
.list-enter-active,
.list-leave-active {
    transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateX(30px);
}

.list-leave-active {
    position: absolute;
    width: 100%;
}
</style>
