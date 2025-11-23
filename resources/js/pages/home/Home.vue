<script setup>
import { onMounted } from 'vue';
import { useHead } from '@unhead/vue';
import Button from 'primevue/button';
import { usePublicExamplesStore } from '~/store/publicExamples';

useHead({
    title: 'Home',
});

const publicExamples = usePublicExamplesStore();

const techStack = [
    { name: 'Laravel 12', icon: 'pi pi-server', color: 'text-red-500' },
    { name: 'Vue 3', icon: 'pi pi-code', color: 'text-green-500' },
    { name: 'PrimeVue', icon: 'pi pi-prime', color: 'text-indigo-500' },
    { name: 'Tailwind', icon: 'pi pi-palette', color: 'text-cyan-500' },
];

const preloadHotPath = () => {
    if (!publicExamples.allCategories.length) {
        publicExamples.getAllCategories();
    }
    if (!publicExamples.allExamples.length) {
        publicExamples.getAllExamples();
    }
};

onMounted(preloadHotPath);
</script>

<template>
    <div class="flex-1 flex flex-col justify-center relative overflow-hidden">
        <div class="absolute top-[-20%] right-[-10%] w-[500px] h-[500px] bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-[-20%] left-[-10%] w-[500px] h-[500px] bg-pink-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="w-full max-w-7xl mx-auto px-6 md:px-12 py-12 md:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8 text-center lg:text-left z-10">
                    <div>
                        <p class="text-sm font-semibold tracking-widest text-indigo-600 uppercase">The Portfolio Of</p>
                        <h1 class="text-5xl md:text-7xl! font-aroly text-gray-900 mt-4">
                            Adam<br />
                            <span class="text-indigo-600">Mackintosh</span>
                        </h1>
                    </div>

                    <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Building scalable, web applications with
                        <span class="font-semibold text-gray-800">clean code</span> and
                        <span class="font-semibold text-gray-800">modern architecture</span>.
                        Specializing in the Laravel & Vue ecosystem.
                    </p>

                    <div class="flex flex-wrap gap-3 justify-center lg:justify-start">
                        <div
                            v-for="tech in techStack"
                            :key="tech.name"
                            class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm border"
                        >
                            <i :class="[tech.icon, tech.color]"></i>
                            <span class="font-semibold text-sm text-gray-700">{{ tech.name }}</span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-4">
                        <router-link :to="{ name: 'public.examples.list' }">
                            <Button
                                type="button"
                                class="w-full sm:w-auto font-semibold"
                                icon-pos="right"
                                icon="pi pi-arrow-right"
                                label="View Examples"
                                size="large"
                            />
                        </router-link>

                        <router-link :to="{ name: 'contact' }">
                            <Button
                                type="button"
                                class="w-full sm:w-auto font-semibold"
                                label="Get in Touch"
                                size="large"
                                outlined
                            />
                        </router-link>
                    </div>
                </div>

                <div class="relative flex justify-center lg:justify-end z-10">
                    <div class="absolute inset-0 bg-linear-to-tr from-indigo-500 to-purple-500 rounded-full blur-xl opacity-20 scale-90 animate-pulse"></div>
                    <div class="relative w-64 h-64 md:w-80 md:h-80 lg:w-96 lg:h-96 rounded-full p-2 bg-white shadow-2xl border">
                        <img
                            class="w-full h-full object-cover rounded-full"
                            src="/adam2.png"
                            alt="Adam Mackintosh"
                        />

                        <div class="absolute bottom-4 right-4 md:bottom-8 md:right-8 bg-white p-3 rounded-xl shadow-lg border border-gray-100 flex items-center gap-3 animate-bounce-slow">
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="font-semibold text-sm text-gray-800">Open to opportunities</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<style scoped>
.animate-bounce-slow {
    animation: bounce 3s infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
</style>
