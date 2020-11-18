<template>
    <div>
        <div v-for="(link, i) in links" :key="`example-link-${i}`">
            <a-text-input
                v-model="links[i].name"
                :class="{
                    'pt-16': (i === (value.length - 1))
                }"
            ></a-text-input>

            <a-text-input
                v-model="links[i].url"
            ></a-text-input>
        </div>

        <a-button type="is-default" @click="handleAddAnother">
            Add another
        </a-button>

        A: {{ links }}
    </div>
</template>

<script>
export default {
    name: 'example-links-input',

    props: {
        // must be included in props
        value: {
            type: Array,
            required: false,
            default: () => '',
        },
    },

    data() {
        return {
            links: {},
        };
    },

    computed: {},

    watch: {
        // handles internal model changes
        innerValue(newVal) {
            return this.$emit('input', newVal);
        },

        // handles external model changes
        value(newVal) {
            this.innerValue = newVal;
        },
    },

    created() {
        console.log('LINKS', this.value);

        this.value.reduce((acc, link, i) => {
            this.links[i] = {};
            this.links[i].name = link.name;
            this.links[i].url = link.url;
            return acc;
        }, {});
    },

    methods: {
        handleAddAnother() {
            const current = Object.keys(this.links).length;

            console.log('links', this.links);

            this.$set(this.links, current, {});
            this.$set(this.links[current], 'name', '');
            this.$set(this.links[current], 'url', '');
        },
    },

};
</script>
