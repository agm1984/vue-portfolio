<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { required, maxLength } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import { useRoute } from 'vue-router';
import axios from 'axios';
import Textarea from 'primevue/textarea';
import Button from 'primevue/button';
import { useAuthStore } from '~/store/auth';

const currentRoute = useRoute();
const auth = useAuthStore();

const INITIAL = 'is-initial';
const SUBMITTING = 'is-submitting';
const state = ref(INITIAL);
const isSubmitting = computed(() => state.value === SUBMITTING);
const submitted = ref(false);
const comments = ref([]);

const form = reactive({
    body: '',
});

const commentRules = {
    body: { required },
};

const v$ = useVuelidate(commentRules, form);

const commentCount = computed(() => comments.value.length);
const commentCountPluralization = computed(() => {
    return commentCount.value === 1 ? 'comment' : 'comments';
});

const fetchComments = async () => {
    try {
        const { data } = await axios.get(route('public.examples.listComments', currentRoute.params.example));

        comments.value = data.comments;
    } catch (err) {
        throw new Error(`comments-manager# Problem fetching list of comments: ${err}.`);
    }
};

onMounted(fetchComments);

const saveComment = async () => {
    try {
        state.value = SUBMITTING;
        submitted.value = true;

        const isFormValid = await v$.value.$validate();

        if (!isFormValid) {
            state.value = INITIAL;
            return;
        }

        const payload = {
            body: form.body,
        };

        await axios.post(route('user.comments.create', currentRoute.params.example), payload);

        form.body = '';

        const { data } = await axios.get(route('public.examples.listComments', currentRoute.params.example));

        comments.value = data.comments;
        state.value = INITIAL;
    } catch (err) {
        state.value = INITIAL;
        throw new Error(`comments-manager# Problem saving new comment: ${err}.`);
    }
};

const updateComment = async (payload) => {
    try {
        await axios.put(route('user.comments.edit', payload.id), {
            body: payload.body,
        });

        await fetchComments();
    } catch (err) {
        throw new Error(`comments-manager# Problem updating comment: ${err}.`);
    }
};

const deleteComment = async (payload) => {
    try {
        await axios.delete(route('user.comments.delete', payload.id));

        await fetchComments();
    } catch (err) {
        throw new Error(`comments-manager# Problem deleting comment: ${err}.`);
    }
};

const voteOnComment = async ({ commentId, value }) => {
    try {
        const { data } = await axios.post(route('user.comments.vote.store', commentId), { value });

        // update that comment in-place with the new score info
        const idx = comments.value.findIndex(c => c.id === commentId);
        if (idx !== -1) {
            comments.value[idx] = {
                ...comments.value[idx],
                score: data.score,
                upvotes: data.upvotes,
                downvotes: data.downvotes,
                user_vote: value,
            };
        }
    } catch (err) {
        console.error(`comments-manager# Problem voting on comment: ${err}.`);
    }
};

const removeVoteFromComment = async ({ commentId }) => {
    try {
        const { data } = await axios.delete(route('user.comments.vote.destroy', commentId));

        const idx = comments.value.findIndex(c => c.id === commentId);
        if (idx !== -1) {
            comments.value[idx] = {
                ...comments.value[idx],
                score: data.score,
                upvotes: data.upvotes,
                downvotes: data.downvotes,
                user_vote: null,
            };
        }
    } catch (err) {
        console.error(`comments-manager# Problem removing vote from comment: ${err}.`);
    }
};
</script>

<template>
    <div id="comments" class="mt-2">
        <form v-if="auth.isAuthenticated" @submit.prevent="saveComment">
            <Textarea
                v-model="v$.body.$model"
                class="w-full"
                placeholder="Add a comment"
                rows="6"
            />

            <div class="flex items-center justify-end mt-2">
                <Button
                    type="submit"
                    :icon="isSubmitting ? 'pi pi-spin pi-spinner' : 'pi pi-check'"
                    label="Save"
                    :disabled="isSubmitting"
                />
            </div>
        </form>

        <div v-else class="">
            <router-link class="font-semibold hover:underline" :to="{ name: 'register' }">Register</router-link> or
            <router-link class="font-semibold hover:underline" :to="{ name: 'login' }">Login</router-link>
            to post a comment.
        </div>

        <h3 class="mt-8">{{ commentCount }} {{ commentCountPluralization }}</h3>

        <comment-item
            v-for="comment in comments"
            :key="`comment-${comment.id}`"
            :user="auth.user"
            :comment="comment"
            @comment-updated="updateComment"
            @comment-deleted="deleteComment"
            @comment-voted="voteOnComment"
            @comment-unvoted="removeVoteFromComment"
        ></comment-item>

        <a-area-empty v-if="commentCount === 0" class="mt-4">
            <span>Be the first one to leave feedback about this example.</span>
        </a-area-empty>
    </div>
</template>
