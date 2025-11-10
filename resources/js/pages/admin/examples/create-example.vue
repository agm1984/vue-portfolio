<script setup>
</script>

<template>
    <a-card class="p-8">
        <h2 level="2" class="mb-16" dark>
            Create example
        </h2>

        <edit-example
            mode="create"
            @reset="() => {}"
            @save="() => {}"
        />
    </a-card>
</template>
