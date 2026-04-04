<?php
/*TO DO:
Creating An Include File With Validation Functions
Create an external PHP include file that contains the following functions:
A function to check that text input is within a specified character range.
A function to check that number input is numeric and within a valid range.
A function to check that selected options are valid using a predefined array of allowed values.
Include this file at the top of your PHP page so you can use these functions.
*/
function checkAge($age){
    if($age > 10 && $age < 120){
        return true;
    }
    return false;
}

function checkName($name){
    if(strlen($name) >1 && strlen($name) < 50){
        return true;
    }
    return false;
}

function checkYesNo($value){
    if ($value == "Yes" || $value == "No"){
        return true;
    }
    return false;
}

function checkCheckboxOption($values){
    if(!is_array($values)){
        return false;
    }
    // Allow empty selection (no checkboxes selected is valid)
    if(empty($values)){
        return true;
    }
    $allowedValues = array("tournament", "gameNight", "room", "other");
    foreach($values as $value){
        if(!in_array($value, $allowedValues)){
            return false;
        }
    }
    return true;
}

function checkText($value){
    if(strlen($value) > 1 && strlen($value) < 500){
        return true;
    }
    return false;
}
?>