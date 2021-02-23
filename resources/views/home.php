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
                    <div class="col-12">
                        <ul v-if="errors && errors.length > 0" class="alert alert-danger" role="alert">
                          <li v-for="msg in errors">{{ msg }}</li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <form v-on:submit.prevent="createMatrix($event, matrix1)">
                            <h3>Matrix 1</h3>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="matrix1Rows">Rows</label>
                                  <input class="form-control" v-model.number="matrix1.rows" id="matrix1Rows" />
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="matrix1Cols">Columns</label>
                                  <input class="form-control" v-model.number="matrix1.cols" id="matrix1Cols">
                                </div>
                              </div>
                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-secondary" value="Create Matrix">
                                <button type="button" class="btn btn-outline-secondary" v-on:click="matrix1.isEditing = !matrix1.isEditing">{{ matrix1.isEditing ? 'Done Editing' : 'Edit Values' }}</button>
                            </div>
                            <div class="matrix-wrapper">
                                <table v-if="matrix1.cells.length > 0" class="matrix">
                                    <tr v-for="row in matrix1.cells">
                                        <td v-if="matrix1.isEditing" v-for="(val, cIdx) in row"><input v-model.number="row[cIdx]" size="3" /></td>
                                        <td v-if="!matrix1.isEditing" v-for="val in row">{{ val }}</td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <form v-on:submit.prevent="createMatrix($event, matrix2)">
                            <h3>Matrix 2</h3>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="matrix2Rows">Rows</label>
                                  <input class="form-control" v-model.number="matrix2.rows" id="matrix2Rows" />
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="matrix2Cols">Columns</label>
                                  <input class="form-control" v-model.number="matrix2.cols" id="matrix2Cols">
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-secondary" value="Create Matrix">
                                <button type="button" class="btn btn-outline-secondary" v-on:click="matrix2.isEditing = !matrix2.isEditing">{{ matrix2.isEditing ? 'Done Editing' : 'Edit Values' }}</button>
                            </div>
                            <div class="matrix-wrapper">
                                <table v-if="matrix2.cells.length > 0" class="matrix">
                                    <tr v-for="row in matrix2.cells">
                                        <td v-if="matrix2.isEditing" v-for="(val, cIdx) in row"><input v-model.number="row[cIdx]" size="3" /></td>
                                        <td v-if="!matrix2.isEditing" v-for="val in row">{{ val }}</td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center">
                    <button type="button" class="btn btn-lg btn-block btn-primary" v-on:click="multiplyMatrices" v-bind:disabled="isMultiplying || matrix1.isEditing || matrix2.isEditing">
                        <span v-if="isMultiplying" class="spinner-border" role="status" aria-hidden="true"></span>
                        <span v-if="!isMultiplying">Multiply</span>
                    </button>
                    <br><br>
                </div>
                <div class="row" v-if="!isMultiplying">
                    <div class="col-lg-6" v-if="result">
                        <h3>Result</h3>
                        <div class="matrix-wrapper">
                            <table class="matrix">
                                <tr v-for="row in result">
                                    <td v-for="val in row">{{ val }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-6" v-if="resultInChars">
                        <h3>Result in Alphabets</h3>
                        <div class="matrix-wrapper">
                            <table class="matrix">
                                <tr v-for="row in resultInChars">
                                    <td v-for="val in row">{{ val }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/app.js"></script>
    </body>
</html>