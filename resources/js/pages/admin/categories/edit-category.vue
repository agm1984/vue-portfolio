<template>
    <div class="relative">
        <a-form v-slot="{ handleSubmit }">
            <a-input-row type="is-split" heading="Status">
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

            <a-input-row type="is-split" heading="Slug">
                <a-text-input
                    v-model="modifiedCategory.slug"
                ></a-text-input>
            </a-input-row>

            <a-input-row type="is-split" heading="Name">
                <a-text-input
                    v-model="modifiedCategory.name"
                ></a-text-input>
            </a-input-row>

            <div class="flex items-center justify-end">
                <a-button @click="onReset">
                    Cancel
                </a-button>

                <a-button @click="handleSubmit(submitForm)">
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
