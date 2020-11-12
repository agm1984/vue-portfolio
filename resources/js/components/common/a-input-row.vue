<template>
    <div class="flex flex-col w-full">
        <!-- top row -->
        <div :class="topRowStyles">
            <div :class="leftSideStyles">
                <a-heading level="4">
                    {{ heading }}
                </a-heading>
            </div>
            <div :class="rightSideStyles">
                <slot v-if="!hasContent"></slot>
            </div>
        </div>

        <!-- bottom row -->
        <div class="flex w-full">
            <div :class="leftSideStyles">
                <p v-if="hasContent">
                    {{ content }}
                </p>
            </div>
            <div :class="rightSideStyles">
                <slot v-if="hasContent"></slot>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: 'a-input-row',

    props: {
        type: {
            type: String,
            required: false,
            default: () => 'is-wider-left',
        },

        heading: {
            type: String,
            required: true,
        },

        content: {
            type: String,
            required: false,
            default: () => '',
        },

        isTall: {
            type: Boolean,
            required: false,
            default: () => false,
        },
    },

    data() {
        return {};
    },

    computed: {
        hasContent() {
            return !!this.content.length;
        },

        topRowStyles() {
            const styles = [''];
            if (!this.hasContent) styles.push('w-full flex');
            if (!this.hasContent && !this.isTall) styles.push('items-center');
            return styles;
        },

        leftSideStyles() {
            const styles = ['pr-32'];
            if (this.type === 'is-wider-left') styles.push('w-3/4');
            if (this.type === 'is-wider-right') styles.push('w-1/4');
            if (this.type === 'is-split') styles.push('w-1/2');
            return styles;
        },

        rightSideStyles() {
            const styles = [''];
            if (this.type === 'is-wider-left') styles.push('w-1/4');
            if (this.type === 'is-wider-right') styles.push('w-3/4');
            if (this.type === 'is-split') styles.push('w-1/2');
            return styles;
        },

    },

    mounted() {},

    methods: {},

};
</script>
