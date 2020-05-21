<template>
    <div>
        <a-button @click="handleCreate">
            Create category
        </a-button>

        <b-table
            :data="categories"
            :loading="false"
        >
            <template slot-scope="props">
                <b-table-column field="id" label="ID" width="1" numeric>
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column field="slug" label="Slug" width="1">
                    {{ props.row.slug }}
                </b-table-column>

                <b-table-column field="name" label="Name">
                    {{ props.row.name }}
                </b-table-column>

                <b-table-column field="created_at" label="Created" width="1" numeric>
                    {{ props.row.created_at }}
                </b-table-column>

                <b-table-column field="updated_at" label="Last updated" width="1" numeric>
                    {{ props.row.updated_at }}
                </b-table-column>

                <b-table-column field="status" label="Status" width="1" numeric>
                    {{ props.row.status }}
                </b-table-column>
            </template>
        </b-table>

    </div>
</template>

<script>
import axios from 'axios';
import CreateCategory from './create-category.vue';

const SHOW = 'SHOW';
const CREATE = 'CREATE';

export default {
    name: 'list-categories',

    middleware: 'role-admin',

    metaInfo() {
        return { title: 'List categories' };
    },

    data() {
        return {
            state: SHOW,
            categories: [],
        };
    },

    computed: {
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
            } catch (err) {
                throw new Error(`list-categories# Problem fetching list of categories: ${err}.`);
            }
        },

        resetCreate() {
            this.state = SHOW;
        },

        handleCreate() {
            this.$buefy.modal.open({
                parent: this,
                component: CreateCategory,
                onCancel: this.resetCreate,
            });

            this.state = CREATE;
        },
    },

};
</script>
