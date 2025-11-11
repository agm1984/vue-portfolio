<script setup>
import { ref, watch } from 'vue';
import FileUpload from 'primevue/fileupload';
import Button from 'primevue/button';

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

const alreadyUploadedImages = ref(props.existingImages);
const files = ref([]);
const src = ref([]);

watch(props.modelValue, (newVal) => {
    alreadyUploadedImages.value = props.existingImages;
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

    src.value = await Promise.all(fileArr.map(readAsDataURL));
}

const handleRemoveExistingImage = async (imageId) => {
    try {
        alreadyUploadedImages.value = alreadyUploadedImages.value.filter(image => image.id !== imageId);

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
    <div class="w-full flex flex-col gap-4">
        <div class="w-full grid grid-cols-2 gap-4">
            <div
                v-for="image in alreadyUploadedImages"
                :key="`existing-image-${image.name}`"
            >
                <img
                    class="w-full aspect-video object-cover"
                    :src="`/storage/examples/${exampleSlug}/${image.filename}`"
                    :alt="image.filename"
                />
                <Button
                    type="button"
                    class="mt-2"
                    severity="danger"
                    icon="pi pi-trash"
                    label="Remove"
                    @click="handleRemoveExistingImage(image.id)"
                />
            </div>

            <div
                v-for="(item, index) in src"
                :key="`new-image-${index}`"
            >
                <img
                    class="w-full aspect-video object-cover"
                    :src="item"
                    :alt="`Selected image ${index + 1}`"
                />
                <Button
                    type="button"
                    class="mt-2"
                    severity="danger"
                    icon="pi pi-trash"
                    label="Remove"
                    @click="handleRemoveNewImage(index)"
                />
            </div>
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
