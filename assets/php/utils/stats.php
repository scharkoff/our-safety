<?php 

require("config.php");
require("querys.php");

// -- Stats of victims (статистика пострадавших)
function count_number_of_victims($region) {
    $result = array();

    global $number_of_victims;
    
    while ($row = mysqli_fetch_assoc($number_of_victims)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $result[$row["name_of_the_statistical_factor"]] = $row["importance_of_the_statistical_factor"];
        }
    }

    return $result;
}


// -- Stats of causes of crimes (статистика причин приступлений)
function count_causes_of_crimes($region) {
    $result = array();

    global $causes_of_crimes;

    while ($row = mysqli_fetch_assoc($causes_of_crimes)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $result[$row["name_of_the_statistical_factor"]] = $row["importance_of_the_statistical_factor"];
        }
    }

    return $result;
}

// -- General statistics (общая статистика)
function count_general_statistics($region) {
    $result = array();

    global $number_of_victims;
    global $causes_of_crimes;
    global $crime_articles;

    while ($row = mysqli_fetch_assoc($number_of_victims)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            if (isset($result["Общее количество потервпеших"])) {
                $result["Общее количество потервпеших"] += $row["importance_of_the_statistical_factor"];
            } else {
                $result["Общее количество потервпеших"] = $row["importance_of_the_statistical_factor"];
            }
        }
    }

    while ($row = mysqli_fetch_assoc($causes_of_crimes)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            if (isset($result["Алкогольные, токсические, наркотические опьянения или лица, ранее совершавшие преступления"])) {
                $result["Алкогольные, токсические, наркотические опьянения или лица, ранее совершавшие преступления"] += $row["importance_of_the_statistical_factor"];
            } else {
                $result["Алкогольные, токсические, наркотические опьянения или лица, ранее совершавшие преступления"] = $row["importance_of_the_statistical_factor"];
            }
            
        }
    }


    while ($row = mysqli_fetch_assoc($crime_articles)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            if (isset($result["Общее число нарушений УК РФ"])) {
                $result["Общее число нарушений УК РФ"] += $row["importance_of_the_statistical_factor"];
            } else {
                $result["Общее число нарушений УК РФ"] = $row["importance_of_the_statistical_factor"];
            }    
        }
    }

    return $result;
}

?>