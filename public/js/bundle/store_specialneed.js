(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["store_specialneed"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/views/app/pages/specialneeds/Add_specialneed.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/src/views/app/pages/specialneeds/Add_specialneed.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_upload_multiple_image__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-upload-multiple-image */ "./node_modules/vue-upload-multiple-image/src/main.js");
/* harmony import */ var _johmun_vue_tags_input__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @johmun/vue-tags-input */ "./node_modules/@johmun/vue-tags-input/dist/vue-tags-input.js");
/* harmony import */ var _johmun_vue_tags_input__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_johmun_vue_tags_input__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var nprogress__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! nprogress */ "./node_modules/nprogress/nprogress.js");
/* harmony import */ var nprogress__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(nprogress__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var vue2_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! vue2-editor */ "./node_modules/vue2-editor/dist/vue2-editor.esm.js");
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

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




/* harmony default export */ __webpack_exports__["default"] = ({
  metaInfo: {
    title: "Create specialneed"
  },
  data: function data() {
    return {
      tag: "",
      len: 8,
      images: [],
      imageArray: [],
      selectedOptions: {},
      change: false,
      isLoading: true,
      SubmitProcessing: false,
      data: new FormData(),
      specialneeds: [],
      areas: [],
      roles: {},
      facilites: [],
      specialneed_types: [],
      sections: [],
      specialneed: {
        area_id: "",
        ar_name: "",
        en_name: "",
        institution_id: "",
        url: "",
        phone: "",
        share: "",
        en_info: "",
        ar_info: "",
        facilities_ar: "",
        facilities_en: "",
        activities_ar: "",
        activities_en: "",
        image: "",
        lat: "",
        "long": "",
        second_lang: "",
        first_lang: "",
        other_lang: "",
        years_accepted: "",
        weekend: "",
        expFrom: "",
        expTo: "",
        children_numbers: "",
        is_accept: ""
      },
      code_exist: ""
    };
  },
  components: {
    VueEditor: vue2_editor__WEBPACK_IMPORTED_MODULE_3__["VueEditor"],
    VueUploadMultipleImage: vue_upload_multiple_image__WEBPACK_IMPORTED_MODULE_0__["default"],
    VueTagsInput: _johmun_vue_tags_input__WEBPACK_IMPORTED_MODULE_1___default.a
  },
  methods: {
    sendData: function sendData() {
      var _this = this;

      var postData = Object.entries(this.selectedOptions).map(function (_ref) {
        var _ref2 = _slicedToArray(_ref, 2),
            sectionId = _ref2[0],
            selectedIds = _ref2[1];

        var section = _this.sections.find(function (section) {
          return section.id === parseInt(sectionId);
        });

        return {
          section_name: section.en_name,
          selected_ids: selectedIds
        };
      });
      console.log(postData);
    },
    addFacilites: function addFacilites() {
      this.facilites.push({
        value: ''
      });
    },
    removeFromArrayF: function removeFromArrayF(index) {
      if (index >= 0 && index < this.facilites.length) {
        this.facilites.splice(index, 1);
      }
    },
    //------------- Submit Validation Create Specialneed
    Submit_Specialneed: function Submit_Specialneed() {
      var _this2 = this;

      // this.sendData()
      this.$refs.Create_Specialneed.validate().then(function (success) {
        if (!success) {
          _this2.makeToast("danger", _this2.$t("Please_fill_the_form_correctly"), _this2.$t("Failed"));
        } else {
          _this2.Create_Specialneed();
        }
      });
    },
    //------ Toast
    makeToast: function makeToast(variant, msg, title) {
      this.$root.$bvToast.toast(msg, {
        title: title,
        variant: variant,
        solid: true
      });
    },
    //------ Validation State
    getValidationState: function getValidationState(_ref3) {
      var dirty = _ref3.dirty,
          validated = _ref3.validated,
          _ref3$valid = _ref3.valid,
          valid = _ref3$valid === void 0 ? null : _ref3$valid;
      return dirty || validated ? valid : null;
    },
    //------Show Notification If Variant is Duplicate
    showNotifDuplicate: function showNotifDuplicate() {
      this.makeToast("warning", this.$t("VariantDuplicate"), this.$t("Warning"));
    },
    //------ Event upload Image Success
    uploadImageSuccess: function uploadImageSuccess(formData, index, fileList, imageArray) {
      this.images = fileList;
    },
    //------ Event before Remove Image
    beforeRemove: function beforeRemove(index, done, fileList) {
      var remove = confirm("remove image");

      if (remove == true) {
        this.images = fileList;
        done();
      } else {}
    },
    //-------------- Specialneed Get Elements
    GetElements: function GetElements() {
      var _this3 = this;

      axios.get("Specialneeds/create").then(function (response) {
        _this3.specialneeds = response.data.specialneeds;
        _this3.areas = response.data.areas;
        _this3.isLoading = false;
      })["catch"](function (response) {
        setTimeout(function () {
          _this3.isLoading = false;
        }, 500);

        _this3.makeToast("danger", _this3.$t("InvalidData"), _this3.$t("Failed"));
      });
    },
    getSecions: function getSecions() {
      var _this4 = this;

      axios.get("drops/list/data?type=SPECIALNEEDS").then(function (response) {
        _this4.sections = response.data.SECIONS;
      })["catch"](function (response) {
        setTimeout(function () {
          _this4.isLoading = false;
        }, 500);

        _this4.makeToast("danger", _this4.$t("InvalidData"), _this4.$t("Failed"));
      });
    },
    //------------------------------ Create new Specialneed ------------------------------\
    Create_Specialneed: function Create_Specialneed() {
      var _this5 = this;

      // Start the progress bar.
      nprogress__WEBPACK_IMPORTED_MODULE_2___default.a.start();
      nprogress__WEBPACK_IMPORTED_MODULE_2___default.a.set(0.1);
      var self = this;
      self.SubmitProcessing = true; // append objet specialneed

      Object.entries(self.specialneed).forEach(function (_ref4) {
        var _ref5 = _slicedToArray(_ref4, 2),
            key = _ref5[0],
            value = _ref5[1];

        self.data.append(key, value);
      });
      var allSelectedIds = Object.values(this.selectedOptions).flat();
      self.data.append('selected_ids', JSON.stringify(allSelectedIds)); //append array images

      if (self.images.length > 0) {
        for (var k = 0; k < self.images.length; k++) {
          Object.entries(self.images[k]).forEach(function (_ref6) {
            var _ref7 = _slicedToArray(_ref6, 2),
                key = _ref7[0],
                value = _ref7[1];

            self.data.append("images[" + k + "][" + key + "]", value);
          });
        }
      } // Send Data with axios


      axios.post("Specialneeds", self.data).then(function (response) {
        console.log(_this5.selectedOptions); // Complete the animation of theprogress bar.

        nprogress__WEBPACK_IMPORTED_MODULE_2___default.a.done();
        self.SubmitProcessing = false;

        _this5.$router.push({
          name: "index_specialneeds"
        });

        _this5.makeToast("success", _this5.$t("Successfully_Created"), _this5.$t("Success"));
      })["catch"](function (error) {
        // Complete the animation of theprogress bar.
        nprogress__WEBPACK_IMPORTED_MODULE_2___default.a.done();

        if (error.errors.code.length > 0) {
          self.code_exist = error.errors.code[0];
        }

        _this5.makeToast("danger", _this5.$t("InvalidData"), _this5.$t("Failed"));

        self.SubmitProcessing = false;
      });
    }
  },
  //end Methods
  //-----------------------------Created function-------------------
  created: function created() {
    this.GetElements();
    this.getSecions();
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/views/app/pages/specialneeds/Add_specialneed.vue?vue&type=template&id=164fede3&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/src/views/app/pages/specialneeds/Add_specialneed.vue?vue&type=template&id=164fede3& ***!
  \*************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "main-content" },
    [
      _c("breadcumb", {
        attrs: {
          page: _vm.$t("AddSpecialneed"),
          folder: _vm.$t("Specialneeds"),
        },
      }),
      _vm._v(" "),
      _vm.isLoading
        ? _c("div", {
            staticClass: "loading_page spinner spinner-primary mr-3",
          })
        : _vm._e(),
      _vm._v(" "),
      !_vm.isLoading
        ? _c(
            "validation-observer",
            { ref: "Create_Specialneed" },
            [
              _c(
                "b-form",
                {
                  attrs: { enctype: "multipart/form-data" },
                  on: {
                    submit: function ($event) {
                      $event.preventDefault()
                      return _vm.Submit_Specialneed($event)
                    },
                  },
                },
                [
                  _c(
                    "b-row",
                    [
                      _c(
                        "b-col",
                        { attrs: { md: "8" } },
                        [
                          _c(
                            "b-card",
                            [
                              _c(
                                "b-row",
                                [
                                  _c(
                                    "b-col",
                                    { staticClass: "mb-2", attrs: { md: "6" } },
                                    [
                                      _c("validation-provider", {
                                        attrs: {
                                          name: "lat",
                                          rules: {
                                            required: true,
                                            min: 3,
                                            max: 55,
                                          },
                                        },
                                        scopedSlots: _vm._u(
                                          [
                                            {
                                              key: "default",
                                              fn: function (validationContext) {
                                                return [
                                                  _c(
                                                    "b-form-group",
                                                    {
                                                      attrs: {
                                                        label: _vm.$t("lat"),
                                                      },
                                                    },
                                                    [
                                                      _c("b-form-input", {
                                                        attrs: {
                                                          state:
                                                            _vm.getValidationState(
                                                              validationContext
                                                            ),
                                                          "aria-describedby":
                                                            "Name-feedback",
                                                          label: "lat",
                                                          placeholder:
                                                            _vm.$t("lat"),
                                                        },
                                                        model: {
                                                          value:
                                                            _vm.specialneed.lat,
                                                          callback: function (
                                                            $$v
                                                          ) {
                                                            _vm.$set(
                                                              _vm.specialneed,
                                                              "lat",
                                                              $$v
                                                            )
                                                          },
                                                          expression:
                                                            "specialneed.lat",
                                                        },
                                                      }),
                                                      _vm._v(" "),
                                                      _c(
                                                        "b-form-invalid-feedback",
                                                        {
                                                          attrs: {
                                                            id: "Name-feedback",
                                                          },
                                                        },
                                                        [
                                                          _vm._v(
                                                            _vm._s(
                                                              validationContext
                                                                .errors[0]
                                                            )
                                                          ),
                                                        ]
                                                      ),
                                                    ],
                                                    1
                                                  ),
                                                ]
                                              },
                                            },
                                          ],
                                          null,
                                          false,
                                          2554268129
                                        ),
                                      }),
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-col",
                                    { staticClass: "mb-2", attrs: { md: "6" } },
                                    [
                                      _c("validation-provider", {
                                        attrs: {
                                          name: "long",
                                          rules: {
                                            required: true,
                                            min: 3,
                                            max: 55,
                                          },
                                        },
                                        scopedSlots: _vm._u(
                                          [
                                            {
                                              key: "default",
                                              fn: function (validationContext) {
                                                return [
                                                  _c(
                                                    "b-form-group",
                                                    {
                                                      attrs: {
                                                        label: _vm.$t("long"),
                                                      },
                                                    },
                                                    [
                                                      _c("b-form-input", {
                                                        attrs: {
                                                          state:
                                                            _vm.getValidationState(
                                                              validationContext
                                                            ),
                                                          "aria-describedby":
                                                            "Name-feedback",
                                                          label: "long",
                                                          placeholder:
                                                            _vm.$t("long"),
                                                        },
                                                        model: {
                                                          value:
                                                            _vm.specialneed
                                                              .long,
                                                          callback: function (
                                                            $$v
                                                          ) {
                                                            _vm.$set(
                                                              _vm.specialneed,
                                                              "long",
                                                              $$v
                                                            )
                                                          },
                                                          expression:
                                                            "specialneed.long",
                                                        },
                                                      }),
                                                      _vm._v(" "),
                                                      _c(
                                                        "b-form-invalid-feedback",
                                                        {
                                                          attrs: {
                                                            id: "Name-feedback",
                                                          },
                                                        },
                                                        [
                                                          _vm._v(
                                                            _vm._s(
                                                              validationContext
                                                                .errors[0]
                                                            )
                                                          ),
                                                        ]
                                                      ),
                                                    ],
                                                    1
                                                  ),
                                                ]
                                              },
                                            },
                                          ],
                                          null,
                                          false,
                                          1039812513
                                        ),
                                      }),
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-col",
                                    { staticClass: "mb-2", attrs: { md: "6" } },
                                    [
                                      _c("validation-provider", {
                                        attrs: {
                                          name: "ar_name",
                                          rules: {
                                            required: true,
                                            min: 3,
                                            max: 55,
                                          },
                                        },
                                        scopedSlots: _vm._u(
                                          [
                                            {
                                              key: "default",
                                              fn: function (validationContext) {
                                                return [
                                                  _c(
                                                    "b-form-group",
                                                    {
                                                      attrs: {
                                                        label:
                                                          _vm.$t("ar_name"),
                                                      },
                                                    },
                                                    [
                                                      _c("b-form-input", {
                                                        attrs: {
                                                          state:
                                                            _vm.getValidationState(
                                                              validationContext
                                                            ),
                                                          "aria-describedby":
                                                            "Name-feedback",
                                                          label: "ar_name",
                                                          placeholder:
                                                            _vm.$t("ar_name"),
                                                        },
                                                        model: {
                                                          value:
                                                            _vm.specialneed
                                                              .ar_name,
                                                          callback: function (
                                                            $$v
                                                          ) {
                                                            _vm.$set(
                                                              _vm.specialneed,
                                                              "ar_name",
                                                              $$v
                                                            )
                                                          },
                                                          expression:
                                                            "specialneed.ar_name",
                                                        },
                                                      }),
                                                      _vm._v(" "),
                                                      _c(
                                                        "b-form-invalid-feedback",
                                                        {
                                                          attrs: {
                                                            id: "Name-feedback",
                                                          },
                                                        },
                                                        [
                                                          _vm._v(
                                                            _vm._s(
                                                              validationContext
                                                                .errors[0]
                                                            )
                                                          ),
                                                        ]
                                                      ),
                                                    ],
                                                    1
                                                  ),
                                                ]
                                              },
                                            },
                                          ],
                                          null,
                                          false,
                                          1373321057
                                        ),
                                      }),
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-col",
                                    { staticClass: "mb-2", attrs: { md: "6" } },
                                    [
                                      _c("validation-provider", {
                                        attrs: {
                                          name: "en_name",
                                          rules: {
                                            required: true,
                                            min: 3,
                                            max: 55,
                                          },
                                        },
                                        scopedSlots: _vm._u(
                                          [
                                            {
                                              key: "default",
                                              fn: function (validationContext) {
                                                return [
                                                  _c(
                                                    "b-form-group",
                                                    {
                                                      attrs: {
                                                        label:
                                                          _vm.$t("en_name"),
                                                      },
                                                    },
                                                    [
                                                      _c("b-form-input", {
                                                        attrs: {
                                                          state:
                                                            _vm.getValidationState(
                                                              validationContext
                                                            ),
                                                          "aria-describedby":
                                                            "Name-feedback",
                                                          label: "en_name",
                                                          placeholder:
                                                            _vm.$t("en_name"),
                                                        },
                                                        model: {
                                                          value:
                                                            _vm.specialneed
                                                              .en_name,
                                                          callback: function (
                                                            $$v
                                                          ) {
                                                            _vm.$set(
                                                              _vm.specialneed,
                                                              "en_name",
                                                              $$v
                                                            )
                                                          },
                                                          expression:
                                                            "specialneed.en_name",
                                                        },
                                                      }),
                                                      _vm._v(" "),
                                                      _c(
                                                        "b-form-invalid-feedback",
                                                        {
                                                          attrs: {
                                                            id: "Name-feedback",
                                                          },
                                                        },
                                                        [
                                                          _vm._v(
                                                            _vm._s(
                                                              validationContext
                                                                .errors[0]
                                                            )
                                                          ),
                                                        ]
                                                      ),
                                                    ],
                                                    1
                                                  ),
                                                ]
                                              },
                                            },
                                          ],
                                          null,
                                          false,
                                          3415172193
                                        ),
                                      }),
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-col",
                                    { staticClass: "mb-2", attrs: { md: "6" } },
                                    [
                                      _c("validation-provider", {
                                        attrs: {
                                          name: "url",
                                          rules: {
                                            required: true,
                                            min: 3,
                                            max: 55,
                                          },
                                        },
                                        scopedSlots: _vm._u(
                                          [
                                            {
                                              key: "default",
                                              fn: function (validationContext) {
                                                return [
                                                  _c(
                                                    "b-form-group",
                                                    {
                                                      attrs: {
                                                        label: _vm.$t("url"),
                                                      },
                                                    },
                                                    [
                                                      _c("b-form-input", {
                                                        attrs: {
                                                          state:
                                                            _vm.getValidationState(
                                                              validationContext
                                                            ),
                                                          "aria-describedby":
                                                            "Name-feedback",
                                                          label: "url",
                                                          placeholder:
                                                            _vm.$t("url"),
                                                        },
                                                        model: {
                                                          value:
                                                            _vm.specialneed.url,
                                                          callback: function (
                                                            $$v
                                                          ) {
                                                            _vm.$set(
                                                              _vm.specialneed,
                                                              "url",
                                                              $$v
                                                            )
                                                          },
                                                          expression:
                                                            "specialneed.url",
                                                        },
                                                      }),
                                                      _vm._v(" "),
                                                      _c(
                                                        "b-form-invalid-feedback",
                                                        {
                                                          attrs: {
                                                            id: "Name-feedback",
                                                          },
                                                        },
                                                        [
                                                          _vm._v(
                                                            _vm._s(
                                                              validationContext
                                                                .errors[0]
                                                            )
                                                          ),
                                                        ]
                                                      ),
                                                    ],
                                                    1
                                                  ),
                                                ]
                                              },
                                            },
                                          ],
                                          null,
                                          false,
                                          74756961
                                        ),
                                      }),
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-col",
                                    { staticClass: "mb-2", attrs: { md: "6" } },
                                    [
                                      _c("validation-provider", {
                                        attrs: {
                                          name: "phone",
                                          rules: {
                                            required: true,
                                            min: 3,
                                            max: 55,
                                          },
                                        },
                                        scopedSlots: _vm._u(
                                          [
                                            {
                                              key: "default",
                                              fn: function (validationContext) {
                                                return [
                                                  _c(
                                                    "b-form-group",
                                                    {
                                                      attrs: {
                                                        label: _vm.$t("phone"),
                                                      },
                                                    },
                                                    [
                                                      _c("b-form-input", {
                                                        attrs: {
                                                          state:
                                                            _vm.getValidationState(
                                                              validationContext
                                                            ),
                                                          "aria-describedby":
                                                            "Name-feedback",
                                                          label: "url",
                                                          placeholder:
                                                            _vm.$t("phone"),
                                                        },
                                                        model: {
                                                          value:
                                                            _vm.specialneed
                                                              .phone,
                                                          callback: function (
                                                            $$v
                                                          ) {
                                                            _vm.$set(
                                                              _vm.specialneed,
                                                              "phone",
                                                              $$v
                                                            )
                                                          },
                                                          expression:
                                                            "specialneed.phone",
                                                        },
                                                      }),
                                                      _vm._v(" "),
                                                      _c(
                                                        "b-form-invalid-feedback",
                                                        {
                                                          attrs: {
                                                            id: "Name-feedback",
                                                          },
                                                        },
                                                        [
                                                          _vm._v(
                                                            _vm._s(
                                                              validationContext
                                                                .errors[0]
                                                            )
                                                          ),
                                                        ]
                                                      ),
                                                    ],
                                                    1
                                                  ),
                                                ]
                                              },
                                            },
                                          ],
                                          null,
                                          false,
                                          2648946774
                                        ),
                                      }),
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-col",
                                    { staticClass: "mb-2", attrs: { md: "6" } },
                                    [
                                      _c("validation-provider", {
                                        attrs: {
                                          name: "share",
                                          rules: {
                                            required: true,
                                            min: 3,
                                            max: 600,
                                          },
                                        },
                                        scopedSlots: _vm._u(
                                          [
                                            {
                                              key: "default",
                                              fn: function (validationContext) {
                                                return [
                                                  _c(
                                                    "b-form-group",
                                                    {
                                                      attrs: {
                                                        label: _vm.$t("share"),
                                                      },
                                                    },
                                                    [
                                                      _c("b-form-input", {
                                                        attrs: {
                                                          state:
                                                            _vm.getValidationState(
                                                              validationContext
                                                            ),
                                                          "aria-describedby":
                                                            "Name-feedback",
                                                          label: "share",
                                                          placeholder:
                                                            _vm.$t("share"),
                                                        },
                                                        model: {
                                                          value:
                                                            _vm.specialneed
                                                              .share,
                                                          callback: function (
                                                            $$v
                                                          ) {
                                                            _vm.$set(
                                                              _vm.specialneed,
                                                              "share",
                                                              $$v
                                                            )
                                                          },
                                                          expression:
                                                            "specialneed.share",
                                                        },
                                                      }),
                                                      _vm._v(" "),
                                                      _c(
                                                        "b-form-invalid-feedback",
                                                        {
                                                          attrs: {
                                                            id: "Name-feedback",
                                                          },
                                                        },
                                                        [
                                                          _vm._v(
                                                            _vm._s(
                                                              validationContext
                                                                .errors[0]
                                                            )
                                                          ),
                                                        ]
                                                      ),
                                                    ],
                                                    1
                                                  ),
                                                ]
                                              },
                                            },
                                          ],
                                          null,
                                          false,
                                          2564288225
                                        ),
                                      }),
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-col",
                                    { staticClass: "mb-2", attrs: { md: "6" } },
                                    [
                                      _c("validation-provider", {
                                        attrs: {
                                          name: "category",
                                          rules: { required: true },
                                        },
                                        scopedSlots: _vm._u(
                                          [
                                            {
                                              key: "default",
                                              fn: function (ref) {
                                                var valid = ref.valid
                                                var errors = ref.errors
                                                return _c(
                                                  "b-form-group",
                                                  {
                                                    attrs: {
                                                      label:
                                                        _vm.$t(
                                                          "Choose_instation"
                                                        ),
                                                    },
                                                  },
                                                  [
                                                    _c("v-select", {
                                                      class: {
                                                        "is-invalid":
                                                          !!errors.length,
                                                      },
                                                      attrs: {
                                                        state: errors[0]
                                                          ? false
                                                          : valid
                                                          ? true
                                                          : null,
                                                        reduce: function (
                                                          label
                                                        ) {
                                                          return label.value
                                                        },
                                                        placeholder:
                                                          _vm.$t(
                                                            "Choose_instation"
                                                          ),
                                                        options:
                                                          _vm.specialneeds.map(
                                                            function (
                                                              specialneeds
                                                            ) {
                                                              return {
                                                                label:
                                                                  specialneeds.ar_name,
                                                                value:
                                                                  specialneeds.id,
                                                              }
                                                            }
                                                          ),
                                                      },
                                                      model: {
                                                        value:
                                                          _vm.specialneed
                                                            .institution_id,
                                                        callback: function (
                                                          $$v
                                                        ) {
                                                          _vm.$set(
                                                            _vm.specialneed,
                                                            "institution_id",
                                                            $$v
                                                          )
                                                        },
                                                        expression:
                                                          "specialneed.institution_id",
                                                      },
                                                    }),
                                                    _vm._v(" "),
                                                    _c(
                                                      "b-form-invalid-feedback",
                                                      [
                                                        _vm._v(
                                                          _vm._s(errors[0])
                                                        ),
                                                      ]
                                                    ),
                                                  ],
                                                  1
                                                )
                                              },
                                            },
                                          ],
                                          null,
                                          false,
                                          1342132050
                                        ),
                                      }),
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-col",
                                    { staticClass: "mb-2", attrs: { md: "6" } },
                                    [
                                      _c("validation-provider", {
                                        attrs: {
                                          name: "Areas",
                                          rules: { required: true },
                                        },
                                        scopedSlots: _vm._u(
                                          [
                                            {
                                              key: "default",
                                              fn: function (ref) {
                                                var valid = ref.valid
                                                var errors = ref.errors
                                                return _c(
                                                  "b-form-group",
                                                  {
                                                    attrs: {
                                                      label:
                                                        _vm.$t("Choose_Area"),
                                                    },
                                                  },
                                                  [
                                                    _c("v-select", {
                                                      class: {
                                                        "is-invalid":
                                                          !!errors.length,
                                                      },
                                                      attrs: {
                                                        state: errors[0]
                                                          ? false
                                                          : valid
                                                          ? true
                                                          : null,
                                                        reduce: function (
                                                          label
                                                        ) {
                                                          return label.value
                                                        },
                                                        placeholder:
                                                          _vm.$t("Choose_Area"),
                                                        options: _vm.areas.map(
                                                          function (areas) {
                                                            return {
                                                              label:
                                                                areas.ar_name,
                                                              value: areas.id,
                                                            }
                                                          }
                                                        ),
                                                      },
                                                      model: {
                                                        value:
                                                          _vm.specialneed
                                                            .area_id,
                                                        callback: function (
                                                          $$v
                                                        ) {
                                                          _vm.$set(
                                                            _vm.specialneed,
                                                            "area_id",
                                                            $$v
                                                          )
                                                        },
                                                        expression:
                                                          "specialneed.area_id",
                                                      },
                                                    }),
                                                    _vm._v(" "),
                                                    _c(
                                                      "b-form-invalid-feedback",
                                                      [
                                                        _vm._v(
                                                          _vm._s(errors[0])
                                                        ),
                                                      ]
                                                    ),
                                                  ],
                                                  1
                                                )
                                              },
                                            },
                                          ],
                                          null,
                                          false,
                                          2170857329
                                        ),
                                      }),
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-col",
                                    {
                                      staticClass: "mb-2",
                                      attrs: { md: "12" },
                                    },
                                    [
                                      _c(
                                        "b-form-group",
                                        { attrs: { label: _vm.$t("en_info") } },
                                        [
                                          _c("vue-editor", {
                                            model: {
                                              value: _vm.specialneed.en_info,
                                              callback: function ($$v) {
                                                _vm.$set(
                                                  _vm.specialneed,
                                                  "en_info",
                                                  $$v
                                                )
                                              },
                                              expression: "specialneed.en_info",
                                            },
                                          }),
                                        ],
                                        1
                                      ),
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-col",
                                    {
                                      staticClass: "mb-2",
                                      attrs: { md: "12" },
                                    },
                                    [
                                      _c(
                                        "b-form-group",
                                        { attrs: { label: _vm.$t("ar_info") } },
                                        [
                                          _c("vue-editor", {
                                            model: {
                                              value: _vm.specialneed.ar_info,
                                              callback: function ($$v) {
                                                _vm.$set(
                                                  _vm.specialneed,
                                                  "ar_info",
                                                  $$v
                                                )
                                              },
                                              expression: "specialneed.ar_info",
                                            },
                                          }),
                                        ],
                                        1
                                      ),
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-col",
                                    {
                                      staticClass: "mb-2",
                                      attrs: { md: "12" },
                                    },
                                    [
                                      _c(
                                        "b-form-group",
                                        {
                                          attrs: {
                                            label: _vm.$t("facilities_ar"),
                                          },
                                        },
                                        [
                                          _c("vue-editor", {
                                            model: {
                                              value:
                                                _vm.specialneed.facilities_ar,
                                              callback: function ($$v) {
                                                _vm.$set(
                                                  _vm.specialneed,
                                                  "facilities_ar",
                                                  $$v
                                                )
                                              },
                                              expression:
                                                "specialneed.facilities_ar",
                                            },
                                          }),
                                        ],
                                        1
                                      ),
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-col",
                                    {
                                      staticClass: "mb-2",
                                      attrs: { md: "12" },
                                    },
                                    [
                                      _c(
                                        "b-form-group",
                                        {
                                          attrs: {
                                            label: _vm.$t("facilities_en"),
                                          },
                                        },
                                        [
                                          _c("vue-editor", {
                                            model: {
                                              value:
                                                _vm.specialneed.facilities_en,
                                              callback: function ($$v) {
                                                _vm.$set(
                                                  _vm.specialneed,
                                                  "facilities_en",
                                                  $$v
                                                )
                                              },
                                              expression:
                                                "specialneed.facilities_en",
                                            },
                                          }),
                                        ],
                                        1
                                      ),
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-col",
                                    {
                                      staticClass: "mb-2",
                                      attrs: { md: "12" },
                                    },
                                    [
                                      _c(
                                        "b-form-group",
                                        {
                                          attrs: {
                                            label: _vm.$t("activities_ar"),
                                          },
                                        },
                                        [
                                          _c("vue-editor", {
                                            model: {
                                              value:
                                                _vm.specialneed.activities_ar,
                                              callback: function ($$v) {
                                                _vm.$set(
                                                  _vm.specialneed,
                                                  "activities_ar",
                                                  $$v
                                                )
                                              },
                                              expression:
                                                "specialneed.activities_ar",
                                            },
                                          }),
                                        ],
                                        1
                                      ),
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-col",
                                    {
                                      staticClass: "mb-2",
                                      attrs: { md: "12" },
                                    },
                                    [
                                      _c(
                                        "b-form-group",
                                        {
                                          attrs: {
                                            label: _vm.$t("activities_en"),
                                          },
                                        },
                                        [
                                          _c("vue-editor", {
                                            model: {
                                              value:
                                                _vm.specialneed.activities_en,
                                              callback: function ($$v) {
                                                _vm.$set(
                                                  _vm.specialneed,
                                                  "activities_en",
                                                  $$v
                                                )
                                              },
                                              expression:
                                                "specialneed.activities_en",
                                            },
                                          }),
                                        ],
                                        1
                                      ),
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _vm._l(_vm.sections, function (section) {
                                    return _c(
                                      "b-col",
                                      {
                                        key: section.id,
                                        staticClass: "mb-6",
                                        attrs: { md: "6" },
                                      },
                                      [
                                        _c("validation-provider", {
                                          attrs: { name: section.ar_name },
                                          scopedSlots: _vm._u(
                                            [
                                              {
                                                key: "default",
                                                fn: function (ref) {
                                                  var valid = ref.valid
                                                  var errors = ref.errors
                                                  return _c(
                                                    "b-form-group",
                                                    {
                                                      attrs: {
                                                        label: _vm.$t(
                                                          section.ar_name
                                                        ),
                                                      },
                                                    },
                                                    [
                                                      _c("v-select", {
                                                        class: {
                                                          "is-invalid":
                                                            !!errors.length,
                                                        },
                                                        attrs: {
                                                          state: errors[0]
                                                            ? false
                                                            : valid
                                                            ? true
                                                            : null,
                                                          reduce: function (
                                                            label
                                                          ) {
                                                            return label.value
                                                          },
                                                          placeholder: _vm.$t(
                                                            section.ar_name
                                                          ),
                                                          multiple: "",
                                                          options:
                                                            section.drop.map(
                                                              function (item) {
                                                                return {
                                                                  label:
                                                                    item.en_name,
                                                                  value:
                                                                    item.id,
                                                                }
                                                              }
                                                            ),
                                                        },
                                                        model: {
                                                          value:
                                                            _vm.selectedOptions[
                                                              section.id
                                                            ],
                                                          callback: function (
                                                            $$v
                                                          ) {
                                                            _vm.$set(
                                                              _vm.selectedOptions,
                                                              section.id,
                                                              $$v
                                                            )
                                                          },
                                                          expression:
                                                            "selectedOptions[section.id]",
                                                        },
                                                      }),
                                                      _vm._v(" "),
                                                      _c(
                                                        "b-form-invalid-feedback",
                                                        [
                                                          _vm._v(
                                                            _vm._s(errors[0])
                                                          ),
                                                        ]
                                                      ),
                                                    ],
                                                    1
                                                  )
                                                },
                                              },
                                            ],
                                            null,
                                            true
                                          ),
                                        }),
                                      ],
                                      1
                                    )
                                  }),
                                ],
                                2
                              ),
                            ],
                            1
                          ),
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "b-col",
                        { attrs: { md: "4" } },
                        [
                          _c("b-card", [
                            _c("div", { staticClass: "card-header" }, [
                              _c("h5", [
                                _vm._v(_vm._s(_vm.$t("MultipleImage"))),
                              ]),
                            ]),
                            _vm._v(" "),
                            _c(
                              "div",
                              { staticClass: "card-body" },
                              [
                                _c(
                                  "b-row",
                                  { staticClass: "form-group" },
                                  [
                                    _c("b-col", { attrs: { md: "12 mb-5" } }, [
                                      _c(
                                        "div",
                                        {
                                          staticClass:
                                            "d-flex justify-content-center",
                                          attrs: {
                                            id: "my-strictly-unique-vue-upload-multiple-image",
                                          },
                                        },
                                        [
                                          _c("vue-upload-multiple-image", {
                                            attrs: {
                                              dragText:
                                                "Drag & Drop Multiple images For specialneed",
                                              dropText: "Drag & Drop image",
                                              browseText: "(or) Select",
                                              accept:
                                                "image/gif,image/jpeg,image/png,image/bmp,image/jpg",
                                              primaryText: "success",
                                              markIsPrimaryText: "success",
                                              popupText:
                                                "have been successfully uploaded",
                                              "data-images": _vm.images,
                                              idUpload: "myIdUpload",
                                              showEdit: false,
                                            },
                                            on: {
                                              "upload-success":
                                                _vm.uploadImageSuccess,
                                              "before-remove": _vm.beforeRemove,
                                            },
                                          }),
                                        ],
                                        1
                                      ),
                                    ]),
                                  ],
                                  1
                                ),
                              ],
                              1
                            ),
                          ]),
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "b-col",
                        { staticClass: "mt-3", attrs: { md: "12" } },
                        [
                          _c(
                            "b-button",
                            {
                              attrs: {
                                variant: "primary",
                                type: "submit",
                                disabled: _vm.SubmitProcessing,
                              },
                            },
                            [_vm._v(_vm._s(_vm.$t("submit")))]
                          ),
                          _vm._v(" "),
                          _vm.SubmitProcessing ? _vm._m(0) : _vm._e(),
                        ],
                        1
                      ),
                    ],
                    1
                  ),
                ],
                1
              ),
            ],
            1
          )
        : _vm._e(),
    ],
    1
  )
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "typo__p" }, [
      _c("div", { staticClass: "spinner sm spinner-primary mt-3" }),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/src/views/app/pages/specialneeds/Add_specialneed.vue":
/*!************************************************************************!*\
  !*** ./resources/src/views/app/pages/specialneeds/Add_specialneed.vue ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Add_specialneed_vue_vue_type_template_id_164fede3___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Add_specialneed.vue?vue&type=template&id=164fede3& */ "./resources/src/views/app/pages/specialneeds/Add_specialneed.vue?vue&type=template&id=164fede3&");
/* harmony import */ var _Add_specialneed_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Add_specialneed.vue?vue&type=script&lang=js& */ "./resources/src/views/app/pages/specialneeds/Add_specialneed.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Add_specialneed_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Add_specialneed_vue_vue_type_template_id_164fede3___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Add_specialneed_vue_vue_type_template_id_164fede3___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/src/views/app/pages/specialneeds/Add_specialneed.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/src/views/app/pages/specialneeds/Add_specialneed.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************!*\
  !*** ./resources/src/views/app/pages/specialneeds/Add_specialneed.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Add_specialneed_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./Add_specialneed.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/views/app/pages/specialneeds/Add_specialneed.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Add_specialneed_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/src/views/app/pages/specialneeds/Add_specialneed.vue?vue&type=template&id=164fede3&":
/*!*******************************************************************************************************!*\
  !*** ./resources/src/views/app/pages/specialneeds/Add_specialneed.vue?vue&type=template&id=164fede3& ***!
  \*******************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Add_specialneed_vue_vue_type_template_id_164fede3___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./Add_specialneed.vue?vue&type=template&id=164fede3& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/views/app/pages/specialneeds/Add_specialneed.vue?vue&type=template&id=164fede3&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Add_specialneed_vue_vue_type_template_id_164fede3___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Add_specialneed_vue_vue_type_template_id_164fede3___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);