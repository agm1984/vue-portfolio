<template>
    <a-card class="p-32" with-geometry>
        <a-heading level="2" class="mb-16" dark>
            Create example
        </a-heading>

        <div class="">
            <a-form v-slot="{ handleSubmit }" has-files>
                <a-input-row type="is-wider-right" heading="Status">
                    <a-select
                        v-model="example.status"
                        vid="status"
                        rules="required"
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
                        v-model="example.category_id"
                        vid="category"
                        rules="required"
                        :expanded="false"
                    >
                        <option
                            v-for="category in categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </a-select>
                </a-input-row>

                <a-input-row type="is-wider-right" heading="Name">
                    <a-text-input
                        v-model="example.name"
                        vid="name"
                        rules="required"
                    ></a-text-input>
                </a-input-row>

                <a-input-row type="is-wider-right" heading="Slug">
                    <a-text-input
                        v-model="example.slug"
                        vid="slug"
                        rules="required"
                    ></a-text-input>
                </a-input-row>

                <a-input-row type="is-wider-right" heading="Images">
                    <a-multi-image-input
                        v-model="example.images"
                        vid="images"
                        rules="required"
                    ></a-multi-image-input>
                </a-input-row>

                <div class="flex items-center justify-end">
                    <a-button @click="handleSubmit(submitForm)">
                        Create
                    </a-button>
                </div>
            </a-form>
        </div>

    </a-card>
</template>

<script>
import axios from 'axios';
import { Example } from '~/globalModelTypes';

const INITIAL = 'INITIAL';
const CREATE = 'CREATE';

export default {
    name: 'create-example',

    props: {},

    data() {
        return {
            state: INITIAL,
            categories: [],
            example: {
                status: Example.STATUS_ACTIVE,
                category_id: undefined,
                slug: '',
                name: '',
                images: [],
            },
        };
    },

    computed: {
        statuses() {
            return [
                { status: Example.STATUS_INACTIVE, label: 'Inactive' },
                { status: Example.STATUS_ACTIVE, label: 'Active' },
            ];
        },
    },

    mounted() {
        return this.fetchAllCategories();
    },

    methods: {
        async fetchAllCategories() {
            try {
                const { data } = await axios.get(route('admin.categories.list'));

                // console.log('catz', data.categories);

                this.categories = data.categories;
                this.example.category_id = 1;
                this.state = CREATE;
            } catch (err) {
                throw new Error(`create-example# Problem fetching all categories: ${err}.`);
            }
        },

        async submitForm() {
            try {
                const payload = new FormData();

                Object.keys(this.example).forEach(field => payload.append(field, this.example[field]));

                this.example.images.forEach(image => payload.append('images[]', image));

                const response = await axios.post(route('admin.examples.create'), payload);

                // console.log('newExample form submitted', response.data.example);
                return this.$router.push({ name: 'admin.examples.show', params: { example: response.data.example.slug } }).catch(() => {});
            } catch (err) {
                throw new Error(`create-example# Problem creating new example: ${err}.`);
            }
        },

        uploadImageSuccess(formData, index, fileList) {
            console.log('uploadImageSuccess', formData);
            this.example.images = fileList;
        },

        beforeRemove(index, done, fileList) {
            console.log('index', index, fileList);
            const r = confirm('remove image');
            if (r == true) {
                done();
            } else {
                // do nothing
            }
        },

        editImage(formData, index, fileList) {
            console.log('editImage', formData);
            console.log('index', index);
            console.log('fileList', fileList);
            this.example.images = fileList;
        },

        dataChange(data) {
            console.log('data change', data);
        },

        limitExceeded(amount) {
            console.log(amount);
        },

    },

};
</script>
