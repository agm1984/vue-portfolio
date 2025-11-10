<script setup>
import { ref, watch } from 'vue';
import FileUpload from 'primevue/fileupload';
import Button from 'primevue/button';
import Message from 'primevue/message';
import Badge from 'primevue/badge';

const props = defineProps({
    exampleSlug: {
        type: String,
        required: true,
    },

    existingImages: {
        type: Array,
        required: false,
        default: () => [],
    },

    modelValue: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits([
    'update:model-value',
    'remove-existing-image',
]);

const files = ref([]);
const src = ref([]);

watch(props.modelValue, (newVal) => {
    files.value = newVal || [];
    src.value = [];
}, { immediate: true });

const readAsDataURL = (file) => {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = (e) => resolve(e.target?.result);
        reader.onerror = reject;
        reader.readAsDataURL(file);
    });
};

const onSelectedFiles = async (event) => {
  const list = event?.files ?? [];
  const fileArr = Array.from(list);

  files.value = fileArr;
  emit('update:model-value', files.value);

  if (fileArr.length === 0) {
    src.value = [];
    return;
  }

  src.value = await Promise.all(fileArr.map(readAsDataURL));
}

const handleRemoveExistingImage = async (imageId) => {
    try {
        console.log('imageId', imageId);
        emit('remove-existing-image', imageId);
    } catch (err) {
        console.error(`a-multi-image-input# Problem removing existing image: ${err}.`);
    }
};

const handleRemoveNewImage = (index) => {
    files.value.splice(index, 1);
    src.value.splice(index, 1);
    emit('update:model-value', files.value);
};
</script>

<template>
    <div class="w-full grid grid-cols-2 gap-4 mb-4">
        <div v-for="image in existingImages" :key="image.name">
            <img :src="`/storage/examples/${exampleSlug}/${image.filename}`" />
            <Button
                type="button"
                severity="danger"
                icon="pi pi-times"
                @click="handleRemoveExistingImage(image.id)"
            />

        </div>

        <div v-for="(item, index) in src" :key="index">
            <img :src="item" />
            <Button
                type="button"
                severity="danger"
                icon="pi pi-times"
                @click="handleRemoveNewImage(index)"
            />
        </div>

        <FileUpload
            mode="basic"
            multiple
            custom-upload
            accept="image/*"
            :max-file-size="10000000"
            @select="onSelectedFiles"
        />
    </div>
</template>
