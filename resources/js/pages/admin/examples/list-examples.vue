<template>
    <a-card class="p-32" with-geometry>
        <a-heading level="2" class="mb-16">
            Examples
        </a-heading>

        <b-table
            :data="examples"
            :loading="isInitializing"
        >
            <template slot-scope="{ row }">
                <b-table-column field="name" label="Name">
                    <router-link :to="{ name: 'admin.examples.show', params: { example: row.slug } }">
                        {{ row.name }}
                    </router-link>
                </b-table-column>

                <b-table-column field="slug" label="Slug">
                    {{ row.slug }}
                </b-table-column>

                <b-table-column field="category.name" label="Category" width="1">
                    {{ row.category.name }}
                </b-table-column>

                <b-table-column field="created_at" label="Created" width="128" numeric>
                    {{ row.created_at_diff }}
                </b-table-column>

                <b-table-column field="updated_at" label="Last updated" width="128" numeric>
                    {{ row.updated_at_diff }}
                </b-table-column>

                <b-table-column field="status" label="Status" width="1" numeric>
                    <a-status-tag :status="row.status_nice"></a-status-tag>
                </b-table-column>
            </template>
        </b-table>

    </a-card>
</template>

<script>
import axios from 'axios';

const INITIAL = 'INITIAL';
const LIST = 'LIST';
const CREATE = 'CREATE';

export default {
    name: 'list-examples',

    middleware: ['auth', 'role-admin'],

    metaInfo() {
        return { title: 'List examples' };
    },

    data() {
        return {
            state: INITIAL,
            examples: [],
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
        return this.fetchAllExamples();
    },

    methods: {
        async fetchAllExamples() {
            try {
                const { data } = await axios.get(route('admin.examples.list'));

                console.log('examples', data.examples[0]);

                this.examples = data.examples;
                this.state = LIST;
            } catch (err) {
                throw new Error(`list-examples# Problem fetching all examples: ${err}.`);
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
