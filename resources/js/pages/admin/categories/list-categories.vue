<template>
    <div>
        <div class="flex items-center justify-between">
            <a-heading level="1">
                Categories
            </a-heading>

            <router-link :to="{ name: 'admin.categories.create' }">
                Create category
            </router-link>
        </div>

        <b-table
            :data="categories"
            :loading="isInitializing"
        >
            <template slot-scope="{ row }">
                <b-table-column field="id" label="ID" width="1" numeric>
                    {{ row.id }}
                </b-table-column>

                <b-table-column field="slug" label="Slug" width="1">
                    {{ row.slug }}
                </b-table-column>

                <b-table-column field="name" label="Name">
                    <router-link :to="{ name: 'admin.categories.show', params: { category: row.slug } }">
                        {{ row.name }}
                    </router-link>
                </b-table-column>

                <b-table-column field="created_at" label="Created" width="1" numeric>
                    {{ row.created_at }}
                </b-table-column>

                <b-table-column field="updated_at" label="Last updated" width="1" numeric>
                    {{ row.updated_at }}
                </b-table-column>

                <b-table-column field="status" label="Status" width="1" numeric>
                    {{ row.status }}
                </b-table-column>
            </template>
        </b-table>

    </div>
</template>

<script>
import axios from 'axios';
import CreateCategory from './create-category.vue';

const INITIAL = 'INITIAL';
const SHOW = 'SHOW';
const CREATE = 'CREATE';

export default {
    name: 'list-categories',

    middleware: ['auth', 'role-admin'],

    metaInfo() {
        return { title: 'List categories' };
    },

    data() {
        return {
            state: INITIAL,
            categories: [],
        };
    },

    computed: {
        isInitializing() {
            return (this.state === INITIAL);
        },

        isShowing() {
            return (this.state === SHOW);
        },

        isCreating() {
            return (this.state === CREATE);
        },

    },

    mounted() {
        return this.fetchData();
    },

    methods: {
        async fetchData() {
            try {
                const { data } = await axios.get(route('admin.categories.list'));

                this.categories = data.categories;
                this.state = SHOW;
            } catch (err) {
                throw new Error(`list-categories# Problem fetching list of categories: ${err}.`);
            }
        },

        resetCreate() {
            this.state = SHOW;
        },

        handleCreate() {
            this.state = CREATE;

            return this.$buefy.modal.open({
                parent: this,
                component: CreateCategory,
                onCancel: this.resetCreate,
            });
        },
    },

};
</script>
