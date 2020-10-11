<template>
    <a-card with-geometry>
        <a-heading level="1" dark>
            Create category
        </a-heading>

        <a-form v-slot="{ handleSubmit }">
            <a-select
                v-model="category.status"
                label="Status"
            >
                <option v-for="status in statuses" :key="status.status" :value="status.status">
                    {{ status.label }}
                </option>
            </a-select>

            <a-text-input
                v-model="category.name"
                label="Name"
            ></a-text-input>

            <a-text-input
                v-model="category.slug"
                label="Slug"
            ></a-text-input>

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
