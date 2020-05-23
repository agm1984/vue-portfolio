<template>
    <component
        :is="isEditable ? 'button' : 'div'"
        :type="isEditable ? 'button' : undefined"
        :class="containerStyles"
        @click="handleEdit"
        @mouseenter="handleMouseenter"
        @mouseleave="handleMouseleave"
    >
        <!-- left side / heading -->
        <div v-if="hasSlotLabel" :class="leftStyles">
            <div class="w-full">
                <slot name="label"></slot>
            </div>
        </div>

        <div v-else :class="leftStyles">
            {{ label }}
        </div>

        <!-- right side / value -->
        <div :class="rightStyles">
            <div class="flex justify-start w-full text-left">
                <slot v-if="hasDefaultSlot"></slot>
                <span v-else>{{ scalarValue }}</span>
            </div>

            <div v-if="isEditable && isHovering" class="absolute top-0 right-0 mt-8 mr-16">
                <div>
                    <i class="text-white fas fa-pencil-alt hover:text-pink-400 active:text-pink-600"></i>
                </div>
            </div>
        </div>

    </component>
</template>

<script>
/**
 * The `WsShowField` component accepts a `label` prop which appears on the left,
 * and a default slot which appears on the right.
 *
 * Alternately, a `label` named slot can be used for the left-side container.
 */
export default {
    name: 'a-show-field',

    props: {
        label: {
            type: String,
            required: false,
            default: () => '',
        },
        value: {
            // temp
            type: [String, Number, Array, Object],
            // type: String,
            required: false,
            default: () => '',
        },
        isRequired: {
            type: Boolean,
            required: false,
            default: () => false,
        },
        isEditable: {
            type: Boolean,
            required: false,
            default: () => false,
        },
    },
    data() {
        return {
            isHovering: false,
        };
    },
    computed: {
        hasSlotLabel() {
            return !!this.$slots.label;
        },
        hasDefaultSlot() {
            return !!this.$slots.default;
        },
        scalarValue() {
            if (!this.value) return '--';
            return this.value;
        },
        containerStyles() {
            const styles = ['flex flex-row'];
            if (this.isRequired) styles.push('border-pink-400');
            else styles.push('border-grey-500');

            if (this.isEditable) styles.push('hover:bg-grey-200 active:bg-grey-300');

            return styles;
        },
        leftStyles() {
            const styles = ['w-1/3 min-h-row-sm flex text-base font-bold text-grey-300 pl-16 py-8'];
            return styles;
        },
        rightStyles() {
            const styles = ['w-2/3 min-h-row-sm flex justify-start text-base font-normal text-white pl-16 py-8 pr-32 relative'];
            return styles;
        },
    },
    methods: {
        handleMouseenter() {
            if (!this.isEditable) return;
            this.isHovering = true;
        },
        handleMouseleave() {
            if (!this.isEditable) return;
            this.isHovering = false;
        },
        handleEdit() {
            if (!this.isEditable) return;
            this.$emit('edit');
        },
    },
};
</script>
