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
    <div>
        <div
            v-if="imagePreview"
            class="flex items-center justify-center"
        >
            <img
                class="w-32 h-32 bg-cover rounded-full"
                :src="imagePreview"
                alt="User avatar"
            >
        </div>

        <div v-else class="flex items-center justify-center">
            <div class="flex items-center justify-center rounded-full bg-grey-400 min-w-32 min-h-32 border">
                <span class="text-3xl font-aroly">
                    {{ firstLetterOfName }}
                </span>
            </div>
        </div>

        <FileUpload
            class="p-button-secondary mt-4"
            mode="basic"
            @select="onFileSelect"
            customUpload
            auto
        />
    </div>
</template>
