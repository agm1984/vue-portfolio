<template>
    <component
        :is="inline ? 'span' : 'div'"
        ref="codeBlock"
        :class="{
            'mx-4': inline,
            'pb-32': !inline,
        }"
    ><pre
        :id="id"
        :class="preStyles"
        :data-language="language"
        :data-line="isHighlightingLines ? highlightLine : undefined"
        data-start="1"
    ><code><slot></slot></code></pre>

    </component>
</template>

<script>
import Prism from 'prism-es6';
import 'prismjs/plugins/custom-class/prism-custom-class';
import 'prismjs/plugins/line-highlight/prism-line-highlight';
import 'prismjs/plugins/line-highlight/prism-line-highlight.css';
import 'prismjs/plugins/line-numbers/prism-line-numbers';
import 'prismjs/plugins/line-numbers/prism-line-numbers.css';
import 'prismjs/plugins/normalize-whitespace/prism-normalize-whitespace';
import 'prism-es6/components/prism-markup-templating';
import 'prism-es6/components/prism-php';

Prism.plugins.customClass.prefix('prism--');

// TODO: make it so the user gets an achievement if they hover over the OSX window buttons
// while in `is-fancy` mode

export default {
    name: 'a-code',

    props: {
        /**
         * Defines a unique element ID that can be used for linking to page anchors.
         * ex) href="/test/#element-id.5" to hyperlink to line 5
         */
        id: {
            type: String,
            required: false,
            default: () => '',
        },

        /**
         * Changes the appearance of the component to be similar to the syntax highlighter
         * at https://carbon.now.sh. This prop is intended to upgrade a code block to more of a feature
         * element on a page, such as if a page only has one instance of this component.
         */
        isFancy: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        /**
         * Toggles line numbers.
         */
        hasLineNumbers: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        /**
         * Set code language.
         */
        language: {
            type: String,
            required: false,
            default: () => 'javascript',
        },

        /**
         * Highlight specific line numbers.
         * ex) '5', '1-5', '1,4', '1-2, 5, 9-20'
         *
         */
        highlightLine: {
            type: String,
            required: false,
            default: () => '',
        },

        /**
         * Toggles inline mode.
         */
        inline: {
            type: Boolean,
            required: false,
            default: () => false,
        },

    },

    data() {
        return {};
    },

    computed: {
        isHighlightingLines() {
            return (this.highlightLine.length > 0);
        },

        isLinkable() {
            return (this.id.length > 0);
        },

        preStyles() {
            const styles = [''];

            if (this.hasLineNumbers) styles.push('line-numbers');
            if (this.isFancy) styles.push('fancy-code');
            if (this.isLinkable) styles.push('linkable-line-numbers');
            if (this.language) styles.push(`language-${this.language}`);

            if (this.inline) styles.push('inline-highlight');
            else styles.push('a-card');

            return styles;
        },

    },

    watch: {
        hasLineNumbers() {
            return this.validateLineHighlighter();
        },

        isHighlightingLines() {
            return this.validateLineHighlighter();
        },
    },

    mounted() {
        this.validateLineHighlighter();
        return Prism.highlightAllUnder(this.$refs.codeBlock);
    },

    beforeUpdate() {
        return Prism.highlightAllUnder(this.$refs.codeBlock);
    },

    methods: {
        validateLineHighlighter() {
            if (this.isFancy && this.isHighlightingLines) {
                throw new Error('a-code# Highlighting lines in fancy mode is not allowed.');
            }
        },

    },

};
</script>

<style>
    pre > code {
        white-space: pre;
    }

    /**
     * !important marks are used because styles stem from numerous config locations,
     * namely node_modules > app.scss > bulma.scss
     */
    pre[class*="language-"].fancy-code {
        display: inline-block;
        padding-right: 10em;
        padding-top: 4rem;
        background-image: url('data:image/svg+xml;utf8, <svg xmlns="http://www.w3.org/2000/svg" width="54" height="14" viewBox="0 0 54 14"><g fill="none" fillRule="evenodd" transform="translate(1 1)"><circle cx="6" cy="6" r="6" fill="%23FF5F56" stroke="%23E0443E" strokeWidth=".5" /><circle cx="26" cy="6" r="6" fill="%23FFBD2E" stroke="%23DEA123" strokeWidth=".5" /><circle cx="46" cy="6" r="6" fill="%2327C93F" stroke="%231AAB29" strokeWidth=".5" /></g></svg>') !important;
        background-repeat: no-repeat;
        background-position: 16px 16px;
        white-space: pre !important;
        /* word-wrap: break-word; */
    }

    code[class*="language-"].fancy-code {
        white-space: pre;
        /* word-wrap: break-word; */
    }

    pre[class*="language-"].inline-highlight {
        display: inline;
        padding: 4px 8px 4px 8px;

        /* background and radius are congruent with .a-card */
        background: rgba(29, 38, 47, 0.96);
        border-radius: 4px;
    }

    pre.inline-highlight > code {
        white-space: pre-wrap;
        word-wrap: break-word;
    }

</style>
