<template>
    <div class="w-full">
        <validation-provider
            v-slot="{ errors, valid }"
            :vid="vid"
            :name="$attrs.name || $attrs.label"
            :rules="rules"
        >
            <b-field
                :label="label"
                :type="{
                    [InputContext.DEFAULT]: false,
                    [InputContext.NEGATIVE]: errors[0],
                    [InputContext.POSITIVE]: false,
                    [InputContext.INFO]: false,
                    [InputContext.WARN]: false,
                }"
                :message="errors"
            >
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
            </b-field>
        </validation-provider>
    </div>
</template>

<script>
import { ValidationProvider } from 'vee-validate';
import { InputContext, InputSize } from '~/globalStateTypes';

export default {
    name: 'a-select',

    components: {
        ValidationProvider,
    },

    props: {
        // must be included in props
        value: {
            type: [Object, String, Number, Boolean],
            required: false,
            default: () => undefined,
        },
        vid: {
            type: String,
            required: false,
            default: () => undefined,
        },
        rules: {
            type: [Object, String, Date],
            default: () => '',
        },
        name: {
            type: String,
            required: false,
            default: () => '',
        },
        label: {
            type: String,
            required: false,
            default: () => '',
        },
        size: {
            type: String,
            required: false,
            default: () => InputSize.DEFAULT,
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
            default: () => true,
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
            InputContext,

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
