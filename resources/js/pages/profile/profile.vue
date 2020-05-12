<template>
    <card title="Your info">
        <form @submit.prevent="update" @keydown="form.onKeydown($event)">
            <alert-success :form="form" message="Info updated"></alert-success>

            <!-- Name -->
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Name</label>
                <div class="col-md-7">
                    <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
                    <has-error :form="form" field="name"></has-error>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Email</label>
                <div class="col-md-7">
                    <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
                    <has-error :form="form" field="email"></has-error>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group row">
                <div class="col-md-9 ml-md-auto">
                    <v-button :loading="form.busy" type="success">
                        Update
                    </v-button>
                </div>
            </div>
        </form>
    </card>
</template>

<script>
import Form from 'vform';
import { mapGetters } from 'vuex';

export default {
    name: 'profile',

    scrollToTop: false,

    metaInfo() {
        return { title: 'Profile' };
    },

    data() {
        return {
            form: new Form({
                name: '',
                email: '',
            }),
        };
    },

    computed: mapGetters({
        user: 'auth/user',
    }),

    created() {
    // Fill the form with user data.
        this.form.keys().forEach((key) => {
            this.form[key] = this.user[key];
        });
    },

    methods: {
        async update() {
            const { data } = await this.form.patch('/api/settings/profile');
            this.$store.dispatch('auth/updateUser', { user: data });
        },

    },

};
</script>
