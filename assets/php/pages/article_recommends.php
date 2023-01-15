<?php 

require("../utils/config.php");
require("../utils/regions.php");
require("../utils/articles.php");

// -- Set current article title
$all_articles = array();
$current_article = "Статья не найдена";

$crime_articles = mysqli_query($connect, "SELECT * FROM crime_articles");


while($row = mysqli_fetch_assoc($crime_articles)) {
    array_push($all_articles, $row["name_of_the_statistical_factor"]);
}

$all_articles = array_slice(array_unique($all_articles), 0, count(array_unique($all_articles)) / 2);

if (isset($_GET["article"])) {
    foreach($all_articles as $article) {
        if (preg_replace('/\s+/', '', str_replace("Количество преступлений, зарегистрированных в отчетном периоде по", "", $article)) == $_GET["article"]) {
            $current_article = trim(str_replace("Количество преступлений, зарегистрированных в отчетном периоде по", "", $article));
        }
    }
}


?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../scss/style.css">
    <link rel="shortcut icon" href="../../images/icons/shield_var_1.png" type="image/x-icon">
    <title><?php echo $current_article; ?></title>
</head>

<body>

    <!-- Preloader -->
    <div class="mask">
        <div class="loader"></div>
    </div>

    <main class="recommends">
        <div class="container">
            <div class="row content">

                <!-- Title -->
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class="recommends__title"><?php 
                        echo $current_article;
                    ?></h1>
                    </div>
                    <div class="col-12 text-center">
                        <p class="recommends__text">
                            <?php echo $articles[$current_article] ?>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-center">
                        <a href=<?php 
                    if (isset($_GET["region"])) {
                        echo "recommends.php?region=".$_GET["region"];
                    }
                
                ?> class="back">Вернуться обратно</a>
                    </div>
                </div>

                <div class="row">
                    <?php require("../components/footer.php"); ?>
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


</body>

</html>