<?php 

require("config.php");
require("querys.php");

// -- General statistics (общая статистика)
// -- # Count
function count_general_statistics($region) {
    $result = array();

    global $connect;

    global $crime_articles;
    global $causes_of_crimes;
    global $number_of_victims;

    // -- Return arrow to start of query string result
    mysqli_data_seek($crime_articles, 0);
    mysqli_data_seek($causes_of_crimes, 0);
    mysqli_data_seek($number_of_victims, 0);

    // -- Sum total amount for every name of the statistical factor of the current region:

    // -- Add to result array new values [$key => name of the statistical factor, $value => sum of this statistical factor]
    while ($row = mysqli_fetch_assoc($number_of_victims)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            if (isset($result["Общее количество потервпеших"])) {
                $result["Общее количество потервпеших"] += $row["importance_of_the_statistical_factor"];
            } else {
                $result["Общее количество потервпеших"] = $row["importance_of_the_statistical_factor"];
            }
        }
    }

    // -- Add to result array new values [$key => name of the statistical factor, $value => sum of this statistical factor]
    while ($row = mysqli_fetch_assoc($causes_of_crimes)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            if (isset($result["Алкогольные, токсические, наркотические опьянения или лица, ранее совершавшие преступления"])) {
                $result["Алкогольные, токсические, наркотические опьянения или лица, ранее совершавшие преступления"] += $row["importance_of_the_statistical_factor"];
            } else {
                $result["Алкогольные, токсические, наркотические опьянения или лица, ранее совершавшие преступления"] = $row["importance_of_the_statistical_factor"];
            }
            
        }
    }


    // -- Add to result array new values [$key => name of the statistical factor, $value => sum of this statistical factor]
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

// -- # Percent
function count_general_statistics_percent($region) {
    $result = array();

    global $connect;
    
    global $crime_articles;
    global $causes_of_crimes;
    global $number_of_victims;

    // -- Return arrow to start of query string result
    mysqli_data_seek($crime_articles, 0);
    mysqli_data_seek($causes_of_crimes, 0);
    mysqli_data_seek($number_of_victims, 0);

    $total_count = 0;

    // -- Total sum
    while ($row = mysqli_fetch_assoc($crime_articles)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $total_count += $row["importance_of_the_statistical_factor"];
        }
    }

    while ($row = mysqli_fetch_assoc($causes_of_crimes)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $total_count += $row["importance_of_the_statistical_factor"];
        }
    }

    while ($row = mysqli_fetch_assoc($number_of_victims)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $total_count += $row["importance_of_the_statistical_factor"];
        }
    }
    
    // -- Return arrow to start of query string result
    mysqli_data_seek($crime_articles, 0);
    mysqli_data_seek($causes_of_crimes, 0);
    mysqli_data_seek($number_of_victims, 0);

    // -- Count total values for every name of statistical factor of current region:
    
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
    
    // -- Count percent values for every region:
    foreach ($result as $key => $value) {
        $result[$key] = round($value / $total_count, 3) * 100;
    }

    return $result;
}


// -- Stats of causes of crimes (статистика причин приступлений)
// # -- Count
function count_causes_of_crimes($region) {
    $result = array();

    global $connect;

    global $causes_of_crimes;

    mysqli_data_seek($causes_of_crimes, 0);

    // -- Create array of data [$key => region, $value => amount of the statistical factor]
    while ($row = mysqli_fetch_assoc($causes_of_crimes)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $result[$row["name_of_the_statistical_factor"]] = $row["importance_of_the_statistical_factor"];
        }
    }

    return $result;
}

// # -- Percent
function count_causes_of_crimes_percent($region) {
    $result = array();

    global $connect;

    global $causes_of_crimes;

    // -- Return arrow to start of query string result
    mysqli_data_seek($causes_of_crimes, 0);

    $total_count = 0;

    while ($row = mysqli_fetch_assoc($causes_of_crimes)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $total_count += $row["importance_of_the_statistical_factor"];
        }
    }

    // -- Return arrow to start of query string result
    mysqli_data_seek($causes_of_crimes, 0);

    while ($row = mysqli_fetch_assoc($causes_of_crimes)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $result[$row["name_of_the_statistical_factor"]] = round($row["importance_of_the_statistical_factor"] / $total_count, 3) * 100;
        }
        
    }

    
    return $result;
}

// -- Article violation statistics (статистика нарушений статей)
// # -- Count
function count_article_violation($region) {
    $result = array();

    global $connect;

    global $crime_articles;

    // -- Return arrow to start of query string result
    mysqli_data_seek($crime_articles, 0);

    // -- Create array of data [$key => region, $value => amount of the statistical factor]
    while ($row = mysqli_fetch_assoc($crime_articles)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $result[$row["name_of_the_statistical_factor"]] = $row["importance_of_the_statistical_factor"];
        }
    }

    return $result;
}

// # -- Percent
function count_article_violation_percent($region) {
    $result = array();

    global $connect;

    global $crime_articles;

    // -- Return arrow to start of query string result
    mysqli_data_seek($crime_articles, 0);

    $total_count = 0;

    while ($row = mysqli_fetch_assoc($crime_articles)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $total_count += $row["importance_of_the_statistical_factor"];
        }
    }

     // -- Return arrow to start of query string result
     mysqli_data_seek($crime_articles, 0);

    while ($row = mysqli_fetch_assoc($crime_articles)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $result[$row["name_of_the_statistical_factor"]] = round($row["importance_of_the_statistical_factor"] / $total_count, 3) * 100;
        }
    }

    return $result;
}

// -- Stats of victims (статистика потерпевших)
// # -- Count
function count_number_of_victims($region) {
    $result = array();

    global $connect;

    global $number_of_victims;

    // -- Return arrow to start of query string result
    mysqli_data_seek($number_of_victims, 0);
    
    // -- Create array of data [$key => region, $value => amount of the statistical factor]
    while ($row = mysqli_fetch_assoc($number_of_victims)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $result[$row["name_of_the_statistical_factor"]] = $row["importance_of_the_statistical_factor"];
        }
    }

    return $result;
}

// # -- Percent
function count_number_of_victims_percent($region) {
    $result = array();

    global $connect;

    global $number_of_victims;

    // -- Return arrow to start of query string result
    mysqli_data_seek($number_of_victims, 0);

    $total_count = 0;

    while ($row = mysqli_fetch_assoc($number_of_victims)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $total_count += $row["importance_of_the_statistical_factor"];
        }
    }

    // -- Return arrow to start of query string result
    mysqli_data_seek($number_of_victims, 0);

    while ($row = mysqli_fetch_assoc($number_of_victims)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $result[$row["name_of_the_statistical_factor"]] = round($row["importance_of_the_statistical_factor"] / $total_count, 3) * 100;
        }
    }

    return $result;
}



?>