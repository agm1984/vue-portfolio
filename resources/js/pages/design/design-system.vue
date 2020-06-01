<template>
    <div class="flex w-full h-auto">
        <div class="flex flex-col w-2/3 h-auto">
            <div class="relative h-auto p-32 mb-64 a-card">
                <a-sacred-geometry id="design-system-1"></a-sacred-geometry>

                <a-heading level="1">Design system</a-heading>

                <a-paragraph>
                    Inside setup I have used this but the canvas size is not according to the div size.
                    How do I know this? Well, When I try to use my mouse to move the ellipse or rectangle on
                    the screen on any sketch, they are off from the mouse cursor. It means the canvas is
                    stretching which is clearly visible in case of ellipse. Why the canvas is not taking
                    the siz eof the div?
                </a-paragraph>
            </div>

            <div class="relative h-auto p-32 a-card">
                <a-sacred-geometry id="design-system-2"></a-sacred-geometry>

                <a-heading level="1">System design</a-heading>

                <a-paragraph>
                    Inside setup I have used this but the canvas size is not according to the div size.
                    How do I know this? Well, When I try to use my mouse to move the ellipse or rectangle on
                    the screen on any sketch, they are off from the mouse cursor. It means the canvas is
                    stretching which is clearly visible in case of ellipse. Why the canvas is not taking
                    the siz eof the div?
                </a-paragraph>
            </div>
        </div>

        <div class="relative w-1/3 h-auto p-32 ml-64 a-card">
            <a-sacred-geometry id="design-system-3"></a-sacred-geometry>

            <a-heading level="1">Design system</a-heading>

            <a-paragraph>
                Inside setup I have used this but the canvas size is not according to the div size.
                How do I know this? Well, When I try to use my mouse to move the ellipse or rectangle on
                the screen on any sketch, they are off from the mouse cursor. It means the canvas is
                stretching which is clearly visible in case of ellipse. Why the canvas is not taking
                the siz eof the div?
            </a-paragraph>
        </div>

    </div>
</template>

<script>
export default {
    name: 'design-system',

    metaInfo() {
        return { title: 'Design system' };
    },

    data() {
        return {};
    },

    computed: {},

    methods: {},

};
</script>
