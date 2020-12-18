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
                :expanded="expanded"
                :required="required"
                :disabled="disabled"
                :loading="loading"
            >
                <b-upload
                    v-model="innerValue"
                    multiple
                    drag-drop
                >
                    <section class="section">
                        <div class="content has-text-centered">
                            <p>
                                <b-icon
                                    icon="upload"
                                    size="is-large"
                                ></b-icon>
                            </p>

                            <p>
                                Drop your files here or click to upload
                            </p>
                        </div>
                    </section>
                </b-upload>
            </b-field>

            <div class="tags">
                <span v-for="(file, index) in innerValue" :key="index" class="tag is-primary">
                    {{ file.name }}

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
    name: 'a-multi-image-input',

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

        loading: {
            type: Boolean,
            required: false,
            default: () => false,
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

    created() {
        if (this.value) {
            this.innerValue = this.value;
        }
    },

    mounted() {},

    methods: {
        deleteDropFile(index) {
            this.innerValue.splice(index, 1);
        },
    },

};
</script>
