<template>
    <section>
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
                <b-upload
                    v-model="innerValue"
                    :type="type"
                    :expanded="expanded"
                    :required="required"
                    :disabled="disabled"
                    :accept="accept"
                    :loading="loading"
                    :multiple="multiple"
                    drag-drop
                >
                    <section class="section">
                        <div class="content has-text-centered">
                            <p>
                                <b-icon
                                    icon="upload"
                                    size="is-large">
                                </b-icon>
                            </p>
                            <p>Drop image here, or click to upload</p>
                        </div>
                    </section>
                </b-upload>
            </b-field>

            <div class="tags">
                <span
                    v-for="(file, index) in innerValue"
                    :key="index"
                    class="tag is-primary"
                >
                    {{file.name}}
                    <button
                        class="delete is-small"
                        type="button"
                        @click="deleteDropFile(index)"
                    ></button>
                </span>
            </div>
        </validation-provider>
    </section>
</template>

<script>
import { ValidationProvider } from 'vee-validate';
import { InputContext } from '~/globalStateTypes';

export default {
    name: 'a-image-input',

    components: {
        ValidationProvider,
    },

    props: {
        // must be included in props
        value: {
            type: Array,
            required: false,
            default: () => '',
        },

        vid: {
            type: String,
            required: false,
            default: () => undefined,
        },

        rules: {
            type: [Object, String],
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
            default: () => 'is-primary',
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

        accept: {
            type: String,
            required: false,
            default: () => '.gif,.jpg,.jpeg,.png',
        },

        loading: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        multiple: {
            type: Boolean,
            required: false,
            default: () => true,
        },

    },

    data() {
        return {
            InputContext,

            innerValue: [],
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

    methods: {
        deleteDropFile(index) {
            this.innerValue.splice(index, 1);
        },
    },

};
</script>
