<template>
    <a-card with-geometry>
        <div class="relative flex items-center justify-between">
            <div class="flex items-center">
                <a-heading level="1" dark>
                    {{ example.name }}
                </a-heading>
                <b-tag class="ml-8">{{ example.category.name }}</b-tag>
            </div>

            <a-button v-if="isShowing" @click="toggleEdit">
                Edit
            </a-button>
        </div>

        <a-card v-if="isShowing">
            <a-input-row type="is-split" heading="ID">
                <span>{{ example.id }}</span>
            </a-input-row>

            <a-input-row type="is-split" heading="Status">
                <span>{{ example.status }}</span>
            </a-input-row>

            <a-input-row type="is-split" heading="Slug">
                <span>{{ example.slug }}</span>
            </a-input-row>

            <a-input-row type="is-split" heading="Name">
                <span>{{ example.name }}</span>
            </a-input-row>

            <a-input-row type="is-split" heading="Created at">
                <span>{{ example.created_at }}</span>
            </a-input-row>

            <a-input-row type="is-split" heading="Updated at">
                <span>{{ example.updated_at }}</span>
            </a-input-row>

            <a-input-row type="is-split" heading="Summary">
                <span>{{ example.summary }}</span>
            </a-input-row>

            <a-input-row type="is-split" heading="Conclusion">
                <span>{{ example.conclusion }}</span>
            </a-input-row>
        </a-card>

        <div v-if="isEditing" class="">
            <edit-example
                :example="example"
                @reset="handleReset"
            ></edit-example>
        </div>

    </a-card>
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
                const { data } = await axios.get(route('admin.examples.show', [this.$route.params.category, this.$route.params.example]));

                console.log('example', data.example);

                this.example = data.example;
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
