<template>
    <div class="relative">
        <a-form v-slot="{ handleSubmit }">
            <a-input-row type="is-wider-right" heading="Status">
                <a-select
                    v-model="modifiedExample.status"
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

            <a-input-row type="is-wider-right" heading="Category">
                <a-select
                    v-model="modifiedExample.category.slug"
                    :expanded="false"
                >
                    <option
                        v-for="category in categories"
                        :key="category.slug"
                        :value="category.slug"
                    >
                        {{ category.name }}
                    </option>
                </a-select>
            </a-input-row>

            <a-input-row type="is-wider-right" heading="Name">
                <a-text-input
                    v-model="modifiedExample.name"
                ></a-text-input>
            </a-input-row>

            <a-input-row type="is-wider-right" heading="Slug">
                <a-text-input
                    v-model="modifiedExample.slug"
                ></a-text-input>
            </a-input-row>

            <a-input-row type="is-wider-right" heading="Summary">
                <a-text-input
                    v-model="modifiedExample.summary"
                    rules="required"
                    vid="summary"
                    type="textarea"
                    maxlength="2000"
                    has-counter
                ></a-text-input>
            </a-input-row>

            <a-input-row type="is-wider-right" heading="Conclusion">
                <a-text-input
                    v-model="modifiedExample.conclusion"
                    rules="required"
                    vid="conclusion"
                    type="textarea"
                    placeholder="Type your message here"
                    maxlength="2000"
                    has-counter
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
import axios from 'axios';
import { Category } from '~/globalModelTypes';

const INITIAL = 'INITIAL';
const EDIT = 'EDIT';

export default {
    name: 'edit-example',

    props: {
        example: {
            type: Object,
            required: false,
            default: () => ({
                status: Category.STATUS_ACTIVE,
                category: {},
            }),
        },
    },

    data() {
        return {
            state: INITIAL,
            categories: [],
            modifiedExample: this.example,
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
        example: {
            deep: true,
            handler() {
                this.modifiedExample = this.example;
            },
        },
    },

    mounted() {
        this.fetchAllCategories();
    },

    methods: {
        onReset() {
            this.modifiedExample = {};
            this.modifiedExample = this.example;
            return this.$emit('reset');
        },

        async fetchAllCategories() {
            try {
                const { data } = await axios.get(route('admin.categories.list'));

                // console.log('catz', data.categories);

                this.categories = data.categories;
                this.state = EDIT;
            } catch (err) {
                throw new Error(`edit-example# Problem fetching all categories: ${err}.`);
            }
        },
    },

};
</script>
