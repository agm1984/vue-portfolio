<template>
    <a-card with-geometry>
        <a-heading level="1" dark>
            Create example
        </a-heading>

        <a-form v-slot="{ handleSubmit }">
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
                    v-model="example.category.slug"
                    vid="category"
                    rules="required"
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
                    @upload-success="uploadImageSuccess"
                    @before-remove="beforeRemove"
                    @edit-image="editImage"
                    @data-change="dataChange"
                    @limit-exceeded="limitExceeded"
                ></a-multi-image-input>
            </a-input-row>

            <div id="my-strictly-unique-vue-upload-multiple-image" style="display: flex; justify-content: center;">

            </div>

            <a-button @click="handleSubmit(submitForm)">
                Create
            </a-button>
        </a-form>

        {{ example }}
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
                category: {},
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
        this.fetchAllCategories();
    },

    methods: {
        async fetchAllCategories() {
            try {
                const { data } = await axios.get(route('admin.categories.list'));

                // console.log('catz', data.categories);

                this.categories = data.categories;
                this.state = CREATE;
            } catch (err) {
                throw new Error(`create-example# Problem fetching all categories: ${err}.`);
            }
        },

        async submitForm() {
            try {
                console.log('testtttttttt');
            } catch (err) {
                throw new Error();
            }
        },

        uploadImageSuccess(formData, index, fileList) {
            console.log('uploadImageSuccess', formData, index, fileList);

            // Upload image api
            // axios.post('http://gostore.gostore-api.test/api/items/upload', formData).then(response => {
            //   console.log(response)
            // })
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
            console.log('edit data', formData, index, fileList);
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
