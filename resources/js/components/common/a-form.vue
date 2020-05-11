<template>
    <validation-observer
        ref="observer"
        v-slot="{
            dirty,
            pristine,
            valid,
            invalid,
            pending,
            touched,
            untouched,
            errors,
            validate,
            reset,
            handleSubmit,
        }"
        tag="form"
        :action="action"
        :enctype="formEncType"
        :method="computedMethod"
        :name="name"
        v-bind="$attrs"
        v-on="$listeners"
        @submit="onSubmit"
    >
        <!-- form fields -->
        <slot
            :dirty="dirty"
            :errors="errors"
            :invalid="invalid"
            :pending="pending"
            :pristine="pristine"
            :reset="reset"
            :touched="touched"
            :untouched="untouched"
            :valid="valid"
            :validate="validate"
            :handle-submit="handleSubmit"
        ></slot>
    </validation-observer>
</template>

<script>
import { ValidationObserver } from 'vee-validate';
import { FormMethod } from '~/globalStateTypes';

const SUPPORTED_FORM_METHODS = Object.values(FormMethod);

export default {
    name: 'a-form',

    components: { ValidationObserver },

    props: {
        method: {
            type: String,
            required: false,
            default: () => FormMethod.GET,
        },

        name: {
            type: String,
            required: false,
            default: () => undefined,
        },

        action: {
            type: String,
            required: false,
            default: () => undefined,
        },

        hasFiles: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        submit: {
            type: Function,
            required: false,
            default: () => false,
        },
    },

    data() {
        return {
            FormMethod,
        };
    },

    computed: {
        isMethodPost() {
            return (this.method === FormMethod.POST);
        },

        isMethodPut() {
            return (this.method === FormMethod.PUT);
        },

        isMethodDelete() {
            return (this.method === FormMethod.DELETE);
        },

        hasAction() {
            return !!this.action;
        },

        computedMethod() {
            if (this.method === FormMethod.GET) return FormMethod.GET;
            return FormMethod.POST; // works for POST, PUT, and DELETE
        },

        formEncType() {
            // currently unused: 'text/plain'
            if (this.hasFiles) return 'multipart/form-data';
            return 'application/x-www-form-urlencoded';
        },
    },

    watch: {
        method() {
            return this.validateFormMethod();
        },
    },

    created() {
        return this.validateFormMethod();
    },

    mounted() {
        return this.$emit('mounted');
    },

    methods: {
        validateFormMethod() {
            if (!SUPPORTED_FORM_METHODS.includes(this.method)) {
                throw new Error(`a-form# Illegal method '${this.method}', expected one of [${SUPPORTED_FORM_METHODS}].`);
            }
        },

        async onSubmit(event) {
            const isValid = await this.$refs.observer.validate();

            if (!isValid) {
                return event.preventDefault();
            } else if (this.submit !== false) {
                event.preventDefault();
                return this.submit();
            }

            return undefined; // do nothing and resolve promise
        },
    },

};
</script>
