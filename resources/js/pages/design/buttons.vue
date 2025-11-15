<script setup>
import Button from 'primevue/button';
</script>

<template>
    <div class="flex flex-col h-auto">
        <a-card class="p-8">
            <h2>Buttons</h2>

            <div class="flex flex-row flex-wrap gap-4 mt-4">
                <Button label="Primary" />
                <Button label="Secondary" severity="secondary" />
                <Button label="Success" severity="success" />
                <Button label="Info" severity="info" />
                <Button label="Warn" severity="warn" />
                <Button label="Help" severity="help" />
                <Button label="Danger" severity="danger" />
                <Button label="Contrast" severity="contrast" />
            </div>

            <a-code
                class="mt-4"
                language="javascript"
                :code="`&lt;Button label=&quot;Primary&quot; /&gt;`"
            />

            <p class="mt-4">
                For all permutations, see the
                <a class="font-semibold hover:underline" href="https://primevue.org/button/">PrimeVue</a>  button docs.
            </p>
        </a-card>
    </div>
</template>
