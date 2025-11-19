<script setup lang="js">
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue'
import Button from 'primevue/button';

const props = defineProps({
    testimonials: {
        type: Array,
        required: false,
        default: () => ([
            {
                name: 'Alex Johnson',
                role: 'Product Designer',
                company: 'Northwind UI',
                quote:
                    'This product has completely changed how our team collaborates. The experience feels effortless now.',
                avatar_url: 'https://i.pravatar.cc/150?img=5'
            },
            {
                name: 'Maria Chen',
                role: 'Engineering Manager',
                company: 'Acme Corp',
                quote:
                    'Implementation was smooth and the support has been outstanding. Our onboarding time dropped by 40%.',
                avatar_url: 'https://i.pravatar.cc/150?img=47'
            },
            {
                name: 'Samir Patel',
                role: 'Founder',
                company: 'BrightPath Studio',
                quote:
                    'We tried several tools before this one. Nothing else came close to the balance of power and simplicity.',
                avatar_url: 'https://i.pravatar.cc/150?img=12'
            },
        ]),
    },
    interval: {
        type: Number,
        required: false,
        default: 7000,
    },
    autoPlay: {
        type: Boolean,
        required: false,
        default: true,
    },
})

const activeIndex = ref(0)
const total = computed(() => props.testimonials.length)

let timer = null

const goTo = (index) => {
    if (!total.value) return
    const max = total.value
    const normalized = ((index % max) + max) % max
    activeIndex.value = normalized
}

const next = () => {
    goTo(activeIndex.value + 1)
}

const prev = () => {
    goTo(activeIndex.value - 1)
}

const clearTimer = () => {
    if (timer !== null) {
        window.clearInterval(timer)
        timer = null
    }
}

const setupTimer = () => {
    clearTimer()
    if (!props.autoPlay || total.value <= 1) return

    timer = window.setInterval(() => {
        next()
    }, props.interval)
}

const handleMouseEnter = () => {
    clearTimer()
}

const handleMouseLeave = () => {
    setupTimer()
}

onMounted(() => {
    setupTimer()
})

onBeforeUnmount(() => {
    clearTimer()
})

watch(
    () => [props.autoPlay, props.interval, total.value],
    () => {
        setupTimer()
    }
)
</script>

<template>
    <section
        class="w-full max-w-5xl mx-auto"
        aria-label="Testimonials"
    >
        <h2>Testimonials</h2>

        <a-card
            class="w-full p-8 relative mt-4"
            @mouseenter="handleMouseEnter"
            @mouseleave="handleMouseLeave"
        >
            <div class="relative min-h-[190px] mt-4" aria-live="polite">
                <div
                    v-for="(testimonial, index) in testimonials"
                    :key="`${testimonial.name}-${index}`"
                    class="absolute inset-0 transition-all duration-500 ease-out"
                    :class="index === activeIndex
                        ? 'opacity-100 translate-y-0'
                        : 'opacity-0 translate-y-4 pointer-events-none'"
                >
                    <figure class="flex flex-col gap-4">
                        <blockquote>
                            “{{ testimonial.quote }}”
                        </blockquote>

                        <figcaption class="flex items-center gap-4">
                            <a-avatar
                                :user="{ name: testimonial.name, avatar_url: testimonial.avatar_url }"
                                :size="64"
                            ></a-avatar>
                            <div>
                                <p class="font-semibold">
                                    {{ testimonial.name }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <span v-if="testimonial.role">{{ testimonial.role }}</span>
                                    <span v-if="testimonial.role && testimonial.company"> · </span>
                                    <span v-if="testimonial.company">{{ testimonial.company }}</span>
                                </p>
                            </div>
                        </figcaption>
                    </figure>
                </div>
            </div>

            <div class="flex items-center justify-between gap-4 mt-8">
                <div class="flex items-center gap-2">
                    <button
                        v-for="(testimonial, index) in testimonials"
                        :key="`${testimonial.name}-${index}-dot`"
                        type="button"
                        class="h-2.5 rounded-full transition-all duration-300"
                        :class="index === activeIndex
                            ? 'w-6 bg-slate-900'
                            : 'w-2.5 bg-slate-300 hover:bg-slate-400'"
                        :aria-label="`Go to testimonial ${index + 1}`"
                        @click="goTo(index)"
                    />
                </div>

                <div class="flex items-center gap-2">
                    <Button
                        type="button"
                        severity="secondary"
                        icon="pi pi-arrow-left"
                        label="Prev"
                        @click="prev"
                    />

                    <Button
                        type="button"
                        severity="secondary"
                        icon="pi pi-arrow-right"
                        icon-pos="right"
                        label="Next"
                        @click="next"
                    />
                </div>
            </div>
        </a-card>
    </section>
</template>
