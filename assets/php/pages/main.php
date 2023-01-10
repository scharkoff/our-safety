<?php 

require("../utils/config.php");
require("../utils/querys.php");
require("../utils/stats.php");

// -- Number of victims
$query = mysqli_query($connect, "SELECT * FROM number_of_victims");

// -- All regions
$regions = array();

// -- Create variable for regions
while ($row = mysqli_fetch_assoc($query)) {
    array_push($regions, $row["subject"]);
}

$regions = array_unique($regions);








?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../scss/style.css">
    <link rel="shortcut icon" href="../../images/icons/shield_var_1.png" type="image/x-icon">
    <link rel="stylesheet" href="../../bootstrap-5.0.1-dist/css/bootstrap.min.css">
    <title>Главная страница</title>
</head>

<body class="main">

    <!-- Preloader -->
    <div class="mask">
        <div class="loader"></div>
    </div>

    <div class="container">
        <div class="row content">

            <!-- Title -->
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="main__title">Анализ региона</h1>
                </div>
            </div>

            <!-- Regions -->
            <div class="row">
                <div class="col-2 region">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="region__menu-title"><strong>Регионы России</strong></div>
                            <div class="region__menu">
                                <?php 
                                sort($regions);
                                foreach ($regions as $region) {
                                    $link_region = preg_replace('/\s+/', '', $region);
                                    
                                    if (isset($_GET["region"]) && (preg_replace('/\s+/', '', $_GET["region"]) == $link_region)) {
                                        if (isset($_GET["option"])) {
                                            echo '<a href="?region='.$link_region.'&option='.$_GET["option"].'"><div class="region__menu-item active-item" data-menu="item">'.$region.'</div></a>';
                                        } else {
                                            echo '<a href="?region='.$link_region.'"><div class="region__menu-item active-item" data-menu="item">'.$region.'</div></a>';
                                        }
                                    } else {
                                        if (isset($_GET["option"])) {
                                            echo '<a href="?region='.$link_region.'&option='.$_GET["option"].'"><div class="region__menu-item" data-menu="item">'.$region.'</div></a>';
                                        } else {
                                            echo '<a href="?region='.$link_region.'&option=general_statistics"><div class="region__menu-item" data-menu="item">'.$region.'</div></a>';
                                        }
                                    }
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Graph -->
                <div class="col-8 graph">
                    <p class="graph__title">Данные за январь-декабрь 2021 г.</p>
                    <canvas id="quantityChart"></canvas>
                    <canvas id="percentageChart"></canvas>
                </div>

                <!-- Options -->
                <div class="col-2 options">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="options__menu-title"><strong>Доступные опции</strong></div>
                            <div class="options__menu">

                                <a href=<?php 
                                 if (isset($_GET["region"])) {
                                    echo "?region=".$_GET["region"]."&option=general_statistics";
                                 } else {
                                    echo "?option=general_statistics";
                                 }
                                ?>>
                                    <div class=<?php 
                                         if (isset($_GET["option"]) && ($_GET["option"] == "general_statistics")) {
                                            echo "active-item";
                                        } else {
                                            echo "options__menu-item";
                                        }
                                    ?> data-menu="item">Общая статистика</div>
                                </a>

                                <a href=<?php 
                                 if (isset($_GET["region"])) {
                                    echo "?region=".$_GET["region"]."&option=causes_of_crimes";
                                 } else {
                                    echo "?option=causes_of_crimes";
                                 }
                                ?>>
                                    <div class=<?php 
                                         if (isset($_GET["option"]) && ($_GET["option"] == "causes_of_crimes")) {
                                            echo "active-item";
                                        } else {
                                            echo "options__menu-item";
                                        }
                                    ?> data-menu="item">Причины преступлений</div>
                                </a>

                                <a href=<?php 
                                 if (isset($_GET["region"])) {
                                    echo "?region=".$_GET["region"]."&option=articles";
                                 } else {
                                    echo "?option=articles";
                                 }
                                ?>>
                                    <div class=<?php 
                                         if (isset($_GET["option"]) && ($_GET["option"] == "articles")) {
                                            echo "active-item";
                                        } else {
                                            echo "options__menu-item";
                                        }
                                    ?> data-menu="item">Статьи преступлений</div>
                                </a>

                                <a href=<?php 
                                 if (isset($_GET["region"])) {
                                    echo "?region=".$_GET["region"]."&option=victims";
                                 } else {
                                    echo "?option=victims";
                                 }
                                ?>>
                                    <div class=<?php 
                                         if (isset($_GET["option"]) && ($_GET["option"] == "victims")) {
                                            echo "active-item";
                                        } else {
                                            echo "options__menu-item";
                                        }
                                    ?> data-menu="item">Потервпевшие</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="../../bootstrap-5.0.1-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>
    <script src="../../js/script.js"></script>
    <script src="../../js/canvas.js"></script>
    <script src="../../js/preloader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    // -- Charts
    const ctxQuantityChart = document.querySelector("#quantityChart").getContext("2d"),
        ctxPercentageChart = document.querySelector("#percentageChart").getContext("2d");

    <?php  

    // -- General statistics (общая статистика)
    $count_general_statistics = array();

    if (isset($_GET["region"]) && isset($_GET["option"]) && $_GET["option"] == "general_statistics") {
        $count_general_statistics = array_merge($count_general_statistics, count_general_statistics($_GET["region"]));
    }
    

    // -- Stats of count of number of victims (кол-во потерпевших)
    $count_number_of_victims = array();

    if (isset($_GET["region"]) && isset($_GET["option"]) && $_GET["option"] == "victims") {
        $count_number_of_victims = array_merge($count_number_of_victims, count_number_of_victims($_GET["region"]));
    }

    // -- Article violation statistics (статистика нарушений статей)
    $count_article_violation = array();

    if (isset($_GET["region"]) && isset($_GET["option"]) && $_GET["option"] == "articles") {
        $count_article_violation = array_merge($count_article_violation, count_article_violation($_GET["region"]));
    }

    // -- Stats of causes of crimes (статистика причин приступлений)
    $count_causes_of_crimes = array();

    if (isset($_GET["region"]) && isset($_GET["option"]) && $_GET["option"] == "causes_of_crimes") {
        $count_causes_of_crimes = array_merge($count_causes_of_crimes, count_causes_of_crimes($_GET["region"]));
    }


    ?>

    // -- Setup for quantity data
    const quantityData = {
        labels: <?php 
                
                // -- General statistics (общая статистика)
                if (isset($_GET["region"]) && isset($_GET["option"]) && $_GET["option"] == "general_statistics") {
                    echo json_encode(array_keys($count_general_statistics));
                } 
                
                // -- Stats of causes of crimes (статистика причин приступлений)
                else if (isset($_GET["region"]) && isset($_GET["option"]) && $_GET["option"] == "causes_of_crimes") {
                    echo json_encode(array_keys($count_causes_of_crimes));
                } 
                
                // -- Article violation statistics (статистика нарушений статей)
                else if (isset($_GET["region"]) && isset($_GET["option"]) && $_GET["option"] == "articles") {
                    $keys = array_keys($count_article_violation);
                    foreach ($keys as $key => $value) {
                        if (strpos($value, "зарегистрированных")) {
                            $keys[$key] = str_replace("Количество преступлений, зарегистрированных в отчетном периоде по", "", $value);
                        }

                        if (strpos($value, "расследованных")) {
                            $keys[$key] = str_replace("Количество предварительно расследованных преступлений в отчетном периоде (из числа находившихся в производстве или зарегистрированных в отчетном периоде) по", "", $value);
                        }
                    }
                    echo json_encode($keys);
                } 

                 // -- Stats of count number of victims (кол-во потерпевших)
                else if (isset($_GET["region"]) && isset($_GET["option"]) && $_GET["option"] == "victims") {
                    echo json_encode(array_keys($count_number_of_victims));
                } 
                
                else {
                    echo json_encode(["Ничего не выбрано"]);
                }

            ?>,
        datasets: [{
            label: <?php 
                if (isset($_GET["region"])) {
                    foreach ($regions as $region) {
                        if (preg_replace('/\s+/', '', $region) == $_GET["region"]) {
                            echo json_encode($region);
                        }
                    }
                } else {
                    echo json_encode("Регион не выбран");
                }
            ?>,
            data: <?php        
                // -- General statistics (общая статистика)
                if (isset($_GET["region"]) && isset($_GET["option"]) && $_GET["option"] == "general_statistics") {
                    echo json_encode(array_values($count_general_statistics));
                }
                
                // -- Stats of causes of crimes (статистика причин приступлений)
                else if (isset($_GET["region"]) && isset($_GET["option"]) && $_GET["option"] == "causes_of_crimes") {
                    echo json_encode(array_values($count_causes_of_crimes));
                } 

                // -- Article violation statistics (статистика нарушений статей)
                else if (isset($_GET["region"]) && isset($_GET["option"]) && $_GET["option"] == "articles") {
                    echo json_encode(array_values($count_article_violation));
                } 

                // -- Stats of count number of victims (кол-во потерпевших)
                else if (isset($_GET["region"]) && isset($_GET["option"]) && $_GET["option"] == "victims") {
                    echo json_encode(array_values($count_number_of_victims));
                } 
                
                else {
                    echo json_encode([]);
                }

                
            ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
            ],
            borderWidth: 1
        }]
    };

    // -- Config
    const config = {
        type: 'bar',
        data: quantityData,
        options: {
            scales: {
                y: {
                    beginAtZero: true,

                },

                x: {
                    display: false,
                    ticks: {
                        // maxRotation: 90,
                        // minRotation: 90,
                    }
                }
            },
        },
    };

    // -- Upload charts
    const quantityChart = new Chart(ctxQuantityChart, config);
    const percentageChart = new Chart(ctxPercentageChart, config);
    </script>

</body>

</html>