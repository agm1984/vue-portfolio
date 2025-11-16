<script setup>
import { ref, computed } from 'vue';
import Button from 'primevue/button';
import Textarea from 'primevue/textarea';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },

    comment: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits([
    'comment-updated',
    'comment-deleted',
]);

const state = ref(SHOW);
const body = ref(props.comment.body);

const SHOW = 'is-showing';
const EDIT = 'is-editing';

const isEditable = computed(() => (props.user.id === props.comment.author.id));
const isShowing = computed(() => (state.value === SHOW));
const isEditing = computed(() => (state.value === EDIT));

const startEditing = () => {
    state.value = EDIT;
};

const reset = () => {
    state.value = SHOW;
    body.value = props.comment.body;
};

const save = () => {
    state.value = SHOW;
    emit('comment-updated', {
        id: props.comment.id,
        body: body.value,
    });
};

const deleteComment = () => {
    emit('comment-deleted', {
        id: props.comment.id,
    });
};
</script>

<template>
    <div class="mt-4">
        <div v-show="isShowing">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <a-avatar :size="32" :user="comment.author"></a-avatar>
                    <div class="flex flex-col">
                        <span>{{ comment.author.name }}</span>
                        <span class="text-sm text-gray-600">Posted: {{ comment.created_at }}</span>
                    </div>
                </div>

                <Button
                    v-if="isEditable"
                    severity="secondary"
                    icon="pi pi-pencil"
                    label="Edit"
                    @click="startEditing"
                />
            </div>
            <div class="p-4 mt-2 bg-white border rounded-md">
                <p>{{ comment.body }}</p>
            </div>
        </div>

        <div v-if="isEditing">
            <h4>Update comment</h4>

            <Textarea
                v-model="body"
                class="w-full"
                type="textarea"
                placeholder=""
                rows="6"
            />
            <div class="flex items-center justify-between mt-2">
                <Button
                    type="button"
                    severity="danger"
                    icon="pi pi-trash"
                    label="Delete"
                    @click="deleteComment"
                />

                <div class="flex items-center gap-2">
                    <Button
                        type="button"
                        severity="secondary"
                        label="Cancel"
                        @click="reset"
                    />
                    <Button
                        type="button"
                        icon="pi pi-check"
                        label="Update"
                        @click="save"
                    />
                </div>
            </div>
        </div>

    </div>
</template>
