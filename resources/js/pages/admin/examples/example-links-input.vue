<template>
    <div class="flex flex-col w-full h-auto">
        <div v-for="(link, i) in innerValue" :key="`example-link-${i}`">
            <a-text-input
                v-model="link.name"
                :vid="`name[${i}]`"
                rules="required"
                placeholder="Name"
            ></a-text-input>

            <a-text-input
                v-model="link.url"
                :vid="`url[${i}]`"
                rules="required"
                placeholder="URL"
                class="pt-8"
            ></a-text-input>

            <a-button
                type="is-danger"
                size="is-small"
                :class="['pt-8', {
                    'mb-16': (i !== (value.length - 1))
                }]"
                outlined
                @click="() => handleRemove(i)"
            >
                Remove
            </a-button>
        </div>

        <div class="flex items-center justify-end">
            <a-button type="is-default" @click="handleAddAnother">
                {{ addButtonText }}
            </a-button>
        </div>

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
            innerValue: [],
        };
    },

    computed: {
        hasLinks() {
            return (this.value.length > 0);
        },

        addButtonText() {
            if (this.hasLinks) return 'Add another';
            return 'Add';
        },
    },

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
        if (this.value) {
            this.innerValue = this.value;
        }
    },

    methods: {
        handleRemove(index) {
            this.innerValue.splice(index, 1);
        },

        handleAddAnother() {
            this.innerValue.push({
                name: '',
                url: '',
            });
        },
    },

};
</script>
