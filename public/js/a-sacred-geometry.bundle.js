(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["a-sacred-geometry"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/a-sacred-geometry.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/a-sacred-geometry.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _tailwind_config__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../tailwind.config */ "./tailwind.config.js");
/* harmony import */ var _tailwind_config__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_tailwind_config__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _utils_geometryLogic__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils/geometryLogic */ "./resources/js/components/utils/geometryLogic.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

 // const testsample = tailwind.theme.colors.green[100];

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'a-sacred-geometry',
  props: {
    circleColor: {
      type: String,
      required: false,
      "default": function _default() {
        return '#014420';
      }
    },
    dotColor: {
      type: String,
      required: false,
      "default": function _default() {
        return '#eeeeee';
      }
    },
    lineColor: {
      type: String,
      required: false,
      "default": function _default() {
        return '#66FCF1';
      }
    },
    extraStyles: {
      type: Object,
      required: false,
      "default": function _default() {
        return {};
      }
    }
  },
  data: function data() {
    return {
      generate: _utils_geometryLogic__WEBPACK_IMPORTED_MODULE_1__["default"],
      defaultStyles: {
        position: 'absolute',
        width: '100%',
        height: '100vh',
        overflow: 'hidden',
        background: 'none',
        opacity: 0.25,
        transition: 'all 1000ms ease-in-out',
        'z-index': -1
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
        lineOpacity: 1.0
      }
    };
  },
  computed: {},
  mounted: function mounted() {},
  methods: {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/a-sacred-geometry.vue?vue&type=template&id=98207a48&":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/a-sacred-geometry.vue?vue&type=template&id=98207a48& ***!
  \********************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("iframe", {
      style: Object.assign(
        {},
        { position: "relative" },
        _vm.defaultStyles,
        _vm.extraStyles,
        { zIndex: 0 }
      ),
      attrs: {
        scrolling: "no",
        srcDoc: _vm.generate(_vm.state),
        name: "sacredGeometry",
        title: "sacredGeometry",
        frameBorder: "0"
      }
    })
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/a-sacred-geometry.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/a-sacred-geometry.vue ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _a_sacred_geometry_vue_vue_type_template_id_98207a48___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./a-sacred-geometry.vue?vue&type=template&id=98207a48& */ "./resources/js/components/a-sacred-geometry.vue?vue&type=template&id=98207a48&");
/* harmony import */ var _a_sacred_geometry_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./a-sacred-geometry.vue?vue&type=script&lang=js& */ "./resources/js/components/a-sacred-geometry.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _a_sacred_geometry_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _a_sacred_geometry_vue_vue_type_template_id_98207a48___WEBPACK_IMPORTED_MODULE_0__["render"],
  _a_sacred_geometry_vue_vue_type_template_id_98207a48___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/a-sacred-geometry.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/a-sacred-geometry.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/a-sacred-geometry.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_a_sacred_geometry_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./a-sacred-geometry.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/a-sacred-geometry.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_a_sacred_geometry_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/a-sacred-geometry.vue?vue&type=template&id=98207a48&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/a-sacred-geometry.vue?vue&type=template&id=98207a48& ***!
  \**************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_a_sacred_geometry_vue_vue_type_template_id_98207a48___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./a-sacred-geometry.vue?vue&type=template&id=98207a48& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/a-sacred-geometry.vue?vue&type=template&id=98207a48&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_a_sacred_geometry_vue_vue_type_template_id_98207a48___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_a_sacred_geometry_vue_vue_type_template_id_98207a48___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/utils/geometryLogic.js":
/*!********************************************************!*\
  !*** ./resources/js/components/utils/geometryLogic.js ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var generate = function generate(props) {
  return "<!DOCTYPE html>\n<html>\n    <head>\n        <meta charset=\"utf-8\" />\n        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n        <title>Sacred Geometry</title>\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/dat-gui/0.7.1/dat.gui.min.js\"></script>\n        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.5/lodash.min.js\"></script>\n        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.6.0/p5.min.js\"></script>\n        <style type=\"text/css\">\n            body {background:none transparent;}\n            * {background:none transparent;}\n            #renderCanvas {background:none transparent;}\n        </style>\n    </head>\n\n    <body>\n        <script>\n            var props = {\n            // canvas\n            // backColor: '".concat(props.backColor, "',\n            rotation: ").concat(props.rotation, ",\n            // shapes\n            count: ").concat(props.count, ",\n            radius: ").concat(props.radius, ",\n            offset: ").concat(props.offset, ",\n            // connections\n            centers: ").concat(props.centers, ",\n            intersects: ").concat(props.intersects, ",\n            network: ").concat(props.network, ",\n            // generations\n            genStart: ").concat(props.genStart, ",\n            genEnd: ").concat(props.genEnd, ",\n            scaleGeneration: ").concat(props.scaleGeneration, ",\n            offsetGeneration: ").concat(props.offsetGeneration, ",\n            // style\n            circleWeight: ").concat(props.circleWeight, ",\n            circleColor: '").concat(props.circleColor, "',\n            circleOpacity: ").concat(props.circleOpacity, ",\n            circleFillColor: '").concat(props.circleFillColor, "',\n            circleFillOpacity: ").concat(props.circleFillOpacity, ",\n            dotWeight: ").concat(props.dotWeight, ",\n            dotColor: '").concat(props.dotColor, "',\n            dotOpacity: ").concat(props.dotOpacity, ",\n            lineWeight: ").concat(props.lineWeight, ",\n            lineColor: '").concat(props.lineColor, "',\n            lineOpacity: ").concat(props.lineOpacity, ",\n            }\n            function generate() {\n            // randomize\n            var controlled = ").concat(props.controlled, ";\n            if (!controlled) {\n                props.rotation = floor(random(8)) * 45;\n                props.count = floor(random(3)) + 3;\n                props.radius = random(0.8) + 0.1;\n                props.offset = random(0.2) + 0.2;\n                props.genStart = floor(random(2));\n                props.genEnd = props.genStart + 2 + floor(random(1));\n                props.scaleGeneration = 1.0 - random(0.6);\n                props.offsetGeneration = props.scaleGeneration - random(0.2);\n                props.centers = random(1) > 0.5;\n                props.intersects = random(1) > 0.6;\n                // if (props.genEnd - props.genStart >= 2)\n                //   props.intersects = false;\n                props.network = random(1) > 0.4;\n                props.circleWeight = random(8) + 0.1;\n                props.circleOpacity = random(1);\n                props.circleFillOpacity = 0;\n                props.dotWeight = random(24);\n                props.dotOpacity = 0.5 + random(0.5);\n                props.lineWeight = random(2);\n                props.lineOpacity = random(1);\n            }\n            points = null;\n            redraw();\n            }\n            function setup() {\n            var canv = createCanvas(windowWidth, windowHeight - 4);\n            canv.id(\"renderCanvas\");\n            smooth();\n            baseSize = width > height ? height : width;\n            noLoop();\n            colorMode(RGB, 255, 255, 255, 1);\n            generate();\n            }\n            function windowResized() {\n            resizeCanvas(windowWidth, windowHeight - 4);\n            baseSize = width > height ? height : width;\n            }\n            var baseSize;\n            var centers;\n            var points = null;\n            function draw() {\n            translate(width / 2, height / 2);\n            // background(color(props.backColor));\n            noFill();\n            rotate(radians(props.rotation)); // base rotation\n            centers = [];\n            drawGeneration(0, 0, 0, 1.0);\n            // CENTER / INTERSECTS\n            if (!points) {\n                points = [];\n                // console.log(\"recalc points\");\n                if (props.centers) {\n                for (var i = 0; i < centers.length; i++) {\n                    var c0 = centers[i];\n                    point(c0[0], c0[1]);\n                    points.push(c0);\n                    // console.log(c0);\n                }\n                }\n                if (props.intersects) {\n                for (var i = 0; i < centers.length; i++) {\n                    var c0 = centers[i];\n                    for (var j = 0; j < centers.length; j++) {\n                    if (i == j)\n                        continue;\n                    var c1 = centers[j];\n                    var pts = circleIntersection(c0[0], c0[1], c0[2], c1[0], c1[1], c1[2]);\n                    // de-duplicate points\n                    _.each(pts, function (c) {\n                        if (!_.find(points, function (pt) { return pt[0] == c[0] && pt[1] == c[1] })) {\n                        points.push(c);\n                        }\n                    });\n                    }\n                    if (points.length > 400)\n                    break; // don't lock up browser\n                }\n                }\n                // console.log(\"pts: \" + points.length);\n            }\n            // draw lines\n            if (props.network) {\n                var count = 0;\n                // for each point, draw a line to all other points\n                setStroke(props.lineColor, props.lineOpacity, props.lineWeight);\n                for (var i = 0; i < points.length; i++) {\n                var c0 = points[i];\n                // start past myself\n                for (var j = i + 1; j < points.length; j++) {\n                    var c1 = points[j];\n                    line(c0[0], c0[1], c1[0], c1[1]);\n                    count++\n                }\n                if (count > 9000) break; // don't lock up browser\n                }\n            }\n            // draw points\n            setStroke(props.dotColor, props.dotOpacity, props.dotWeight);\n            for (var i = 0; i < points.length; i++) {\n                var p = points[i];\n                point(p[0], p[1]);\n            }\n            }\n            function setStroke(colorString, opacity, weight) {\n            var col = color(colorString);\n            stroke(red(col), green(col), blue(col), opacity);\n            strokeWeight(weight);\n            noFill();\n            }\n            function setFill(colorString, opacity) {\n            var col = color(colorString);\n            fill(red(col), green(col), blue(col), opacity);\n            }\n            function drawGeneration(generation, centerX, centerY, scale) {\n            for (var i = 0; i < props.count; i++) {\n                // determine rotation\n                var rot = radians(i * 360.0 / props.count);\n                // determine offset from center\n                var offset = baseSize * props.offset;\n                offset *= props.offsetGeneration * generation;\n                // determine center\n                var cX = centerX + offset * sin(rot);\n                var cY = centerY + offset * cos(rot);\n                // determine radius of circle - based on generational scaling\n                var rad = baseSize * props.radius * scale;\n                // hide culled generations\n                if (generation >= props.genStart) {\n                // log shape details connections\n                centers.push([cX, cY, rad / 2.0]);\n                // draw\n                if (props.circleOpacity > 0 || props.circleFillOpacity > 0) {\n                    setStroke(props.circleColor, props.circleOpacity, props.circleWeight);\n                    setFill(props.circleFillColor, props.circleFillOpacity);\n                    ellipse(cX, cY, rad, rad);\n                }\n                }\n                // draw generation from this shape\n                if (generation < props.genEnd - 1) {\n                drawGeneration(generation + 1, cX, cY, scale * props.scaleGeneration);\n                }\n            }\n            }\n            /* Adapted from: http://paulbourke.net/geometry/circlesphere/tvoght.c */\n            function circleIntersection(x0, y0, r0, x1, y1, r1) {\n            /* dx and dy are the vertical and horizontal distances between\n                the cirlce centers\n            */\n            var dx = x1 - x0;\n            var dy = y1 - y0;\n            /* Determine the straight-line distance between the centers */\n            var d = dist(x0, y0, x1, y1);\n            /* Check for solvability */\n            if (d > (r0 + r1))\n                return [];\n            if (d < abs(r0 - r1))\n                return [];\n            /* 'point 2' is the point where the line through the circle\n                intersection points crosses the line between the circle\n                centers.\n            */\n            /* Determine the distance from point 0 to point 2 */\n            var a = ((r0 * r0) - (r1 * r1) + (d * d)) / (2.0 * d);\n            /* Determine the coordinates of point 2 */\n            var x2 = x0 + (dx * a / d);\n            var y2 = y0 + (dy * a / d);\n            /* Determine the distance from point 2 to either of the\n                intersection points.\n                */\n            var h = sqrt(r0 * r0 - a * a);\n            /* Now determine the offset of the intersection points from\n                point 2.\n                */\n            var rx = -dy * (h / d);\n            var ry = dx * (h / d);\n            /* Determine the absolute interesction points */\n            return [\n                [x2 + rx, y2 + ry],\n                [x2 - rx, y2 - ry]\n            ];\n            }\n        </script>\n    </body>\n</html>");
};

