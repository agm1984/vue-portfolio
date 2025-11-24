<script setup>
defineProps({
    /**
     * By default, each error message is generic, and the value is referred to as 'Value'.
     * By passing in a name, you can instruct Vuelidate to refer to the value as the name.
     * ex) With name 'Email', 'Value is required', will display as 'Email is required'.
     */
    name: {
        type: String,
        required: true,
    },

    /**
     * This is the array of field errors, supplied by Vuelidate.
     */
    errors: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div class="pt-1">
        <div v-for="(error, index) of errors" :key="`field-error-${index}`" class="flex flex-col">
            <span
                class="text-red-700 text-xs"
            >{{ error.$message.replace('Value', name).replace('The value', name).replace('This field', name) }}</span>
        </div>
    </div>
</template>
