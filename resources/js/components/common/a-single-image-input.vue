<template>
    <section>
        <div
            v-if="hasPreview"
            class="flex items-center justify-center p-8"
        >
            <img
                class="bg-no-repeat bg-cover rounded-full w-128 h-128"
                :src="imageData"
            >
        </div>
        <div v-else class="flex items-center justify-center pb-16">
            <div class="flex items-center justify-center rounded-full border-primary bg-grey-400 w-128 h-128 border-1">
                <span class="text-3xl font-aroly" style="margin-top: 1.6rem;">
                    {{ firstLetterOfName }}
                </span>
            </div>
        </div>

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
                    class="file-label"
                    @input="previewImage"
                >
                    <div class="flex flex-col justify-center">
                        <span v-if="innerValue" class="p-8 text-sm">
                            {{ innerValue.name }}
                        </span>
                        <div class="flex justify-center">
                            <span class="file-cta">
                                <b-icon class="file-icon" icon="upload"></b-icon>
                                <span class="file-label">Click to upload</span>
                            </span>
                        </div>
                    </div>
                </b-upload>
            </b-field>
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
            type: [File, String],
            required: false,
            default: () => '',
        },

        user: {
            type: Object,
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
            innerValue: undefined,
            imageData: '',
            file: undefined,
        };
    },

    computed: {
        hasFile() {
            return (Object.keys(this.innerValue).length > 0);
        },

        hasPreview() {
            return (this.imageData.length > 0);
        },

        firstLetterOfName() {
            return (this.user.name.charAt(0));
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

    },

    created() {
        if (this.value) {
            this.innerValue = this.value;
        }

        if (this.user.avatar_url) {
            this.imageData = this.user.avatar_url;
        }
    },

    mounted() {},

    methods: {
        previewImage(file) {
            console.log('runnign test', file);
            console.log('running thiss');
            const reader = new FileReader();

            reader.onload = (e) => {
                this.imageData = e.target.result;
            };
            reader.readAsDataURL(file);
        },

        deleteDropFile(index) {
            this.innerValue.splice(index, 1);
        },

    },

};
</script>
