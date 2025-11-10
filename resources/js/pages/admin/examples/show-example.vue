<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import Button from 'primevue/button';
import Tag from 'primevue/tag';

const currentRoute = useRoute();

const SHOWING = 'SHOWING';
const EDITING = 'EDITING';
const state = ref(SHOWING);
const newImages = ref([]);

const isShowing = computed(() => state.value === SHOWING);
const isEditing = computed(() => state.value === EDITING);

const example = ref({
    id: null,
    name: '',
    slug: '',
    status_nice: '',
    summary: '',
    conclusion: '',
    created_at_nice: '',
    created_at_diff: '',
    updated_at_nice: '',
    updated_at_diff: '',
    category: {},
    links: [],
    tags: [],
    images: [],
});

const fetchExample = async () => {
    try {
        const { data } = await axios.get(route('admin.examples.show', currentRoute.params.example));

        example.value = data.example;
    } catch (err) {
        console.error(`show-example# Problem fetching example: ${err}.`);
    }
};

const toggleEdit = () => {
    state.value = EDITING;
}

const handleReset = () => {
    state.value = SHOWING;
}

const handleExampleSaved = (updatedExample) => {
    example.value = updatedExample;
    state.value = SHOWING;
};

const submitNewImages = async () => {
    try {
        const payload = new FormData();
        newImages.value.forEach((image) => payload.append('images[]', image));

        await axios.post(route('admin.examples.appendImages', example.value.slug), payload);
        await fetchExample();
        newImages.value = [];
    } catch (err) {
        console.error(`show-example# Problem adding images: ${err}.`);
    }
};

onMounted(fetchExample);
</script>

<template>
    <div>
        <a-card class="p-8" with-geometry>
            <div class="flex items-center justify-between gap-4 pb-16">
                <h2 level="2" dark>
                    {{ example.name }}
                </h2>

                <Button
                    v-if="isShowing"
                    icon="icon-pencil"
                    label="Edit"
                    @click="toggleEdit"
                />
            </div>

            <div v-if="isShowing" class="p-8">
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
                        <span>Name: {{ link.name }}</span>
                        <span>URL: {{ link.url }}</span>
                        <hr
                          v-if="i !== (example.links?.length || 0) - 1"
                          class="h-1 my-16 bg-grey-600"
                        />
                    </div>
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Tags" is-tall>
                    <Tag
                        v-for="(tag, index) in example.tags"
                        :key="`example-tag-${index}`"
                        :value="tag"
                        rounded
                    />
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Images" is-tall>
                    <div class="w-full grid grid-cols-2 gap-4">
                        <router-link
                            v-for="image in example.images"
                            :key="`example-image-${image.id}`"
                            :to="{
                                name: 'public.examples.images',
                                params: {
                                    category: example.category.slug,
                                    example: example.slug,
                                    filename: image.filename,
                                },
                            }"
                            class="relative bg-no-repeat bg-cover cursor-pointer border w-full aspect-video"
                            title="Click to enlarge"
                            :style="{ backgroundImage: `url('/storage/examples/${example.slug}/${image.filename}')` }"
                        />
                    </div>
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Created at">
                    <span>{{ example.created_at_nice }} ({{ example.created_at_diff }})</span>
                </a-input-row>

                <a-input-row class="pt-8" type="is-wider-right" heading="Updated at">
                    <span>{{ example.updated_at_nice }} ({{ example.updated_at_diff }})</span>
                </a-input-row>
            </div>

          <edit-example
                v-if="isEditing"
                mode="edit"
                :initial-example="example"
                @reset="handleReset"
                @save="handleExampleSaved"
          />
        </a-card>

        <a-card v-if="!isEditing" class="p-8 mt-16">
            <h2 level="2" class="mb-8">Add images</h2>

            <form @submit.prevent="submitNewImages">
                <a-multi-image-input v-model="newImages" />

                <div class="flex items-center justify-end">
                    <Button type="submit">
                        Upload
                    </Button>
                </div>
            </form>
        </a-card>
    </div>
</template>
