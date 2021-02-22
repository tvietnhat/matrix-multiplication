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
        matrix1: { rows: 10, cols: 10, cells: [] },
        matrix2: { rows: 10, cols: 10, cells: [] },
    },
    methods: {
        createMatrix: function (event, matrix) {
            refreshMatrix(matrix);
        },
        multiplyMatrices(event) {
            axios.post('api/multiply-matrices')
            .then(function (response) {
              // handle success
              console.log(response.data);
            });
        }
    },
    created: function () {
        refreshMatrix(this.matrix1);
        refreshMatrix(this.matrix2);
    }
});

function refreshMatrix(matrix) {
    matrix.cells = [];
    for (var rIdx = 0; rIdx < matrix.rows; rIdx++) {
        var row = new Array(matrix.cols); 
        for (var cIdx = 0; cIdx < matrix.cols; cIdx++) {
            row[cIdx] = Math.floor(Math.random() * Math.floor(matrix.rows + matrix.cols));
        }
        matrix.cells.push(row);
    }
}

window.vApp = vApp;