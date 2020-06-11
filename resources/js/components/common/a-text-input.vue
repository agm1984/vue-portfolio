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
                <b-input
                    v-model="innerValue"
                    ref="textInput"
                    :name="vid"
                    :type="type"
                    :size="size"
                    :expanded="expanded"
                    :required="required"
                    :disabled="disabled"
                    :password-reveal="passwordReveal"
                    :loading="loading"
                    :icon-pack="iconPack"
                    :icon="icon"
                    :placeholder="placeholder"
                    :maxlength="maxlength"
                    :has-counter="hasCounter"
                    :custom-class="customClass"
                    :rounded="rounded"
                ></b-input>

            </b-field>
        </validation-provider>
    </div>
</template>

<script>
import { ValidationProvider } from 'vee-validate';
import { InputContext, InputSize } from '~/globalStateTypes';

const SUPPORTED_INPUT_SIZES = Object.values(InputSize);

export default {
    name: 'a-text-input',

    components: {
        ValidationProvider,
    },

    props: {
        // must be included in props
        value: {
            type: [String, Number],
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

        passwordReveal: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        loading: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        rounded: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        iconPack: {
            type: String,
            required: false,
            default: () => 'fas',
        },

        icon: {
            type: String,
            required: false,
            default: () => undefined,
        },

        placeholder: {
            type: String,
            required: false,
            default: () => '',
        },

        maxlength: {
            type: [Number, String],
            required: false,
            default: () => undefined,
        },

        hasCounter: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        customClass: {
            type: String,
            required: false,
            default: () => '',
        },
    },

    data() {
        return {
            InputContext,

            innerValue: '',
        };
    },

    computed: {
        hasRulesWithoutVid() {
            return (!this.vid && !!this.rules);
        },

    },

    watch: {
        // handles internal model changes
        innerValue(newVal) {
            return this.$emit('input', newVal);
        },

        // handles external model changes
        value(newVal) {
            this.innerValue = newVal;
        },

        size() {
            if (!SUPPORTED_INPUT_SIZES.includes(this.size)) {
                throw new Error(`a-text-input# Illegal size '${this.size}', expected one of [${SUPPORTED_INPUT_SIZES}].`);
            }
        },

    },

    created() {
        if (this.value) {
            this.innerValue = this.value;
        }

        if (!SUPPORTED_INPUT_SIZES.includes(this.size)) {
            throw new Error(`a-text-input# Illegal size '${this.size}', expected one of [${SUPPORTED_INPUT_SIZES}].`);
        }

        if (this.hasRulesWithoutVid) {
            throw new Error('a-text-input# If you specify validation \'rules\' prop, you must also use the \'vid\' prop.');
        }
    },

    methods: {},
};
</script>
