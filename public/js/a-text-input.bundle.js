(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["a-text-input"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/a-text-input.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/a-text-input.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vee_validate__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vee-validate */ "./node_modules/vee-validate/dist/vee-validate.esm.js");
/* harmony import */ var _globalStateTypes__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../globalStateTypes */ "./resources/js/globalStateTypes.js");
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


var SUPPORTED_INPUT_SIZES = Object.values(_globalStateTypes__WEBPACK_IMPORTED_MODULE_1__["InputSize"]);
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'a-text-input',
  components: {
    ValidationProvider: vee_validate__WEBPACK_IMPORTED_MODULE_0__["ValidationProvider"]
  },
  props: {
    vid: {
      type: String,
      required: false,
      "default": function _default() {
        return undefined;
      }
    },
    rules: {
      type: [Object, String, Date],
      "default": function _default() {
        return '';
      }
    },
    // must be included in props
    value: {
      type: [String, Number],
      required: false,
      "default": function _default() {
        return '';
      }
    },
    title: {
      type: String,
      required: false,
      "default": function _default() {
        return undefined;
      }
    },
    type: {
      type: String,
      required: false,
      "default": function _default() {
        return 'text';
      }
    },
    size: {
      type: String,
      required: false,
      "default": function _default() {
        return _globalStateTypes__WEBPACK_IMPORTED_MODULE_1__["InputSize"].DEFAULT;
      }
    },
    expanded: {
      type: Boolean,
      required: false,
      "default": function _default() {
        return true;
      }
    },
    required: {
      type: Boolean,
      required: false,
      "default": function _default() {
        return false;
      }
    },
    disabled: {
      type: Boolean,
      required: false,
      "default": function _default() {
        return false;
      }
    },
    passwordReveal: {
      type: Boolean,
      required: false,
      "default": function _default() {
        return false;
      }
    },
    loading: {
      type: Boolean,
      required: false,
      "default": function _default() {
        return false;
      }
    },
    rounded: {
      type: Boolean,
      required: false,
      "default": function _default() {
        return false;
      }
    },
    iconPack: {
      type: String,
      required: false,
      "default": function _default() {
        return 'fas';
      }
    },
    icon: {
      type: String,
      required: false,
      "default": function _default() {
        return undefined;
      }
    },
    placeholder: {
      type: String,
      required: false,
      "default": function _default() {
        return '';
      }
    },
    maxlength: {
      type: [Number, String],
      required: false,
      "default": function _default() {
        return undefined;
      }
    },
    hasCounter: {
      type: Boolean,
      required: false,
      "default": function _default() {
        return false;
      }
    },
    customClass: {
      type: String,
      required: false,
      "default": function _default() {
        return '';
      }
    }
  },
  data: function data() {
    return {
      InputContext: _globalStateTypes__WEBPACK_IMPORTED_MODULE_1__["InputContext"],
      innerValue: ''
    };
  },
  computed: {
    hasRulesWithoutVid: function hasRulesWithoutVid() {
      return !this.vid && !!this.rules;
    }
  },
  watch: {
    // handles internal model changes
    innerValue: function innerValue(newVal) {
      return this.$emit('input', newVal);
    },
    // handles external model changes
    value: function value(newVal) {
      this.innerValue = newVal;
    },
    size: function size() {
      if (!SUPPORTED_INPUT_SIZES.includes(this.size)) {
        throw new Error("ws-text-input# Illegal size '".concat(this.size, "', expected one of [").concat(SUPPORTED_INPUT_SIZES, "]."));
      }
    }
  },
  created: function created() {
    if (this.value) {
      this.innerValue = this.value;
    }

    if (!SUPPORTED_INPUT_SIZES.includes(this.size)) {
      throw new Error("ws-text-input# Illegal size '".concat(this.size, "', expected one of [").concat(SUPPORTED_INPUT_SIZES, "]."));
    }

    if (this.hasRulesWithoutVid) {
      throw new Error('ws-text-input# If you specify validation \'rules\' prop, you must also use the \'vid\' prop.');
    }
  },
  methods: {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/a-text-input.vue?vue&type=template&id=86c6b63e&":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/a-text-input.vue?vue&type=template&id=86c6b63e& ***!
  \***************************************************************************************************************************************************************************************************************/
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
    [
      _c("validation-provider", {
        attrs: { vid: _vm.vid, name: _vm.vid, rules: _vm.rules },
        scopedSlots: _vm._u([
          {
            key: "default",
            fn: function(ref) {
              var _obj

              var errors = ref.errors
              var valid = ref.valid
              return [
                _c(
                  "b-field",
                  _vm._b(
                    {
                      attrs: {
                        type:
                          ((_obj = {}),
                          (_obj[_vm.InputContext.DEFAULT] = false),
                          (_obj[_vm.InputContext.NEGATIVE] = errors[0]),
                          (_obj[_vm.InputContext.POSITIVE] = false),
                          (_obj[_vm.InputContext.INFO] = false),
                          (_obj[_vm.InputContext.WARN] = false),
                          _obj),
                        message: errors
                      }
                    },
                    "b-field",
                    _vm.$attrs,
                    false
                  ),
                  [
                    _c(
                      "b-input",
                      _vm._g(
                        _vm._b(
                          {
                            ref: "textInput",
                            attrs: {
                              name: _vm.vid,
                              type: _vm.type,
                              size: _vm.size,
                              expanded: _vm.expanded,
                              required: _vm.required,
                              disabled: _vm.disabled,
                              "password-reveal": _vm.passwordReveal,
                              loading: _vm.loading,
                              "icon-pack": _vm.iconPack,
                              icon: _vm.icon,
                              placeholder: _vm.placeholder,
                              maxlength: _vm.maxlength,
                              "has-counter": _vm.hasCounter,
                              "custom-class": _vm.customClass,
                              rounded: _vm.rounded
                            },
                            model: {
                              value: _vm.innerValue,
                              callback: function($$v) {
                                _vm.innerValue = $$v
                              },
                              expression: "innerValue"
                            }
                          },
                          "b-input",
                          _vm.$attrs,
                          false
                        ),
                        _vm.$listeners
                      )
                    )
                  ],
                  1
                )
              ]
            }
          }
        ])
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/a-text-input.vue":
/*!**************************************************!*\
  !*** ./resources/js/components/a-text-input.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _a_text_input_vue_vue_type_template_id_86c6b63e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./a-text-input.vue?vue&type=template&id=86c6b63e& */ "./resources/js/components/a-text-input.vue?vue&type=template&id=86c6b63e&");
/* harmony import */ var _a_text_input_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./a-text-input.vue?vue&type=script&lang=js& */ "./resources/js/components/a-text-input.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _a_text_input_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _a_text_input_vue_vue_type_template_id_86c6b63e___WEBPACK_IMPORTED_MODULE_0__["render"],
  _a_text_input_vue_vue_type_template_id_86c6b63e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/a-text-input.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/a-text-input.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/a-text-input.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_a_text_input_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./a-text-input.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/a-text-input.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_a_text_input_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/a-text-input.vue?vue&type=template&id=86c6b63e&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/a-text-input.vue?vue&type=template&id=86c6b63e& ***!
  \*********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_a_text_input_vue_vue_type_template_id_86c6b63e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./a-text-input.vue?vue&type=template&id=86c6b63e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/a-text-input.vue?vue&type=template&id=86c6b63e&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_a_text_input_vue_vue_type_template_id_86c6b63e___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_a_text_input_vue_vue_type_template_id_86c6b63e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/globalStateTypes.js":
/*!******************************************!*\
  !*** ./resources/js/globalStateTypes.js ***!
  \******************************************/
/*! exports provided: FormMethod, InputContext, InputSize, Category, Example */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "FormMethod", function() { return FormMethod; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "InputContext", function() { return InputContext; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "InputSize", function() { return InputSize; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Category", function() { return Category; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Example", function() { return Example; });
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
var Category = {
  STATUS_INACTIVE: 0,
  STATUS_ACTIVE: 1
};
var Example = {
  STATUS_INACTIVE: 0,
  STATUS_ACTIVE: 1
};

/***/ })

}]);