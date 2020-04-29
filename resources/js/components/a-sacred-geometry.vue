<template>
    <div>
        <iframe
            scrolling="no"
            :srcDoc="generate(state)"
            name="sacredGeometry"
            title="sacredGeometry"
            frameBorder="0"
            :style="{
                position: 'relative',
                ...defaultStyles,
                ...extraStyles,
                zIndex: 0,
            }"
      ></iframe>
    </div>
</template>

<script>
import tailwind from '../../../tailwind.config';
import generate from './utils/geometryLogic';

// const testsample = tailwind.theme.colors.green[100];

export default {
    name: 'a-sacred-geometry',

    props: {
        circleColor: {
            type: String,
            required: false,
            default: () => '#014420',
        },

        dotColor: {
            type: String,
            required: false,
            default: () => '#eeeeee',
        },

        lineColor: {
            type: String,
            required: false,
            default: () => '#66FCF1',
        },

        extraStyles: {
            type: Object,
            required: false,
            default: () => ({}),
        },
    },

    data() {
        return {
            generate,
            defaultStyles: {
                position: 'absolute',
                width: '100%',
                height: '100vh',
                overflow: 'hidden',
                background: 'none',
                opacity: 0.25,
                transition: 'all 1000ms ease-in-out',
                'z-index': -1,
            },

            state: {
                controlled: false,
                // canvas
                // backColor: '#000',
                rotation: 180,
                // shapes
                count: 3,
                radius: 0.1,
                offset: 0.5,
                // connections
                centers: true,
                intersects: true,
                network: false,
                // generations
                genStart: 0,
                genEnd: 2,
                scaleGeneration: 0.99,
                offsetGeneration: 0.4,
                // style
                circleWeight: 3,
                circleColor: this.circleColor,
                circleOpacity: 1.0,
                circleFillColor: '#222222',
                circleFillOpacity: 1.0,
                dotWeight: 12,
                dotColor: this.dotColor,
                dotOpacity: 1.0,
                lineWeight: 0.1,
                lineColor: this.lineColor,
                lineOpacity: 1.0,
            },
        };
    },

    computed: {},

    mounted() {},

    methods: {

    },

};
</script>
