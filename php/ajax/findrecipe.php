<?php
require_once(dirname(__FILE__).'/../class/FindRecipe.php');
$returnMessage = array('error'=>false,'message'=>'');
if (isset($_FILES["fridge_csv"])) {
    if ($_FILES["file"]["error"] > 0) {
        $returnMessage['error'] = true;
        $returnMessage['message'] = 'There was an error uploading the Fridge List CSV file';
        die (json_encode($returnMessage));
    }
    else {
        $fridgeTempName = $_FILES["fridge_csv"]["tmp_name"];
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
        $recipeTempName = $_FILES["recipe_json"]["tmp_name"];
    }
} else {
    $returnMessage['error'] = true;
    $returnMessage['message'] = 'Please Select a Recipe JSON File';
    die (json_encode($returnMessage));
}

// TEST if data is parsed correctly
$returnMessage['error'] = false;
$returnMessage['message'] = 'Testing is data is parsed correctly';
$findRecipe = new FindRecipe($recipeTempName, $fridgeTempName);
$returnMessage['recipes'] = $findRecipe->findRecipe();
die (json_encode($returnMessage));

?>