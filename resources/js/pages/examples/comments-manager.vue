<template>
    <div>
        <div>
            <div class="mb-16">
                <template v-if="isLoggedIn">
                    <a-form ref="new-comment-form" v-slot="{ handleSubmit }">
                        <a-text-input
                            v-model="newComment.body"
                            vid="newComment"
                            rules="required"
                            type="textarea"
                            placeholder="Add a comment"
                            class="border"
                        ></a-text-input>

                        <div class="flex items-center justify-end mt-8">
                            <a-button type="is-primary" @click="handleSubmit(saveComment)">
                                Save
                            </a-button>
                        </div>
                    </a-form>
                </template>
                <template v-else>
                    <a :href="route('register')">Register</a> or <a :href="route('login')">Login</a>
                    to post a comment.
                </template>
            </div>

            <a-heading level="3" class="" nunito>{{ commentCount }} {{ commentCountPluralization }}</a-heading>

            <comment-item
                v-for="comment in comments"
                :key="`comment-${comment.id}`"
                :user="user"
                :comment="comment"
                @comment-updated="updateComment($event)"
                @comment-deleted="deleteComment($event)"
            ></comment-item>

            <div v-if="commentCount === 0" class="py-16 pl-16 mt-32 border-l-1 border-primary">
                Be the first one to leave feedback about this example.
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import CommentItem from './comment-item.vue';

export default {
    name: 'comments-manager',

    components: {
        CommentItem,
    },

    props: {},

    data() {
        return {
            newComment: {
                body: '',
            },
            comments: [],
        };
    },

    computed: {
        isLoggedIn() {
            return this.$store.getters['auth/check'];
        },

        user() {
            return this.$store.getters['auth/user'];
        },

        commentCount() {
            return this.comments.length;
        },

        commentCountPluralization() {
            if (this.commentCount === 1) return 'comment';
            return 'comments';
        },
    },

    mounted() {
        return this.fetchComments();
    },

    methods: {
        async fetchComments() {
            try {
                const { data } = await axios.get(route('public.examples.listComments', this.$route.params.example));

                this.comments = data.comments;
                return undefined; // resolve promise and do nothing
            } catch (err) {
                throw new Error(`comments-manager# Problem fetching list of comments: ${err}.`);
            }
        },

        async updateComment($event) {
            try {
                await axios.put(route('user.comments.edit', $event.id), {
                    body: $event.body,
                });

                return this.fetchComments();
            } catch (err) {
                throw new Error(`comments-manager# Problem updating comment: ${err}.`);
            }
        },

        async deleteComment($event) {
            try {
                await axios.delete(route('user.comments.delete', $event.id), {
                    body: $event.body,
                });

                return this.fetchComments();
            } catch (err) {
                throw new Error(`comments-manager# Problem deleting comment: ${err}.`);
            }
        },

        resetForm() {
            this.newComment.body = '';
        },

        async saveComment() {
            try {
                const newComment = {
                    body: this.newComment.body,
                };

                await axios.post(route('user.comments.create', this.$route.params.example), newComment);

                this.newComment.body = '';
                this.$refs['new-comment-form'].$refs.observer.reset();

                const { data } = await axios.get(route('public.examples.listComments', this.$route.params.example));
                this.comments = data.comments;

                return undefined; // resolve promise and do nothing
            } catch (err) {
                throw new Error(`comments-manager# Problem saving new comment: ${err}.`);
            }
        },
    },

};
</script>
