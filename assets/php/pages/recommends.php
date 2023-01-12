<?php 

require("../utils/config.php");
require("../utils/regions.php");


// -- Current region
$current_region = "";

if (isset($_GET["region"])) {
    foreach ($regions as $region) {
        if (preg_replace('/\s+/', '', $region) == $_GET["region"]) {
            $current_region = $region;
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
                    <h1 class="main__title">Советы и рекомендации</h1>
                    <p class="main__suptitle"><?php 
                        echo $current_region;
                    ?></p>
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