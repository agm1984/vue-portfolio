<template>
    <div class="flex flex-col h-auto">
        <a-card id="design-system-buttons" class="p-32" with-geometry>
            <a-heading level="2" dark>Buttons</a-heading>

            <div class="flex flex-row flex-wrap">
                <a-button class="m-8" type="is-primary">Primary</a-button>
                <a-button class="m-8" type="is-default">Default</a-button>
                <a-button class="m-8" type="is-info">Info</a-button>
                <a-button class="m-8" type="is-warning">Warning</a-button>
                <a-button class="m-8" type="is-danger">Danger</a-button>
                <a-button class="m-8" type="is-success">Success</a-button>
                <b-button class="m-8" type="is-link">Link</b-button>
                <b-button class="m-8" type="is-light">Light</b-button>
                <b-button class="m-8" type="is-dark">Dark</b-button>
                <b-button class="m-8" type="is-text">Text</b-button>
            </div>

            <a-code language="html">
                &lt;a-button type="is-primary" size="is-default"&gt;
                    Submit
                &lt;/a-button&gt;
            </a-code>

            <a-paragraph>
                For all permutations, see the <a href="https://buefy.org/documentation/button">Buefy button docs</a>.
            </a-paragraph>

        </a-card>

        <a-card id="design-system-buttons" class="p-32 mt-32" with-geometry>
            <a-heading level="2" dark>Light buttons</a-heading>

            <div class="flex flex-row flex-wrap">
                <a-button class="m-8" type="is-primary is-light">Primary</a-button>
                <a-button class="m-8" type="is-default is-light">Default</a-button>
                <a-button class="m-8" type="is-info is-light">Info</a-button>
                <a-button class="m-8" type="is-warning is-light">Warning</a-button>
                <a-button class="m-8" type="is-danger is-light">Danger</a-button>
                <a-button class="m-8" type="is-success is-light">Success</a-button>
                <b-button class="m-8" type="is-link is-light">Link Light</b-button>
            </div>

            <a-code language="html">
                &lt;a-button type="is-primary is-light" size="is-default"&gt;
                    Submit
                &lt;/a-button&gt;
            </a-code>

        </a-card>

        <a-card id="design-system-buttons" class="p-32 mt-32" with-geometry>
            <a-heading level="2" dark>Outlined buttons</a-heading>

            <div class="flex flex-row flex-wrap">
                <a-button class="m-8" type="is-primary" outlined>Primary</a-button>
                <a-button class="m-8" type="is-default" outlined>Default</a-button>
                <a-button class="m-8" type="is-info" outlined>Info</a-button>
                <a-button class="m-8" type="is-warning" outlined>Warning</a-button>
                <a-button class="m-8" type="is-danger" outlined>Danger</a-button>
                <a-button class="m-8" type="is-success" outlined>Success</a-button>
                <b-button class="m-8" type="is-link" outlined>Link Light</b-button>
            </div>

            <a-code language="html">
                &lt;a-button type="is-primary" outlined&gt;
                    Submit
                &lt;/a-button&gt;
            </a-code>

        </a-card>

        <a-card id="design-system-buttons" class="p-32 mt-32" with-geometry>
            <a-heading level="2" dark>Size</a-heading>

            <div class="flex flex-row flex-wrap">
                <a-button class="m-8" type="is-default" size="is-small">Small</a-button>
                <a-button class="m-8" type="is-default" size="is-default">Default</a-button>
                <a-button class="m-8" type="is-default" size="is-medium">Medium</a-button>
                <a-button class="m-8" type="is-default" size="is-large">Large</a-button>
            </div>

            <a-code language="html">
                &lt;a-button type="is-primary" size="is-medium"&gt;
                    Submit
                &lt;/a-button&gt;
            </a-code>

        </a-card>

        <a-card id="design-system-buttons" class="p-32 mt-32" with-geometry>
            <a-heading level="2" dark>Links</a-heading>

            <div class="flex flex-row flex-wrap">
                <a href="#">Link</a>
                <!-- <a-button class="m-8" type="is-default" size="is-small">Small</a-button>
                <a-button class="m-8" type="is-default" size="is-default">Default</a-button>
                <a-button class="m-8" type="is-default" size="is-medium">Medium</a-button>
                <a-button class="m-8" type="is-default" size="is-large">Large</a-button> -->
            </div>

            <a-code language="html">
                &lt;a href="#"&gt;Link&lt;/a&gt;
            </a-code>

        </a-card>
    </div>
</template>

<script>
export default {
    name: 'buttons',

    data() {
        return {};
    },

    computed: {},

    methods: {},

};
</script>
