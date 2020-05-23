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
// import tailwind from '../../../../tailwind.config';
// import generate from '../utils/geometryLogic';

// const testsample = tailwind.theme.colors.green[100];

export default {
    name: 'a-sacred-geometry-two',

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

    mounted() {
        this.drawShit();
    },

    methods: {
        drawShit() {
            let props = {
                // canvas
                // backColor: 'this.state.backColor',
                rotation: this.state.rotation,
                // shapes
                count: this.state.count,
                radius: this.state.radius,
                offset: this.state.offset,
                // connections
                centers: this.state.centers,
                intersects: this.state.intersects,
                network: this.state.network,
                // generations
                genStart: this.state.genStart,
                genEnd: this.state.genEnd,
                scaleGeneration: this.state.scaleGeneration,
                offsetGeneration: this.state.offsetGeneration,
                // style
                circleWeight: this.state.circleWeight,
                circleColor: this.state.circleColor,
                circleOpacity: this.state.circleOpacity,
                circleFillColor: this.state.circleFillColor,
                circleFillOpacity: this.state.circleFillOpacity,
                dotWeight: this.state.dotWeight,
                dotColor: this.state.dotColor,
                dotOpacity: this.state.dotOpacity,
                lineWeight: this.state.lineWeight,
                lineColor: this.state.lineColor,
                lineOpacity: this.state.lineOpacity,
            };

            function generate() {
                // randomize
                const controlled = this.state.controlled;

                if (!controlled) {
                    props.rotation = floor(random(8)) * 45;
                    props.count = floor(random(3)) + 3;
                    props.radius = random(0.8) + 0.1;
                    props.offset = random(0.2) + 0.2;
                    props.genStart = floor(random(2));
                    props.genEnd = props.genStart + 2 + floor(random(1));
                    props.scaleGeneration = 1.0 - random(0.6);
                    props.offsetGeneration = props.scaleGeneration - random(0.2);
                    props.centers = random(1) > 0.5;
                    props.intersects = random(1) > 0.6;
                    // if (props.genEnd - props.genStart >= 2)
                    //   props.intersects = false;
                    props.network = random(1) > 0.4;
                    props.circleWeight = random(8) + 0.1;
                    props.circleOpacity = random(1);
                    props.circleFillOpacity = 0;
                    props.dotWeight = random(24);
                    props.dotOpacity = 0.5 + random(0.5);
                    props.lineWeight = random(2);
                    props.lineOpacity = random(1);
                }
                points = null;
                redraw();
            }

            function setup() {
                var canv = createCanvas(windowWidth, windowHeight - 4);
                canv.id("renderCanvas");
                smooth();
                baseSize = width > height ? height : width;
                noLoop();
                colorMode(RGB, 255, 255, 255, 1);
                generate();
            }

            function windowResized() {
                resizeCanvas(windowWidth, windowHeight - 4);
                baseSize = width > height ? height : width;
            }
            var baseSize;
            var centers;
            var points = null;

            function draw() {
                translate(width / 2, height / 2);
                // background(color(props.backColor));
                noFill();
                rotate(radians(props.rotation)); // base rotation
                centers = [];
                drawGeneration(0, 0, 0, 1.0);
                // CENTER / INTERSECTS
                if (!points) {
                    points = [];
                    // console.log("recalc points");
                    if (props.centers) {
                        for (var i = 0; i < centers.length; i++) {
                            var c0 = centers[i];
                            point(c0[0], c0[1]);
                            points.push(c0);
                            // console.log(c0);
                        }
                    }
                    if (props.intersects) {
                        for (var i = 0; i < centers.length; i++) {
                            var c0 = centers[i];
                            for (var j = 0; j < centers.length; j++) {
                                if (i == j)
                                    continue;
                                var c1 = centers[j];
                                var pts = circleIntersection(c0[0], c0[1], c0[2], c1[0], c1[1], c1[2]);
                                // de-duplicate points
                                _.each(pts, function (c) {
                                    if (!_.find(points, function (pt) { return pt[0] == c[0] && pt[1] == c[1] })) {
                                    points.push(c);
                                    }
                                });
                            }
                            if (points.length > 400) break; // don't lock up browser
                        }
                    }
                // console.log("pts: " + points.length);
                }
                // draw lines
                if (props.network) {
                    var count = 0;
                    // for each point, draw a line to all other points
                    setStroke(props.lineColor, props.lineOpacity, props.lineWeight);
                    for (var i = 0; i < points.length; i++) {
                        var c0 = points[i];
                        // start past myself
                        for (var j = i + 1; j < points.length; j++) {
                            var c1 = points[j];
                            line(c0[0], c0[1], c1[0], c1[1]);
                            count++
                        }
                        if (count > 9000) break; // don't lock up browser
                    }
                }
                // draw points
                setStroke(props.dotColor, props.dotOpacity, props.dotWeight);
                for (var i = 0; i < points.length; i++) {
                    var p = points[i];
                    point(p[0], p[1]);
                }
            }
            function setStroke(colorString, opacity, weight) {
                var col = color(colorString);
                stroke(red(col), green(col), blue(col), opacity);
                strokeWeight(weight);
                noFill();
            }
            function setFill(colorString, opacity) {
                var col = color(colorString);
                fill(red(col), green(col), blue(col), opacity);
            }
            function drawGeneration(generation, centerX, centerY, scale) {
                for (var i = 0; i < props.count; i++) {
                    // determine rotation
                    var rot = radians(i * 360.0 / props.count);
                    // determine offset from center
                    var offset = baseSize * props.offset;
                    offset *= props.offsetGeneration * generation;
                    // determine center
                    var cX = centerX + offset * sin(rot);
                    var cY = centerY + offset * cos(rot);
                    // determine radius of circle - based on generational scaling
                    var rad = baseSize * props.radius * scale;
                    // hide culled generations
                    if (generation >= props.genStart) {
                        // log shape details connections
                        centers.push([cX, cY, rad / 2.0]);
                        // draw
                        if (props.circleOpacity > 0 || props.circleFillOpacity > 0) {
                            setStroke(props.circleColor, props.circleOpacity, props.circleWeight);
                            setFill(props.circleFillColor, props.circleFillOpacity);
                            ellipse(cX, cY, rad, rad);
                        }
                    }
                    // draw generation from this shape
                    if (generation < props.genEnd - 1) {
                        drawGeneration(generation + 1, cX, cY, scale * props.scaleGeneration);
                    }
                }
            }
            /* Adapted from: http://paulbourke.net/geometry/circlesphere/tvoght.c */
            function circleIntersection(x0, y0, r0, x1, y1, r1) {
                /* dx and dy are the vertical and horizontal distances between
                    the cirlce centers
                */
                var dx = x1 - x0;
                var dy = y1 - y0;
                /* Determine the straight-line distance between the centers */
                var d = dist(x0, y0, x1, y1);
                /* Check for solvability */
                if (d > (r0 + r1))
                    return [];
                if (d < abs(r0 - r1))
                    return [];
                /* 'point 2' is the point where the line through the circle
                    intersection points crosses the line between the circle
                    centers.
                */
                /* Determine the distance from point 0 to point 2 */
                var a = ((r0 * r0) - (r1 * r1) + (d * d)) / (2.0 * d);
                /* Determine the coordinates of point 2 */
                var x2 = x0 + (dx * a / d);
                var y2 = y0 + (dy * a / d);
                /* Determine the distance from point 2 to either of the
                    intersection points.
                    */
                var h = sqrt(r0 * r0 - a * a);
                /* Now determine the offset of the intersection points from
                    point 2.
                    */
                var rx = -dy * (h / d);
                var ry = dx * (h / d);
                /* Determine the absolute interesction points */
                return [
                    [x2 + rx, y2 + ry],
                    [x2 - rx, y2 - ry]
                ];
            }
        },
    },

};
</script>
