<html>
<head>
    <link rel="stylesheet" href="assets/plugins/bootstrap.min.css">
    <script src="assets/plugins/jquery-3.2.1.min.js"></script>
    <script src="assets/plugins/bootstrap.min.js"></script>
    <script src="assets/recipefinder.js"></script>
    <style>
        ol li{
            font-size:20px;
        }
        ul li{
            font-size:16px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Recipe Finder</h1>
    <h2>Please upload a list of item in the fridge (CSV) and upload a list of recipes (JSON)</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Select Fridge CSV File</label>
                <input class="form-control" type="file" id="fridge_csv" name="fridge_csv">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Select Recipe JSON File</label>
                <input class="form-control" type="file" id="recipe_json" name="recipe_json">
            </div>
        </div>
    </div>
    <button class="btn btn-md btn-info" id="find_recipe_btn">What to cook tonight?</button>
    <div id="error_wrapper" style="display:none;"></div>
    <div id="results_wrapper" class="row" style="display:none;">
        <div class="col-md-12">
            <h2>You can cook:</h2>
        </div>
        <div class="col-md-12">
            <ol id="results">

            </ol>
        </div>
    </div>
</div>
</body>
</html>