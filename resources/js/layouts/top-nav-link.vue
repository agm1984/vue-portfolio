<template>
    <router-link
        v-slot="{ href, route, navigate, isActive }"
        :to="to"
    >
        <div class="relative">
            <a
                :class="['nav-link-white', {
                    'nav-link-white-active': isActive,
                    'opacity-50': isDisabled,
                }]"
                :href="isDisabled ? undefined : href"
                @click="handler => handleClick(handler, navigate)"
            >
                <slot></slot>
            </a>

            <div v-show="isActive" class="absolute left-0 w-full h-2 mt-8 bg-primary"></div>
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
