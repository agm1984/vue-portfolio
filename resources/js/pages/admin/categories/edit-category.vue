<template>
    <div class="relative">
        <a-form v-slot="{ handleSubmit }">
            <a-input-row type="is-wider-right" heading="Status">
                <a-select
                    v-model="modifiedCategory.status"
                    :expanded="false"
                >
                    <option
                        v-for="status in statuses"
                        :key="status.status"
                        :value="status.status"
                    >
                        {{ status.label }}
                    </option>
                </a-select>
            </a-input-row>

            <a-input-row class="pt-16" type="is-wider-right" heading="Slug">
                <a-text-input
                    v-model="modifiedCategory.slug"
                    vid="slug"
                    rules="required"
                ></a-text-input>
            </a-input-row>

            <a-input-row class="pt-16" type="is-wider-right" heading="Name">
                <a-text-input
                    v-model="modifiedCategory.name"
                    vid="name"
                    rules="required"
                ></a-text-input>
            </a-input-row>

            <div class="flex items-center justify-end pt-16">
                <a-button type="is-default" outlined @click="onReset">
                    Cancel
                </a-button>

                <a-button class="ml-16" @click="handleSubmit(submitForm)">
                    Save
                </a-button>
            </div>
        </a-form>
    </div>
</template>

<script>
import { Category } from '~/globalModelTypes';

export default {
    name: 'edit-category',

    props: {
        category: {
            type: Object,
            required: false,
            default: () => ({
                status: Category.STATUS_ACTIVE,
            }),
        },
    },

    data() {
        return {
            modifiedCategory: this.category,
        };
    },

    computed: {
        statuses() {
            return [
                { status: Category.STATUS_INACTIVE, label: 'Inactive' },
                { status: Category.STATUS_ACTIVE, label: 'Active' },
            ];
        },
    },

    watch: {
        category: {
            deep: true,
            handler() {
                this.modifiedCategory = this.category;
            },
        },
    },

    methods: {
        onReset() {
            return this.$emit('reset');
        },
    },

};
</script>
