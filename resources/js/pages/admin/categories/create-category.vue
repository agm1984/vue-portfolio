<template>
    <a-card class="p-32" with-geometry>
        <a-heading level="2" class="mb-16" dark>
            Create category
        </a-heading>

        <a-form v-slot="{ handleSubmit }">
            <a-input-row type="is-wider-right" heading="Status">
                <a-select
                    v-model="category.status"
                    vid="status"
                    rules="required"
                    :expanded="false"
                >
                    <option v-for="status in statuses" :key="status.status" :value="status.status">
                        {{ status.label }}
                    </option>
                </a-select>
            </a-input-row>

            <a-input-row type="is-wider-right" heading="Name">
                <a-text-input
                    v-model="category.name"
                ></a-text-input>
            </a-input-row>

            <a-input-row type="is-wider-right" heading="Slug">
                <a-text-input
                    v-model="category.slug"
                ></a-text-input>
            </a-input-row>

            <a-button @click="handleSubmit(submitForm)">
                Create
            </a-button>
        </a-form>
    </a-card>
</template>

<script>
import { Category } from '~/globalModelTypes';

export default {
    name: 'create-category',

    props: {},

    data() {
        return {
            category: {
                status: 1,
                slug: '',
                name: '',
            },
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

    methods: {},

};
</script>
