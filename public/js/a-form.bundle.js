(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["a-form"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/a-form.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/a-form.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vee_validate__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vee-validate */ "./node_modules/vee-validate/dist/vee-validate.esm.js");
/* harmony import */ var _mixins_csrfToken__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./mixins/csrfToken */ "./resources/js/components/mixins/csrfToken.js");
/* harmony import */ var _globalStateTypes__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../globalStateTypes */ "./resources/js/globalStateTypes.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

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



var SUPPORTED_FORM_METHODS = Object.values(_globalStateTypes__WEBPACK_IMPORTED_MODULE_3__["FormMethod"]);
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'a-form',
  components: {
    ValidationObserver: vee_validate__WEBPACK_IMPORTED_MODULE_1__["ValidationObserver"]
  },
  mixins: [_mixins_csrfToken__WEBPACK_IMPORTED_MODULE_2__["default"]],
  props: {
    method: {
      type: String,
      required: false,
      "default": function _default() {
        return _globalStateTypes__WEBPACK_IMPORTED_MODULE_3__["FormMethod"].GET;
      }
    },
    name: {
      type: String,
      required: false,
      "default": function _default() {
        return undefined;
      }
    },
    action: {
      type: String,
      required: false,
      "default": function _default() {
        return undefined;
      }
    },
    hasFiles: {
      type: Boolean,
      required: false,
      "default": function _default() {
        return false;
      }
    },
    submit: {
      type: Function,
      required: false,
      "default": function _default() {
        return false;
      }
    }
  },
  data: function data() {
    return {
      FormMethod: _globalStateTypes__WEBPACK_IMPORTED_MODULE_3__["FormMethod"]
    };
  },
  computed: {
    isMethodPost: function isMethodPost() {
      return this.method === _globalStateTypes__WEBPACK_IMPORTED_MODULE_3__["FormMethod"].POST;
    },
    isMethodPut: function isMethodPut() {
      return this.method === _globalStateTypes__WEBPACK_IMPORTED_MODULE_3__["FormMethod"].PUT;
    },
    isMethodDelete: function isMethodDelete() {
      return this.method === _globalStateTypes__WEBPACK_IMPORTED_MODULE_3__["FormMethod"].DELETE;
    },
    hasAction: function hasAction() {
      return !!this.action;
    },
    computedMethod: function computedMethod() {
      if (this.method === _globalStateTypes__WEBPACK_IMPORTED_MODULE_3__["FormMethod"].GET) return _globalStateTypes__WEBPACK_IMPORTED_MODULE_3__["FormMethod"].GET;
      return _globalStateTypes__WEBPACK_IMPORTED_MODULE_3__["FormMethod"].POST; // works for POST, PUT, and DELETE
    },
    formEncType: function formEncType() {
      // currently unused: 'text/plain'
      if (this.hasFiles) return 'multipart/form-data';
      return 'application/x-www-form-urlencoded';
    }
  },
  watch: {
    method: function method() {
      return this.validateFormMethod();
    }
  },
  created: function created() {
    return this.validateFormMethod();
  },
  mounted: function mounted() {
    return this.$emit('mounted');
  },
  methods: {
    validateFormMethod: function validateFormMethod() {
      if (!SUPPORTED_FORM_METHODS.includes(this.method)) {
        throw new Error("a-form# Illegal method '".concat(this.method, "', expected one of [").concat(SUPPORTED_FORM_METHODS, "]."));
      }
    },
    onSubmit: function onSubmit(event) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var isValid;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return _this.$refs.observer.validate();

              case 2:
                isValid = _context.sent;

                if (isValid) {
                  _context.next = 7;
                  break;
                }

                return _context.abrupt("return", event.preventDefault());

              case 7:
                if (!(_this.submit !== false)) {
                  _context.next = 10;
                  break;
                }

                event.preventDefault();
                return _context.abrupt("return", _this.submit());

              case 10:
                return _context.abrupt("return", undefined);

              case 11:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/a-form.vue?vue&type=template&id=8075868a&":
/*!*********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/a-form.vue?vue&type=template&id=8075868a& ***!
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
    "validation-observer",
    _vm._g(
      _vm._b(
        {
          ref: "observer",
          attrs: {
            tag: "form",
            action: _vm.action,
            enctype: _vm.formEncType,
            method: _vm.computedMethod,
            name: _vm.name
          },
          on: { submit: _vm.onSubmit },
          scopedSlots: _vm._u(
            [
              {
                key: "default",
                fn: function(ref) {
                  var dirty = ref.dirty
                  var pristine = ref.pristine
                  var valid = ref.valid
                  var invalid = ref.invalid
                  var pending = ref.pending
                  var touched = ref.touched
                  var untouched = ref.untouched
                  var errors = ref.errors
                  var validate = ref.validate
                  var reset = ref.reset
                  var handleSubmit = ref.handleSubmit
                  return [
                    _vm.hasAction
                      ? _c("input", {
                          attrs: { name: "_token", type: "hidden" },
                          domProps: { value: _vm.csrf }
                        })
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.hasAction && _vm.isMethodPut
                      ? _c("input", {
                          attrs: { name: "_method", type: "hidden" },
                          domProps: { value: _vm.FormMethod.PUT }
                        })
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.hasAction && _vm.isMethodDelete
                      ? _c("input", {
                          attrs: { name: "_method", type: "hidden" },
                          domProps: { value: _vm.FormMethod.DELETE }
                        })
                      : _vm._e(),
                    _vm._v(" "),
                    _vm._t("default", null, {
                      dirty: dirty,
                      errors: errors,
                      invalid: invalid,
                      pending: pending,
                      pristine: pristine,
                      reset: reset,
                      touched: touched,
                      untouched: untouched,
                      valid: valid,
                      validate: validate,
                      handleSubmit: handleSubmit
                    })
                  ]
                }
              }
            ],
            null,
            true
          )
        },
        "validation-observer",
        _vm.$attrs,
        false
      ),
      _vm.$listeners
    )
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/a-form.vue":
/*!********************************************!*\
  !*** ./resources/js/components/a-form.vue ***!
  \********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _a_form_vue_vue_type_template_id_8075868a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./a-form.vue?vue&type=template&id=8075868a& */ "./resources/js/components/a-form.vue?vue&type=template&id=8075868a&");
