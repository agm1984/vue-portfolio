<script setup>
import { ref, computed, nextTick } from 'vue';
import Button from 'primevue/button';
import Textarea from 'primevue/textarea';
import Avatar from 'primevue/avatar'; // Using PrimeVue Avatar for consistency

const props = defineProps({
    user: {
        type: Object,
        required: false, // Made optional so guests don't break it
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

// --- STATE ---
const isEditing = ref(false);
const body = ref(props.comment.body);

// --- COMPUTED ---
const isEditable = computed(() => props.user && props.user.id === props.comment.author.id);
const userVote = computed(() => props.comment.user_vote); // 1, -1, or null

// --- PURE HELPERS ---
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

const getInitials = (name) => name ? name.substring(0, 1).toUpperCase() : 'U';

// --- ACTIONS ---
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

const deleteComment = () => {
    if(confirm("Delete this comment?")) {
        emit('comment-deleted', { id: props.comment.id });
    }
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
    <div class="flex gap-4 p-6 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl shadow-sm transition-all hover:shadow-md">
        
        <div class="shrink-0">
            <Avatar 
                :label="getInitials(comment.author.name)" 
                class="bg-indigo-100 text-indigo-600 dark:bg-indigo-900/50 dark:text-indigo-300 font-bold"
                size="large"
                shape="circle"
            />
        </div>

        <div class="flex-1 min-w-0">
            
            <div class="flex items-start justify-between mb-2">
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white text-sm md:text-base">
                        {{ comment.author.name }}
                    </h4>
                    <span class="text-xs text-gray-500 dark:text-gray-400" :title="comment.created_at">
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

                <div class="flex items-center gap-4 mt-4 pt-3 border-t border-gray-50 dark:border-gray-700/50">
                    <div class="flex items-center bg-gray-50 dark:bg-gray-700/50 rounded-lg p-1">
                        <Button
                            icon="pi pi-thumbs-up"
                            :class="[
                                'transition-colors', 
                                userVote === 1 ? '!text-green-600' : '!text-gray-400 hover:!text-gray-600 dark:hover:!text-gray-200'
                            ]"
                            text
                            rounded
                            size="small"
                            @click="toggleUpvote"
                        />
                        
                        <span class="text-xs font-bold px-2 min-w-[1.5rem] text-center" 
                              :class="{'text-green-600': (comment.score > 0), 'text-red-500': (comment.score < 0), 'text-gray-500': (comment.score === 0)}">
                            {{ comment.score ?? 0 }}
                        </span>

                        <Button
                            icon="pi pi-thumbs-down"
                            :class="[
                                'transition-colors', 
                                userVote === -1 ? '!text-red-500' : '!text-gray-400 hover:!text-gray-600 dark:hover:!text-gray-200'
                            ]"
                            text
                            rounded
                            size="small"
                            @click="toggleDownvote"
                        />
                    </div>
                    
                    </div>
            </div>

            <div v-else class="animate-fade-in">
                <Textarea
                    v-model="body"
                    class="w-full mb-3"
                    rows="4"
                    autoResize
                />
                
                <div class="flex items-center justify-between">
                    <Button
                        label="Delete"
                        icon="pi pi-trash"
                        severity="danger"
                        text
                        size="small"
                        @click="deleteComment"
                    />

                    <div class="flex gap-2">
                        <Button
                            label="Cancel"
                            severity="secondary"
                            text
                            size="small"
                            @click="cancelEdit"
                        />
                        <Button
                            label="Update"
                            icon="pi pi-check"
                            size="small"
                            @click="save"
                        />
                    </div>
                </div>
            </div>

        </div>
    </div>
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
