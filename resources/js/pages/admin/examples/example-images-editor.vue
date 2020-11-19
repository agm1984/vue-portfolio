<template>
    <div>
        <div v-for="(image, i) in innerValue" :key="`image-${image.filename}`">
            <div
                class="bg-no-repeat bg-cover border-1 border-primary w-320 h-160"
                :style="{ backgroundImage: `url('/storage/examples/${example.slug}/${image.filename}')` }"
            ></div>

            <a-button type="is-danger" size="is-small" outlined @click="() => handleRemove(image, i)">
                Remove
            </a-button>
        </div>

    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'example-images-editor',

    props: {
        // must be included in props
        value: {
            type: Array,
            required: false,
            default: () => '',
        },

        example: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            innerValue: [],
            newImages: [],
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
        if (this.value) {
            this.innerValue = this.value;
            console.log('innerValue', this.innerValue);
        }
    },

    methods: {
        async handleRemove(image, index) {
            try {
                console.log('REMOVE', image.filename);

                await axios.put(route('admin.examples.removeImage', [this.example.slug, image.filename]));

                this.innerValue.splice(index, 1);
            } catch (err) {
                throw new Error(`example-images-editor# Problem removing image: ${err}.`);
            }
        },
    },

};
</script>
