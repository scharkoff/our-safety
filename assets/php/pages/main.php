<?php 

require("../utils/config.php");

// -- All relationships
$query = mysqli_query($connect, "SELECT * FROM crime_articles");
$crime_articles = mysqli_fetch_assoc($query);

$query = mysqli_query($connect, "SELECT * FROM committed_crimes");
$committed_crimes = mysqli_fetch_assoc($query);

$query = mysqli_query($connect, "SELECT * FROM number_of_victims");
$number_of_victims = mysqli_fetch_assoc($query);

// -- All regions
$regions = array();

// -- Create variable for regions
while ($row = mysqli_fetch_assoc($query)) {
    array_push($regions, $row["subject"]);
}

$regions = array_unique($regions);




?>

<!DOCTYPE html>
<html lang="en">

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

            <!-- Титул -->
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="main__title">Анализ региона</h1>
                </div>
            </div>

            <!-- Доступные регионы -->
            <div class="row">
                <div class="col-3 region">
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
                                            echo '<a href="?region='.$link_region.'&option=percent"><div class="region__menu-item" data-menu="item">'.$region.'</div></a>';
                                        }
                                    }
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- График -->
                <div class="col-6 graph">
                    <canvas id="myChart" width="600" height="300"></canvas>
                </div>

                <!-- Настройки графика -->
                <div class="col-3 options">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="options__menu-title"><strong>Доступные опции</strong></div>
                            <div class="options__menu">

                                <a href=<?php 
                                 if (isset($_GET["region"])) {
                                    echo "?region=".$_GET["region"]."&option=percent";
                                 } else {
                                    echo "?option=percent";
                                 }
                                ?>>
                                    <div class=<?php 
                                         if (isset($_GET["option"]) && ($_GET["option"] == "percent")) {
                                            echo "active-item";
                                        } else {
                                            echo "options__menu-item";
                                        }
                                    ?> data-menu="item">Процент (%)</div>
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
                                    echo "?region=".$_GET["region"]."&option=affected";
                                 } else {
                                    echo "?option=affected";
                                 }
                                ?>>
                                    <div class=<?php 
                                         if (isset($_GET["option"]) && ($_GET["option"] == "affected")) {
                                            echo "active-item";
                                        } else {
                                            echo "options__menu-item";
                                        }
                                    ?> data-menu="item">Пострадавшие</div>
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
    const ctx = document.querySelector("#myChart").getContext("2d");

    // -- Setup
    const data = {
        labels: ["Раз", "Два", "Три", "Четыре", "Раз", "Два", "Три"],
        datasets: [{
            label: <?php 
                if (isset($_GET["region"])) {
                    echo json_encode($_GET["region"]);
                } else {
                    echo json_encode("Регион не выбран");
                }
            ?>,
            data: <?php 
                if (isset($_GET["region"])) {
                    echo json_encode([1, 2, 3, 4, 3, 2, 1]);
                } else {
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
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    };

    // -- Pie chart
    const myChart = new Chart(ctx, config);

    // -- Actions
    const actions = [{
            name: 'Randomize',
            handler(chart) {
                chart.data.datasets.forEach(dataset => {
                    dataset.data = Utils.numbers({
                        count: chart.data.labels.length,
                        min: 0,
                        max: 100
                    });
                });
                chart.update();
            }
        },
        {
            name: 'Add Dataset',
            handler(chart) {
                const data = chart.data;
                const newDataset = {
                    label: 'Dataset ' + (data.datasets.length + 1),
                    backgroundColor: [],
                    data: [],
                };

                for (let i = 0; i < data.labels.length; i++) {
                    newDataset.data.push(Utils.numbers({
                        count: 1,
                        min: 0,
                        max: 100
                    }));

                    const colorIndex = i % Object.keys(Utils.CHART_COLORS).length;
                    newDataset.backgroundColor.push(Object.values(Utils.CHART_COLORS)[colorIndex]);
                }

                chart.data.datasets.push(newDataset);
                chart.update();
            }
        },
        {
            name: 'Add Data',
            handler(chart) {
                const data = chart.data;
                if (data.datasets.length > 0) {
                    data.labels.push('data #' + (data.labels.length + 1));

                    for (let index = 0; index < data.datasets.length; ++index) {
                        data.datasets[index].data.push(Utils.rand(0, 100));
                    }

                    chart.update();
                }
            }
        },
        {
            name: 'Remove Dataset',
            handler(chart) {
                chart.data.datasets.pop();
                chart.update();
            }
        },
        {
            name: 'Remove Data',
            handler(chart) {
                chart.data.labels.splice(-1, 1); // remove the label first

                chart.data.datasets.forEach(dataset => {
                    dataset.data.pop();
                });

                chart.update();
            }
        }
    ];
    </script>

</body>

</html>