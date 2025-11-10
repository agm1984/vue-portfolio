<script setup>
import { ref, computed, onMounted, onBeforeUnmount, useAttrs } from 'vue';

// Vue 3.3+ — lets us keep attrs off the root like in the original
defineOptions({ name: 'AppImg', inheritAttrs: false });

const props = defineProps({
  src: { type: String, required: true },
  placeholder: String,
  background: String,
});

const attrs = useAttrs();

const rootRef = ref(null);
const imgRef = ref(null);
const placeholderRef = ref(null);

let observer;
let timeOut;

onMounted(() => {
  const el = rootRef.value;
  const img = imgRef.value;

  observer = new IntersectionObserver(([entry]) => {
    const placeholderEl = placeholderRef.value;

    img.onload = () => {
      img.onload = null;
      el.classList.add('app-img--loaded');
      if (placeholderEl) {
        timeOut = setTimeout(() => {
          placeholderEl.remove();
        }, 300);
      }
    };

    if (entry.isIntersecting) {
      if (attrs.srcset) {
        img.setAttribute('srcset', attrs.srcset);
      }
      img.src = props.src;
      observer && observer.disconnect();
    }
  });

  observer.observe(el);
});

onBeforeUnmount(() => {
  if (observer) observer.disconnect();
  if (timeOut) clearTimeout(timeOut);
});
</script>

<template>
  <div class="app-img" ref="rootRef">
    <slot></slot>

    <div
      v-if="src"
      :style="{ background: props.background }"
      class="app-img__placeholder"
      ref="placeholderRef"
    >
      <img :src="props.placeholder || dataUrl" alt v-bind="attrs">
    </div>

    <img
      ref="imgRef"
      :src="src"
      :alt="attrs.alt || ''"
      v-bind="attrs"
      class="w-full aspect-video"
    >
  </div>
</template>

<style>
  .app-img {
    display: inline-block;
    position: relative;
  }

  .app-img__placeholder {
    position: absolute;
    overflow: hidden;
  }

  .app-img__placeholder img {
    transform: scale(1.05);
    filter: blur(10px);
  }

  .app-img__img {
    opacity: 0;
    transition: opacity 300ms ease;
  }

  .app-img--loaded .app-img__img {
    opacity: 1;
  }
</style>
