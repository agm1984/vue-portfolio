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

onMounted(fetchExample);
</script>

<template>
    <div class="w-full flex flex-col gap-8">
        <a-card class="p-8">
            <div class="flex items-center justify-between gap-4">
                <h2>{{ example.name }}</h2>

                <Button
                    v-if="isShowing"
                    icon="pi pi-pencil"
                    label="Edit"
                    @click="toggleEdit"
                />
            </div>

            <div v-if="isShowing" class="w-full grid grid-cols-[100px_1fr] gap-4 mt-8">
                <a-input-field title="ID"></a-input-field>
                <span>{{ example.id }}</span>

                <a-input-field title="Status"></a-input-field>
                <span>{{ example.status_nice }}</span>

                <a-input-field title="Name"></a-input-field>
                <span>{{ example.name }}</span>

                <a-input-field title="Slug"></a-input-field>
                <span>{{ example.slug }}</span>

                <a-input-field title="Summary"></a-input-field>
                <span>{{ example.summary }}</span>

                <a-input-field title="Conclusion"></a-input-field>
                <span>{{ example.conclusion }}</span>

                <a-input-field title="Links"></a-input-field>
                <div v-if="example.links.length" class="w-full grid grid-cols-[200px_1fr] gap-2">
                    <template
                        v-for="(link, i) in example.links"
                        :key="`link-${link.url}`"
                    >
                        <span>{{ link.name }}</span>
                        <span>{{ link.url }}</span>
                    </template>
                </div>
                <a-area-empty v-else>No links yet</a-area-empty>

                <a-input-field title="Tags"></a-input-field>
                <div v-if="example.tags.length" class="w-full flex flex-wrap gap-2">
                    <Tag
                        v-for="(tag, index) in example.tags"
                        :key="`example-tag-${index}`"
                        :value="tag"
                        rounded
                    />
                </div>
                <a-area-empty v-else>No tags yet</a-area-empty>

                <a-input-field title="Images"></a-input-field>
                <div v-if="example.images.length" class="w-full grid grid-cols-2 gap-4">
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
                <a-area-empty v-else>No images yet</a-area-empty>

                <a-input-field title="Created at"></a-input-field>
                <span>{{ example.created_at_nice }} ({{ example.created_at_diff }})</span>

                <a-input-field title="Updated at"></a-input-field>
                <span>{{ example.updated_at_nice }} ({{ example.updated_at_diff }})</span>
            </div>

            <edit-example
                v-if="isEditing"
                mode="edit"
                :initial-example="example"
                @reset="handleReset"
                @save="handleExampleSaved"
            />
        </a-card>
    </div>
</template>
