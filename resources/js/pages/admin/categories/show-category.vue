<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
import Button from 'primevue/button';
import EditCategory from './edit-category.vue'

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
  <div class="">
    <a-card class="p-32" with-geometry>
      <div class="relative flex items-center mb-16">
        <h2 level="2">
          {{ category.name }}
        </h2>

        <Button
            v-if="isShowing"
            class="ml-16"
            icon="pi pi-pencil"
            label="Edit"
            @click="toggleEdit"
        />
      </div>

      <div v-if="isShowing">
        <a-input-row type="is-wider-right" heading="ID">
          <span>{{ category.id }}</span>
        </a-input-row>

        <a-input-row class="pt-8" type="is-wider-right" heading="Status">
          <a-status-tag v-if="category.status === 1" status="Active"></a-status-tag>
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
          @save="handleCategorySaved"
        />
      </div>
    </a-card>

    <a-card class="p-8 mt-8">
      <h2 level="2" class="mb-16">
        Examples
      </h2>

      <div class="w-full grid grid-cols-2 gap-4">
        <router-link
          v-for="example in category.examples"
          :key="example.slug"
          :to="{ name: 'admin.examples.show', params: { example: example.slug } }"
        >
          <a-tilt>
            <a-card class="">
              <div
                class="relative bg-no-repeat bg-cover w-full aspect-video"
                :style="{ backgroundImage: `url('/storage/examples/${example.slug}/${example.images[0].filename}')` }"
              >
                <div class="px-16 py-8 bg-transparent-grey">
                  <span class="text-white font-nunito">
                    {{ example.name }}
                  </span>
                </div>

                <span v-if="example.status === 1" class="absolute bottom-0 right-0 m-8" type="is-success is-light" rounded>
                  {{ example.status_nice }}
                </span>
                <span v-else class="absolute bottom-0 right-0 m-8" type="is-warning is-light" rounded>
                  {{ example.status_nice }}
                </span>
              </div>
            </a-card>
          </a-tilt>
        </router-link>
      </div>
    </a-card>
  </div>
</template>
