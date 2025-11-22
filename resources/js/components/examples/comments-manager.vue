<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { required, minLength } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import { useRoute } from 'vue-router';
import axios from 'axios';
import { useToast } from 'primevue/usetoast';
import Skeleton from 'primevue/skeleton';
import { useAuthStore } from '~/store/auth';

const currentRoute = useRoute();
const toast = useToast();
const auth = useAuthStore();

const LOADING = 'is-loading';
const LOADED = 'is-loaded';
const state = ref(LOADING);
const isLoading = computed(() => state.value === LOADING);
const isLoaded = computed(() => state.value === LOADED);
const comments = ref([]);

const commentCount = computed(() => comments.value.length);

// todo: extract this to utils
const pluralize = (count, noun) => (count === 1 ? noun : `${noun}s`);

const fetchComments = async () => {
    try {
        state.value = LOADING;

        const { data } = await axios.get(route('public.examples.listComments', currentRoute.params.example));

        comments.value = data.comments;

        state.value = LOADED;
    } catch (err) {
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Failed to load comments.',
            life: 5000,
        });
    }
};

onMounted(fetchComments);

const handleCommentAdded = (newComment) => {
    comments.value = [newComment, ...comments.value];
};

const updateComment = async (payload) => {
    try {
        await axios.put(route('user.comments.edit', payload.id), {
            body: payload.body,
        });

        comments.value = comments.value.map(c =>
            c.id === payload.id ? { ...c, body: payload.body, updated_at: new Date() } : c
        );

        toast.add({
            severity: 'info',
            summary: 'Updated',
            detail: 'Comment updated successfully.',
            life: 3000,
        });
    } catch (err) {
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Failed to update comment.',
            life: 3000,
        });
    }
};

const deleteComment = async (payload) => {
    try {
        await axios.delete(route('user.comments.delete', payload.id));

        comments.value = comments.value.filter(c => c.id !== payload.id);

        toast.add({
            severity: 'success',
            summary: 'Deleted',
            detail: 'Comment removed.',
            life: 3000,
        });
    } catch (err) {
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Failed to delete comment.',
            life: 3000,
        });
    }
};

const updateVoteState = (list, commentId, newData, userVote) => {
    return list.map(c => c.id === commentId ? {
        ...c,
        score: newData.score,
        upvotes: newData.upvotes,
        downvotes: newData.downvotes,
        user_vote: userVote
    } : c);
};

const voteOnComment = async ({ commentId, value }) => {
    try {
        const { data } = await axios.post(route('user.comments.vote.store', commentId), { value });

        comments.value = updateVoteState(comments.value, commentId, data, value);
    } catch (err) {
        console.error(err);
    }
};

const removeVoteFromComment = async ({ commentId }) => {
    try {
        const { data } = await axios.delete(route('user.comments.vote.destroy', commentId));

        comments.value = updateVoteState(comments.value, commentId, data, null);
    } catch (err) {
        console.error(err);
    }
};
</script>

<template>
    <div id="comments" class="flex flex-col">
        <comment-form
            @comment-added="handleCommentAdded"
        ></comment-form>

        <div class="flex items-center justify-between mt-8">
            <h3>{{ commentCount }} {{ pluralize(commentCount, 'Comment') }}</h3>
            <div></div>
        </div>

        <div class="mt-4">
            <div v-if="isLoading" class="space-y-4">
                <div v-for="n in 3" :key="n" class="flex gap-4">
                    <Skeleton shape="circle" size="3rem" class="mr-2"></Skeleton>
                    <div style="flex: 1">
                        <Skeleton width="30%" class="mb-2"></Skeleton>
                        <Skeleton width="100%" height="4rem"></Skeleton>
                    </div>
                </div>
            </div>

            <TransitionGroup v-else name="list" tag="div" class="flex flex-col gap-4">
                <comment-item
                    v-for="comment in comments"
                    :key="`example-comment-${comment.id}`"
                    :user="auth.user"
                    :comment="comment"
                    @comment-updated="updateComment"
                    @comment-deleted="deleteComment"
                    @comment-voted="voteOnComment"
                    @comment-unvoted="removeVoteFromComment"
                ></comment-item>
            </TransitionGroup>

            <a-card v-if="!isLoading && commentCount === 0" class="flex flex-col items-center p-8">
                <div class="w-16 h-16 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center mb-4">
                    <i class="pi pi-search" style="font-size: 24px;"></i>
                </div>

                <p class="text-gray-600 mt-2">No comments yet. Be the first to share your thoughts!</p>
            </a-card>
        </div>
    </div>
</template>

<style scoped>
.list-move,
.list-enter-active,
.list-leave-active {
    transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateX(30px);
}

.list-leave-active {
    position: absolute;
    width: 100%; /* prevent layout collapse during exit */
}
</style>
