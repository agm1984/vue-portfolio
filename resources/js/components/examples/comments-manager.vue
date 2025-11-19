<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { required, minLength } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import { useRoute } from 'vue-router';
import axios from 'axios';

// PrimeVue & UI Imports
import Textarea from 'primevue/textarea';
import Button from 'primevue/button';
import Avatar from 'primevue/avatar';
import Skeleton from 'primevue/skeleton';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

// Store
import { useAuthStore } from '~/store/auth';

const currentRoute = useRoute();
const auth = useAuthStore();
const toast = useToast();

// --- STATE ---
const state = ref('loading'); // loading, idle, submitting
const comments = ref([]);

const form = reactive({
    body: '',
});

// --- VALIDATION ---
const commentRules = {
    body: { required, minLength: minLength(3) },
};
const v$ = useVuelidate(commentRules, form);

// --- COMPUTED ---
const isSubmitting = computed(() => state.value === 'submitting');
const isLoading = computed(() => state.value === 'loading');
const commentCount = computed(() => comments.value.length);

// --- PURE UTILITIES ---
const pluralize = (count, noun) => (count === 1 ? noun : `${noun}s`);

// --- ACTIONS ---

const fetchComments = async () => {
    try {
        state.value = 'loading';
        const { data } = await axios.get(route('public.examples.listComments', currentRoute.params.example));
        comments.value = data.comments;
    } catch (err) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to load comments.', life: 3000 });
    } finally {
        state.value = 'idle';
    }
};

onMounted(fetchComments);

const saveComment = async () => {
    const isFormValid = await v$.value.$validate();
    if (!isFormValid) return;

    state.value = 'submitting';

    try {
        const payload = { body: form.body };
        // Assume backend returns the fully created comment object including ID and User
        const { data } = await axios.post(route('user.comments.create', currentRoute.params.example), payload);

        // IMMUTABLE UPDATE: Prepend new comment to list (New Array)
        // No need to re-fetch the whole list!
        comments.value = [data.comment, ...comments.value];

        // Reset form
        form.body = '';
        v$.value.$reset();
        toast.add({ severity: 'success', summary: 'Posted', detail: 'Thanks for your feedback!', life: 3000 });

    } catch (err) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Could not save comment.', life: 3000 });
    } finally {
        state.value = 'idle';
    }
};

const updateComment = async (payload) => {
    try {
        // Optimistic UI Update or wait for server? Let's wait for server to be safe on content edits.
        const { data } = await axios.put(route('user.comments.edit', payload.id), {
            body: payload.body,
        });

        // IMMUTABLE UPDATE: Replace the specific item in the array
        comments.value = comments.value.map(c => 
            c.id === payload.id ? { ...c, body: payload.body, updated_at: new Date() } : c
        );

        toast.add({ severity: 'info', summary: 'Updated', detail: 'Comment updated successfully.', life: 3000 });
    } catch (err) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to update comment.', life: 3000 });
    }
};

const deleteComment = async (payload) => {
    if (!confirm('Are you sure you want to delete this?')) return;

    try {
        await axios.delete(route('user.comments.delete', payload.id));

        // IMMUTABLE UPDATE: Filter out the deleted item
        comments.value = comments.value.filter(c => c.id !== payload.id);
        
        toast.add({ severity: 'success', summary: 'Deleted', detail: 'Comment removed.', life: 3000 });
    } catch (err) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to delete comment.', life: 3000 });
    }
};

// Reusable Pure Function for Voting Logic
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
        // Immutable State Update
        comments.value = updateVoteState(comments.value, commentId, data, value);
    } catch (err) {
        console.error(err);
    }
};

const removeVoteFromComment = async ({ commentId }) => {
    try {
        const { data } = await axios.delete(route('user.comments.vote.destroy', commentId));
        // Immutable State Update
        comments.value = updateVoteState(comments.value, commentId, data, null);
    } catch (err) {
        console.error(err);
    }
};
</script>

<template>
    <div id="comments" class="space-y-8">
        <Toast />

        <div v-if="auth.isAuthenticated" class="bg-gray-50 dark:bg-gray-800/50 p-6 rounded-xl border border-gray-100 dark:border-gray-700">
            <div class="flex gap-4">
                <div class="hidden md:block">
                    <Avatar 
                        :label="auth.user.name[0]" 
                        shape="circle" 
                        size="large" 
                        class="bg-indigo-100 text-indigo-600 font-bold"
                    />
                </div>
                
                <form @submit.prevent="saveComment" class="flex-1 relative">
                    <Textarea
                        v-model="v$.body.$model"
                        class="w-full focus:ring-0"
                        :class="{ 'p-invalid': v$.body.$error }"
                        placeholder="What are your thoughts on this project?"
                        rows="3"
                        autoResize
                    />
                    
                    <div class="flex items-center justify-between mt-3">
                        <span class="text-xs text-gray-400">Markdown supported</span>
                        <Button
                            type="submit"
                            :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-send'"
                            label="Post Comment"
                            :disabled="isSubmitting"
                            size="small"
                        />
                    </div>
                </form>
            </div>
        </div>

        <div v-else class="bg-indigo-50 dark:bg-indigo-900/20 p-6 rounded-xl border border-indigo-100 dark:border-indigo-800 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <i class="pi pi-lock text-indigo-500 text-xl"></i>
                <span class="text-gray-700 dark:text-gray-300 font-medium">Join the discussion to leave feedback.</span>
            </div>
            <div class="flex gap-2">
                <Button label="Login" link @click="$router.push({ name: 'login' })" />
                <Button label="Register" severity="secondary" @click="$router.push({ name: 'register' })" />
            </div>
        </div>

        <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-4">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                {{ commentCount }} {{ pluralize(commentCount, 'Comment') }}
            </h3>
            </div>

        <div class="space-y-6">
            <div v-if="isLoading" class="space-y-4">
                <div v-for="n in 3" :key="n" class="flex gap-4">
                    <Skeleton shape="circle" size="3rem" class="mr-2"></Skeleton>
                    <div style="flex: 1">
                        <Skeleton width="30%" class="mb-2"></Skeleton>
                        <Skeleton width="100%" height="4rem"></Skeleton>
                    </div>
                </div>
            </div>

            <TransitionGroup name="list" tag="div" class="flex flex-col gap-6" v-else>
                <comment-item
                    v-for="comment in comments"
                    :key="comment.id"
                    :user="auth.user"
                    :comment="comment"
                    @comment-updated="updateComment"
                    @comment-deleted="deleteComment"
                    @comment-voted="voteOnComment"
                    @comment-unvoted="removeVoteFromComment"
                ></comment-item>
            </TransitionGroup>

            <div v-if="!isLoading && commentCount === 0" class="text-center py-12 opacity-60">
                <i class="pi pi-comments text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500">No comments yet. Be the first to share your thoughts!</p>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* List Animations for Add/Remove */
.list-move, /* smooth reordering */
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
