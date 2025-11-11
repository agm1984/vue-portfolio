<script setup>
import { ref, computed, onMounted, onBeforeUnmount, defineProps } from 'vue';

const props = defineProps({
    max: {
        type: Number,
        required: false,
        default: 5,
    },

    perspective: {
        type: Number,
        required: false,
        default: 1000,
    },

    reverse: {
        type: Boolean,
        required: false,
        default: true,
    },
});

const root = ref(null);
let timer = null;

const reverseValue = computed(() => (props.reverse ? -1 : 1));

const toggleTransition = () => {
    if (!root.value) return;
    if (timer) clearTimeout(timer);

    root.value.style.transition = 'all 150ms cubic-bezier(.03,.98,.52,.99)';

    timer = setTimeout(() => {
        if (root.value) root.value.style.transition = '';
        timer = null;
    }, 150);
};

const handleMouseEnter = () => {
    toggleTransition();
};

const handleMouseMove = (e) => {
    const el = root.value;
    if (!el) return;

    const rect = el.getBoundingClientRect();

    const x = Math.min((e.clientX - rect.left) / el.offsetWidth, 1);
    const y = Math.min((e.clientY - rect.top) / el.offsetHeight, 1);

    const X = reverseValue.value * (props.max / 2 - x * props.max);
    const Y = reverseValue.value * (y * props.max - props.max / 2);

    el.style.transform = `perspective(${props.perspective}px) rotateX(${Y}deg) rotateY(${X}deg)`;
};

const handleMouseLeave = () => {
    toggleTransition();

    const el = root.value;
    if (!el) return;

    el.style.transform = `perspective(${props.perspective}px) rotateX(0) rotateY(0)`;
};

onMounted(() => {
    if (root.value) {
        root.value.style.transformOrigin = 'center';
        root.value.style.willChange = 'transform';
    }
});

onBeforeUnmount(() => {
    if (timer) clearTimeout(timer);
});
</script>

<template>
    <div
        ref="root"
        @mouseenter="handleMouseEnter"
        @mousemove="handleMouseMove"
        @mouseleave="handleMouseLeave"
    >
        <slot />
    </div>
</template>
