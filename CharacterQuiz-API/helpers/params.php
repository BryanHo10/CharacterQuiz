<?php

/**
 * Check params
 */
function check_params($paramList, $listToCheck) {
    $missing = array();

    foreach ($paramList as $param) {
        if (!array_key_exists($param, $listToCheck)) {
            array_push($missing, $param);
        }
    }

    return $missing;
}

function array_except($array, $keys)
{
    return array_diff_key($array, array_flip((array) $keys));
}