/* harmony default export */ __webpack_exports__["default"] = (generate);

/***/ }),

/***/ "./tailwind.config.js":
/*!****************************!*\
  !*** ./tailwind.config.js ***!
  \****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

/**
 * You are free to add more sizes as needed, but make sure
 * they are divisible by 2, 4, 8, 16, 32, and/or 64, because
 * these are derived from 'factors of 16'.
 *
 * For example, if you are using `w-32` and you discover that
 * margin/padding of 28 or 40 will not solve your problem,
 * then maybe you need 32+2 or 32+4, so feel free to add 34 or 36.
 *
 * Try to solve your problem without adding sizes. The fact that you
 * appear to need to add a size may indicate a different solution
 * should be looked for. This is true except when working in larger
 * sizes, such as greater than 64. If 128, 256, or 512 do not meet
 * your width/height needs, try 128+64 or 256+128, etc.
 *
 * Also, try to avoid using `style=""` prop unless you know what
 * you're doing because media queries cannot be applied to them.
 *
 * In this project, font-size is 10px for the <html> element,
 * and base font-size is 1.6rem for the <body>. This means `1px`
 * is equal to `0.1rem`, so your math conversions are simple.
 * Use REM and pretend they are pixels but with the decimal shifted
 * by one place. 6.4rem is 64px.
 *
 * This base16 scaling strategy is heavily inspired by the Fibonacci
 * sequence and the golden ratio. Note that 16px to 10px is a rounded
 * version of the ratio 1.618:1. Knowing this, designs tend to be
 * pleasant on the eyes without conscious effort.
 *
 * Tailwind docs: https://next.tailwindcss.com/docs/what-is-tailwind/
 * Atomic design: http://bradfrost.com/blog/post/atomic-web-design/
 *
 */
