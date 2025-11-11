<template>
    <div
        @mouseenter="handleMouseEnter"
        @mousemove="handleMouseMove"
        @mouseleave="handleMouseLeave"
    >
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: 'a-tilt',

    props: {
        max: {
            type: Number,
            required: false,
            default: () => 5,
        },

        perspective: {
            type: Number,
            required: false,
            default: () => 1000,
        },

        reverse: {
            type: Boolean,
            required: false,
            default: () => true,
        },
    },

    data() {
        return {
            timer: undefined,
        };
    },

    computed: {
        reverseValue() {
            return this.reverse ? -1 : 1;
        },
    },

    mounted() {
        this.$el.style.cssText = `
            transform-origin: center;
            will-change: transform;
        `;
    },

    methods: {
        getPosition(el) {
            const { left, top, width, height } = el.getBoundingClientRect();

            return {
                left,
                top,
                width,
                height,
            };
        },

        toggleTransition() {
            if (this.timer) {
                clearTimeout(this.timer);
            }

            this.$el.style.transition = 'all 150ms cubic-bezier(.03,.98,.52,.99)';

            this.timer = setTimeout(() => {
                this.$el.style.transition = '';
            }, 150);
        },

        handleMouseEnter() {
            return this.toggleTransition();
        },

        handleMouseMove(e) {
            const { left, top } = this.getPosition(this.$el);

            const x = Math.min(((e.clientX - left) / this.$el.offsetWidth), 1);
            const y = Math.min(((e.clientY - top) / this.$el.offsetHeight), 1);

            const X = (this.reverseValue * (this.max / 2 - x * this.max));
            const Y = (this.reverseValue * ((y * this.max) - (this.max / 2)));

            this.$el.style.transform = `perspective(${this.perspective}px) rotateX(${Y}deg) rotateY(${X}deg)`;
        },

        handleMouseLeave() {
            this.toggleTransition();

            this.$el.style.transform = `perspective(${this.perspective}px) rotateX(0) rotateY(0)`;
        },
    },

};
</script>
