<template>
    <a-card with-geometry class="p-32">
        <a-heading level="2" class="mb-16">
            Users
        </a-heading>

        <b-table
            :data="users"
            :loading="isInitializing"
        >
            <template slot-scope="{ row }">
                <b-table-column field="name" label="Name">
                    <div class="flex items-center">
                        <a-avatar :size="24" :user="row" class="mr-4"></a-avatar>
                        <router-link :to="{ name: 'admin.users.show', params: { user: row.id } }">
                            {{ row.name }}
                        </router-link>
                    </div>
                </b-table-column>

                <b-table-column field="email" label="Email">
                    {{ row.email }}
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

export default {
    name: 'list-users',

    metaInfo() {
        return { title: 'List users' };
    },

    data() {
        return {
            state: INITIAL,
            users: [],
        };
    },

    computed: {
        isInitializing() {
            return (this.state === INITIAL);
        },

        isListing() {
            return (this.state === LIST);
        },
    },

    mounted() {
        return this.fetchAllUsers();
    },

    methods: {
        async fetchAllUsers() {
            try {
                const { data } = await axios.get(route('admin.users.list'));

                console.log('users', data);

                this.users = data.users;
                this.state = LIST;
            } catch (err) {
                throw new Error(`list-users# Problem fetching all users: ${err}.`);
            }
        },
    },

};
</script>
