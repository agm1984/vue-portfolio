<template>
    <a-card id="design-system-typography" class="p-32" with-geometry>

        <a-heading level="1" class="mb-16" dark>Typography</a-heading>

        <a-paragraph>
            This website uses base font-size <strong>10px</strong>, so most elements are sized with REM units because body copy is
            16px which is 1.6rem. This makes REM units evenly divisible with pixels, and more human-readable.
        </a-paragraph>

        <a-paragraph>
            This website uses two fonts: Aroly and Nunito. Aroly is used for H1 and H2 headings, and anything larger than that.
            Nunito is used for all other text.
        </a-paragraph>

        <a-paragraph>
            Headings can be black or primary green.
        </a-paragraph>

        <a-heading level="1" dark>This portfolio has a design system.</a-heading>
        <a-code>
            font-family: AROLY;
            font-size: 4.8rem;
            font-weight: 400;
        </a-code>

        <a-heading level="2" dark>This portfolio has a design system.</a-heading>
        <a-code>
            font-family: AROLY;
            font-size: 3.4rem;
            font-weight: 400;
        </a-code>

        <a-heading level="3" dark nunito>This portfolio has a design system.</a-heading>
        <a-code>
            font-family: Nunito;
            font-size: 1.9rem;
            font-weight: 700;
        </a-code>

        <a-heading level="4" dark nunito>This portfolio has a design system.</a-heading>
        <a-code>
            font-family: Nunito;
            font-size: 1.6rem;
            font-weight: 400;
        </a-code>

        <a-heading level="5" dark nunito>This portfolio has a design system.</a-heading>
        <a-code>
            font-family: Nunito;
            font-size: 1.3rem;
            font-weight: 400;
        </a-code>

        <a-heading level="6" dark nunito>This portfolio has a design system.</a-heading>
        <a-code>
            font-family: Nunito;
            font-size: 1.1rem;
            font-weight: 400;
        </a-code>

        <a-heading level="1" class="mb-16" dark>Paragraphs</a-heading>
        <a-code>
            &lt;a-paragraph dark&gt;
                This is a paragraph.
            &lt;/a-paragraph&gt;
        </a-code>

    </a-card>
</template>

<script>
export default {
    name: 'typography',

    data() {
        return {};
    },

    computed: {},

    methods: {},

};
</script>
