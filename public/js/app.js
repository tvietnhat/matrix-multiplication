(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/app"],{

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
__webpack_require__(/*! ./bootstrap */ "./resources/js/bootstrap.js");
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


var vApp = new Vue({
  el: '#app',
  data: {
    matrix1: {
      rows: 7,
      cols: 10,
      cells: [],
      isEditing: false
    },
    matrix2: {
      rows: 10,
      cols: 8,
      cells: [],
      isEditing: false
    },
    result: null,
    resultInChars: null,
    errors: [],
    isMultiplying: false
  },
  methods: {
    refreshMatrix: function refreshMatrix(matrix) {
      matrix.cells = [];

      for (var rIdx = 0; rIdx < matrix.rows; rIdx++) {
        var row = new Array(matrix.cols);

        for (var cIdx = 0; cIdx < matrix.cols; cIdx++) {
          row[cIdx] = Math.floor(Math.random() * Math.floor(matrix.rows + matrix.cols));
        }

        matrix.cells.push(row);
      }
    },
    createMatrix: function createMatrix(event, matrix) {
      this.refreshMatrix(matrix);
    },
    multiplyMatrices: function multiplyMatrices(event) {
      // setting up
      this.errors = null;
      this.result = null;
      this.resultInChars = null;
      this.isMultiplying = true;
      var thisApp = this; // request for calculation from api

      axios.post('api/multiply-matrices', {
        matrix1: this.matrix1.cells,
        matrix2: this.matrix2.cells
      }).then(function (response) {
        // handle success
        console.log(response.data);

        if (response.data.success) {
          thisApp.result = response.data.result;
          thisApp.resultInChars = response.data.resultInChars;
        } else if (response.data.error) {
          thisApp.errors = [response.data.error];
        }
      })["catch"](function (error) {
        console.log(error);
      }).then(function () {
        // always executed
        // pretend delay
        setTimeout(function () {
          thisApp.isMultiplying = false;
        }, 1000);
      });
    }
  },
  created: function created() {
    this.refreshMatrix(this.matrix1);
    this.refreshMatrix(this.matrix2);
  }
});
window.vApp = vApp;

/***/ }),

/***/ "./resources/js/bootstrap.js":
/*!***********************************!*\
  !*** ./resources/js/bootstrap.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

// window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
try {//window.Popper = require('popper.js').default;
  //window.$ = window.jQuery = require('jquery');
  // require('bootstrap');
} catch (e) {}
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */


window.axios = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Vue = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js").default;
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
// import Echo from 'laravel-echo';
// window.Pusher = require('pusher-js');
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

},
0,[["./resources/js/app.js","/js/manifest","/js/vendor"],["./resources/sass/app.scss","/js/manifest","/js/vendor"]]]);