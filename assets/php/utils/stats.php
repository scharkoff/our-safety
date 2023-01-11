<?php 

require("config.php");
require("querys.php");

// -- General statistics (общая статистика)
// -- # Количество

function count_general_statistics($region) {
    $result = array();

    global $connect;

    $crime_articles = mysqli_query($connect, "SELECT * FROM crime_articles");
    $causes_of_crimes = mysqli_query($connect, "SELECT * FROM causes_of_crimes");
    $number_of_victims = mysqli_query($connect, "SELECT * FROM number_of_victims");

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

// -- # Проценты
function count_general_statistics_percent($region) {
    $result = array();

    global $connect;

    $total_count = 0;

    $crime_articles = mysqli_query($connect, "SELECT * FROM crime_articles");
    $crime_articles_total = mysqli_query($connect, "SELECT * FROM crime_articles");
    $causes_of_crimes = mysqli_query($connect, "SELECT * FROM causes_of_crimes");
    $causes_of_crimes_total = mysqli_query($connect, "SELECT * FROM causes_of_crimes");
    $number_of_victims = mysqli_query($connect, "SELECT * FROM number_of_victims");
    $number_of_victims_total = mysqli_query($connect, "SELECT * FROM number_of_victims");

    // -- Total sum
    while ($row = mysqli_fetch_assoc($crime_articles_total)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $total_count += $row["importance_of_the_statistical_factor"];
        }
    }

    while ($row = mysqli_fetch_assoc($causes_of_crimes_total)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $total_count += $row["importance_of_the_statistical_factor"];
        }
    }

    while ($row = mysqli_fetch_assoc($number_of_victims_total)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $total_count += $row["importance_of_the_statistical_factor"];
        }
    }

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
    
    foreach ($result as $key => $value) {
        $result[$key] = round($value / $total_count, 2) * 100;
    }

    return $result;
}


// -- Stats of causes of crimes (статистика причин приступлений)
// # -- Количество
function count_causes_of_crimes($region) {
    $result = array();

    global $connect;

    $causes_of_crimes = mysqli_query($connect, "SELECT * FROM causes_of_crimes");

    while ($row = mysqli_fetch_assoc($causes_of_crimes)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $result[$row["name_of_the_statistical_factor"]] = $row["importance_of_the_statistical_factor"];
        }
    }

    return $result;
}

// # -- Проценты
function count_causes_of_crimes_percent($region) {
    $result = array();

    global $connect;

    $total_count = 0;

    $causes_of_crimes = mysqli_query($connect, "SELECT * FROM causes_of_crimes");
    $for_total = mysqli_query($connect, "SELECT * FROM causes_of_crimes");

    while ($row = mysqli_fetch_assoc($for_total)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $total_count += $row["importance_of_the_statistical_factor"];
        }
    }

    while ($row = mysqli_fetch_assoc($causes_of_crimes)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $result[$row["name_of_the_statistical_factor"]] = round($row["importance_of_the_statistical_factor"] / $total_count, 2) * 100;
        }
        
    }

    
    return $result;
}

// -- Article violation statistics (статистика нарушений статей)
// # -- Количество
function count_article_violation($region) {
    $result = array();

    global $connect;

    $crime_articles = mysqli_query($connect, "SELECT * FROM crime_articles");

    while ($row = mysqli_fetch_assoc($crime_articles)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $result[$row["name_of_the_statistical_factor"]] = $row["importance_of_the_statistical_factor"];
        }
    }

    return $result;
}

// # -- Проценты
function count_article_violation_percent($region) {
    $result = array();

    global $connect;

    $total_count = 0;

    $crime_articles = mysqli_query($connect, "SELECT * FROM crime_articles");
    $for_total = mysqli_query($connect, "SELECT * FROM crime_articles");

    while ($row = mysqli_fetch_assoc($for_total)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $total_count += $row["importance_of_the_statistical_factor"];
        }
    }

    while ($row = mysqli_fetch_assoc($crime_articles)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $result[$row["name_of_the_statistical_factor"]] = round($row["importance_of_the_statistical_factor"] / $total_count, 2) * 100;
        }
    }

    return $result;
}

// -- Stats of victims (статистика потерпевших)
// # -- Количество
function count_number_of_victims($region) {
    $result = array();

    global $connect;

    $number_of_victims = mysqli_query($connect, "SELECT * FROM number_of_victims");
    
    while ($row = mysqli_fetch_assoc($number_of_victims)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $result[$row["name_of_the_statistical_factor"]] = $row["importance_of_the_statistical_factor"];
        }
    }

    return $result;
}

// # -- Проценты
function count_number_of_victims_percent($region) {
    $result = array();

    global $connect;

    $total_count = 0;

    $number_of_victims = mysqli_query($connect, "SELECT * FROM number_of_victims");
    $for_total = mysqli_query($connect, "SELECT * FROM crime_articles");

    while ($row = mysqli_fetch_assoc($for_total)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $total_count += $row["importance_of_the_statistical_factor"];
        }
    }

    while ($row = mysqli_fetch_assoc($number_of_victims)) {
        if (preg_replace('/\s+/', '', $row["subject"]) == $region) {
            $result[$row["name_of_the_statistical_factor"]] = round($row["importance_of_the_statistical_factor"] / $total_count, 2) * 100;
        }
    }

    return $result;
}



?>