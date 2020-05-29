<template>
    <div ref="p5" class="absolute inset-0">
        <vue-p5
            @preload="preload"
            @setup="setup"
            @draw=""
            @redraw="redraw"
            @windowresized="windowResized"
        ></vue-p5>

    </div>
</template>

<script>
import VueP5 from 'vue-p5';

export default {
    name: 'a-sacred-geometry-three',

    components: {
        'vue-p5': VueP5,
    },

    data() {
        return {
            sketch: {},
            baseSize: undefined,
            points: undefined,
            centers: undefined,

            controlled: false,

            state: {
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
                circleColor: '#137F7C',
                circleOpacity: 1,
                circleFillColor: '#000001',
                circleFillOpacity: 1,
                dotWeight: 0.1,
                dotColor: '#eeeeee',
                dotOpacity: 1,
                lineWeight: 0.1,
                lineColor: '#136C8A',
                lineOpacity: 1,
            },
        };
    },

    computed: {},

    watch: {
        /**
         * To ensure the DOM has been fully updated, we must wait until the next tick,
         * and then execute a double-requestAnimationFrame; otherwise, the <html> element
         * may still have the previous height.
         */
        $route() {
            this.$nextTick(() => requestAnimationFrame(() => requestAnimationFrame(() => this.draw(this.sketch))));
        },

    },

    mounted() {},

    methods: {

        windowResized(sketch) {
            sketch.redraw();

            const container = document.querySelector('html').getBoundingClientRect();
            sketch.resizeCanvas(container.width, container.height - 4);
            this.baseSize = container.width > container.height ? container.height : container.width;

            // console.log('resizing');
            this.draw(this.sketch);
        },

        setState(sketch) {
            this.state.rotation = sketch.floor(sketch.random(8)) * 45;
            this.state.count = sketch.floor(sketch.random(3)) + 3;
            // this.state.count = sketch.random(3, 6);
            this.state.radius = sketch.random(0.4);
            this.state.offset = sketch.random(0.2) + 0.2;
            this.state.genStart = sketch.floor(sketch.random(2));
            this.state.genEnd = this.state.genStart + 2 + sketch.floor(sketch.random(1));
            // this.state.genStart = 1;
            // this.state.genEnd = 4;
            this.state.scaleGeneration = 1.0 - sketch.random(0.6);
            this.state.offsetGeneration = this.state.scaleGeneration - sketch.random(0.2);
            this.state.centers = sketch.random(1) > 0.5;
            this.state.intersects = sketch.random(1) > 0.6;
            // if (this.state.genEnd - this.state.genStart >= 2)
            //   this.state.intersects = false;
            this.state.network = sketch.random(1) > 0.4;
            this.state.circleWeight = sketch.random(8) + 0.1;
            this.state.circleOpacity = sketch.random(1);
            this.state.circleFillOpacity = 0;
            this.state.dotWeight = sketch.random(12);
            this.state.dotOpacity = 0.5 + sketch.random(0.5);
            this.state.lineWeight = sketch.random(2);
            this.state.lineOpacity = sketch.random(1);
        },

        preload(sketch) {
            this.sketch = sketch;
        },

        setup(sketch) {
            const container = document.querySelector('html').getBoundingClientRect();

            sketch.createCanvas(container.width, container.height - 4);
            sketch.smooth();

            this.baseSize = container.width > container.height ? container.height : container.width;

            sketch.noLoop();
            sketch.colorMode(sketch.RGB, 255, 255, 255, 1);

            // randomize
            if (!this.controlled) {
                this.draw(this.sketch);
            }
        },

        drawGeneration(generation, centerX, centerY, scale, sketch) {
            for (let i = 0; i < this.state.count; i += 1) {
                // determine rotation
                const rot = sketch.radians((i * 360.0) / this.state.count);

                // determine offset from center
                let offset = (this.baseSize * this.state.offset);
                offset *= (this.state.offsetGeneration * generation);

                // determine center
                const cX = (centerX + (offset * sketch.sin(rot)));
                const cY = (centerY + (offset * sketch.cos(rot)));

                // determine radius of circle - based on generational scaling
                const rad = (this.baseSize * this.state.radius * scale);

                // hide culled generations
                if (generation >= this.state.genStart) {
                    // log shape details connections
                    this.centers.push([cX, cY, rad / 2.0]);

                    // draw
                    if (this.state.circleOpacity > 0 || this.state.circleFillOpacity > 0) {
                        this.setStroke(this.state.circleColor, this.state.circleOpacity, this.state.circleWeight, sketch);
                        this.setFill(this.state.circleFillColor, this.state.circleFillOpacity, sketch);
                        sketch.fill(this.state.circleFillColor);
                        sketch.ellipse(cX, cY, rad, rad);
                    }
                }

                // draw generation from this shape
                if (generation < this.state.genEnd - 1) {
                    this.drawGeneration(generation + 1, cX, cY, scale * this.state.scaleGeneration, sketch);
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

        draw(sketch) {
            console.log('drawing, sketch instance:', sketch);
            if (!sketch || !Object.keys(sketch).length) {
                console.log('R&D: NO SKETCH INSTANCE');
                const p5 = this.$refs.p5;
                console.log('p5: ', p5);
                return;
            }

            this.setState(sketch);
            const container = document.querySelector('html').getBoundingClientRect();
            sketch.resizeCanvas(container.width, container.height - 4, false);
            this.baseSize = container.width > container.height ? container.height : container.width;

            sketch.translate(container.width / 2, container.height / 2);
            // sketch.background(sketch.color(this.state.backColor));
            sketch.noFill();
            sketch.rotate(sketch.radians(this.state.rotation)); // base rotation
            this.centers = [];
            this.drawGeneration(0, 0, 0, 1.0, sketch);

            // CENTER / INTERSECTS
            if (!this.points) {
                this.points = [];

                // console.log("recalc points");
                if (this.state.centers) {
                    for (let i = 0; i < this.centers.length; i += 1) {
                        const c0 = this.centers[i];
                        sketch.point(c0[0], c0[1]);
                        this.points.push(c0);
                        // console.log(c0);
                    }
                }

                if (this.state.intersects) {
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
            this.setStroke(this.state.dotColor, this.state.dotOpacity, this.state.dotWeight, sketch);

            for (let i = 0; i < this.points.length; i += 1) {
                const p = this.points[i];
                sketch.point(p[0], p[1]);
            }

            // draw lines
            if (this.state.network) {
                let count = 0;

                // for each point, draw a line to all other points
                this.setStroke(this.state.lineColor, this.state.lineOpacity, this.state.lineWeight, sketch);

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
        },

        redraw() {
            console.log('test redraw');
        },

    },
};
</script>
