<template>
    <div>
        <a-card class="p-32" with-geometry>
            <div class="flex items-center pb-16">
                <a-heading level="2" dark>
                    {{ example.name }}
                </a-heading>

                <a-button v-if="isShowing" class="ml-16" outlined @click="toggleEdit">
                    Edit
                </a-button>
            </div>

            <div v-if="isShowing" class="p-32">
                <a-input-row type="is-wider-right" heading="ID">
                    <span>{{ example.id }}</span>
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Status">
                    <span>{{ example.status_nice }}</span>
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Name">
                    <span>{{ example.name }}</span>
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Slug">
                    <span>{{ example.slug }}</span>
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Summary" is-tall>
                    <span>{{ example.summary }}</span>
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Conclusion" is-tall>
                    <span>{{ example.conclusion }}</span>
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Links" is-tall>
                    <div
                        v-for="(link, i) in example.links"
                        :key="`link-${link.url}`"
                        class="flex flex-col"
                    >
                        <span>
                            Name: {{ link.name }}
                        </span>

                        <span>
                            URL: {{ link.url }}
                        </span>

                        <hr v-if="(i !== (example.links.length - 1))" class="h-1 my-16 bg-grey-600">
                    </div>

                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Tags" is-tall>
                    <b-tag
                        v-for="tag in example.tags"
                        :key="`tag-${tag.name}`"
                        type="is-info is-light"
                        class="m-4"
                    >
                        {{ tag.name }}
                    </b-tag>
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Images" is-tall>
                    <div class="flex flex-row flex-wrap justify-start">
                        <router-link
                            v-for="image in example.images"
                            :key="image.image_id"
                            :to="{ name: 'public.examples.images', params: { filename: image.filename } }"
                            class="relative m-16 bg-no-repeat bg-cover cursor-pointer border-1 border-primary w-256 h-128"
                            title="Click to enlarge"
                            :style="{ backgroundImage: `url('/storage/examples/${example.slug}/${image.filename}')` }"
                        ></router-link>
                    </div>
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Created at">
                    <span>{{ example.created_at_nice }} ({{ example.created_at_diff }})</span>
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Updated at">
                    <span>{{ example.updated_at_nice }} ({{ example.updated_at_diff }})</span>
                </a-input-row>
            </div>

            <div v-if="isEditing" class="">
                <edit-example
                    :example="example"
                    @reset="handleReset"
                    @saved="handleSaved"
                ></edit-example>
            </div>
        </a-card>

        <a-card class="p-32 mt-16">
            <a-heading level="2" class="mb-16">
                Add images
            </a-heading>

            <a-form v-slot="{ handleSubmit }" has-files>
                <a-multi-image-input
                    v-model="newImages"
                    vid="images"
                    rules="required"
                ></a-multi-image-input>

                <div class="flex items-center justify-end">
                    <a-button @click="handleSubmit(submitNewImages)">
                        Upload
                    </a-button>
                </div>
            </a-form>
        </a-card>

    </div>
</template>

<script>
import axios from 'axios';
import EditExample from './edit-example.vue';

const SHOWING = 'SHOWING';
const EDITING = 'EDITING';

export default {
    name: 'show-example',

    components: {
        EditExample,
    },

    middleware: ['auth', 'role-admin'],

    data() {
        return {
            state: SHOWING,
            example: {
                category: {},
            },
            links: [],
            newImages: [],
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
        return this.fetchExample();
    },

    methods: {
        async fetchExample() {
            try {
                console.log('params', this.$route.params);
                const { data } = await axios.get(route('admin.examples.show', this.$route.params.example));

                console.log('example', data.example);

                this.example = data.example;

                this.example.links.reduce((acc, link) => {
                    this.links[link.id] = {};
                    this.links[link.id].name = link.name;
                    this.links[link.id].url = link.url;
                    return acc;
                }, {});

                // this.state = SHOWING;
            } catch (err) {
                throw new Error(`show-example# Problem fetching example: ${err}.`);
            }
        },

        toggleEdit() {
            this.state = EDITING;
        },

        handleReset() {
            this.state = SHOWING;
        },

        handleSaved() {
            this.fetchExample();
            this.state = SHOWING;
        },

        async submitNewImages() {
            try {
                console.log('newImages', this.newImages);
                const payload = new FormData();

                this.newImages.forEach(image => payload.append('images[]', image));

                const { data } = await axios.post(route('admin.examples.appendImages', this.example.slug), payload);

                console.log('data', data);
            } catch (err) {
                throw new Error(`show-example# Problem adding images: ${err}.`);
            }
        },

    },

};
</script>
