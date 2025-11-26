<script setup>
import { ref, computed } from 'vue';
import { useHead } from '@unhead/vue';

useHead({
    title: 'About Me',
});

const START_YEAR = 2017;
const yearsExperience = computed(() => new Date().getFullYear() - START_YEAR);
const isSeeingSupra = ref(false);

const openSupraModal = () => {
    isSeeingSupra.value = true;
};

const closeSupraModal = () => {
    isSeeingSupra.value = false;
};
</script>

<template>
    <div class="w-full max-w-6xl mx-auto flex flex-col p-8">
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-7 flex flex-col gap-4">
                <h1>About <span class="text-indigo-600 dark:text-indigo-400">Me</span></h1>
                <div class="w-20 h-1 bg-indigo-600 dark:bg-indigo-500 rounded-full"></div>

                <div class="prose text-gray-600 dark:text-gray-300 text-lg leading-relaxed">
                    <p>
                        I'll keep this short. I've been programming for about
                        <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ yearsExperience }} years</span>,
                        but I've been working with iOS, Android, and web apps since 2013.
                        I discovered my passion for coding around that time.
                    </p>

                    <p class="mt-4">
                        I'm an <span class="italic font-serif text-gray-800 dark:text-gray-200">autodidact</span>.
                        All I need is a topic and an impetus, and I can start researching it.
                        Google really is a magical thing.
                    </p>

                    <p class="mt-4">
                        My list of hobbies is short because <strong class="text-gray-900 dark:text-white">programming is my main hobby</strong>.
                        Beyond that, I've been working out consistently for over a decade.
                        I'm currently back in the gym four times a week, and it feels great to reconnect with that discipline.
                    </p>
                </div>

                <div class="bg-gray-200 dark:bg-gray-800 border-l-4 border-red-600 dark:border-red-500 rounded-r-lg p-4 mt-2">
                    <div class="flex items-start gap-4">
                        <div class="min-w-16 max-w-16 min-h-16 max-h-16 hidden sm:flex items-center justify-center bg-white dark:bg-gray-700 rounded-full shadow-sm shrink-0">
                            <i class="pi pi-car text-red-600 dark:text-red-400" style="font-size: 24px;"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white text-sm uppercase tracking-wide">Car Enthusiast</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                                I have a <strong class="text-gray-900 dark:text-white">700 horsepower 1993 Toyota Supra</strong>. When the engine isn't broken and it's clean, 
                                you can find me out driving with friends and finding new places to visit.
                            </p>
                            <button
                                type="button"
                                class="cursor-pointer font-semibold text-red-600 dark:text-red-400 hover:underline mt-2 hover:text-red-700 dark:hover:text-red-300"
                                @click="openSupraModal"
                            >See the Supra</button>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-4 mt-4">
                    <h3>Connect</h3>
                    <div class="flex gap-3">
                        <a-social-link network="twitter" class="hover:-translate-y-1 transition-transform duration-300" />
                        <a-social-link network="github" class="hover:-translate-y-1 transition-transform duration-300" />
                        <a-social-link network="stackoverflow" class="hover:-translate-y-1 transition-transform duration-300" />
                        <a-social-link network="medium" class="hover:-translate-y-1 transition-transform duration-300" />
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 relative group">
                <div class="absolute -inset-2 bg-linear-to-r from-gray-900 to-gray-600 dark:from-indigo-900 dark:to-purple-900 rounded-xl blur-lg opacity-30 group-hover:opacity-50 transition duration-1000"></div>

                <img
                    src="/adam2.png"
                    class="relative w-full aspect-4/5 object-cover rounded-xl shadow-2xl rotate-2 group-hover:rotate-0 transition-all duration-500 ease-out border-2 border-white dark:border-gray-700"
                    alt="Adam Mackintosh"
                >
            </div>
        </section>

        <section class="mt-16">
            <div class="flex items-center gap-4">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">A Brief Word</h2>
                <div class="flex-1 h-px bg-gray-300 dark:bg-gray-700"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
                <to-programmers-card></to-programmers-card>
                <to-non-programmers-card></to-non-programmers-card>
            </div>
        </section>

        <section class="max-w-2xl mx-auto mt-16">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">My Timeline</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-2">A history of jobs</p>
            </div>

            <interactive-timeline></interactive-timeline>
        </section>

        <p class="text-lg text-center mt-8 text-gray-600 dark:text-gray-300">
            Want to chat about cars or code?
            <router-link
                :to="{ name: 'contact' }"
                class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline hover:text-indigo-700 dark:hover:text-indigo-300 active:text-indigo-800 ml-1"
            >
                Drop me a message.
            </router-link>
        </p>
    </div>

    <see-supra-modal
        v-if="isSeeingSupra"
        @close="closeSupraModal"
    />
</template>
