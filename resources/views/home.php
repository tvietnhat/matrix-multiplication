<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Home</title>
        
        <link rel="stylesheet" href="css/app.css">
        <script src="js/manifest.js"></script>
        <script src="js/vendor.js"></script>
        
    </head>
    <body>
        <div id="app">
            <div class="container">
                
                <h1 class="text-center">Matrix Multiplication</h1>
                <div class="row">
                    <div class="col-lg-6">
                        <form v-on:submit.prevent="createMatrix($event, matrix1)">
                            <h3>Matrix 1</h3>
                            <div class="form-group">
                                Rows: <input v-model.number="matrix1.rows" size="4" type="number" max="100" />
                            </div>
                            <div class="form-group">
                                Columns: <input v-model.number="matrix1.cols" size="4" type="number" max="100" />
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-secondary" value="Create Matrix">
                            </div>
                            <table v-if="matrix1.cells.length > 0" class="matrix">
                                <tr v-for="row in matrix1.cells">
                                    <td v-for="val in row">{{ val }}</td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <form v-on:submit.prevent="createMatrix($event, matrix2)">
                            <h3>Matrix 2</h3>
                            <div class="form-group">
                                Rows: <input v-model.number="matrix2.rows" size="4" type="number" max="100" />
                            </div>
                            <div class="form-group">
                                Columns: <input v-model.number="matrix2.cols" size="4" type="number" max="100" />
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-secondary" value="Create Matrix">
                            </div>
                            <table v-if="matrix2.cells.length > 0" class="matrix">
                                <tr v-for="row in matrix2.cells">
                                    <td v-for="val in row">{{ val }}</td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
                <div class="text-center"><button type="button" class="btn btn-lg btn-block btn-primary" v-on:click="multiplyMatrices">Multiply</button></div>
            </div>
        </div>
        <script src="js/app.js"></script>
    </body>
</html>