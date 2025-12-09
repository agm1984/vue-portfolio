<script setup>
import { ref, computed } from 'vue';
import { useConfirm } from 'primevue/useconfirm';
import Button from 'primevue/button';
import Textarea from 'primevue/textarea';

const props = defineProps({
    user: {
        type: Object,
        required: false,
        default: () => ({ id: null }),
    },

    comment: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits([
    'comment-updated',
    'comment-deleted',
    'comment-voted',
    'comment-unvoted',
]);

const confirm = useConfirm();

const isEditing = ref(false);
const body = ref(props.comment.body);
const isEditable = computed(() => props.user && props.user.id === props.comment.author.id);
const userVote = computed(() => props.comment.user_vote);

const formatDate = (dateString) => {
    if (!dateString) return '';
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const startEditing = () => {
    body.value = props.comment.body;

    isEditing.value = true;
};

const cancelEdit = () => {
    isEditing.value = false;

    body.value = props.comment.body;
};

const save = () => {
    isEditing.value = false;

    emit('comment-updated', {
        id: props.comment.id,
        body: body.value,
    });
};

const onDeleteComment = () => {
    console.log('test');
    confirm.require({
        message: 'Are you sure you want to delete this comment?',
        header: 'Delete Comment',
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Delete'
        },
        accept: () => {
            emit('comment-deleted', { id: props.comment.id });
        },
        reject: () => {}
    });
};

const toggleUpvote = () => {
    if (userVote.value === 1) {
        emit('comment-unvoted', { commentId: props.comment.id });
    } else {
        emit('comment-voted', { commentId: props.comment.id, value: 1 });
    }
};

const toggleDownvote = () => {
    if (userVote.value === -1) {
        emit('comment-unvoted', { commentId: props.comment.id });
    } else {
        emit('comment-voted', { commentId: props.comment.id, value: -1 });
    }
};
</script>

<template>
    <a-card class="flex gap-4 p-8">
        <div class="shrink-0">
            <a-avatar
                :user="comment.author"
                :size="48"
            ></a-avatar>
        </div>

        <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between mb-2">
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm md:text-base">
                        {{ comment.author.name }}
                    </h4>
                    <span class="text-xs text-gray-600 dark:text-gray-400" :title="comment.created_at">
                        {{ formatDate(comment.created_at) }}
                    </span>
                </div>

                <div v-if="isEditable && !isEditing">
                    <Button
                        icon="pi pi-pencil"
                        text
                        rounded
                        severity="secondary"
                        size="small"
                        aria-label="Edit Comment"
                        @click="startEditing"
                        class="!p-1 w-8 h-8"
                    />
                </div>
            </div>

            <div v-if="!isEditing">
                <div class="text-gray-700 dark:text-gray-300 text-sm md:text-base leading-relaxed whitespace-pre-wrap break-words">
                    {{ comment.body }}
                </div>

                <div class="flex items-center gap-4 mt-4 pt-3 border-t border-gray-300 dark:border-gray-700">
                    <div class="flex items-center bg-gray-100 dark:bg-gray-700/50 rounded-lg p-1">
                        <Button
                            type="button"
                            icon="pi pi-thumbs-up"
                            :class="[
                                'transition-colors',
                                userVote === 1 
                                    ? 'text-green-600! dark:text-green-400!' 
                                    : 'text-gray-500! dark:text-gray-400! hover:text-gray-600! dark:hover:text-gray-200!'
                            ]"
                            text
                            rounded
                            size="small"
                            @click="toggleUpvote"
                        />

                        <span
                            :class="['text-xs font-semibold px-2 min-w-6 text-center', {
                                'text-green-600 dark:text-green-400': (comment.score > 0),
                                'text-red-500 dark:text-red-400': (comment.score < 0),
                                'text-gray-600 dark:text-gray-400': (comment.score === 0),
                            }]"
                        >{{ comment.score ?? 0 }}</span>

                        <Button
                            type="button"
                            :class="[
                                'transition-colors',
                                userVote === -1 
                                    ? 'text-red-500! dark:text-red-400!' 
                                    : 'text-gray-500! dark:text-gray-400! hover:text-gray-600! dark:hover:text-gray-200!'
                            ]"
                            icon="pi pi-thumbs-down"
                            size="small"
                            text
                            rounded
                            @click="toggleDownvote"
                        />
                    </div>
                </div>
            </div>

            <div v-else class="animate-fade-in">
                <Textarea
                    v-model="body"
                    class="w-full"
                    rows="4"
                    autoResize
                />

                <div class="flex items-center justify-between gap-4 mt-2">
                    <Button
                        type="button"
                        severity="danger"
                        icon="pi pi-trash"
                        label="Delete"
                        size="small"
                        text
                        @click="onDeleteComment"
                    />

                    <div class="flex gap-2">
                        <Button
                            type="button"
                            severity="secondary"
                            label="Cancel"
                            size="small"
                            text
                            @click="cancelEdit"
                        />

                        <Button
                            type="button"
                            icon="pi pi-check"
                            label="Update"
                            size="small"
                            @click="save"
                        />
                    </div>
                </div>
            </div>
        </div>
    </a-card>
</template>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.2s ease-in-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
