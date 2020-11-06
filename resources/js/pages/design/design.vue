<template>
    <div class="flex w-full h-auto">

        <div class="sidebar-page">
            <section class="sidebar-layout">
                <b-sidebar
                    type="is-light"
                    mobile="reduce"
                    position="static"
                    expand-on-hover
                    open
                    reduce
                >
                    <div class="">
                        <div class="block">
                            <a-heading level="1">
                                Design system
                            </a-heading>
                        </div>
                        <b-menu class="is-custom-mobile">
                            <b-menu-list label="UI Elements">
                                <b-menu-item
                                    label="Buttons"
                                    tag="router-link"
                                    :to="{ name: 'design.buttons' }"
                                    :active="$router.currentRoute.name === 'design.buttons'"
                                ></b-menu-item>
                                <b-menu-item
                                    label="Colour"
                                    tag="router-link"
                                    :to="{ name: 'design.colour' }"
                                    :active="$router.currentRoute.name === 'design.colour'"
                                ></b-menu-item>
                                <b-menu-item
                                    label="Space & Size"
                                    tag="router-link"
                                    :to="{ name: 'design.sizing' }"
                                    :active="$router.currentRoute.name === 'design.sizing'"
                                ></b-menu-item>
                                <b-menu-item
                                    label="Typography"
                                    tag="router-link"
                                    :to="{ name: 'design.typography' }"
                                    :active="$router.currentRoute.name === 'design.typography'"
                                ></b-menu-item>
                            </b-menu-list>

                            <b-menu-list label="Form controls">
                                <b-menu-item
                                    label="Text inputs"
                                    tag="router-link"
                                    to="/textinputs"
                                ></b-menu-item>
                                <b-menu-item
                                    label="Selects"
                                    tag="router-link"
                                    to="/selects"
                                ></b-menu-item>
                            </b-menu-list>

                            <b-menu-list label="Components">
                                <b-menu-item
                                    label="Radical thing"
                                    tag="router-link"
                                    to="/textinputs"
                                ></b-menu-item>
                                <b-menu-item
                                    label="Blast widget"
                                    tag="router-link"
                                    to="/selects"
                                ></b-menu-item>
                            </b-menu-list>
                        </b-menu>
                    </div>
                </b-sidebar>
            </section>
        </div>

        <div class="pt-64 pl-64">
            <router-view></router-view>
        </div>

        <!-- <div class="flex flex-col w-2/3 h-auto">
            <div class="relative h-auto p-32 mb-64 dark-card">
                <a-sacred-geometry id="design-system-1"></a-sacred-geometry>

                <a-heading level="1" light>Design system</a-heading>

                <a-paragraph>
                    Inside setup I have used this but the canvas size is not according to the div size.
                    How do I know this? Well, When I try to use my mouse to move the ellipse or rectangle on
                    the screen on any sketch, they are off from the mouse cursor. It means the canvas is
                    stretching which is clearly visible in case of ellipse. Why the canvas is not taking
                    the siz eof the div?
                </a-paragraph>
            </div>

            <div class="relative h-auto p-32 dark-card">
                <a-sacred-geometry id="design-system-2"></a-sacred-geometry>

                <a-heading level="1" light>System design</a-heading>

                <a-paragraph>
                    Inside setup I have used this but the canvas size is not according to the div size.
                    How do I know this? Well, When I try to use my mouse to move the ellipse or rectangle on
                    the screen on any sketch, they are off from the mouse cursor. It means the canvas is
                    stretching which is clearly visible in case of ellipse. Why the canvas is not taking
                    the siz eof the div?
                </a-paragraph>
            </div>
        </div>

        <div class="relative w-1/3 h-auto p-32 ml-64 dark-card">
            <a-sacred-geometry id="design-system-3"></a-sacred-geometry>

            <a-heading level="1" light>Design system</a-heading>

            <a-paragraph>
                Inside setup I have used this but the canvas size is not according to the div size.
                How do I know this? Well, When I try to use my mouse to move the ellipse or rectangle on
                the screen on any sketch, they are off from the mouse cursor. It means the canvas is
                stretching which is clearly visible in case of ellipse. Why the canvas is not taking
                the siz eof the div?
            </a-paragraph>
        </div> -->

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