var availableSizes = {
  1: '0.1rem',
  2: '0.3rem',
  // 1/8 standard-padding/margin
  4: '0.4rem',
  // 1/4 standard-padding/margin
  8: '0.8rem',
  // 1/2 standard-padding/margin
  10: '1.0rem',
  12: '1.2rem',
  // 16 minus 4
  14: '1.4rem',
  // used to align checkboxes with no labels
  16: '1.6rem',
  // 1x standard padding/margin, base font size
  20: '2.0rem',
  // 16 plus 4
  24: '2.4rem',
  28: '2.8rem',
  32: '3.2rem',
  // 2x standard padding/margin
  36: '3.6rem',
  40: '4.0rem',
  // small row height
  48: '4.8rem',
  // standard input row height
  56: '5.6rem',
  // 48+8=56, and 64-8=56
  64: '6.4rem',
  // 4x standard standard padding/margin, standard header height
  72: '7.2rem',
  // 80-8 (aka 64+8)
  80: '8.0rem',
  88: '8.8rem',
  // 80+8 (aka 96-8)
  96: '9.6rem',
  // header row height for H1 headings
  112: '11.2rem',
  128: '12.8rem',
  144: '14.4rem',
  160: '16.0rem',
  // 192-32 (aka 144+16)
  192: '19.2rem',
  224: '22.4rem',
  // 192+32 (aka 256-32)
  256: '25.6rem',
  320: '32.0rem',
  // 256+64
  352: '35.2rem',
  // 256+96
  384: '38.4rem',
  // 256+128
  416: '41.6rem',
  // 384+32 (aka 448-32)
  448: '44.8rem',
  // 256+128+64 (aka 512-64)
  512: '51.2rem',
  640: '64.0rem',
  768: '76.8rem',
  1024: '102.4rem',
  1280: '128.0rem',
  1600: '160.0rem',
  2048: '204.8rem'
};
module.exports = {
  prefix: '',
  important: false,
  separator: ':',
  theme: {
    colors: {
      transparent: 'transparent',
      black: '#000000',
      white: '#ffffff',
      primary: {
        100: '#45A29E',
        200: '#66FCF1'
      },
      grey: {
        100: '#f5f5f5',
        200: '#EAEAEA',
        300: '#E0E0E0',
        325: '#C1C1C1',
        350: '#BDBDBD',
        400: '#B9BCC5',
        450: '#A9A9A9',
        500: '#9F9F9F',
        550: '#777777',
        600: '#656565',
        650: '#5B5C5F',
        700: '#4a5568',
        800: '#2d3748',
        900: '#1a202c',
        1000: '#231f20'
      },
      red: {
        100: '#fff5f5',
        200: '#FFC3CD',
        300: '#feb2b2',
        400: '#fc8181',
        500: '#f56565',
        600: '#e53e3e',
        700: '#c53030',
        800: '#9b2c2c',
        900: '#742a2a'
      },
      orange: {
        100: '#fffaf0',
        200: '#feebc8',
        300: '#fbd38d',
        400: '#f6ad55',
        500: '#ed8936',
        600: '#dd6b20',
        700: '#c05621',
        800: '#9c4221',
        900: '#7b341e'
      },
      yellow: {
        100: '#fffff0',
        200: '#fefcbf',
        300: '#faf089',
        400: '#f6e05e',
        500: '#ecc94b',
        600: '#d69e2e',
        700: '#b7791f',
        800: '#975a16',
        900: '#744210'
      },
      green: {
        100: '#f0fff4',
        200: '#D3FAEA',
        300: '#9ae6b4',
        400: '#68d391',
        500: '#48bb78',
        600: '#38a169',
        700: '#2f855a',
        800: '#276749',
        900: '#22543d',
        money: '#00C058'
      },
      teal: {
        100: '#e6fffa',
        200: '#b2f5ea',
        300: '#81e6d9',
        400: '#4fd1c5',
        500: '#38b2ac',
        600: '#319795',
        700: '#2c7a7b',
        800: '#285e61',
        900: '#234e52'
      },
      // todo: these blues should possibly be reset back to Tailwind's original specifications
      // because they don't gradient smoothly
      blue: {
        100: '#E3EDFF',
        200: '#E4EDFF',
        300: '#90cdf4',
        400: '#4C88FF',
        450: '#63b3ed',
        // original 400
        500: '#0176FF',
        600: '#4299e1',
        700: '#3182ce',
        800: '#2b6cb0',
        900: '#0076FF'
      },
      indigo: {
        100: '#ebf4ff',
        200: '#c3dafe',
        300: '#a3bffa',
        400: '#7f9cf5',
        500: '#667eea',
        600: '#5a67d8',
        700: '#4c51bf',
        800: '#434190',
        900: '#3c366b'
      },
      purple: {
        100: '#faf5ff',
        200: '#e9d8fd',
        300: '#DBD8FF',
        400: '#6C60FF',
        500: '#9f7aea',
        600: '#805ad5',
        700: '#6b46c1',
        800: '#553c9a',
        900: '#44337a'
      },
      // pink: {
      //     100: '#fff5f7',
      //     200: '#fed7e2',
      //     300: '#fbb6ce',
      //     400: '#f687b3',
      //     500: '#ed64a6',
      //     600: '#d53f8c',
      //     700: '#b83280',
      //     800: '#97266d',
      //     900: '#702459',
      // },
      // whitespark pink
      pink: {
        100: '#ffebef',
        200: '#ffbbca',
        300: '#fa7ea8',
        400: '#ee3150',
        500: '#da1233',
        600: '#b90f2b',
        700: '#a10d26',
        800: '#72091b',
        900: '#451225'
      },
      facebook: '#33689B',
      twitter: '#24AAE1',
      instagram: '#D43281',
      youtube: '#CE3334'
    },
    spacing: _objectSpread({
      px: '1px',
      0: '0'
    }, availableSizes),

    /* We are using Bootstrap V4 screen dimensions */
    screens: {
      sm: '576px',
      md: '720px',
      lg: '960px',
      xl: '1140px'
    },
    fontFamily: {
      aroly: ['AROLY'],
      sans: ['Roboto', 'Arial', 'sans-serif'],
      serif: ['Archivo', 'serif'],
      mono: ['Menlo', 'Monaco', 'Consolas', '"Liberation Mono"', '"Courier New"', 'monospace']
    },
    fontSize: {
      // xs: '.75rem',
      // sm: '.875rem',
      // base: '1rem',
      // lg: '1.125rem',
      // xl: '1.25rem',
      // '2xl': '1.5rem',
      // '3xl': '1.875rem',
      // '4xl': '2.25rem',
      // '5xl': '3rem',
      // '6xl': '4rem',
      xs: '1.1rem',
      sm: '1.3rem',
      base: '1.6rem',
      md: '1.9rem',
      lg: '2.4rem',
      xl: '3.4rem',
      '2xl': '4.8rem',
      '3xl': '6.4rem',
      '4xl': '1.6rem',
      '5xl': '1.6rem',
      10: '1.0rem',
      11: '1.1rem',
      12: '1.2rem',
      13: '1.3rem',
      14: '1.4rem',
      15: '1.5rem',
      16: '1.6rem',
      17: '1.7rem',
      18: '1.8rem',
      19: '1.9rem',
      20: '2.0rem',
      24: '2.4rem',
      34: '3.4rem' // 36: '3.6rem',

    },
    fontWeight: {
      hairline: 100,
      thin: 200,
      light: 300,
      normal: 400,
      medium: 500,
      semibold: 600,
      bold: 700,
      extrabold: 800,
      black: 900
    },
    lineHeight: {
      none: 1,
      tight: 1.25,
      snug: 1.375,
      normal: 1.5,
      relaxed: 1.625,
      loose: 2
    },
    letterSpacing: {
      tight: '-.0618em',
      normal: '0',
      wide: '0.1em'
    },
    textColor: function textColor(theme) {
      return theme('colors');
    },
    backgroundColor: function backgroundColor(theme) {
      return theme('colors');
    },
    backgroundPosition: {
      bottom: 'bottom',
      center: 'center',
      left: 'left',
      'left-bottom': 'left bottom',
      'left-top': 'left top',
      right: 'right',
      'right-bottom': 'right bottom',
      'right-top': 'right top',
      top: 'top'
    },
    backgroundSize: {
      auto: 'auto',
      cover: 'cover',
      contain: 'contain'
    },
    borderWidth: {
      "default": '1px',
      0: '0',
      1: '1px',
      2: '2px',
      3: '3px',
      4: '4px' // '8': '8px',

    },
    borderColor: function borderColor(theme) {
      // eslint-disable-line arrow-body-style
      return global.Object.assign({
        "default": theme('colors.grey.300', 'currentColor')
      }, theme('colors')); // eslint-disable-line prefer-object-spread
    },
    borderRadius: {
      none: '0',
      sm: '0.6rem',
      "default": '1.5rem',
      lg: '1.5rem',
      full: '9999px'
    },
    cursor: {
      auto: 'auto',
      "default": 'default',
      pointer: 'pointer',
      wait: 'wait',
      move: 'move',
      'not-allowed': 'not-allowed'
    },
    width: function width(theme) {
      return _objectSpread({
        auto: 'auto'
      }, theme('spacing'), {
        '1/2': '50%',
        '1/3': '33.33333%',
        '2/3': '66.66667%',
        '1/4': '25%',
        '3/4': '75%',
        '1/5': '20%',
        '2/5': '40%',
        '3/5': '60%',
        '4/5': '80%',
        '1/6': '16.66667%',
        '5/6': '83.33333%',
        full: '100%',
        screen: '100vw',
        'truncated-cell': '95%'
      });
    },
    height: function height(theme) {
      return _objectSpread({
        auto: 'auto'
      }, theme('spacing'), {
        'row-sm': '4.0rem',
        row: '4.8rem',
        full: '100%',
        screen: '100vh',
        page: 'calc(100vh - 6.4rem)',
        // minus nav-topbar h-64
        'modal-full': 'calc(100vh - 5%)' // used to make modals full-screen minus some top/bottom margin

      });
    },
    minWidth: function minWidth(theme) {
      return _objectSpread({
        0: '0'
      }, theme('spacing'), {
        screen: '100vw',
        full: '100%'
      });
    },
    minHeight: function minHeight(theme) {
      return _objectSpread({
        0: '0'
      }, theme('spacing'), {
        'row-sm': '3.2rem',
        row: '4.8rem',
        full: '100%',
        screen: '100vh',
        page: 'calc(100vh - 6.4rem)' // minus nav-topbar h-64

      });
    },
    maxWidth: function maxWidth(theme) {
      return _objectSpread({
        // these should be setup to base16 scaling
        xs: '20rem',
        sm: '24rem',
        md: '28rem',
        lg: '32rem',
        xl: '36rem',
        '2xl': '42rem',
        '3xl': '48rem',
        '4xl': '56rem',
        '5xl': '64rem',
        '6xl': '72rem',
        full: '100%'
      }, theme('spacing'));
    },
    maxHeight: function maxHeight(theme) {
      return _objectSpread({
        row: '4.8rem',
        full: '100%',
        screen: '100vh',
        page: 'calc(100vh - 6.4rem)'
      }, theme('spacing'));
    },
    padding: function padding(theme) {
      return theme('spacing');
    },
    margin: function margin(theme) {
      return _objectSpread({
        auto: 'auto'
      }, theme('spacing'));
    },
    negativeMargin: function negativeMargin(theme) {
      return theme('spacing');
    },
    objectPosition: {
      bottom: 'bottom',
      center: 'center',
      left: 'left',
      'left-bottom': 'left bottom',
      'left-top': 'left top',
      right: 'right',
      'right-bottom': 'right bottom',
      'right-top': 'right top',
      top: 'top'
    },
    boxShadow: {
      "default": '0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06)',
      md: '0 4px 6px -1px rgba(0, 0, 0, .1), 0 2px 4px -1px rgba(0, 0, 0, .06)',
      lg: '0 10px 15px -3px rgba(0, 0, 0, .1), 0 4px 6px -2px rgba(0, 0, 0, .05)',
      'lg-primary': '0 15px 30px 0 rgba(238, 49, 80,0.24), 0 5px 15px 0 rgba(238, 49, 80,0.20)',
      'lg-secondary': '0 15px 30px 0 rgba(0,0,0,0.11), 0 5px 15px 0 rgba(0,0,0,0.08)',
      xl: '0 20px 25px -5px rgba(0, 0, 0, .1), 0 10px 10px -5px rgba(0, 0, 0, .04)',
      '2xl': '0 25px 50px -12px rgba(0, 0, 0, .25)',
      inner: 'inset 0 2px 4px 0 rgba(0,0,0,0.06)',
      outline: '0 0 0 3px rgba(66,153,225,0.5)',
      none: 'none'
    },
    zIndex: {
      auto: 'auto',
      0: 0,
      10: 10,
      20: 20,
      30: 30,
      40: 40,
      50: 50
    },
    opacity: {
      0: '0',
      25: '.25',
      50: '.5',
      75: '.75',
      100: '1'
    },
    fill: {
      current: 'currentColor'
    },
    stroke: {
      current: 'currentColor'
    },
    flex: {
      0: '0',
      1: '1',
      auto: '1 1 auto',
      initial: '0 1 auto',
      none: 'none'
    },
    flexGrow: {
      0: 0,
      "default": 1
    },
    flexShrink: {
      0: 0,
      "default": 1
    },
    listStyleType: {
      none: 'none',
      disc: 'disc',
      decimal: 'decimal'
    },
    inset: {
      0: 0,
      auto: 'auto'
    },
    container: {}
  },
  variants: {
    appearance: ['responsive'],
    backgroundAttachment: ['responsive'],
    backgroundColor: ['responsive', 'hover', 'focus', 'active'],
    backgroundPosition: ['responsive'],
    backgroundRepeat: ['responsive'],
    backgroundSize: ['responsive'],
    borderCollapse: [],
    borderColor: ['responsive', 'hover', 'focus'],
    borderRadius: ['responsive', 'hover'],
    borderStyle: ['responsive', 'hover'],
    borderWidth: ['responsive', 'hover'],
    cursor: ['responsive'],
    display: ['responsive'],
    flexDirection: ['responsive'],
    flexWrap: ['responsive'],
    alignItems: ['responsive'],
    alignSelf: ['responsive'],
    justifyContent: ['responsive'],
    alignContent: ['responsive'],
    flex: ['responsive'],
    flexGrow: ['responsive'],
    flexShrink: ['responsive'],
    "float": ['responsive'],
    fontFamily: ['responsive'],
    fontWeight: ['responsive', 'hover', 'focus'],
    height: ['responsive'],
    lineHeight: ['responsive'],
    listStylePosition: ['responsive'],
    listStyleType: ['responsive'],
    margin: ['responsive'],
    maxHeight: ['responsive'],
    maxWidth: ['responsive'],
    minHeight: ['responsive'],
    minWidth: ['responsive'],
    negativeMargin: ['responsive'],
    objectFit: ['responsive'],
    objectPosition: ['responsive'],
    opacity: ['responsive', 'hover'],
    outline: ['focus', 'active'],
    overflow: ['responsive'],
    padding: ['responsive'],
    pointerEvents: ['responsive'],
    position: ['responsive'],
    inset: ['responsive'],
    resize: ['responsive'],
    boxShadow: ['responsive', 'hover', 'focus'],
    fill: [],
    stroke: [],
    tableLayout: ['responsive'],
    textAlign: ['responsive'],
    textColor: ['responsive', 'hover', 'focus', 'active'],
    fontSize: ['responsive'],
    fontStyle: ['responsive'],
    textTransform: ['responsive'],
    textDecoration: ['responsive', 'hover', 'focus'],
    fontSmoothing: ['responsive'],
    letterSpacing: ['responsive'],
    userSelect: ['responsive'],
    verticalAlign: ['responsive'],
    visibility: ['responsive'],
    whitespace: ['responsive'],
    wordBreak: ['responsive'],
    width: ['responsive'],
    zIndex: ['responsive']
  },
  corePlugins: {
    container: false // todo: explore this in the future

  },
  plugins: [function (_ref) {
    var addUtilities = _ref.addUtilities;
    return addUtilities({
      '.outline-pink-400': {
        // outline: 'none',
        outline: '1px solid',
        outlineColor: module.exports.theme.colors.pink[400],
        boxShadow: "0px 0px 8px 0px ".concat(module.exports.theme.colors.pink[400])
      }
    });
  }]
};
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./node_modules/webpack/buildin/global.js */ "./node_modules/webpack/buildin/global.js")))

/***/ })

}]);