<script setup>
import { onMounted } from 'vue';
import { useHead } from '@unhead/vue';
import { usePublicExamplesStore } from '~/store/publicExamples';

useHead({
    title: 'Home',
});

const publicExamples = usePublicExamplesStore();

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
    <div class="flex-1 flex flex-col items-center justify-center p-8">
        <div
            class="bg-no-repeat bg-cover rounded-full h-16 w-16 border"
            style="background-image: url('/adam.png')"
        ></div>

        <div class="my-8">
            THE PORTFOLIO OF
        </div>

        <div class="text-2xl lg:text-5xl font-aroly text-primary">
            Adam
        </div>

        <div class="text-2xl lg:text-5xl font-aroly text-primary">
            Mackintosh
        </div>
    </div>
</template>
