<template>
    <router-link
        v-slot="{ href, route, navigate, isActive }"
        :to="to"
    >
        <div class="relative mx-4 nav-link-white">
            <a
                :class="['text-white', {
                    'opacity-50': isDisabled,
                }]"
                :href="isDisabled ? undefined : href"
                @click="handler => handleClick(handler, navigate)"
            >
                <slot></slot>
            </a>

            <div v-show="isActive" class="absolute left-0 w-full h-4 mt-12 bg-mint-active"></div>
        </div>
    </router-link>


</template>

<script>
export default {
    name: 'top-nav-link',

    props: {
        to: {
            type: Object,
            required: true,
        },

        isDisabled: {
            type: Boolean,
            required: false,
            default: () => false,
        },
    },

    data() {
        return {};
    },

    computed: {},

    methods: {
        handleClick(handler, navigate) {
            if (this.isDisabled) return;
            navigate(handler);
        },
    },

};
</script>

<style>
    /* default */
    .nav-link-white {
        @apply bg-grey-400 font-aroly font-bold text-base leading-none tracking-wide rounded-sm p-8;
        transition: all 250ms ease-in-out;
    }

    .nav-link-white:hover {
        @apply cursor-pointer;
    }

    .nav-link-white:active {
        /* @apply ; */
    }

    .nav-link-white-active {
        /* @apply ; */
    }
</style>
