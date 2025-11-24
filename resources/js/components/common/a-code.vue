<script setup>
import Prism from 'prismjs';
import VCodeBlock from '@wdns/vue-code-block';
import 'prismjs/plugins/line-numbers/prism-line-numbers.js';
import 'prismjs/plugins/line-numbers/prism-line-numbers.css';
import 'prismjs/components/prism-markup-templating';
import 'prismjs/components/prism-php';

const props = defineProps({
    label: {
        type: String,
        required: false,
        default: () => '',
    },

    code: {
        type: String,
        required: false,
        default: () => '',
    },

    language: {
        type: String,
        required: false,
        default: () => 'javascript',
    },
});
</script>

<template>
    <VCodeBlock
        :code="code"
        :label="label"
        :lang="language"
        theme="tomorrow"
        prismjs
        prism-plugin
    />
</template>