/* harmony import */ var _a_form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./a-form.vue?vue&type=script&lang=js& */ "./resources/js/components/a-form.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _a_form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _a_form_vue_vue_type_template_id_8075868a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _a_form_vue_vue_type_template_id_8075868a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/a-form.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/a-form.vue?vue&type=script&lang=js&":
/*!*********************************************************************!*\
  !*** ./resources/js/components/a-form.vue?vue&type=script&lang=js& ***!
  \*********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_a_form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./a-form.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/a-form.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_a_form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/a-form.vue?vue&type=template&id=8075868a&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/a-form.vue?vue&type=template&id=8075868a& ***!
  \***************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_a_form_vue_vue_type_template_id_8075868a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./a-form.vue?vue&type=template&id=8075868a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/a-form.vue?vue&type=template&id=8075868a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_a_form_vue_vue_type_template_id_8075868a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_a_form_vue_vue_type_template_id_8075868a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/mixins/csrfToken.js":
/*!*****************************************************!*\
  !*** ./resources/js/components/mixins/csrfToken.js ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var csrfToken = {
  data: function data() {
    return {
      csrf: document.head.querySelector('meta[name="csrf-token"]').content
    };
  }
};
/* harmony default export */ __webpack_exports__["default"] = (csrfToken);

/***/ }),

/***/ "./resources/js/globalStateTypes.js":
/*!******************************************!*\
  !*** ./resources/js/globalStateTypes.js ***!
  \******************************************/
/*! exports provided: FormMethod, InputContext, InputSize */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "FormMethod", function() { return FormMethod; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "InputContext", function() { return InputContext; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "InputSize", function() { return InputSize; });
// form actions
var FormMethod = {
  GET: 'get',
  POST: 'post',
  PUT: 'put',
  DELETE: 'delete'
}; // theme context

var InputContext = {
  DEFAULT: 'is-default',
  WARN: 'is-warning',
  NEGATIVE: 'is-danger',
  POSITIVE: 'is-success',
  INFO: 'is-info',
  DISABLED: 'disabled'
};
var InputSize = {
  SMALL: 'is-small',
  DEFAULT: 'is-default',
  MEDIUM: 'is-medium',
  LARGE: 'is-large'
};

/***/ })

}]);