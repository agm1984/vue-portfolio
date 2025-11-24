<script setup>
import { ref, onMounted, onBeforeUnmount, computed, useAttrs } from 'vue';

defineOptions({ inheritAttrs: false });

const props = defineProps({
    src: {
        type: String,
        required: true,
    },

    placeholder: {
        type: String,
        required: false,
        default: null,
    },

    background: {
        type: String,
        required: false,
        default: '#ffffff',
    },
});

const attrs = useAttrs();
const imgAttrs = computed(() => {
    const { class: className, style, ...rest } = attrs;
    return rest;
});

const rootRef = ref(null);
const isIntersecting = ref(false);
const isLoaded = ref(false);

const computedSrc = computed(() => isIntersecting.value ? props.src : undefined);
const computedSrcSet = computed(() => isIntersecting.value ? attrs.srcset : undefined);

const onImageLoad = () => {
    isLoaded.value = true;
};

let observer;

onMounted(() => {
    // fallback for very old browsers or SEO bots: load immediately
    if (!window.IntersectionObserver) {
        isIntersecting.value = true;
        return;
    }

    observer = new IntersectionObserver(([entry]) => {
        if (entry.isIntersecting) {
            isIntersecting.value = true;
            observer.disconnect();
        }
    });

    if (rootRef.value) {
        observer.observe(rootRef.value);
    }
});

onBeforeUnmount(() => {
    if (observer) {
        observer.disconnect();
    }
});
</script>

<template>
    <div
        ref="rootRef"
        class="app-img"
        :class="[attrs.class, { 'app-img--loaded': isLoaded }]"
        :style="attrs.style"
    >
        <slot></slot>

        <transition name="fade">
            <div
              v-if="src && !isLoaded"
              :style="{ background: props.background }"
              class="app-img__placeholder"
            >
                <img
                    v-if="props.placeholder"
                    :src="props.placeholder"
                    alt=""
                    aria-hidden="true"
                >
            </div>
        </transition>

        <img
            class="app-img__img w-full aspect-video"
            :src="computedSrc"
            :srcset="computedSrcSet"
            :alt="attrs.alt || ''"
            v-bind="imgAttrs"
            @load="onImageLoad"
        >
    </div>
</template>

<style scoped>
    .app-img {
        display: inline-block;
        position: relative;
        overflow: hidden; /* Keeps the blur contained */
    }

    .app-img__placeholder {
        position: absolute;
        inset: 0;
        z-index: 1;
    }

    .app-img__placeholder img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transform: scale(1.05);
        filter: blur(10px);
    }

    .app-img__img {
        opacity: 0;
        transition: opacity 500ms ease;
        display: block;
    }

    .app-img--loaded .app-img__img {
        opacity: 1;
    }

    .fade-leave-active {
        transition: opacity 500ms ease;
    }
    .fade-leave-to {
        opacity: 0;
    }
</style>
