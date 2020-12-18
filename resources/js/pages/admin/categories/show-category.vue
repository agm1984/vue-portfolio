<template>
    <div class="">
        <a-card class="p-32" with-geometry>
            <div class="relative flex items-center mb-16">
                <a-heading level="2">
                    {{ category.name }}
                </a-heading>

                <a-button v-if="isShowing" class="ml-16" outlined @click="toggleEdit">
                    Edit
                </a-button>
            </div>

            <div v-if="isShowing">
                <a-input-row type="is-wider-right" heading="ID">
                    <span>{{ category.id }}</span>
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Status">
                    <span>{{ category.status_nice }}</span>
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Name">
                    <span>{{ category.name }}</span>
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Slug">
                    <span>{{ category.slug }}</span>
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Examples">
                    <span>{{ category.examples_count }}</span>
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Created at">
                    <span>{{ category.created_at_nice }} ({{ category.created_at_diff }})</span>
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Updated at">
                    <span>{{ category.updated_at_nice }} ({{ category.updated_at_diff }})</span>
                </a-input-row>
            </div>

            <div v-if="isEditing" class="">
                <edit-category
                    :category="category"
                    @reset="handleReset"
                ></edit-category>
            </div>

        </a-card>

        <a-card class="p-32 mt-16">
            <a-heading level="2" class="mb-16">
                Examples
            </a-heading>

            <div class="flex flex-wrap w-full">
                <router-link
                    v-for="example in category.examples"
                    :key="example.slug"
                    :to="{ name: 'admin.examples.show', params: { category: example.category.slug, example: example.slug } }"
                    class="m-32"
                >
                    <a-tilt>
                        <a-card class="">
                            <div
                                class="relative bg-no-repeat bg-cover h-160 w-320"
                                :style="{ backgroundImage: `url('/storage/examples/${example.slug}/${example.images[0].filename}')` }"
                            >
                                <div class="px-16 py-8 bg-transparent-grey">
                                    <span class="text-white font-nunito">
                                        {{ example.name }}
                                    </span>
                                </div>

                                <b-tag v-if="example.status === 1" class="absolute bottom-0 right-0 m-8" type="is-success is-light" rounded>
                                    {{ example.status_nice }}
                                </b-tag>
                                <b-tag v-else class="absolute bottom-0 right-0 m-8" type="is-warning is-light" rounded>
                                    {{ example.status_nice }}
                                </b-tag>
                            </div>
                        </a-card>
                    </a-tilt>
                </router-link>
            </div>
        </a-card>
    </div>
</template>

<script>
import axios from 'axios';
import EditCategory from './edit-category.vue';

const SHOWING = 'SHOWING';
const EDITING = 'EDITING';

export default {
    name: 'show-category',

    components: {
        EditCategory,
    },

    middleware: ['auth', 'role-admin'],

    data() {
        return {
            state: SHOWING,
            category: {},
        };
    },

    computed: {
        isShowing() {
            return (this.state === SHOWING);
        },

        isEditing() {
            return (this.state === EDITING);
        },
    },

    mounted() {
        return this.fetchCategory();
    },

    methods: {
        async fetchCategory() {
            try {
                const { data } = await axios.get(route('admin.categories.show', this.$route.params.category));

                console.log('category', data.category);

                this.category = data.category;
                // this.state = SHOWING;
            } catch (err) {
                throw new Error(`show-category# Problem fetching category: ${err}.`);
            }
        },

        handleReset() {
            this.state = SHOWING;
        },

        toggleEdit() {
            this.state = EDITING;
        },
    },

};
</script>
