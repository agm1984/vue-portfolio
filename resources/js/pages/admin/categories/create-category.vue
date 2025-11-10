<template>
    <a-card class="p-8" with-geometry>
        <h2 level="2" class="mb-16" dark>
            Create category
        </h2>

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

            <a-input-row class="pt-8" type="is-wider-right" heading="Name">
                <a-text-input
                    v-model="category.name"
                    vid="name"
                    rules="required"
                ></a-text-input>
            </a-input-row>

            <a-input-row class="pt-8" type="is-wider-right" heading="Slug">
                <a-text-input
                    v-model="category.slug"
                    vid="slug"
                    rules="required"
                ></a-text-input>
            </a-input-row>

            <div class="flex items-center justify-end pt-8">
                <a-button @click="handleSubmit(submitForm)">
                    Create
                </a-button>
            </div>
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
