<template>
    <div class="p-16 mt-8 bg-grey-200">
        <div v-show="isShowing">
            <div class="flex items-center">
                <a-avatar :size="32" :user="comment.author"></a-avatar>
                <div class="flex flex-col flex-1 ml-8">
                    <span class="flex-1 truncate">{{ comment.author.name }}</span>
                    <span class="text-sm">Posted: {{ comment.created_at }}</span>
                </div>
                <button
                    v-if="isEditable"
                    class="ml-16"
                    @click="startEditing"
                >
                    Edit
                </button>
            </div>
            <div class="p-16 mt-8 bg-white border-1 border-primary">
                <p>{{ comment.body }}</p>
            </div>
        </div>

        <div v-show="isEditing">
            <div>
                <h2 level="4" class="mb-8" nunito>Update comment</h2>
            </div>
            <a-text-input
                v-model="data.body"
                vid="comment"
                rules="required"
                type="textarea"
                placeholder="Update comment"
            ></a-text-input>
            <div class="flex items-center justify-between mt-8">
                <a-button type="is-danger" @click="deleteComment">Delete</a-button>
                <div class="flex items-center">
                    <a-button type="is-default" @click="reset">Cancel</a-button>
                    <a-button type="is-primary" @click="save">Update</a-button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
const SHOW = 'is-showing';
const EDIT = 'is-editing';

export default {
    name: 'comment-item',

    props: {
        user: {
            type: Object,
            required: true,
        },

        comment: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            state: SHOW,
            data: {
                body: this.comment.body,
            },
        };
    },

    computed: {
        isEditable() {
            return (this.user.id === this.comment.author.id);
        },

        isShowing() {
            return (this.state === SHOW);
        },

        isEditing() {
            return (this.state === EDIT);
        },

    },

    mounted() {
        // console.log('author222', this.comment.author);
    },

    methods: {
        startEditing() {
            this.state = EDIT;
        },

        reset() {
            this.state = SHOW;
            this.data.body = this.comment.body;
        },

        save() {
            this.state = SHOW;

            return this.$emit('comment-updated', {
                id: this.comment.id,
                body: this.data.body,
            });
        },

        deleteComment() {
            return this.$emit('comment-deleted', {
                id: this.comment.id,
            });
        },

    },

};
</script>
