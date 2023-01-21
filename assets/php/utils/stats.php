<?php 

require("config.php");
require("querys.php");
require("regions.php");


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

    // -- Total sums:
    
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


// -- Stats of datasets (статистика для каждого датасета)
// # -- Count
function count_quantitative_values($region, $query) {
    $result = array();

    global $connect;

    mysqli_data_seek($query, 0);

    // -- Create array of data [$key => region, $value => amount of the statistical factor]
    while ($row = mysqli_fetch_assoc($query)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $result[$row["name_of_the_statistical_factor"]] = $row["importance_of_the_statistical_factor"];
        }
    }

    return $result;
}

// # -- Percent
function count_percent_values($region, $query) {
    $result = array();

    global $connect;

    // -- Return arrow to start of query string result
    mysqli_data_seek($query, 0);

    $total_count = 0;

    while ($row = mysqli_fetch_assoc($query)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $total_count += $row["importance_of_the_statistical_factor"];
        }
    }

    // -- Return arrow to start of query string result
    mysqli_data_seek($query, 0);

    // -- Create array of data [$key => region, $value => percent of the statistical factor]
    while ($row = mysqli_fetch_assoc($query)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $result[$row["name_of_the_statistical_factor"]] = round($row["importance_of_the_statistical_factor"] / $total_count, 3) * 100;
        }
        
    }

    
    return $result;
}


// -- Dispersion of the statistical factor
function count_dispersion($query) {
    $result = array();

    global $connect;

    global $regions;

    // -- Return arrow to start of query string result
    mysqli_data_seek($query, 0);

    $total_sum = 0;
    $total_count = 0;

    $total_sum_of_the_statistical_factors = array();
    $average_of_the_statistical_factors = array();
    
    $dispersions = array();


    // -- Count total sum and count of the statistical factor
    while ($row = mysqli_fetch_assoc($query)) {
        if ($row["subject"] != "Всего по России") {  
            if (isset($total_sum_of_the_statistical_factors[$row["name_of_the_statistical_factor"]])) {
                $total_sum_of_the_statistical_factors[$row["name_of_the_statistical_factor"]] += $row["importance_of_the_statistical_factor"];
            } else {
                $total_sum_of_the_statistical_factors[$row["name_of_the_statistical_factor"]] = $row["importance_of_the_statistical_factor"];
            }
        }
    }

    // -- Count average for each statistical factor
    foreach ($total_sum_of_the_statistical_factors as $key => $value) {
        $average_of_the_statistical_factors[$key] = round($total_sum_of_the_statistical_factors[$key] / (count($regions) - 1), 2);
    }

    // -- Return arrow to start of query string result
    mysqli_data_seek($query, 0);

    // -- Count dispersion for each statistical factor
    $numerators = array();
    $result = 0;
    while ($row = mysqli_fetch_assoc($query)) {
        if ($row["subject"] != "Всего по России") {
            foreach ($average_of_the_statistical_factors as $key => $value) {
                if ($key == $row["name_of_the_statistical_factor"]) {
                    if (isset($numerators[$key])) {
                        $numerators[$key] += pow($row["importance_of_the_statistical_factor"] - $value, 2);
                        $result = sqrt($numerators[$key] / (count($regions) - 1));
                        $dispersions[$key] = round($result, 2);
                    } else {
                        $numerators[$key] = pow($row["importance_of_the_statistical_factor"] - $value, 2);
                    }
                

                }
            }
        }
    }

    return $dispersions;
}


?>