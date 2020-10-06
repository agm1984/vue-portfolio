<template>
    <a-card with-geometry>
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

    </a-card>
</template>

<script>
import axios from 'axios';
import CreateCategory from './create-category.vue';

const INITIAL = 'INITIAL';
const LIST = 'LIST';
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

        isListing() {
            return (this.state === LIST);
        },

        // isCreating() {
        //     return (this.state === CREATE);
        // },

    },

    mounted() {
        return this.fetchAllCategories();
    },

    methods: {
        async fetchAllCategories() {
            try {
                const { data } = await axios.get(route('admin.categories.list'));

                this.categories = data.categories;
                this.state = LIST;
            } catch (err) {
                throw new Error(`list-categories# Problem fetching all categories: ${err}.`);
            }
        },

        // resetCreate() {
        //     this.state = LIST;
        // },

        // use as reference for modals?
        // handleCreate() {
        //     this.state = CREATE;

        //     return this.$buefy.modal.open({
        //         parent: this,
        //         component: CreateCategory,
        //         onCancel: this.resetCreate,
        //     });
        // },
    },

};
</script>
