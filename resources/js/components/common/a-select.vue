<template>
    <div>
        <b-select
            v-model="innerValue"
            ref="select"
            :name="name"
            :size="size"
            :placeholder="placeholder"
            :loading="loading"
            :expanded="expanded"
            :disabled="disabled"
            :required="required"
            :rounded="rounded"
        >
            <!-- accepts option or optgroup + option -->
            <slot></slot>
        </b-select>
    </div>
</template>

<script>
export default {
    name: 'a-select',

    props: {
        // must be included in props
        value: {
            type: [Object, String, Number, Boolean],
            required: false,
            default: () => undefined,
        },
        name: {
            type: String,
            required: false,
            default: () => '',
        },
        size: {
            type: String,
            required: false,
            default: () => 'is-default',
        },
        placeholder: {
            type: String,
            required: false,
            default: () => '',
        },
        loading: {
            type: Boolean,
            required: false,
            default: () => false,
        },
        expanded: {
            type: Boolean,
            required: false,
            default: () => false,
        },
        disabled: {
            type: Boolean,
            required: false,
            default: () => false,
        },
        required: {
            type: Boolean,
            required: false,
            default: () => false,
        },
        rounded: {
            type: Boolean,
            required: false,
            default: () => false,
        },
    },

    data() {
        return {
            innerValue: undefined,
        };
    },

    computed: {},

    watch: {
        // handles internal model changes
        innerValue(newVal) {
            return this.$emit('input', newVal);
        },

        // handles external model changes
        value(newVal) {
            this.innerValue = newVal;
        },
    },

    created() {
        if (this.value || ((this.value === 0) || (this.value === false))) {
            this.innerValue = this.value;
        }
    },

    methods: {},

};
</script>
