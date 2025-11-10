<script setup>
</script>

<template>
    <a-card class="p-8" with-geometry>
        <h2 level="2" class="mb-16" dark>
            Create category
        </h2>

        <edit-category
            mode="create"
            @reset="() => {}"
            @save="() => {}"
        />
    </a-card>
</template>
