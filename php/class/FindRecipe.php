<?php

class FindRecipe{
    private $recipeList;
    private $fridgeList;
    private $debug;

    public function __construct($recipeFile, $fridgeFile){
        $fridgeList = array_map('str_getcsv', file($fridgeFile));
        $this->fridgeList = $this->parseFridgeCSV($fridgeList);
        $this->recipeList = json_decode(file_get_contents($recipeFile), true);
        $this->debug = true;
    }
    public function findRecipe(){
        if(empty($this->recipeList)){
            return false;
        }
        if(empty($this->fridgeList)){
            return false;
        }
        $returnArray = array();
        foreach($this->recipeList as $recipe){
            $temp = $this->checkRecipe($recipe);
            if ($temp !== false){
                $returnArray[] = $temp;
            }
        }
        usort($returnArray, array($this,'cmpUseBy'));
        return $returnArray;
    }

    public function checkRecipe($recipe){
        if ($this->debug) {
            error_log($recipe['name']);
        }
        if (empty($recipe['ingredients'])){
            return false;
            if ($this->debug) {
                error_log($recipe['name'] . ' no ingredients found');
            }
        }
        $itemInvalid = false;
        $closestUseBy = false;
        $itemsCount = count($recipe['ingredients']);
        $itemsFound = 0;
        foreach($recipe['ingredients'] as $ingredient){
            if (!empty($ingredient['item']) && !empty($ingredient['amount']) && !empty($ingredient['unit'])){
                foreach($this->fridgeList as $fridgeItem) {
                    if ($fridgeItem['item'] === $ingredient['item'] && $fridgeItem['unit'] === $ingredient['unit']) {
                        if ($fridgeItem['amount'] < $ingredient['amount']) {
                            $itemInvalid = true;
                            if ($this->debug) {
                                error_log($recipe['name'] . '/' . $ingredient['item'] . ' not enough amount');
                            }
                        }
                        if (strtotime($fridgeItem['useBy']) < time()) {
                            $itemInvalid = true;
                            if ($this->debug) {
                                error_log($recipe['name'] . '/' . $ingredient['item'] . ' useBy: ' . $fridgeItem['useBy']);
                                error_log('Current Time: ' . time());
                                error_log($recipe['name'] . '/' . $ingredient['item'] . ' expired');
                            }
                        }
                        if ($itemInvalid === false) {
                            $itemsFound++;
                            if ($closestUseBy === false) {
                                $closestUseBy = strtotime($fridgeItem['useBy']);
                                if ($this->debug) {
                                    error_log($recipe['name'] . '/' . $ingredient['item'] . ' useBy: ' . $fridgeItem['useBy']);
                                }
                            } elseif ($closestUseBy > strtotime($fridgeItem['useBy'])) {
                                if ($this->debug) {
                                    error_log($recipe['name'] . '/' . $ingredient['item'] . ' new useBy: ' . $fridgeItem['useBy']);
                                }
                                $closestUseBy = strtotime($fridgeItem['useBy']);
                            }
                        }
                    }
                }
            } else {
                if ($this->debug){
                    error_log($recipe['name'] . ' missing item, amount or unit');
                }
            }
        }
        if ($itemsFound === $itemsCount){
            $recipe['useBy'] = $closestUseBy;
            return $recipe;
        } else {
            return false;
        }
    }

    private function parseFridgeCSV($data){
        $returnArray = array();
        if (!empty($data)){
            foreach($data as $item){
                $newObj = array();
                $error = false;
                if (!empty($item[0])){
                    $newObj['item'] = $item[0];
                } else {
                    $error = true;
                }
                if (!empty($item[1])){
                    $newObj['amount'] = $item[1];
                } else{
                    $error = true;
                }
                if (!empty($item[2])){
                    $newObj['unit'] = $item[2];
                } else {
                    $error = true;
                }
                if (!empty($item[3])){
                    $newObj['useBy'] = str_replace('/','-',$item[3]);
                } else {
                    $error = true;
                }
                if ($error === false){
                    $returnArray[] = $newObj;
                }
            }
        }
        return $returnArray;
    }
    private function cmpUseBy($a, $b) {
        if ($a['useBy'] == $b['useBy']) {
            return 0;
        }
        return ($a['useBy'] < $b['useBy']) ? -1 : 1;
    }
}
?>