<template>
    <div>
        <a-card class="p-32" with-geometry>
            <a-heading level="1" class="mb-16" dark>
                {{ example.name }}
            </a-heading>

            <div class="flex items-center justify-end">
                <a-button v-if="isShowing" @click="toggleEdit">
                    Edit
                </a-button>
            </div>

            <div v-if="isShowing" class="p-32">
                <a-input-row type="is-wider-right" heading="ID">
                    <span>{{ example.id }}</span>
                </a-input-row>

                <a-input-row class="pt-16" type="is-wider-right" heading="Status">
                    <span>{{ example.status_nice }}</span>
                </a-input-row>

                <a-input-row class="pt-16" type="is-wider-right" heading="Name">
                    <span>{{ example.name }}</span>
                </a-input-row>

                <a-input-row class="pt-16" type="is-wider-right" heading="Slug">
                    <span>{{ example.slug }}</span>
                </a-input-row>

                <a-input-row class="pt-16" type="is-wider-right" heading="Summary" is-tall>
                    <span>{{ example.summary }}</span>
                </a-input-row>

                <a-input-row class="pt-16" type="is-wider-right" heading="Conclusion" is-tall>
                    <span>{{ example.conclusion }}</span>
                </a-input-row>

                <a-input-row class="pt-16" type="is-wider-right" heading="Created at">
                    <span>{{ example.created_at }}</span>
                </a-input-row>

                <a-input-row class="pt-16" type="is-wider-right" heading="Updated at">
                    <span>{{ example.updated_at }}</span>
                </a-input-row>
            </div>

            <div v-if="isEditing" class="">
                <edit-example
                    :example="example"
                    @reset="handleReset"
                ></edit-example>
            </div>
        </a-card>

        <a-card class="p-32 mt-16">
            <a-heading level="2" class="mb-16">
                Images
            </a-heading>

            <div class="flex flex-row flex-wrap justify-start">
                <router-link
                    v-for="image in example.images"
                    :key="image.image_id"
                    :to="{ name: 'public.examples.images', params: { filename: image.filename } }"
                    class="relative m-16 bg-no-repeat bg-cover cursor-pointer border-1 border-primary w-320 h-160"
                    title="Click to enlarge"
                    :style="{ backgroundImage: `url('/storage/examples/${example.slug}/${image.filename}')` }"
                ></router-link>
            </div>
        </a-card>

        <a-card class="p-32 mt-16">
            <a-heading level="2" class="mb-16">
                Links
            </a-heading>

            <div v-for="(link, i) in example.links" :key="`link-${link.id}`" class="flex flex-col">
                <a-input-row type="is-wider-right" heading="Name">
                    <a-text-input
                        v-model="links[link.id].name"
                    ></a-text-input>
                </a-input-row>

                <a-input-row type="is-wider-right" heading="URL">
                    <a-text-input
                        v-model="links[link.id].url"
                    ></a-text-input>
                </a-input-row>

                <hr v-if="(i !== (example.links.length - 1))" class="h-1 my-16 bg-grey-600">
            </div>
        </a-card>

        <a-card class="p-32 mt-16">
            <a-heading level="2" class="mb-16">
                Tags
            </a-heading>

            <div v-for="tag in example.tags" :key="`tag-${tag.id}`" class="flex flex-col">
                <a-input-row type="is-wider-right" heading="Name">
                    <a-text-input
                        v-model="tags[tag.id].name"
                    ></a-text-input>
                </a-input-row>
            </div>

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
            links: {},
            tags: {},
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

                this.example.tags.reduce((acc, tag) => {
                    this.tags[tag.id] = {};
                    this.tags[tag.id].name = tag.name;
                    return acc;
                }, {});

                // this.state = SHOWING;
            } catch (err) {
                throw new Error(`show-example# Problem fetching example: ${err}.`);
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
