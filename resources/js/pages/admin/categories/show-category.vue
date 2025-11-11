<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import Button from 'primevue/button';

const currentRoute = useRoute()

const SHOWING = 'SHOWING'
const EDITING = 'EDITING'

const state = ref(SHOWING)
const category = ref({
  id: null,
  name: '',
  slug: '',
  status_nice: '',
  examples_count: 0,
  created_at_nice: '',
  created_at_diff: '',
  updated_at_nice: '',
  updated_at_diff: '',
  examples: [],
})

const isShowing = computed(() => state.value === SHOWING)
const isEditing = computed(() => state.value === EDITING)

async function fetchCategory() {
  try {
    const { data } = await axios.get(route('admin.categories.show', currentRoute.params.category))

    category.value = data.category
  } catch (err) {
    console.error(`show-category# Problem fetching category: ${err}.`)
  }
}

async function handleReset() {
    await fetchCategory();
    state.value = SHOWING;
}

function toggleEdit() {
  state.value = EDITING
}

onMounted(fetchCategory)

const handleCategorySaved = (updatedCategory) => {
    category.value = updatedCategory;
    state.value = SHOWING;
};
</script>

<template>
    <div class="w-full flex flex-col gap-8">
        <a-card class="p-8">
            <div class="flex items-center justify-between gap-4">
                <h2>{{ category.name }}</h2>

                <Button
                    v-if="isShowing"
                    icon="pi pi-pencil"
                    label="Edit"
                    @click="toggleEdit"
                />
            </div>

            <div v-if="isShowing" class="w-full grid grid-cols-[100px_1fr] gap-4 mt-8">
                <a-input-field title="ID"></a-input-field>
                <span>{{ category.id }}</span>

                <a-input-field title="Status"></a-input-field>
                <a-status-tag v-if="category.status === 0" severity="danger" label="Inactive"></a-status-tag>
                <a-status-tag v-if="category.status === 1" severity="success" label="Active"></a-status-tag>

                <a-input-field title="Name"></a-input-field>
                <span>{{ category.name }}</span>

                <a-input-field title="Slug"></a-input-field>
                <span>{{ category.slug }}</span>

                <a-input-field title="Examples"></a-input-field>
                <span>{{ category.examples_count }}</span>

                <a-input-field title="Created at"></a-input-field>
                <span>{{ category.created_at_nice }} ({{ category.created_at_diff }})</span>

                <a-input-field title="Updated at"></a-input-field>
                <span>{{ category.updated_at_nice }} ({{ category.updated_at_diff }})</span>
            </div>

            <edit-category
                v-if="isEditing"
                mode="edit"
                :initial-category="category"
                @reset="handleReset"
                @save="handleCategorySaved"
            />
        </a-card>

        <a-card class="p-8">
            <h2>Examples</h2>

            <div v-if="category.examples.length" class="w-full grid grid-cols-2 gap-4 mt-8">
                <router-link
                    v-for="example in category.examples"
                    :key="example.slug"
                    :to="{ name: 'admin.examples.show', params: { example: example.slug } }"
                >
                    <a-tilt>
                        <div
                            class="relative w-full bg-cover aspect-video"
                            :style="{ backgroundImage: `url('/storage/examples/${example.slug}/${example.images[0].filename}')` }"
                        >
                            <div class="w-full bg-gray-100 text-grey-900 p-2">
                                <span>{{ example.name }}</span>
                            </div>

                            <div class="absolute bottom-0 right-0 p-2">
                                <a-status-tag v-if="example.status === 1" severity="success" :label="example.status_nice" />
                                <a-status-tag v-else severity="danger" :label="example.status_nice" />
                            </div>
                        </div>
                    </a-tilt>
                </router-link>
            </div>

            <a-area-empty v-else class="mt-8">
                No examples yet
            </a-area-empty>
        </a-card>
    </div>
</template>
