<script setup>
import { ref } from 'vue';
import FileUpload from 'primevue/fileupload';
import Button from 'primevue/button';
import Message from 'primevue/message';
import Badge from 'primevue/badge';

defineProps({
    modelValue: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(['update:model-value']);

const files = ref([]);
const src = ref([]); // can be Array or Object

const readAsDataURL = (file) => {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = (e) => resolve(e.target?.result);
        reader.onerror = reject;
        reader.readAsDataURL(file);
    });
};

const onSelectedFiles = async (event) => {
  // Works with <input type="file"> (event.target.files) and libs like PrimeVue (event.files)
  const list = event?.files ?? []
  const fileArr = Array.from(list)

  files.value = fileArr
  emit('update:model-value', files.value);

  if (fileArr.length === 0) {
    src.value = [] // or {}
    return
  }

  // --- OPTION A: src.value as an ARRAY of data URLs (in the same order) ---
  src.value = await Promise.all(fileArr.map(readAsDataURL))

  // --- OPTION B: src.value as an OBJECT keyed by filename ---
  // const entries = await Promise.all(
  //   fileArr.map(async (f) => [f.name, await readAsDataURL(f)])
  // )
  // src.value = Object.fromEntries(entries)
}

const handleRemoveImage = (index) => {
    files.value.splice(index, 1);
    src.value.splice(index, 1);
    emit('update:model-value', files.value);
};

</script>

<template>
    <div class="w-full grid grid-cols-2 gap-4 mb-4">
        <div v-for="(item, index) in src" :key="index">
            <img :src="item" />
            <Button
                icon="pi pi-times"
                @click="handleRemoveImage(index)"
                severity="danger"
            />
        </div>

        <FileUpload
            mode="basic"
            multiple
            custom-upload
            accept="image/*"
            :max-file-size="10000000"
            @select="onSelectedFiles"
        >
            <template #content="{ files, uploadedFiles, removeUploadedFileCallback, removeFileCallback, messages }">
                <div class="flex flex-col gap-8 pt-4">
                    <Message v-for="message of messages" :key="message" :class="{ 'mb-8': !files.length && !uploadedFiles.length}" severity="error">
                        {{ message }}
                    </Message>

                    <div v-if="files.length > 0">
                        <h5>Pending</h5>
                        <div class="flex flex-wrap gap-4">
                            <div v-for="(file, index) of files" :key="file.name + file.type + file.size" class="p-8 rounded-border flex flex-col border border-surface items-center gap-4">
                                <div>
                                    <img role="presentation" :alt="file.name" :src="file.objectURL" width="100" height="50" />
                                </div>
                                <span class="font-semibold text-ellipsis max-w-60 whitespace-nowrap overflow-hidden">{{ file.name }}</span>
                                <div>{{ formatSize(file.size) }}</div>
                                <Badge value="Pending" severity="warn" />
                                <Button icon="pi pi-times" @click="onRemoveTemplatingFile(file, removeFileCallback, index)" variant="outlined" rounded severity="danger" />
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template #empty>
                <div class="flex items-center justify-center flex-col">
                    <i class="pi pi-cloud-upload border p-4" />
                    <p class="mt-6 mb-0">Drag and drop files to here to upload.</p>
                </div>
            </template>
        </FileUpload>
    </div>
</template>
