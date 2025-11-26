<script setup>
import { ref, computed } from 'vue';
import FileUpload from 'primevue/fileupload';

const props = defineProps({
    modelValue: {
        type: [File, String],
        required: false,
        default: () => '',
    },

    user: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['update:model-value']);

const imagePreview = ref(props.user.avatar_url || '');
const firstLetterOfName = computed(() => props.user.name.charAt(0));

function onFileSelect(event) {
    const file = event.files[0];
    emit('update:model-value', file);

    const reader = new FileReader();

    reader.onload = async (e) => {
        imagePreview.value = e.target.result;
    };

    reader.readAsDataURL(file);
}
</script>

<template>
    <div class="flex flex-col items-center gap-4">
        <div
            v-if="imagePreview"
            class="flex items-center justify-center"
        >
            <img
                class="w-32 h-32 bg-cover rounded-full border-4 border-white dark:border-gray-700 shadow-md"
                :src="imagePreview"
                alt="User avatar"
            >
        </div>

        <div v-else class="flex items-center justify-center">
            <div class="flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 min-w-32 min-h-32 border border-gray-300 dark:border-gray-600">
                <span class="text-4xl font-bold text-gray-500 dark:text-gray-300">
                    {{ firstLetterOfName }}
                </span>
            </div>
        </div>

        <div class="relative overflow-hidden">
            <FileUpload
                mode="basic"
                name="avatar"
                accept="image/*"
                :maxFileSize="1000000"
                @select="onFileSelect"
                customUpload
                auto
                chooseLabel="Change Image"
                class="p-button-secondary p-button-outlined"
            />
        </div>
    </div>
</template>
