<?php 

require("../utils/config.php");
require("../utils/querys.php");
require("../utils/stats.php");
require("../utils/regions.php");



?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../scss/style.css">
    <link rel="shortcut icon" href="../../images/icons/shield_var_1.png" type="image/x-icon">
    <title>Главная страница</title>
</head>

<body>
    <main class="analysis">

        <!-- Preloader -->
        <div class="mask">
            <div class="loader"></div>
        </div>

        <div class="container">
            <div class="row content">

                <!-- Title -->
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class="analysis__title">Анализ региона</h1>
                    </div>
                </div>

                <!-- Regions -->
                <div class="row">
                    <div class="col-2">
                        <div class="row analysis__region">
                            <div class="col-12 text-center">
                                <div class="analysis__region-title"><strong>Регионы России</strong></div>
                                <div class="analysis__region-menu">
                                    <?php 
                                sort($regions);
                                foreach ($regions as $region) {
                                    $link_region = preg_replace('/\s+/', '', $region);
                                    
                                    if (isset($_GET["region"]) && (preg_replace('/\s+/', '', $_GET["region"]) == $link_region)) {
                                        if (isset($_GET["option"])) {
                                            echo '<a href="?region='.$link_region.'&option='.$_GET["option"].'"><div class="analysis__region-menu-item_active" data-menu="item">'.$region.'</div></a>';
                                        } else {
                                            echo '<a href="?region='.$link_region.'"><div class="analysis__region-menu-item_active" data-menu="item">'.$region.'</div></a>';
                                        }
                                    } else {
                                        if (isset($_GET["option"])) {
                                            echo '<a href="?region='.$link_region.'&option='.$_GET["option"].'"><div class="analysis__region-menu-item" data-menu="item">'.$region.'</div></a>';
                                        } else {
                                            echo '<a href="?region='.$link_region.'&option=general_statistics"><div class="analysis__region-menu-item" data-menu="item">'.$region.'</div></a>';
                                        }
                                    }
                                }
                            ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Graph -->
                    <div class="col-8 analysis__graph">
                        <p class="analysis__graph-title">Данные за январь-июнь 2022 г.</p>
                        <canvas id="quantityChart"></canvas>
                        <canvas id="percentageChart"></canvas>
                        <canvas class=<?php 
                            if (isset($_GET["option"]) && $_GET["option"] == "general_statistics") {
                                echo "hide-chart";
                            } else {
                                echo "show-chartфц";
                            }
                        ?> id="dispersionChart"></canvas>
                    </div>

                    <!-- Options -->
                    <div class="col-2 analysis__options">
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="analysis__options-title"><strong>Доступные опции</strong></div>
                                <div class="analysis__options-menu">

                                    <a href=<?php 
                                 if (isset($_GET["region"])) {
                                    echo "?region=".$_GET["region"]."&option=general_statistics";
                                 } else {
                                    echo "?option=general_statistics";
                                 }
                                ?>>
                                        <div class=<?php 
                                         if (isset($_GET["option"]) && ($_GET["option"] == "general_statistics")) {
                                            echo "analysis__options-menu-item_active";
                                        } else {
                                            echo "analysis__options-menu-item";
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
                                            echo "analysis__options-menu-item_active";
                                        } else {
                                            echo "analysis__options-menu-item";
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
                                            echo "analysis__options-menu-item_active";
                                        } else {
                                            echo "analysis__options-menu-item";
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
                                            echo "analysis__options-menu-item_active";
                                        } else {
                                            echo "analysis__options-menu-item";
                                        }
                                        ?> data-menu="item">Потерпевшие</div>
                                    </a>

                                    <a class=<?php
                                        if (isset($_GET["region"])) {
                                            echo "unlock";
                                        } else {
                                            echo "blocked-link";
                                        }
                                        ?> href=<?php 
                                        if (isset($_GET["region"])) {
                                            echo "./recommends.php?region=".$_GET["region"];
                                        } else {
                                            echo "#";
                                        }
                                        ?>>
                                        <div class=<?php 
                                         if (isset($_GET["region"])) {
                                            echo "analysis__options-menu-item_recommends";
                                        } else {
                                            echo "analysis__options-menu-item_blocked";
                                        }
                                        ?> data-menu="item">Рекомендации</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="contacts">
                        <ul class="contacts__list">
                            <li class="contacts__list-item">Developed by <span>Sharkoff</span></li>
                            <li class="contacts__list-item">sharkov.agent@mail.ru</li>
                            <li class="contacts__list-item"><a href="https://sharkoff.su"
                                    target="_blank">sharkoff.su</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

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
    const ctxQuantityChart = document.querySelector("#quantityChart").getContext("2d"), // -- количественный график
        ctxPercentageChart = document.querySelector("#percentageChart").getContext("2d"), // -- процентный график
        ctxDispersionChart = document.querySelector("#dispersionChart").getContext("2d"); // -- дисперсионный график

    // -- Setup data for quantity chart
    const quantityData = {
        labels: <?php 
                
                if (isset($_GET["region"]) && isset($_GET["option"])) {
     
                    // -- General statistics (общая статистика)
                    if ($_GET["option"] == "general_statistics") {
                        $count_general_statistics = count_general_statistics($_GET["region"]);
                        echo json_encode(array_keys($count_general_statistics));
                    } 
                    
                    // -- Stats of causes of crimes (статистика причин преступлений)
                    else if ($_GET["option"] == "causes_of_crimes") {
                        $count_causes_of_crimes = count_quantitative_values($_GET["region"], $causes_of_crimes);
                        echo json_encode(array_keys($count_causes_of_crimes));
                    } 
                    
                    // -- Article violation statistics (статистика нарушений статей)
                    else if ($_GET["option"] == "articles") {
                        $count_article_violation = count_quantitative_values($_GET["region"], $crime_articles);
                        $keys = array_keys($count_article_violation);
                        foreach ($keys as $key => $value) {
                            if (strpos($value, "зарегистрированных")) {
                                $keys[$key] = str_replace("Количество преступлений, зарегистрированных в отчетном периоде по", "(Зарегистрированных)", $value);
                            }

                            if (strpos($value, "расследованных")) {
                                $keys[$key] = str_replace("Количество предварительно расследованных преступлений в отчетном периоде (из числа находившихся в производстве или зарегистрированных в отчетном периоде) по", "(Расследованных)", $value);
                            }
                        }
                        echo json_encode($keys);
                    } 

                    // -- Stats of count number of victims (кол-во потерпевших)
                    else if ($_GET["option"] == "victims") {
                        $count_number_of_victims = count_quantitative_values($_GET["region"], $number_of_victims);
                        echo json_encode(array_keys($count_number_of_victims));
                    } else {
                        echo json_encode([]);
                    }
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
                if (isset($_GET["region"]) && isset($_GET["option"])) {
  
                    if ($_GET["option"] == "general_statistics") {
                        $count_general_statistics = count_general_statistics($_GET["region"]);
                        echo json_encode(array_values($count_general_statistics));
                    }
                    
                    // -- Stats of causes of crimes (статистика причин преступлений)
                    else if ($_GET["option"] == "causes_of_crimes") {
                        $count_causes_of_crimes = count_quantitative_values($_GET["region"], $causes_of_crimes);
                        echo json_encode(array_values($count_causes_of_crimes));
                    } 

                    // -- Article violation statistics (статистика нарушений статей)
                    else if ($_GET["option"] == "articles") {
                        $count_article_violation = count_quantitative_values($_GET["region"], $crime_articles);
                        echo json_encode(array_values($count_article_violation));
                    } 

                    // -- Stats of count number of victims (кол-во потерпевших)
                    else if ($_GET["option"] == "victims") {
                        $count_number_of_victims = count_quantitative_values($_GET["region"], $number_of_victims);
                        echo json_encode(array_values($count_number_of_victims));
                    } 
                    
                    else {
                        echo json_encode([]);
                    }
                }
                else {
                    echo json_encode([]);
                }

                
            ?>,
            backgroundColor: [
                'rgba(111, 0, 255, 0.2)',
                'rgba(0, 140, 255, 0.2)',
                'rgba(0, 183, 255, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
                'rgb(111, 0, 255)',
                'rgb(0, 140, 255)',
                'rgb(0, 183, 255)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
            ],
            borderWidth: 1
        }]
    };

    // -- Setup data for percentage chart
    const percentageData = {
        labels: <?php 
                
                if (isset($_GET["region"]) && isset($_GET["option"])) {

                    // -- General statistics (общая статистика)
                    if ($_GET["option"] == "general_statistics") {
                        $count_general_statistics_percent = count_general_statistics_percent($_GET["region"]);
                        echo json_encode(array_keys($count_general_statistics_percent));
                    } 
                    
                    // -- Stats of causes of crimes (статистика причин приступлений)
                    else if ($_GET["option"] == "causes_of_crimes") {
                        $count_causes_of_crimes_percent = count_percent_values($_GET["region"], $causes_of_crimes);
                        echo json_encode(array_keys($count_causes_of_crimes_percent));
                    } 

                    // -- Article violation statistics (статистика нарушений статей)
                    else if ($_GET["option"] == "articles") {
                        $count_article_violation_percent = count_percent_values($_GET["region"], $crime_articles);
                        $keys = array_keys($count_article_violation_percent);
                        foreach ($keys as $key => $value) {
                            if (strpos($value, "зарегистрированных")) {
                                $keys[$key] = str_replace("Количество преступлений, зарегистрированных в отчетном периоде по", "(Зарегистрированных)", $value);
                            }

                            if (strpos($value, "расследованных")) {
                                $keys[$key] = str_replace("Количество предварительно расследованных преступлений в отчетном периоде (из числа находившихся в производстве или зарегистрированных в отчетном периоде) по", "(Расследованных)", $value);
                            }
                        }
                        echo json_encode($keys);
                    } 

                    // -- Stats of count number of victims (кол-во потерпевших)
                    else if ($_GET["option"] == "victims") {
                        $count_number_of_victims_percent = count_percent_values($_GET["region"], $number_of_victims);
                        echo json_encode(array_keys($count_number_of_victims_percent));
                    } 
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
                            echo json_encode($region." (%)");
                        }
                    }
                } else {
                    echo json_encode("Регион не выбран");
                }
            ?>,
            data: <?php        

                if (isset($_GET["region"]) && isset($_GET["option"])) {
 
                    // -- General statistics (общая статистика)
                    if ($_GET["option"] == "general_statistics") {
                        $count_general_statistics_percent = count_general_statistics_percent($_GET["region"]);
                        echo json_encode(array_values($count_general_statistics_percent));
                    }
                    
                    // -- Stats of causes of crimes (статистика причин приступлений)
                    else if ($_GET["option"] == "causes_of_crimes") {
                        $count_causes_of_crimes_percent = count_percent_values($_GET["region"], $causes_of_crimes);
                        echo json_encode(array_values($count_causes_of_crimes_percent));
                    } 

                    // -- Article violation statistics (статистика нарушений статей)
                    else if ($_GET["option"] == "articles") {
                        $count_article_violation_percent = count_percent_values($_GET["region"], $crime_articles);
                        echo json_encode(array_values($count_article_violation_percent));
                    } 

                    // -- Stats of count number of victims (кол-во потерпевших)
                    else if ($_GET["option"] == "victims") {
                        $count_number_of_victims_percent = count_percent_values($_GET["region"], $number_of_victims);
                        echo json_encode(array_values($count_number_of_victims_percent));
                    } else {
                        echo json_encode([]);
                    }
                }   
                else {
                    echo json_encode([]);
                }

                
            ?>,
            backgroundColor: [
                'rgba(105, 205, 86, 0.2)',
                'rgba(25, 192, 192, 0.2)',
                'rgba(100, 55, 164, 0.2)',
                'rgba(55, 99, 132, 0.2)',
                'rgba(101, 203, 207, 0.2)',
                'rgba(154, 162, 235, 0.2)',
                'rgba(53, 102, 255, 0.2)',
            ],
            borderColor: [
                'rgb(105, 205, 86)',
                'rgb(25, 192, 192)',
                'rgb(100, 55, 164)',
                'rgb(55, 99, 132)',
                'rgb(101, 203, 207)',
                'rgb(154, 162, 235)',
                'rgb(53, 102, 255)',
            ],
            borderWidth: 1,
            fill: true
        }]
    };

    // -- Setup data for dispersion chart
    const dispersionData = {
        labels: <?php 
                
                if (isset($_GET["option"])) {

                    if ($_GET["option"] == "causes_of_crimes") {
                        $dispersion = count_dispersion($causes_of_crimes);
                        echo json_encode(array_keys($dispersion));
                    } 
                    
                    else if ($_GET["option"] == "articles") {
                         $dispersion = count_dispersion($crime_articles);
                        $keys = array_keys($dispersion);
                        foreach ($keys as $key => $value) {
                            if (strpos($value, "зарегистрированных")) {
                                $keys[$key] = str_replace("Количество преступлений, зарегистрированных в отчетном периоде по", "(Зарегистрированных)", $value);
                            }

                            if (strpos($value, "расследованных")) {
                                $keys[$key] = str_replace("Количество предварительно расследованных преступлений в отчетном периоде (из числа находившихся в производстве или зарегистрированных в отчетном периоде) по", "(Расследованных)", $value);
                            }
                        }
                        echo json_encode($keys);
                    }

                    else if ($_GET["option"] == "victims") {
                        $dispersion = count_dispersion($number_of_victims);
                        echo json_encode(array_keys($dispersion));
                    } 
                    
                    else {
                        echo json_encode([]);
                    }
                    
                } else {
                    echo json_encode([]);
                }

                

            ?>,
        datasets: [{
            label: <?php echo json_encode("Стандартное отклонение показателей"); ?>,
            data: <?php    
            
                if (isset($_GET["option"])) {

                    if ($_GET["option"] == "causes_of_crimes") {
                        $dispersion = count_dispersion($causes_of_crimes);
                        echo json_encode(array_values($dispersion));
                    } 

                    else if ($_GET["option"] == "articles") {
                        $dispersion = count_dispersion($crime_articles);
                        echo json_encode(array_values($dispersion));  
                    }

                    else if ($_GET["option"] == "victims") {
                        $dispersion = count_dispersion($number_of_victims);
                        echo json_encode(array_values($dispersion));
                    } 
                    
                    else {
                        echo json_encode([]);
                    }
                    
                } else {
                    echo json_encode([]);
                }
 
            ?>,
            backgroundColor: [
                'rgba(55, 199, 252, 0.2)',
                'rgba(105, 205, 86, 0.2)',
                'rgba(100, 55, 164, 0.2)',
                'rgba(55, 99, 132, 0.2)',
                'rgba(101, 203, 207, 0.2)',
                'rgba(154, 162, 235, 0.2)',
                'rgba(53, 102, 255, 0.2)',
            ],
            borderColor: [
                'rgb(55, 199, 252)',
                'rgb(105, 205, 86)',
                'rgb(100, 55, 164)',
                'rgb(55, 99, 132)',
                'rgb(101, 203, 207)',
                'rgb(154, 162, 235)',
                'rgb(53, 102, 255)',
            ],
            borderWidth: 1,
            fill: true

        }]
    };

    // -- Quantity chart config
    const quantityConfig = {
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

    // -- Percentage chart config
    const percentageConfig = {
        type: 'line',
        data: percentageData,
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

    // -- Dispersion chart config
    const dispersionConfig = {
        type: 'line',
        data: dispersionData,
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
    const quantityChart = new Chart(ctxQuantityChart, quantityConfig),
        percentageChart = new Chart(ctxPercentageChart, percentageConfig),
        dispersionChart = new Chart(ctxDispersionChart, dispersionConfig);
    </script>

</body>

</html>