<?php 

require("../utils/config.php");
require("../utils/regions.php");
require("../utils/articles.php");


// -- Current region (выбранный регион)
$current_region = "";

if (isset($_GET["region"])) {
    foreach ($regions as $region) {
        if (preg_replace('/\s+/', '', $region) == $_GET["region"]) {
            $current_region = $region;
        }
    }
}

// -- Top articles of the current region (поп статей по выбранному региону)
$articles_of_region = array();
if (isset($_GET["region"]))  {
    $crime_articles = mysqli_query($connect, "SELECT * FROM crime_articles WHERE Subject='".$current_region."'");
    while($row = mysqli_fetch_assoc($crime_articles)) {
        $articles_of_region[$row["name_of_the_statistical_factor"]] = $row["importance_of_the_statistical_factor"];
    }
}

// -- Top 5 articles (топ 5 статей в регионе)
arsort($articles_of_region);
$articles_of_region = array_slice($articles_of_region, 0, 5);

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
    <title>Рекомендации</title>
</head>

<body class="recommends">

    <!-- Preloader -->
    <div class="mask">
        <div class="loader"></div>
    </div>

    <div class="container">
        <div class="row content">

            <div class="row">
                <div class="col-3">
                    <a href=<?php 
                    if (isset($_GET["region"])) {
                        echo "main.php?region=".$_GET["region"]."&option=general_statistics";
                    }
                
                ?> class="back">На главную</a>
                </div>
            </div>

            <!-- Title -->
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="recommends__title">Советы и рекомендации</h1>
                    <p class="recommends__suptitle"><?php 
                        echo "В регионе <b>".$current_region."</b> преобладают следующие нарушения УК РФ (нажмите, чтобы узнать рекомендации):";
                    ?></p>
                </div>
                <div class="col-12 text-center">
                    <ol class="recommends__list">
                        <?php 
                        $count = 1;
                            foreach($articles_of_region as $key => $value) {
                                echo '<li class="recommends__item">
                                    <a href="recommends.php?article='.$key.'">'.$count.'. '.$key.'</a>
                                </li>';
                                $count++;
                            }                         
                        ?>
                    </ol>
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


</body>

</html>