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

const form = reactive({
    body: '',
});

const commentRules = {
    body: { required },
};

const v$ = useVuelidate(commentRules, form);

const newCommentForm = ref(null);

const newComment = ref({
    body: '',
});

const comments = ref([]);

const commentCount = computed(() => comments.value.length);
const commentCountPluralization = computed(() => {
    return commentCount.value === 1 ? 'comment' : 'comments';
});

const fetchComments = async () => {
    try {
        const { data } = await axios.get(
            route('public.examples.listComments', currentRoute.params.example)
        );

        comments.value = data.comments;
    } catch (err) {
        throw new Error(`comments-manager# Problem fetching list of comments: ${err}.`);
    }
};

const updateComment = async ($event) => {
    try {
        await axios.put(route('user.comments.edit', $event.id), {
            body: $event.body,
        });

        await fetchComments();
    } catch (err) {
        throw new Error(`comments-manager# Problem updating comment: ${err}.`);
    }
};

const deleteComment = async ($event) => {
    try {
        await axios.delete(route('user.comments.delete', $event.id), {
            body: $event.body,
        });

        await fetchComments();
    } catch (err) {
        throw new Error(`comments-manager# Problem deleting comment: ${err}.`);
    }
};

const resetForm = () => {
    newComment.value.body = '';
};

const saveComment = async () => {
    try {
        state.value = SUBMITTING;
        submitted.value = true;

        const isFormValid = await v$.value.$validate();

        if (!isFormValid) {
            console.log('Form is invalid');
            state.value = INITIAL;
            return;
        }

        const payload = {
            body: newComment.value.body,
        };

        await axios.post(
            route('user.comments.create', currentRoute.params.example),
            payload
        );

        newComment.value.body = '';

        // Preserve existing behavior that uses the internal observer
        if (newCommentForm.value?.$refs?.observer) {
            newCommentForm.value.$refs.observer.reset();
        }

        const { data } = await axios.get(
            route('public.examples.listComments', currentRoute.params.example)
        );
        comments.value = data.comments;

        return undefined; // resolve promise and do nothing
    } catch (err) {
        throw new Error(`comments-manager# Problem saving new comment: ${err}.`);
    }
};

onMounted(fetchComments);
</script>

<template>
    <div>
        <div class="">
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
                        icon="pi pi-check"
                        label="Save"
                        :disabled="isSubmitting"
                    />
                </div>
            </form>

            <div v-else class="">
                <router-link :to="{ name: 'register' }">Register</router-link> or
                <router-link :to="{ name: 'login' }">Login</router-link>
                to post a comment.
            </div>
        </div>

        <h3 class="mt-4">{{ commentCount }} {{ commentCountPluralization }}</h3>

        <comment-item
            v-for="comment in comments"
            :key="`comment-${comment.id}`"
            :user="auth.user"
            :comment="comment"
            @comment-updated="updateComment($event)"
            @comment-deleted="deleteComment($event)"
        ></comment-item>

        <a-area-empty v-if="commentCount === 0" class="mt-4">
            <span>Be the first one to leave feedback about this example.</span>
        </a-area-empty>
    </div>
</template>
