(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["a-tilt"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/a-tilt.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/a-tilt.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
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
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'a-tilt',
  props: {
    max: {
      type: Number,
      required: false,
      "default": function _default() {
        return 5;
      }
    },
    perspective: {
      type: Number,
      required: false,
      "default": function _default() {
        return 1000;
      }
    },
    reverse: {
      type: Boolean,
      required: false,
      "default": function _default() {
        return true;
      }
    }
  },
  data: function data() {
    return {
      timer: undefined
    };
  },
  computed: {
    reverseValue: function reverseValue() {
      return this.reverse ? -1 : 1;
    }
  },
  mounted: function mounted() {
    this.$el.style.cssText = "\n            transform-origin: center;\n            will-change: transform;\n        ";
  },
  methods: {
    getPosition: function getPosition(el) {
      var _el$getBoundingClient = el.getBoundingClientRect(),
          left = _el$getBoundingClient.left,
          top = _el$getBoundingClient.top,
          width = _el$getBoundingClient.width,
          height = _el$getBoundingClient.height;

      return {
        left: left,
        top: top,
        width: width,
        height: height
      };
    },
    toggleTransition: function toggleTransition() {
      var _this = this;

      if (this.timer) {
        clearTimeout(this.timer);
      }

      this.$el.style.transition = 'all 150ms cubic-bezier(.03,.98,.52,.99)';
      this.timer = setTimeout(function () {
        _this.$el.style.transition = '';
      }, 150);
    },
    handleMouseEnter: function handleMouseEnter() {
      return this.toggleTransition();
    },
    handleMouseMove: function handleMouseMove(e) {
      var _this$getPosition = this.getPosition(this.$el),
          left = _this$getPosition.left,
          top = _this$getPosition.top;

      var x = Math.min((e.clientX - left) / this.$el.offsetWidth, 1);
      var y = Math.min((e.clientY - top) / this.$el.offsetHeight, 1);
      var X = this.reverseValue * (this.max / 2 - x * this.max);
      var Y = this.reverseValue * (y * this.max - this.max / 2);
      this.$el.style.transform = "perspective(".concat(this.perspective, "px) rotateX(").concat(Y, "deg) rotateY(").concat(X, "deg)");
    },
    handleMouseLeave: function handleMouseLeave() {
      this.toggleTransition();
      this.$el.style.transform = "perspective(".concat(this.perspective, "px) rotateX(0) rotateY(0)");
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/a-tilt.vue?vue&type=template&id=26d5de34&":
/*!*********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/a-tilt.vue?vue&type=template&id=26d5de34& ***!
  \*********************************************************************************************************************************************************************************************************/
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
  return _c(
    "div",
    {
      on: {
        mouseenter: _vm.handleMouseEnter,
        mousemove: _vm.handleMouseMove,
        mouseleave: _vm.handleMouseLeave
      }
    },
    [_vm._t("default")],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/a-tilt.vue":
/*!********************************************!*\
  !*** ./resources/js/components/a-tilt.vue ***!
  \********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _a_tilt_vue_vue_type_template_id_26d5de34___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./a-tilt.vue?vue&type=template&id=26d5de34& */ "./resources/js/components/a-tilt.vue?vue&type=template&id=26d5de34&");
/* harmony import */ var _a_tilt_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./a-tilt.vue?vue&type=script&lang=js& */ "./resources/js/components/a-tilt.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _a_tilt_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _a_tilt_vue_vue_type_template_id_26d5de34___WEBPACK_IMPORTED_MODULE_0__["render"],
  _a_tilt_vue_vue_type_template_id_26d5de34___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/a-tilt.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/a-tilt.vue?vue&type=script&lang=js&":
/*!*********************************************************************!*\
  !*** ./resources/js/components/a-tilt.vue?vue&type=script&lang=js& ***!
  \*********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_a_tilt_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./a-tilt.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/a-tilt.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_a_tilt_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/a-tilt.vue?vue&type=template&id=26d5de34&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/a-tilt.vue?vue&type=template&id=26d5de34& ***!
  \***************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_a_tilt_vue_vue_type_template_id_26d5de34___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./a-tilt.vue?vue&type=template&id=26d5de34& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/a-tilt.vue?vue&type=template&id=26d5de34&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_a_tilt_vue_vue_type_template_id_26d5de34___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_a_tilt_vue_vue_type_template_id_26d5de34___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);