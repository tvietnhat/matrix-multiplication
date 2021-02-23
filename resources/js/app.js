/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

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

const vApp = new Vue({
    el: '#app',
    data: {
        matrix1: { rows: 7, cols: 10, cells: [], isEditing: false },
        matrix2: { rows: 10, cols: 8, cells: [], isEditing: false },
        result: null,
        resultInChars: null,
        errors: [],
        isMultiplying: false,
    },
    methods: {
        refreshMatrix: function (matrix) {
            matrix.cells = [];
            for (var rIdx = 0; rIdx < matrix.rows; rIdx++) {
                var row = new Array(matrix.cols); 
                for (var cIdx = 0; cIdx < matrix.cols; cIdx++) {
                    row[cIdx] = Math.floor(Math.random() * Math.floor(matrix.rows + matrix.cols));
                }
                matrix.cells.push(row);
            }
        },
        createMatrix: function (event, matrix) {
            this.refreshMatrix(matrix);
        },
        multiplyMatrices(event) {
            // setting up
            this.errors = null;
            this.result = null;
            this.resultInChars = null;
            this.isMultiplying = true;
            var thisApp = this;
            
            // request for calculation from api
            axios.post('api/multiply-matrices', {
                matrix1: this.matrix1.cells,
                matrix2: this.matrix2.cells,
            })
            .then(function (response) {
              // handle success
              console.log(response.data);
              if (response.data.success) {
                  thisApp.result = response.data.result;
                  thisApp.resultInChars = response.data.resultInChars;
              } else if (response.data.error) {
                  thisApp.errors = [ response.data.error ];
              }
            })
            .catch(function (error) {
                console.log(error);
            })
            .then(function () {
                // always executed
                // pretend delay
                setTimeout(function(){ thisApp.isMultiplying = false; }, 1000);
            });
        }
    },
    created: function () {
        this.refreshMatrix(this.matrix1);
        this.refreshMatrix(this.matrix2);
    }
});


window.vApp = vApp;