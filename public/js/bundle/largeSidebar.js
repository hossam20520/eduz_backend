(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["largeSidebar"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/containers/layouts/common/footer.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/src/containers/layouts/common/footer.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  data: function data() {
    return {};
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapGetters"])(["currentUser"])),
  methods: {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/containers/layouts/largeSidebar/Sidebar.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/src/containers/layouts/largeSidebar/Sidebar.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TopNav__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TopNav */ "./resources/src/containers/layouts/largeSidebar/TopNav.vue");
/* harmony import */ var mobile_device_detect__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! mobile-device-detect */ "./node_modules/mobile-device-detect/dist/index.js");
/* harmony import */ var mobile_device_detect__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(mobile_device_detect__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  components: {
    Topnav: _TopNav__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      isDisplay: true,
      isMenuOver: false,
      isStyle: true,
      selectedParentMenu: "",
      isMobile: mobile_device_detect__WEBPACK_IMPORTED_MODULE_1__["isMobile"]
    };
  },
  mounted: function mounted() {
    this.toggleSelectedParentMenu();
    window.addEventListener("resize", this.handleWindowResize);
    document.addEventListener("click", this.returnSelectedParentMenu);
    this.handleWindowResize();
  },
  beforeDestroy: function beforeDestroy() {
    document.removeEventListener("click", this.returnSelectedParentMenu);
    window.removeEventListener("resize", this.handleWindowResize);
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_2__["mapGetters"])(["getSideBarToggleProperties", "currentUserPermissions"])),
  methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_2__["mapActions"])(["changeSecondarySidebarProperties", "changeSecondarySidebarPropertiesViaMenuItem", "changeSecondarySidebarPropertiesViaOverlay", "changeSidebarProperties"])), {}, {
    handleWindowResize: function handleWindowResize() {
      if (window.innerWidth <= 1200) {
        if (this.getSideBarToggleProperties.isSideNavOpen) {
          this.changeSidebarProperties();
        }

        if (this.getSideBarToggleProperties.isSecondarySideNavOpen) {
          this.changeSecondarySidebarProperties();
        }
      } else {
        if (!this.getSideBarToggleProperties.isSideNavOpen) {
          this.changeSidebarProperties();
        }
      }
    },
    toggleSelectedParentMenu: function toggleSelectedParentMenu() {
      var currentParentUrl = this.$route.path.split("/").filter(function (x) {
        return x !== "";
      })[1];

      if (currentParentUrl !== undefined || currentParentUrl !== null) {
        this.selectedParentMenu = currentParentUrl.toLowerCase();
      } else {
        this.selectedParentMenu = "dashboard";
      }
    },
    toggleSubMenu: function toggleSubMenu(e) {
      var hasSubmenu = e.target.dataset.submenu;
      var parent = e.target.dataset.item;

      if (hasSubmenu) {
        this.selectedParentMenu = parent;
        this.changeSecondarySidebarPropertiesViaMenuItem(true);
      } else {
        this.selectedParentMenu = parent;
        this.changeSecondarySidebarPropertiesViaMenuItem(false);
      }
    },
    removeOverlay: function removeOverlay() {
      this.changeSecondarySidebarPropertiesViaOverlay();

      if (window.innerWidth <= 1200) {
        this.changeSidebarProperties();
      }

      this.toggleSelectedParentMenu();
    },
    returnSelectedParentMenu: function returnSelectedParentMenu() {
      if (!this.isMenuOver) {
        this.toggleSelectedParentMenu();
      }
    },
    toggleSidebarDropdwon: function toggleSidebarDropdwon(event) {
      var dropdownMenus = this.$el.querySelectorAll(".dropdown-sidemenu.open");
      event.currentTarget.classList.toggle("open");
      dropdownMenus.forEach(function (dropdown) {
        dropdown.classList.remove("open");
      });
    }
  })
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/containers/layouts/largeSidebar/TopNav.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/src/containers/layouts/largeSidebar/TopNav.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./../../../utils */ "./resources/src/utils/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var mobile_device_detect__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! mobile-device-detect */ "./node_modules/mobile-device-detect/dist/index.js");
/* harmony import */ var mobile_device_detect__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(mobile_device_detect__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var vue_clickaway__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vue-clickaway */ "./node_modules/vue-clickaway/dist/vue-clickaway.common.js");
/* harmony import */ var vue_clickaway__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(vue_clickaway__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var vue_flag_icon__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! vue-flag-icon */ "./node_modules/vue-flag-icon/index.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

var _objectSpread2;

function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return generator._invoke = function (innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; }(innerFn, self, context), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; this._invoke = function (method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); }; } function maybeInvokeDelegate(delegate, context) { var method = delegate.iterator[context.method]; if (undefined === method) { if (context.delegate = null, "throw" === context.method) { if (delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method)) return ContinueSentinel; context.method = "throw", context.arg = new TypeError("The iterator does not provide a 'throw' method"); } return ContinueSentinel; } var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) { if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; } return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, define(Gp, "constructor", GeneratorFunctionPrototype), define(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (object) { var keys = []; for (var key in object) { keys.push(key); } return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) { "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); } }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

 // import Sidebar from "./Sidebar";



 // import { setTimeout } from 'timers';


/* harmony default export */ __webpack_exports__["default"] = ({
  mixins: [vue_clickaway__WEBPACK_IMPORTED_MODULE_4__["mixin"]],
  components: {
    FlagIcon: vue_flag_icon__WEBPACK_IMPORTED_MODULE_5__["default"]
  },
  data: function data() {
    return {
      langs: ["en", "fr", "ar", "de", "es", "it", "Ind", "thai", "tr_ch", "sm_ch", "tur", "ru", "hn", "vn"],
      isDisplay: true,
      isStyle: true,
      isSearchOpen: false,
      isMouseOnMegaMenu: true,
      isMegaMenuOpen: false,
      is_Load: false // alerts:0,

    };
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_3__["mapGetters"])(["currentUser", "getSideBarToggleProperties", "currentUserPermissions", "notifs_alert", "phone_alert"])),
  methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_3__["mapActions"])(["changeSecondarySidebarProperties", "changeSidebarProperties", "changeThemeMode", "logout"])), {}, (_objectSpread2 = {
    updateUserMessage: function updateUserMessage() {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return axios__WEBPACK_IMPORTED_MODULE_1___default.a.get("updateusernoti").then(function (userAuth) {
                  window.href = '/app/People/Users';
                })["catch"](function () {});

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    logoutUser: function logoutUser() {
      this.$store.dispatch("logout");
    },
    SetLocal: function SetLocal(locale) {
      this.$i18n.locale = locale;
      this.$store.dispatch("language/setLanguage", locale);
      Fire.$emit("ChangeLanguage");
    },
    handleFullScreen: function handleFullScreen() {
      _utils__WEBPACK_IMPORTED_MODULE_0__["default"].toggleFullScreen();
    }
  }, _defineProperty(_objectSpread2, "logoutUser", function logoutUser() {
    this.logout();
  }), _defineProperty(_objectSpread2, "closeMegaMenu", function closeMegaMenu() {
    this.isMegaMenuOpen = false;
  }), _defineProperty(_objectSpread2, "toggleMegaMenu", function toggleMegaMenu() {
    this.isMegaMenuOpen = !this.isMegaMenuOpen;
  }), _defineProperty(_objectSpread2, "toggleSearch", function toggleSearch() {
    this.isSearchOpen = !this.isSearchOpen;
  }), _defineProperty(_objectSpread2, "sideBarToggle", function sideBarToggle(el) {
    if (this.getSideBarToggleProperties.isSideNavOpen && this.getSideBarToggleProperties.isSecondarySideNavOpen && mobile_device_detect__WEBPACK_IMPORTED_MODULE_2__["isMobile"]) {
      this.changeSidebarProperties();
      this.changeSecondarySidebarProperties();
    } else if (this.getSideBarToggleProperties.isSideNavOpen && this.getSideBarToggleProperties.isSecondarySideNavOpen) {
      this.changeSecondarySidebarProperties();
    } else if (this.getSideBarToggleProperties.isSideNavOpen) {
      this.changeSidebarProperties();
    } else if (!this.getSideBarToggleProperties.isSideNavOpen && !this.getSideBarToggleProperties.isSecondarySideNavOpen && !this.getSideBarToggleProperties.isActiveSecondarySideNav) {
      this.changeSidebarProperties();
    } else if (!this.getSideBarToggleProperties.isSideNavOpen && !this.getSideBarToggleProperties.isSecondarySideNavOpen) {
      this.changeSidebarProperties();
      this.changeSecondarySidebarProperties();
    }
  }), _objectSpread2))
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/containers/layouts/largeSidebar/index.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/src/containers/layouts/largeSidebar/index.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Sidebar__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Sidebar */ "./resources/src/containers/layouts/largeSidebar/Sidebar.vue");
/* harmony import */ var _TopNav__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TopNav */ "./resources/src/containers/layouts/largeSidebar/TopNav.vue");
/* harmony import */ var _common_footer__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../common/footer */ "./resources/src/containers/layouts/common/footer.vue");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
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
  components: {
    Sidebar: _Sidebar__WEBPACK_IMPORTED_MODULE_0__["default"],
    TopNav: _TopNav__WEBPACK_IMPORTED_MODULE_1__["default"],
    appFooter: _common_footer__WEBPACK_IMPORTED_MODULE_2__["default"]
  },
  data: function data() {
    return {};
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_3__["mapGetters"])(["getSideBarToggleProperties"])),
  methods: {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/containers/layouts/common/footer.vue?vue&type=template&id=1dfb17ff&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/src/containers/layouts/common/footer.vue?vue&type=template&id=1dfb17ff&scoped=true& ***!
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
  return _c("div", { staticClass: "footer_wrap" }, [
    _c("div", { staticClass: "flex-grow-1" }),
    _vm._v(" "),
    _c("div", { staticClass: "app-footer" }, [
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-md-9" }, [
          _c("p", [_c("strong", [_vm._v(_vm._s(_vm.currentUser.footer))])]),
        ]),
      ]),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass:
            "footer-bottom border-top pt-3 d-flex flex-column flex-sm-row align-items-center",
        },
        [
          _c("div", { staticClass: "d-flex align-items-center" }, [
            _c("img", {
              staticClass: "logo",
              attrs: {
                src: "/images/" + _vm.currentUser.logo,
                alt: "",
                width: "60",
                height: "60",
              },
            }),
            _vm._v(" "),
            _c("div", [
              _c("div", [
                _c("p", { staticClass: "m-0" }, [
                  _vm._v(
                    "© 2021 " +
                      _vm._s(_vm.$t("developed_by")) +
                      " " +
                      _vm._s(_vm.currentUser.developed_by)
                  ),
                ]),
                _vm._v(" "),
                _c("p", { staticClass: "m-0" }, [
                  _vm._v("All rights reserved - v3.7.0"),
                ]),
              ]),
            ]),
            _vm._v(" "),
            _c("span", { staticClass: "flex-grow-1" }),
          ]),
        ]
      ),
    ]),
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/containers/layouts/largeSidebar/Sidebar.vue?vue&type=template&id=696fbebe&scoped=true&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/src/containers/layouts/largeSidebar/Sidebar.vue?vue&type=template&id=696fbebe&scoped=true& ***!
  \********************************************************************************************************************************************************************************************************************************************/
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
    {
      staticClass: "side-content-wrap",
      on: {
        mouseenter: function ($event) {
          _vm.isMenuOver = true
        },
        mouseleave: function ($event) {
          _vm.isMenuOver = false
        },
        touchstart: function ($event) {
          _vm.isMenuOver = true
        },
      },
    },
    [
      _c(
        "vue-perfect-scrollbar",
        {
          ref: "myData",
          staticClass: "sidebar-left rtl-ps-none ps scroll",
          class: { open: _vm.getSideBarToggleProperties.isSideNavOpen },
          attrs: {
            settings: { suppressScrollX: true, wheelPropagation: false },
          },
        },
        [
          _c("div", [
            _c("ul", { staticClass: "navigation-left" }, [
              _c(
                "li",
                {
                  staticClass: "nav-item",
                  class: { active: _vm.selectedParentMenu == "dashboard" },
                  attrs: { "data-item": "dashboard" },
                  on: { mouseenter: _vm.toggleSubMenu },
                },
                [
                  _c(
                    "router-link",
                    {
                      staticClass: "nav-item-hold",
                      attrs: { tag: "a", to: "/app/dashboard" },
                    },
                    [
                      _c("img", {
                        attrs: {
                          src: "https://cdn-icons-png.flaticon.com/512/3408/3408591.png",
                          width: "50%",
                        },
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "nav-text" }, [
                        _vm._v(_vm._s(_vm.$t("dashboard"))),
                      ]),
                    ]
                  ),
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value:
                        _vm.currentUserPermissions &&
                        (_vm.currentUserPermissions.includes("products_add") ||
                          _vm.currentUserPermissions.includes(
                            "products_view"
                          ) ||
                          _vm.currentUserPermissions.includes("barcode_view")),
                      expression:
                        "currentUserPermissions \n            && (currentUserPermissions.includes('products_add')\n            || currentUserPermissions.includes('products_view') \n            || currentUserPermissions.includes('barcode_view'))",
                    },
                  ],
                  staticClass: "nav-item",
                  class: { active: _vm.selectedParentMenu == "products" },
                  attrs: { "data-item": "products", "data-submenu": true },
                  on: { mouseenter: _vm.toggleSubMenu },
                },
                [
                  _c(
                    "a",
                    { staticClass: "nav-item-hold", attrs: { href: "#" } },
                    [
                      _c("img", {
                        attrs: {
                          src: "https://cdn-icons-png.flaticon.com/512/4401/4401713.png",
                          width: "50%",
                        },
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "nav-text" }, [
                        _vm._v(_vm._s(_vm.$t("Products"))),
                      ]),
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "triangle" }),
                ]
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  staticClass: "nav-item",
                  class: { active: _vm.selectedParentMenu == "blogs" },
                  attrs: { "data-item": "blogs", "data-submenu": true },
                  on: { mouseenter: _vm.toggleSubMenu },
                },
                [
                  _c(
                    "a",
                    { staticClass: "nav-item-hold", attrs: { href: "#" } },
                    [
                      _c("img", {
                        attrs: {
                          src: "https://cdn-icons-png.flaticon.com/512/4581/4581944.png ",
                          width: "50%",
                        },
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "nav-text" }, [
                        _vm._v(_vm._s(_vm.$t("Blogs"))),
                      ]),
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "triangle" }),
                ]
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  staticClass: "nav-item",
                  class: { active: _vm.selectedParentMenu == "schools" },
                  attrs: { "data-item": "schools", "data-submenu": true },
                  on: { mouseenter: _vm.toggleSubMenu },
                },
                [
                  _c(
                    "a",
                    { staticClass: "nav-item-hold", attrs: { href: "#" } },
                    [
                      _c("img", {
                        attrs: {
                          src: "https://cdn-icons-png.flaticon.com/512/8074/8074788.png",
                          width: "50%",
                        },
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "nav-text" }, [
                        _vm._v(_vm._s(_vm.$t("Schools"))),
                      ]),
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "triangle" }),
                ]
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  staticClass: "nav-item",
                  class: { active: _vm.selectedParentMenu == "kindergartens" },
                  attrs: { "data-item": "kindergartens", "data-submenu": true },
                  on: { mouseenter: _vm.toggleSubMenu },
                },
                [
                  _c(
                    "a",
                    { staticClass: "nav-item-hold", attrs: { href: "#" } },
                    [
                      _c("img", {
                        attrs: {
                          src: "https://cdn-icons-png.flaticon.com/512/7069/7069373.png",
                          width: "50%",
                        },
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "nav-text" }, [
                        _vm._v(_vm._s(_vm.$t("kindergartens"))),
                      ]),
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "triangle" }),
                ]
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  staticClass: "nav-item",
                  class: { active: _vm.selectedParentMenu == "centers" },
                  attrs: { "data-item": "centers", "data-submenu": true },
                  on: { mouseenter: _vm.toggleSubMenu },
                },
                [
                  _c(
                    "a",
                    { staticClass: "nav-item-hold", attrs: { href: "#" } },
                    [
                      _c("img", {
                        attrs: {
                          src: "https://cdn-icons-png.flaticon.com/512/7118/7118114.png",
                          width: "50%",
                        },
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "nav-text" }, [
                        _vm._v(_vm._s(_vm.$t("Entertainment"))),
                      ]),
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "triangle" }),
                ]
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  staticClass: "nav-item",
                  class: { active: _vm.selectedParentMenu == "educenters" },
                  attrs: { "data-item": "educenters", "data-submenu": true },
                  on: { mouseenter: _vm.toggleSubMenu },
                },
                [
                  _c(
                    "a",
                    { staticClass: "nav-item-hold", attrs: { href: "#" } },
                    [
                      _c("img", {
                        attrs: {
                          src: "https://cdn-icons-png.flaticon.com/512/1237/1237798.png",
                          width: "50%",
                        },
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "nav-text" }, [
                        _vm._v(_vm._s(_vm.$t("training_centers"))),
                      ]),
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "triangle" }),
                ]
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  staticClass: "nav-item",
                  class: { active: _vm.selectedParentMenu == "specialneeds" },
                  attrs: { "data-item": "specialneeds", "data-submenu": true },
                  on: { mouseenter: _vm.toggleSubMenu },
                },
                [
                  _c(
                    "a",
                    { staticClass: "nav-item-hold", attrs: { href: "#" } },
                    [
                      _c("img", {
                        attrs: {
                          src: "https://cdn-icons-png.flaticon.com/512/3996/3996139.png",
                          width: "50%",
                        },
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "nav-text" }, [
                        _vm._v(_vm._s(_vm.$t("specialneeds"))),
                      ]),
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "triangle" }),
                ]
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  staticClass: "nav-item",
                  class: { active: _vm.selectedParentMenu == "universities" },
                  attrs: { "data-item": "universities", "data-submenu": true },
                  on: { mouseenter: _vm.toggleSubMenu },
                },
                [
                  _c(
                    "a",
                    { staticClass: "nav-item-hold", attrs: { href: "#" } },
                    [
                      _c("img", {
                        attrs: {
                          src: "https://cdn-icons-png.flaticon.com/512/2997/2997322.png",
                          width: "50%",
                        },
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "nav-text" }, [
                        _vm._v(_vm._s(_vm.$t("Children Activites"))),
                      ]),
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "triangle" }),
                ]
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value:
                        _vm.currentUserPermissions &&
                        (_vm.currentUserPermissions.includes(
                          "Purchases_view"
                        ) ||
                          _vm.currentUserPermissions.includes("Purchases_add")),
                      expression:
                        "currentUserPermissions && (currentUserPermissions.includes('Purchases_view') \n                        || currentUserPermissions.includes('Purchases_add'))",
                    },
                  ],
                  staticClass: "nav-item",
                  class: { active: _vm.selectedParentMenu == "purchases" },
                  attrs: { "data-item": "purchases", "data-submenu": true },
                  on: { mouseenter: _vm.toggleSubMenu },
                },
                [
                  _c(
                    "a",
                    { staticClass: "nav-item-hold", attrs: { href: "#" } },
                    [
                      _c("img", {
                        attrs: {
                          src: "https://cdn-icons-png.flaticon.com/512/1019/1019607.png",
                          width: "50%",
                        },
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "nav-text" }, [
                        _vm._v(_vm._s(_vm.$t("Purchases"))),
                      ]),
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "triangle" }),
                ]
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value:
                        _vm.currentUserPermissions &&
                        (_vm.currentUserPermissions.includes("Sales_view") ||
                          _vm.currentUserPermissions.includes("Sales_add")),
                      expression:
                        "currentUserPermissions && (currentUserPermissions.includes('Sales_view') \n                        || currentUserPermissions.includes('Sales_add'))",
                    },
                  ],
                  staticClass: "nav-item",
                  class: { active: _vm.selectedParentMenu == "sales" },
                  attrs: { "data-item": "sales", "data-submenu": true },
                  on: { mouseenter: _vm.toggleSubMenu },
                },
                [
                  _c(
                    "a",
                    { staticClass: "nav-item-hold", attrs: { href: "#" } },
                    [
                      _c("img", {
                        attrs: {
                          src: "https://cdn-icons-png.flaticon.com/512/3211/3211596.png",
                          width: "50%",
                        },
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "nav-text" }, [
                        _vm._v(_vm._s(_vm.$t("Sales"))),
                      ]),
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "triangle" }),
                ]
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value:
                        _vm.currentUserPermissions &&
                        (_vm.currentUserPermissions.includes(
                          "Customers_view"
                        ) ||
                          _vm.currentUserPermissions.includes(
                            "Suppliers_view"
                          ) ||
                          _vm.currentUserPermissions.includes("users_view")),
                      expression:
                        "currentUserPermissions && (currentUserPermissions.includes('Customers_view') \n                        ||currentUserPermissions.includes('Suppliers_view')\n                        ||currentUserPermissions.includes('users_view'))",
                    },
                  ],
                  staticClass: "nav-item",
                  class: { active: _vm.selectedParentMenu == "People" },
                  attrs: { "data-item": "People", "data-submenu": true },
                  on: { mouseenter: _vm.toggleSubMenu },
                },
                [
                  _c(
                    "a",
                    { staticClass: "nav-item-hold", attrs: { href: "#" } },
                    [
                      _c("img", {
                        attrs: {
                          src: "https://cdn-icons-png.flaticon.com/512/921/921347.png",
                          width: "50%",
                        },
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "nav-text" }, [
                        _vm._v(_vm._s(_vm.$t("People"))),
                      ]),
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "triangle" }),
                ]
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value:
                        _vm.currentUserPermissions &&
                        (_vm.currentUserPermissions.includes(
                          "setting_system"
                        ) ||
                          _vm.currentUserPermissions.includes("warehouse") ||
                          _vm.currentUserPermissions.includes("brand") ||
                          _vm.currentUserPermissions.includes("backup") ||
                          _vm.currentUserPermissions.includes("unit") ||
                          _vm.currentUserPermissions.includes("currency") ||
                          _vm.currentUserPermissions.includes("category") ||
                          _vm.currentUserPermissions.includes(
                            "permissions_view"
                          )),
                      expression:
                        "currentUserPermissions && (currentUserPermissions.includes('setting_system') \n                        || currentUserPermissions.includes('warehouse') || currentUserPermissions.includes('brand')\n                        || currentUserPermissions.includes('backup')    || currentUserPermissions.includes('unit')\n                        || currentUserPermissions.includes('currency')  || currentUserPermissions.includes('category')\n                        || currentUserPermissions.includes('permissions_view'))",
                    },
                  ],
                  staticClass: "nav-item",
                  class: { active: _vm.selectedParentMenu == "settings" },
                  attrs: { "data-item": "settings", "data-submenu": true },
                  on: { mouseenter: _vm.toggleSubMenu },
                },
                [
                  _c(
                    "a",
                    { staticClass: "nav-item-hold", attrs: { href: "#" } },
                    [
                      _c("img", {
                        attrs: {
                          src: "https://cdn-icons-png.flaticon.com/512/738/738853.png",
                          width: "50%",
                        },
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "nav-text" }, [
                        _vm._v(_vm._s(_vm.$t("Settings"))),
                      ]),
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "triangle" }),
                ]
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value:
                        _vm.currentUserPermissions &&
                        (_vm.currentUserPermissions.includes(
                          "Reports_payments_Sales"
                        ) ||
                          _vm.currentUserPermissions.includes(
                            "Reports_payments_Purchases"
                          ) ||
                          _vm.currentUserPermissions.includes(
                            "Reports_payments_Sale_Returns"
                          ) ||
                          _vm.currentUserPermissions.includes(
                            "Reports_payments_purchase_Return"
                          ) ||
                          _vm.currentUserPermissions.includes(
                            "Warehouse_report"
                          ) ||
                          _vm.currentUserPermissions.includes(
                            "Reports_profit"
                          ) ||
                          _vm.currentUserPermissions.includes(
                            "Reports_purchase"
                          ) ||
                          _vm.currentUserPermissions.includes(
                            "Reports_quantity_alerts"
                          ) ||
                          _vm.currentUserPermissions.includes(
                            "Reports_sales"
                          ) ||
                          _vm.currentUserPermissions.includes(
                            "Reports_suppliers"
                          ) ||
                          _vm.currentUserPermissions.includes(
                            "Reports_customers"
                          )),
                      expression:
                        "currentUserPermissions && \n                     (currentUserPermissions.includes('Reports_payments_Sales') \n                     || currentUserPermissions.includes('Reports_payments_Purchases')\n                     || currentUserPermissions.includes('Reports_payments_Sale_Returns')\n                     || currentUserPermissions.includes('Reports_payments_purchase_Return')\n                     || currentUserPermissions.includes('Warehouse_report')\n                     || currentUserPermissions.includes('Reports_profit')\n                     || currentUserPermissions.includes('Reports_purchase') \n                     || currentUserPermissions.includes('Reports_quantity_alerts')\n                     || currentUserPermissions.includes('Reports_sales') \n                     || currentUserPermissions.includes('Reports_suppliers')\n                     || currentUserPermissions.includes('Reports_customers'))",
                    },
                  ],
                  staticClass: "nav-item",
                  class: { active: _vm.selectedParentMenu == "reports" },
                  attrs: { "data-item": "reports", "data-submenu": true },
                  on: { mouseenter: _vm.toggleSubMenu },
                },
                [
                  _c(
                    "a",
                    { staticClass: "nav-item-hold", attrs: { href: "#" } },
                    [
                      _c("img", {
                        attrs: {
                          src: "https://cdn-icons-png.flaticon.com/512/3029/3029337.png",
                          width: "50%",
                        },
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "nav-text" }, [
                        _vm._v(_vm._s(_vm.$t("Reports"))),
                      ]),
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "triangle" }),
                ]
              ),
            ]),
          ]),
        ]
      ),
      _vm._v(" "),
      _c(
        "vue-perfect-scrollbar",
        {
          staticClass: "sidebar-left-secondary ps rtl-ps-none",
          class: {
            open: _vm.getSideBarToggleProperties.isSecondarySideNavOpen,
          },
          attrs: {
            settings: { suppressScrollX: true, wheelPropagation: false },
          },
        },
        [
          _c("div", { ref: "sidebarChild" }, [
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "forms" },
                attrs: { "data-parent": "forms" },
              },
              [
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/forms/list" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Files" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("formsList"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "teachers" },
                attrs: { "data-parent": "teachers" },
              },
              [
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/teachers/store" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Add-File" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("AddTeacher"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/teachers/list" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Files" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("teachersList"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "educations" },
                attrs: { "data-parent": "educations" },
              },
              [
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/educations/store" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Add-File" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("AddEducation"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/educations/list" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Files" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("educationsList"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "schools" },
                attrs: { "data-parent": "schools" },
              },
              [
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/schools/store" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Add-File" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("addSchool"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/schools/list" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Files" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("schoolsList"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "universities" },
                attrs: { "data-parent": "universities" },
              },
              [
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/universities/store" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Add-File" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("add"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/universities/list" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Files" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("list"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "centers" },
                attrs: { "data-parent": "centers" },
              },
              [
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/centers/store" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Add-File" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("addcenters"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/centers/list" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Files" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("centersList"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "educenters" },
                attrs: { "data-parent": "educenters" },
              },
              [
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/educenters/store" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Add-File" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("add"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/educenters/list" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Files" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("list"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "kindergartens" },
                attrs: { "data-parent": "kindergartens" },
              },
              [
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/kindergartens/store" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Add-File" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("kindergartens"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/kindergartens/list" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Files" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("kindergartensList"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "specialneeds" },
                attrs: { "data-parent": "specialneeds" },
              },
              [
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/specialneeds/store" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Add-File" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("specialneeds"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/specialneeds/list" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Files" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("specialneedsList"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "products" },
                attrs: { "data-parent": "products" },
              },
              [
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("products_add")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/products/store" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Add-File" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("AddProduct"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("products_view")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/products/list" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Files" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("productsList"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "Kindergrants" },
                attrs: { "data-parent": "Kindergrants" },
              },
              [
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/Kindergrants/store" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Add-File" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("AddKindergrant"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/Kindergrants/list" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Files" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("KindergrantsList"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "deferreds" },
                attrs: { "data-parent": "deferreds" },
              },
              [
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("deferreds_add")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/deferreds/store" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Add-File" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("AddDeferreds"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("deferreds_view")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/deferreds/list" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Files" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("DeferredsList"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "adjustments" },
                attrs: { "data-parent": "adjustments" },
              },
              [
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("adjustment_add")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/adjustments/store" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Add-File" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("CreateAdjustment"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("adjustment_view")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/adjustments/list" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Files" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("ListAdjustments"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "transfers" },
                attrs: { "data-parent": "transfers" },
              },
              [
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("transfer_add")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/transfers/store" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Add-File" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("CreateTransfer"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("transfer_view")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/transfers/list" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Files" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("ListTransfers"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "expenses" },
                attrs: { "data-parent": "expenses" },
              },
              [
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("expense_add")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/expenses/store" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Add-File" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("Create_Expense"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("expense_view")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/expenses/list" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Files" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("ListExpenses"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("expense_view")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/expenses/category" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Files" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("Expense_Category"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "quotations" },
                attrs: { "data-parent": "quotations" },
              },
              [
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("Quotations_add")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/quotations/store" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Add-File" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("AddQuote"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("Quotations_view")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/quotations/list" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Files" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("ListQuotations"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "purchases" },
                attrs: { "data-parent": "purchases" },
              },
              [
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("Purchases_add")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/purchases/store" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Add-File" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("AddPurchase"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("Purchases_view")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/purchases/list" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Files" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("ListPurchases"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "sales" },
                attrs: { "data-parent": "sales" },
              },
              [
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("Sales_view")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/sales/list" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Files" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("ListSales"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "sale_return" },
                attrs: { "data-parent": "sale_return" },
              },
              [
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("Sale_Returns_add")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/sale_return/store" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Add-File" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("AddReturn"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("Sale_Returns_view")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/sale_return/list" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Files" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("ListReturns"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: {
                  "d-block": _vm.selectedParentMenu == "purchase_return",
                },
                attrs: { "data-parent": "purchase_return" },
              },
              [
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("Purchase_Returns_add")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          {
                            attrs: {
                              tag: "a",
                              to: "/app/purchase_return/store",
                            },
                          },
                          [
                            _c("i", { staticClass: "nav-icon i-Add-File" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("AddReturn"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("Purchase_Returns_view")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          {
                            attrs: {
                              tag: "a",
                              to: "/app/purchase_return/list",
                            },
                          },
                          [
                            _c("i", { staticClass: "nav-icon i-Files" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("ListReturns"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "People" },
                attrs: { "data-parent": "People" },
              },
              [
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("Customers_view")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/People/Customers" } },
                          [
                            _c("i", {
                              staticClass: "nav-icon i-Administrator",
                            }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("Customers"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("Suppliers_view")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/People/Suppliers" } },
                          [
                            _c("i", {
                              staticClass: "nav-icon i-Administrator",
                            }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("Suppliers"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("users_view")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/People/Users" } },
                          [
                            _c("i", {
                              staticClass: "nav-icon i-Administrator",
                            }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("Users"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "blogs" },
                attrs: { "data-parent": "blogs" },
              },
              [
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/blogs/store" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Add-File" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("AddBlog"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/blogs/list" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Files" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("blogsList"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "settings" },
                attrs: { "data-parent": "settings" },
              },
              [
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("setting_system")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          {
                            attrs: {
                              tag: "a",
                              to: "/app/settings/System_settings",
                            },
                          },
                          [
                            _c("i", {
                              staticClass: "nav-icon i-Data-Settings",
                            }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("SystemSettings"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _c(
                  "ul",
                  {
                    staticClass: "childNav d-none",
                    class: { "d-block": _vm.selectedParentMenu == "blogs" },
                    attrs: { "data-parent": "blogs" },
                  },
                  [
                    _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/blogs/store" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Add-File" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("AddBlog"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/blogs/list" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Files" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("blogsList"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    ),
                  ]
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/settings/Drops" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Bookmark" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("Drop"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/settings/Section" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Bookmark" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("Section"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("category")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          {
                            attrs: { tag: "a", to: "/app/settings/Categories" },
                          },
                          [
                            _c("i", {
                              staticClass: "nav-icon i-Duplicate-Layer",
                            }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("Categories"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/settings/Deals" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Bookmark" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("Deal"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/settings/Govs" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Bookmark" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("Gov"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/settings/Reviews" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Bookmark" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("Review"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/settings/Recentlys" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Bookmark" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("Recently"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/settings/Areas" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Bookmark" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("Area"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("brand")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/settings/Brands" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Bookmark" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("Brand"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _c(
                  "li",
                  { staticClass: "nav-item" },
                  [
                    _c(
                      "router-link",
                      { attrs: { tag: "a", to: "/app/settings/Institutions" } },
                      [
                        _c("i", { staticClass: "nav-icon i-Bookmark" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "item-name" }, [
                          _vm._v(_vm._s(_vm.$t("Institution"))),
                        ]),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("currency")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          {
                            attrs: { tag: "a", to: "/app/settings/Currencies" },
                          },
                          [
                            _c("i", { staticClass: "nav-icon i-Dollar-Sign" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("Currencies"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("unit")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/settings/Units" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Quotes" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("Units"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("backup")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          { attrs: { tag: "a", to: "/app/settings/Backup" } },
                          [
                            _c("i", { staticClass: "nav-icon i-Data-Backup" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("Backup"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
              ]
            ),
            _vm._v(" "),
            _c(
              "ul",
              {
                staticClass: "childNav d-none",
                class: { "d-block": _vm.selectedParentMenu == "reports" },
                attrs: { "data-parent": "reports" },
              },
              [
                _vm.currentUserPermissions &&
                (_vm.currentUserPermissions.includes(
                  "Reports_payments_Purchases"
                ) ||
                  _vm.currentUserPermissions.includes(
                    "Reports_payments_Sales"
                  ) ||
                  _vm.currentUserPermissions.includes(
                    "Reports_payments_Sale_Returns"
                  ) ||
                  _vm.currentUserPermissions.includes(
                    "Reports_payments_purchase_Return"
                  ))
                  ? _c(
                      "li",
                      {
                        staticClass: "nav-item dropdown-sidemenu",
                        on: {
                          click: function ($event) {
                            $event.preventDefault()
                            return _vm.toggleSidebarDropdwon($event)
                          },
                        },
                      },
                      [
                        _c("a", { attrs: { href: "#" } }, [
                          _c("i", { staticClass: "nav-icon i-Credit-Card" }),
                          _vm._v(" "),
                          _c("span", { staticClass: "item-name" }, [
                            _vm._v(_vm._s(_vm.$t("Payments"))),
                          ]),
                          _vm._v(" "),
                          _c("i", { staticClass: "dd-arrow i-Arrow-Down" }),
                        ]),
                        _vm._v(" "),
                        _c("ul", { staticClass: "submenu" }, [
                          _vm.currentUserPermissions &&
                          _vm.currentUserPermissions.includes(
                            "Reports_payments_Sales"
                          )
                            ? _c(
                                "li",
                                [
                                  _c(
                                    "router-link",
                                    {
                                      attrs: {
                                        tag: "a",
                                        to: "/app/reports/payments_sale",
                                      },
                                    },
                                    [
                                      _c("i", {
                                        staticClass: "nav-icon i-ID-Card",
                                      }),
                                      _vm._v(" "),
                                      _c("span", { staticClass: "item-name" }, [
                                        _vm._v(_vm._s(_vm.$t("Sales"))),
                                      ]),
                                    ]
                                  ),
                                ],
                                1
                              )
                            : _vm._e(),
                        ]),
                      ]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("Reports_profit")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          {
                            attrs: {
                              tag: "a",
                              to: "/app/reports/profit_and_loss",
                            },
                          },
                          [
                            _c("i", {
                              staticClass: "nav-icon i-Split-FourSquareWindow",
                            }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("ProfitandLoss"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("Reports_sales")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          {
                            attrs: {
                              tag: "a",
                              to: "/app/reports/sales_report",
                            },
                          },
                          [
                            _c("i", { staticClass: "nav-icon i-Line-Chart" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("SalesReport"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.currentUserPermissions &&
                _vm.currentUserPermissions.includes("Reports_customers")
                  ? _c(
                      "li",
                      { staticClass: "nav-item" },
                      [
                        _c(
                          "router-link",
                          {
                            attrs: {
                              tag: "a",
                              to: "/app/reports/customers_report",
                            },
                          },
                          [
                            _c("i", { staticClass: "nav-icon i-Bar-Chart" }),
                            _vm._v(" "),
                            _c("span", { staticClass: "item-name" }, [
                              _vm._v(_vm._s(_vm.$t("CustomersReport"))),
                            ]),
                          ]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
              ]
            ),
          ]),
        ]
      ),
      _vm._v(" "),
      _c("div", {
        staticClass: "sidebar-overlay",
        class: { open: _vm.getSideBarToggleProperties.isSecondarySideNavOpen },
        on: {
          click: function ($event) {
            return _vm.removeOverlay()
          },
        },
      }),
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/containers/layouts/largeSidebar/TopNav.vue?vue&type=template&id=7dfa9f1c&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/src/containers/layouts/largeSidebar/TopNav.vue?vue&type=template&id=7dfa9f1c& ***!
  \*******************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "main-header" }, [
    _c(
      "div",
      { staticClass: "logo" },
      [
        _c("router-link", { attrs: { to: "/app/dashboard" } }, [
          _c("img", {
            attrs: {
              src: "/images/" + _vm.currentUser.logo,
              alt: "",
              width: "60",
              height: "60",
            },
          }),
        ]),
      ],
      1
    ),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "menu-toggle", on: { click: _vm.sideBarToggle } },
      [_c("div"), _vm._v(" "), _c("div"), _vm._v(" "), _c("div")]
    ),
    _vm._v(" "),
    _c("div", { staticStyle: { margin: "auto" } }),
    _vm._v(" "),
    _c("div", { staticClass: "header-part-right" }, [
      _c("i", {
        staticClass: "i-Full-Screen header-icon d-none d-sm-inline-block",
        on: { click: _vm.handleFullScreen },
      }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "dropdown" },
        [
          _c(
            "b-dropdown",
            {
              staticClass: "m-md-2 d-none  d-md-block",
              attrs: {
                id: "dropdown",
                text: "Dropdown Button",
                "toggle-class": "text-decoration-none",
                "no-caret": "",
                variant: "link",
              },
            },
            [
              _c("template", { slot: "button-content" }, [
                _c("i", {
                  staticClass: "i-Globe text-muted header-icon",
                  attrs: {
                    role: "button",
                    id: "dropdownMenuButton",
                    "data-toggle": "dropdown",
                    "aria-haspopup": "true",
                    "aria-expanded": "false",
                  },
                }),
              ]),
              _vm._v(" "),
              _c(
                "vue-perfect-scrollbar",
                {
                  ref: "myData",
                  staticClass:
                    "dropdown-menu-right rtl-ps-none notification-dropdown ps scroll",
                  attrs: {
                    settings: {
                      suppressScrollX: true,
                      wheelPropagation: false,
                    },
                  },
                },
                [
                  _c("div", { staticClass: "menu-icon-grid" }, [
                    _c(
                      "a",
                      {
                        on: {
                          click: function ($event) {
                            return _vm.SetLocal("en")
                          },
                        },
                      },
                      [
                        _c("i", {
                          staticClass:
                            "flag-icon flag-icon-squared flag-icon-gb",
                          attrs: { title: "en" },
                        }),
                        _vm._v(" English\n            "),
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "a",
                      {
                        on: {
                          click: function ($event) {
                            return _vm.SetLocal("ar")
                          },
                        },
                      },
                      [
                        _c("i", {
                          staticClass:
                            "flag-icon flag-icon-squared flag-icon-sa",
                          attrs: { title: "sa" },
                        }),
                        _vm._v(" "),
                        _c("span", { staticClass: "title-lang" }, [
                          _vm._v("Arabic"),
                        ]),
                      ]
                    ),
                  ]),
                ]
              ),
            ],
            2
          ),
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "dropdown" },
        [
          _c(
            "b-dropdown",
            {
              staticClass:
                "m-md-2 badge-top-container d-none  d-sm-inline-block",
              attrs: {
                id: "dropdown-1",
                text: "Dropdown Button",
                "toggle-class": "text-decoration-none",
                "no-caret": "",
                variant: "link",
              },
            },
            [
              _c("template", { slot: "button-content" }, [
                _vm.phone_alert.length > 0
                  ? _c("span", { staticClass: "badge badge-primary" }, [
                      _vm._v("1"),
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _c("i", { staticClass: "i-Bell text-muted header-icon" }),
              ]),
              _vm._v(" "),
              _c(
                "vue-perfect-scrollbar",
                {
                  ref: "myData",
                  staticClass:
                    "dropdown-menu-right rtl-ps-none notification-dropdown ps scroll",
                  class: { open: _vm.getSideBarToggleProperties.isSideNavOpen },
                  attrs: {
                    settings: {
                      suppressScrollX: true,
                      wheelPropagation: false,
                    },
                  },
                },
                [
                  _c("div", { staticClass: "dropdown-item d-flex" }, [
                    _c(
                      "div",
                      {
                        staticClass: "notification-icon",
                        on: { click: _vm.updateUserMessage },
                      },
                      [_c("i", { staticClass: "i-Bell text-primary mr-1" })]
                    ),
                    _vm._v(" "),
                    _vm.currentUserPermissions &&
                    _vm.currentUserPermissions.includes(
                      "Reports_quantity_alerts"
                    )
                      ? _c(
                          "div",
                          { staticClass: "notification-details flex-grow-1" },
                          [
                            _c(
                              "router-link",
                              { attrs: { tag: "a", to: "/app/People/Users" } },
                              _vm._l(_vm.phone_alert, function (i) {
                                return _c(
                                  "p",
                                  { staticClass: "text-small text-muted m-0" },
                                  [
                                    _vm._v(
                                      "\n                " +
                                        _vm._s(i["phone"]) +
                                        "  \n                "
                                    ),
                                  ]
                                )
                              }),
                              0
                            ),
                          ],
                          1
                        )
                      : _vm._e(),
                  ]),
                ]
              ),
            ],
            2
          ),
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "dropdown" },
        [
          _c(
            "b-dropdown",
            {
              staticClass:
                "m-md-2 badge-top-container d-none  d-sm-inline-block",
              attrs: {
                id: "dropdown-1",
                text: "Dropdown Button",
                "toggle-class": "text-decoration-none",
                "no-caret": "",
                variant: "link",
              },
            },
            [
              _c("template", { slot: "button-content" }, [
                _vm.notifs_alert > 0
                  ? _c("span", { staticClass: "badge badge-primary" }, [
                      _vm._v("1"),
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _c("i", { staticClass: "i-Bell text-muted header-icon" }),
              ]),
              _vm._v(" "),
              _c(
                "vue-perfect-scrollbar",
                {
                  ref: "myData",
                  staticClass:
                    "dropdown-menu-right rtl-ps-none notification-dropdown ps scroll",
                  class: { open: _vm.getSideBarToggleProperties.isSideNavOpen },
                  attrs: {
                    settings: {
                      suppressScrollX: true,
                      wheelPropagation: false,
                    },
                  },
                },
                [
                  _vm.notifs_alert > 0
                    ? _c("div", { staticClass: "dropdown-item d-flex" }, [
                        _c("div", { staticClass: "notification-icon" }, [
                          _c("i", { staticClass: "i-Bell text-primary mr-1" }),
                        ]),
                        _vm._v(" "),
                        _vm.currentUserPermissions &&
                        _vm.currentUserPermissions.includes(
                          "Reports_quantity_alerts"
                        )
                          ? _c(
                              "div",
                              {
                                staticClass: "notification-details flex-grow-1",
                              },
                              [
                                _c(
                                  "router-link",
                                  {
                                    attrs: {
                                      tag: "a",
                                      to: "/app/reports/quantity_alerts",
                                    },
                                  },
                                  [
                                    _c(
                                      "p",
                                      {
                                        staticClass:
                                          "text-small text-muted m-0",
                                      },
                                      [
                                        _vm._v(
                                          "\n                " +
                                            _vm._s(_vm.notifs_alert) +
                                            " " +
                                            _vm._s(
                                              _vm.$t("ProductQuantityAlerts")
                                            ) +
                                            "\n                "
                                        ),
                                      ]
                                    ),
                                  ]
                                ),
                              ],
                              1
                            )
                          : _vm._e(),
                      ])
                    : _vm._e(),
                ]
              ),
            ],
            2
          ),
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "dropdown" },
        [
          _c(
            "b-dropdown",
            {
              staticClass: "m-md-2 user col align-self-end d-md-block",
              attrs: {
                id: "dropdown-1",
                text: "Dropdown Button",
                "toggle-class": "text-decoration-none",
                "no-caret": "",
                variant: "link",
              },
            },
            [
              _c("template", { slot: "button-content" }, [
                _c("img", {
                  attrs: {
                    src: "/images/avatar/" + _vm.currentUser.avatar,
                    id: "userDropdown",
                    alt: "",
                    "data-toggle": "dropdown",
                    "aria-haspopup": "true",
                    "aria-expanded": "false",
                  },
                }),
              ]),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass: "dropdown-menu-right",
                  attrs: { "aria-labelledby": "userDropdown" },
                },
                [
                  _c("div", { staticClass: "dropdown-header" }, [
                    _c("i", { staticClass: "i-Lock-User mr-1" }),
                    _vm._v(" "),
                    _c("span", [_vm._v(_vm._s(_vm.currentUser.username))]),
                  ]),
                  _vm._v(" "),
                  _c(
                    "router-link",
                    {
                      staticClass: "dropdown-item",
                      attrs: { to: "/app/profile" },
                    },
                    [_vm._v(_vm._s(_vm.$t("profil")))]
                  ),
                  _vm._v(" "),
                  _vm.currentUserPermissions &&
                  _vm.currentUserPermissions.includes("setting_system")
                    ? _c(
                        "router-link",
                        {
                          staticClass: "dropdown-item",
                          attrs: { to: "/app/settings/System_settings" },
                        },
                        [_vm._v(_vm._s(_vm.$t("Settings")))]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _c(
                    "a",
                    {
                      staticClass: "dropdown-item",
                      attrs: { href: "#" },
                      on: {
                        click: function ($event) {
                          $event.preventDefault()
                          return _vm.logoutUser($event)
                        },
                      },
                    },
                    [_vm._v(_vm._s(_vm.$t("logout")))]
                  ),
                ],
                1
              ),
            ],
            2
          ),
        ],
        1
      ),
    ]),
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/containers/layouts/largeSidebar/index.vue?vue&type=template&id=427f8858&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/src/containers/layouts/largeSidebar/index.vue?vue&type=template&id=427f8858& ***!
  \******************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "app-admin-wrap layout-sidebar-large clearfix" },
    [
      _c("top-nav"),
      _vm._v(" "),
      _c("sidebar"),
      _vm._v(" "),
      _c("main", [
        _c(
          "div",
          {
            staticClass: "main-content-wrap d-flex flex-column flex-grow-1",
            class: {
              "sidenav-open": _vm.getSideBarToggleProperties.isSideNavOpen,
            },
          },
          [
            _c(
              "transition",
              { attrs: { name: "page", mode: "out-in" } },
              [_c("router-view")],
              1
            ),
            _vm._v(" "),
            _c("div", { staticClass: "flex-grow-1" }),
            _vm._v(" "),
            _c("appFooter"),
          ],
          1
        ),
      ]),
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/src/containers/layouts/common/footer.vue":
/*!************************************************************!*\
  !*** ./resources/src/containers/layouts/common/footer.vue ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _footer_vue_vue_type_template_id_1dfb17ff_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./footer.vue?vue&type=template&id=1dfb17ff&scoped=true& */ "./resources/src/containers/layouts/common/footer.vue?vue&type=template&id=1dfb17ff&scoped=true&");
/* harmony import */ var _footer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./footer.vue?vue&type=script&lang=js& */ "./resources/src/containers/layouts/common/footer.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _footer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _footer_vue_vue_type_template_id_1dfb17ff_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _footer_vue_vue_type_template_id_1dfb17ff_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "1dfb17ff",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/src/containers/layouts/common/footer.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/src/containers/layouts/common/footer.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./resources/src/containers/layouts/common/footer.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_footer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./footer.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/containers/layouts/common/footer.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_footer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/src/containers/layouts/common/footer.vue?vue&type=template&id=1dfb17ff&scoped=true&":
/*!*******************************************************************************************************!*\
  !*** ./resources/src/containers/layouts/common/footer.vue?vue&type=template&id=1dfb17ff&scoped=true& ***!
  \*******************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_footer_vue_vue_type_template_id_1dfb17ff_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./footer.vue?vue&type=template&id=1dfb17ff&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/containers/layouts/common/footer.vue?vue&type=template&id=1dfb17ff&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_footer_vue_vue_type_template_id_1dfb17ff_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_footer_vue_vue_type_template_id_1dfb17ff_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/src/containers/layouts/largeSidebar/Sidebar.vue":
/*!*******************************************************************!*\
  !*** ./resources/src/containers/layouts/largeSidebar/Sidebar.vue ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Sidebar_vue_vue_type_template_id_696fbebe_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Sidebar.vue?vue&type=template&id=696fbebe&scoped=true& */ "./resources/src/containers/layouts/largeSidebar/Sidebar.vue?vue&type=template&id=696fbebe&scoped=true&");
/* harmony import */ var _Sidebar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Sidebar.vue?vue&type=script&lang=js& */ "./resources/src/containers/layouts/largeSidebar/Sidebar.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Sidebar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Sidebar_vue_vue_type_template_id_696fbebe_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Sidebar_vue_vue_type_template_id_696fbebe_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "696fbebe",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/src/containers/layouts/largeSidebar/Sidebar.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/src/containers/layouts/largeSidebar/Sidebar.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/src/containers/layouts/largeSidebar/Sidebar.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Sidebar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Sidebar.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/containers/layouts/largeSidebar/Sidebar.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Sidebar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/src/containers/layouts/largeSidebar/Sidebar.vue?vue&type=template&id=696fbebe&scoped=true&":
/*!**************************************************************************************************************!*\
  !*** ./resources/src/containers/layouts/largeSidebar/Sidebar.vue?vue&type=template&id=696fbebe&scoped=true& ***!
  \**************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Sidebar_vue_vue_type_template_id_696fbebe_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Sidebar.vue?vue&type=template&id=696fbebe&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/containers/layouts/largeSidebar/Sidebar.vue?vue&type=template&id=696fbebe&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Sidebar_vue_vue_type_template_id_696fbebe_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Sidebar_vue_vue_type_template_id_696fbebe_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/src/containers/layouts/largeSidebar/TopNav.vue":
/*!******************************************************************!*\
  !*** ./resources/src/containers/layouts/largeSidebar/TopNav.vue ***!
  \******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TopNav_vue_vue_type_template_id_7dfa9f1c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TopNav.vue?vue&type=template&id=7dfa9f1c& */ "./resources/src/containers/layouts/largeSidebar/TopNav.vue?vue&type=template&id=7dfa9f1c&");
/* harmony import */ var _TopNav_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TopNav.vue?vue&type=script&lang=js& */ "./resources/src/containers/layouts/largeSidebar/TopNav.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TopNav_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TopNav_vue_vue_type_template_id_7dfa9f1c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TopNav_vue_vue_type_template_id_7dfa9f1c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/src/containers/layouts/largeSidebar/TopNav.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/src/containers/layouts/largeSidebar/TopNav.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/src/containers/layouts/largeSidebar/TopNav.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TopNav_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./TopNav.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/containers/layouts/largeSidebar/TopNav.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TopNav_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/src/containers/layouts/largeSidebar/TopNav.vue?vue&type=template&id=7dfa9f1c&":
/*!*************************************************************************************************!*\
  !*** ./resources/src/containers/layouts/largeSidebar/TopNav.vue?vue&type=template&id=7dfa9f1c& ***!
  \*************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TopNav_vue_vue_type_template_id_7dfa9f1c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./TopNav.vue?vue&type=template&id=7dfa9f1c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/containers/layouts/largeSidebar/TopNav.vue?vue&type=template&id=7dfa9f1c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TopNav_vue_vue_type_template_id_7dfa9f1c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TopNav_vue_vue_type_template_id_7dfa9f1c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/src/containers/layouts/largeSidebar/index.vue":
/*!*****************************************************************!*\
  !*** ./resources/src/containers/layouts/largeSidebar/index.vue ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _index_vue_vue_type_template_id_427f8858___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index.vue?vue&type=template&id=427f8858& */ "./resources/src/containers/layouts/largeSidebar/index.vue?vue&type=template&id=427f8858&");
/* harmony import */ var _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./index.vue?vue&type=script&lang=js& */ "./resources/src/containers/layouts/largeSidebar/index.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _index_vue_vue_type_template_id_427f8858___WEBPACK_IMPORTED_MODULE_0__["render"],
  _index_vue_vue_type_template_id_427f8858___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/src/containers/layouts/largeSidebar/index.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/src/containers/layouts/largeSidebar/index.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/src/containers/layouts/largeSidebar/index.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/containers/layouts/largeSidebar/index.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/src/containers/layouts/largeSidebar/index.vue?vue&type=template&id=427f8858&":
/*!************************************************************************************************!*\
  !*** ./resources/src/containers/layouts/largeSidebar/index.vue?vue&type=template&id=427f8858& ***!
  \************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_427f8858___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./index.vue?vue&type=template&id=427f8858& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/containers/layouts/largeSidebar/index.vue?vue&type=template&id=427f8858&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_427f8858___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_427f8858___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/src/utils/index.js":
/*!**************************************!*\
  !*** ./resources/src/utils/index.js ***!
  \**************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var toggleFullScreen = function toggleFullScreen() {
  var doc = window.document;
  var docEl = doc.documentElement;
  var requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;
  var cancelFullScreen = doc.exitFullscreen || doc.mozCancelFullScreen || doc.webkitExitFullscreen || doc.msExitFullscreen;

  if (!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) {
    requestFullScreen.call(docEl);
  } else {
    cancelFullScreen.call(doc);
  }
};

/* harmony default export */ __webpack_exports__["default"] = ({
  toggleFullScreen: toggleFullScreen
});

/***/ })

}]);