<?php
$returnMessage = array('error'=>false,'message'=>'');
if (isset($_FILES["fridge_csv"])) {
    if ($_FILES["file"]["error"] > 0) {
        $returnMessage['error'] = true;
        $returnMessage['message'] = 'There was an error uploading the Fridge List CSV file';
        die (json_encode($returnMessage));
    }
    else {
        $tmpName = $_FILES["fridge_csv"]["tmp_name"];
        $fridgeList = array_map('str_getcsv', file($tmpName));
    }
} else {
    $returnMessage['error'] = true;
    $returnMessage['message'] = 'Please Select a Fridge List CSV File';
    die (json_encode($returnMessage));
}
if (isset($_FILES["recipe_json"])) {
    if ($_FILES["file"]["error"] > 0) {
        $returnMessage['error'] = true;
        $returnMessage['message'] = 'There was an error uploading the Recipe JSON file';
        die (json_encode($returnMessage));
    }
    else {
        $tmpNameRecipe = $_FILES["recipe_json"]["tmp_name"];
        $recipeList = json_decode(file_get_contents($tmpNameRecipe), true);
    }
} else {
    $returnMessage['error'] = true;
    $returnMessage['message'] = 'Please Select a Recipe JSON File';
    die (json_encode($returnMessage));
}

// TEST if data is parsed correctly
$returnMessage['error'] = true;
$returnMessage['message'] = 'Testing is data is parsed correctly';
$returnMessage['fridge'] = $fridgeList;
$returnMessage['recipe'] = $recipeList;
die (json_encode($returnMessage));
?>