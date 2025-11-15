<template>
    <!-- Label -->
    <div
      class="flex-1 font-light tracking-[0.2em] text-xl leading-none"
    >
      {{ label }}
    </div>

    <!-- Points bar -->
    <div
      class="relative flex w-[32.36rem] border border-white"
    >
      <div
        class="h-6 bg-[#339999]"
        :style="{ width: `${points}%` }"
      ></div>

      <div
        v-for="d in dividers"
        :key="`divider-${d}`"
        class="absolute top-0 w-[0.8rem] h-[2.4rem]"
        :style="{ left: `calc(${d}% - 0.8rem)` }"
      ></div>
    </div>
</template>

<script setup>
/**
 * Keep the original component name for devtools, routing, etc.
 * Requires Vue 3.3+ for defineOptions.
 */
defineOptions({
  name: 'stat-bar',
});

const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  points: {
    type: Number,
    required: true,
  },
});

// Divider positions (percentages along the bar)
const dividers = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
</script>