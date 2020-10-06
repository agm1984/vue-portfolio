<template>
    <div ref="p5" :id="id" class="absolute inset-0 -z-10">
        <!-- on DOM-change, push redraw action -->
        <!-- note: https://developer.mozilla.org/en-US/docs/Web/API/MutationObserver -->
        <vue-p5
            :class="['p5wrapper absolute inset-0', {
                'opacity-50': isWallpaper,
                'rounded-lg': !isWallpaper,
                'overflow-hidden': !isWallpaper,
            }]"
            style=""
            @preload="preload"
            @setup="setup"
            @windowresized=""
        ></vue-p5>

    </div>
</template>

<script>
import VueP5 from 'vue-p5';

// states
const IS_INITIAL = 'IS_INITIAL';
const IS_PRELOADED = 'IS_PRELOADED';
const IS_SETUP = 'IS_SETUP';
const HAS_SETTINGS = 'HAS_SETTINGS';
const IS_DRAWN = 'IS_DRAWN';
const IS_RESET = 'IS_RESET';

export default {
    name: 'a-sacred-geometry',

    components: {
        VueP5,
    },

    props: {
        /**
         * Requires a unique ID because this component latches onto that DOM element ID
         * to determine the canvas area.
         */
        id: {
            type: String,
            required: true,
        },

        /**
         * If this component is instantiated as a wallpaper, it will reduce opacity by 50%
         * to help it blend in to the background area.
         */
        isWallpaper: {
            type: Boolean,
            required: false,
            default: () => false,
        },
    },

    data() {
        return {
            state: IS_INITIAL,

            offsetWidth: 0,
            offsetHeight: 0,
            containerDimensionAnalyzer: undefined,

            sketch: {},
            baseSize: undefined,
            points: undefined,
            centers: undefined,

            settings: {
                // canvas
                // backColor: '#000000',
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
                circleWeight: 0.1,
                circleColor: '#006666',
                circleOpacity: 1,
                circleFillColor: '#000000',
                circleFillOpacity: 1,
                dotWeight: 0.1,
                dotColor: '#cccccc',
                dotOpacity: 1,
                lineWeight: 0.1,
                lineColor: '#006699',
                lineOpacity: 1,
            },
        };
    },

    computed: {
        isInitial() {
            return (this.state === IS_INITIAL);
        },

        isPreloaded() {
            return (this.state === IS_PRELOADED);
        },

        isSetup() {
            return (this.state === IS_SETUP);
        },

        hasSettings() {
            return (this.state === HAS_SETTINGS);
        },

        isDrawn() {
            return (this.state === IS_DRAWN);
        },

        isReset() {
            return (this.state === IS_RESET);
        },

    },

    watch: {
        $route(to, from) {
            // retain the wallpaper if the route-base is the same
            if (from.name === to.name) return undefined;
            return this.reset();
        },

        isSetup() {
            return this.setState(this.sketch);
        },

        hasSettings() {
            return this.draw(this.sketch);
        },

        isReset() {
            return this.setState(this.sketch);
        },

        offsetWidth() {
            return this.restretchCanvas();
        },

        offsetHeight() {
            return this.restretchCanvas();
        },

    },

    mounted() {
        this.containerDimensionAnalyzer = setInterval(this.checkForDimensionChanges, 100);
    },

    beforeDestroy() {
        clearInterval(this.containerDimensionAnalyzer);
    },

    methods: {
        /**
         * P5.js acts upon DOM nodes outside Vue's control, and Vue lacks an event hook for when
         * the DOM is done loading, so we must actively sample the geometry container's dimensions
         * during the pageload to ensure the background is stretched and centered.
         *
         * The issue stems from P5 limitations, and unpredictable-child-dimensions inside `a-card.vue`.
         */
        restretchCanvas() {
            if ([HAS_SETTINGS, IS_DRAWN].includes(this.state)) {
                this.draw(this.sketch);
            }
        },

        checkForDimensionChanges() {
            return requestAnimationFrame(() => requestAnimationFrame(() => {
                const node = document.getElementById(this.id);
                if (!node) return;

                const { offsetWidth, offsetHeight } = node;
                this.offsetWidth = offsetWidth;
                this.offsetHeight = offsetHeight;
            }));
        },

        windowResized(sketch) {
            // const { offsetWidth, offsetHeight } = document.getElementById(this.id);
            // sketch.resizeCanvas(offsetWidth, offsetHeight - 4, false);
            // this.baseSize = offsetWidth > offsetHeight ? offsetHeight : offsetWidth;
            // return this.draw(this.sketch);
        },

        preload(sketch) {
            this.sketch = sketch;
            this.state = IS_PRELOADED;
        },

        setup(sketch) {
            const { offsetWidth, offsetHeight } = document.getElementById(this.id);
            sketch.createCanvas(offsetWidth, offsetHeight - 4);
            sketch.smooth();
            sketch.noLoop();
            sketch.colorMode(sketch.RGB, 255, 255, 255, 1);
            this.baseSize = offsetWidth > offsetHeight ? offsetHeight : offsetWidth;
            this.state = IS_SETUP;
        },

        setState(sketch) {
            this.settings.rotation = sketch.floor(sketch.random(8)) * 45;
            this.settings.count = sketch.floor(sketch.random(3)) + 3;
            // this.settings.count = sketch.random(3, 6);
            this.settings.radius = sketch.random(0.4);
            this.settings.offset = sketch.random(0.2) + 0.2;
            this.settings.genStart = sketch.floor(sketch.random(2));
            this.settings.genEnd = this.settings.genStart + 2 + sketch.floor(sketch.random(1));
            // this.settings.genStart = 1;
            // this.settings.genEnd = 4;
            this.settings.scaleGeneration = 1.0 - sketch.random(0.6);
            this.settings.offsetGeneration = this.settings.scaleGeneration - sketch.random(0.2);
            this.settings.centers = sketch.random(1) > 0.5;
            this.settings.intersects = sketch.random(1) > 0.6;
            // if (this.settings.genEnd - this.settings.genStart >= 2)
            //   this.settings.intersects = false;
            this.settings.network = sketch.random(1) > 0.4;
            this.settings.circleWeight = sketch.random(8) + 0.1;
            this.settings.circleOpacity = sketch.random(1);
            this.settings.circleFillOpacity = 0;
            this.settings.dotWeight = sketch.random(12);
            this.settings.dotOpacity = 0.5 + sketch.random(0.5);
            this.settings.lineWeight = sketch.random(2);
            this.settings.lineOpacity = sketch.random(1);
            this.state = HAS_SETTINGS;
        },

        draw(sketch) {
            const { offsetWidth, offsetHeight } = document.getElementById(this.id);
            sketch.resizeCanvas(offsetWidth, offsetHeight - 4, false);
            this.baseSize = offsetWidth > offsetHeight ? offsetHeight : offsetWidth;

            sketch.translate(offsetWidth / 2, offsetHeight / 2);
            // sketch.background(sketch.color(this.settings.backColor));
            sketch.noFill();
            sketch.rotate(sketch.radians(this.settings.rotation)); // base rotation
            this.centers = [];
            this.drawGeneration(0, 0, 0, 1.0, sketch);

            // CENTER / INTERSECTS
            if (!this.points) {
                this.points = [];

                // console.log("recalc points");
                if (this.settings.centers) {
                    for (let i = 0; i < this.centers.length; i += 1) {
                        const c0 = this.centers[i];
                        sketch.point(c0[0], c0[1]);
                        this.points.push(c0);
                        // console.log(c0);
                    }
                }

                if (this.settings.intersects) {
                    for (let i = 0; i < this.centers.length; i += 1) {
                        const c0 = this.centers[i];

                        for (let j = 0; j < this.centers.length; j += 1) {
                            if (i === j) continue; // eslint-disable-line no-continue
                            const c1 = this.centers[j];
                            const pts = this.circleIntersection(c0[0], c0[1], c0[2], c1[0], c1[1], c1[2], sketch);

                            for (let ix = 0; ix < pts.length; ix += 1) {
                                if (!this.points.find(pt => ((pt[0] === pts[ix][0]) && (pt[1] === pts[ix][1])))) {
                                    this.points.push(pts[ix]);
                                }
                            }
                        }

                        if (this.points.length > 400) break; // don't lock up browser
                    }
                }
                // console.log("pts: " + this.points.length);
            }

            // draw points
            this.setStroke(this.settings.dotColor, this.settings.dotOpacity, this.settings.dotWeight, sketch);

            for (let i = 0; i < this.points.length; i += 1) {
                const p = this.points[i];
                sketch.point(p[0], p[1]);
            }

            // draw lines
            if (this.settings.network) {
                let count = 0;

                // for each point, draw a line to all other points
                this.setStroke(this.settings.lineColor, this.settings.lineOpacity, this.settings.lineWeight, sketch);

                for (let i = 0; i < this.points.length; i += 1) {
                    const c0 = this.points[i];

                    // start past myself
                    for (let j = (i + 1); j < this.points.length; j += 1) {
                        const c1 = this.points[j];
                        sketch.line(c0[0], c0[1], c1[0], c1[1]);
                        count += 1;
                    }

                    if (count > 9000) break; // don't lock up browser
                }
            }

            this.state = IS_DRAWN;
        },

        reset() {
            if (this.state !== IS_DRAWN) {
                throw new Error(`a-sacred-geometry# Problem resetting p5 canvas: reset must be called from '${IS_DRAWN}' state. Current state: '${this.state}'.`);
            }

            this.baseSize = undefined;
            this.points = undefined;
            this.centers = undefined;

            this.sketch.clear();

            this.state = IS_RESET;
        },

        drawGeneration(generation, centerX, centerY, scale, sketch) {
            for (let i = 0; i < this.settings.count; i += 1) {
                // determine rotation
                const rot = sketch.radians((i * 360.0) / this.settings.count);

                // determine offset from center
                let offset = (this.baseSize * this.settings.offset);
                offset *= (this.settings.offsetGeneration * generation);

                // determine center
                const cX = (centerX + (offset * sketch.sin(rot)));
                const cY = (centerY + (offset * sketch.cos(rot)));

                // determine radius of circle - based on generational scaling
                const rad = (this.baseSize * this.settings.radius * scale);

                // hide culled generations
                if (generation >= this.settings.genStart) {
                    // log shape details connections
                    this.centers.push([cX, cY, rad / 2.0]);

                    // draw
                    if (this.settings.circleOpacity > 0 || this.settings.circleFillOpacity > 0) {
                        this.setStroke(this.settings.circleColor, this.settings.circleOpacity, this.settings.circleWeight, sketch);
                        this.setFill(this.settings.circleFillColor, this.settings.circleFillOpacity, sketch);
                        sketch.fill(this.settings.circleFillColor);
                        sketch.ellipse(cX, cY, rad, rad);
                    }
                }

                // draw generation from this shape
                if (generation < this.settings.genEnd - 1) {
                    this.drawGeneration(generation + 1, cX, cY, scale * this.settings.scaleGeneration, sketch);
                }
            }
        },

        /**
         * When circles are drawn, generate a list of x, y point co-ordinates
         * where the circles intersect.
         *
         * Adapted from: http://paulbourke.net/geometry/circlesphere/tvoght.c
         *
         * @param {Number} x0
         * @param {Number} y0
         * @param {Number} r0
         * @param {Number} x1
         * @param {Number} y1
         * @param {Number} r1
         * @return {Array}
         */
        circleIntersection(x0, y0, r0, x1, y1, r1, sketch) {
            // `dx` and `dy` are the vertical and horizontal distances between the cirlce centers
            const dx = (x1 - x0);
            const dy = (y1 - y0);

            // determine the straight-line distance between the centers
            const d = sketch.dist(x0, y0, x1, y1);

            // check for solvability
            if (d > (r0 + r1)) return [];
            if (d < sketch.abs(r0 - r1)) return [];

            // `point 2` is the point where the line through the circle intersection
            // points crosses the line between the circle centers

            // determine the distance from `point 0` to `point 2`
            const a = (((r0 * r0) - (r1 * r1) + (d * d)) / (2.0 * d));

            // determine the coordinates of `point 2`
            const x2 = (x0 + ((dx * a) / d));
            const y2 = (y0 + ((dy * a) / d));

            // determine the distance from `point 2` to either of the intersection points
            const h = sketch.sqrt(r0 * r0 - a * a);

            // now determine the offset of the intersection points from `point 2`
            const rx = (-dy * (h / d));
            const ry = (dx * (h / d));

            // return the absolute intersection points
            return [
                [x2 + rx, y2 + ry],
                [x2 - rx, y2 - ry],
            ];
        },

        setStroke(colorString, opacity, weight, sketch) {
            const col = sketch.color(colorString);
            sketch.stroke(sketch.red(col), sketch.green(col), sketch.blue(col), opacity);
            sketch.strokeWeight(weight);
            sketch.noFill();
        },

        setFill(colorString, opacity, sketch) {
            const col = sketch.color(colorString);
            sketch.fill(sketch.red(col), sketch.green(col), sketch.blue(col), opacity);
        },

    },
};
</script>

<style>
    canvas[id^="defaultCanvas"] {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }
</style>
