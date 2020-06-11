<template>
    <div>
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
                <b-checkbox
                    v-model="innerValue"
                    ref="checkbox"
                    :name="vid"
                    :type="type"
                    :size="size"
                    :expanded="expanded"
                    :required="required"
                    :disabled="disabled"
                    :native-value="nativeValue"
                    :indeterminate="indeterminate"
                    :true-value="trueValue"
                    :false-value="falseValue"
                >
                    <slot></slot>
                </b-checkbox>

            </b-field>
        </validation-provider>
    </div>
</template>

<script>
import { ValidationProvider } from 'vee-validate';
import { InputContext, InputSize } from '~/globalStateTypes';

const SUPPORTED_INPUT_SIZES = Object.values(InputSize);

export default {
    name: 'a-checkbox',

    components: {
        ValidationProvider,
    },

    props: {
        // must be included in props
        value: {
            type: Boolean,
            required: false,
            default: () => '',
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
        type: {
            type: String,
            required: false,
            default: () => 'text',
        },
        size: {
            type: String,
            required: false,
            default: () => InputSize.DEFAULT,
        },
        expanded: {
            type: Boolean,
            required: false,
            default: () => false,
        },
        required: {
            type: Boolean,
            required: false,
            default: () => false,
        },
        disabled: {
            type: Boolean,
            required: false,
            default: () => false,
        },
        nativeValue: {
            type: [Boolean, Number, String],
            required: false,
            default: () => undefined,
        },
        indeterminate: {
            type: Boolean,
            required: false,
            default: () => false,
        },
        trueValue: {
            type: [Boolean, Number, String, Object, Array, Date],
            required: false,
            default: () => true,
        },
        falseValue: {
            type: [Boolean, Number, String, Object, Array, Date],
            required: false,
            default: () => false,
        },
    },

    data() {
        return {
            InputContext,

            innerValue: '',
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
        if (this.value) {
            this.innerValue = this.value;
        }
    },

    methods: {},

};
</script>
