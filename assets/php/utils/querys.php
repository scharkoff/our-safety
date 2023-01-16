<?php

require("config.php");

// -- Get * from all relationships
$crime_articles = mysqli_query($connect, "SELECT * FROM crime_articles");
$causes_of_crimes = mysqli_query($connect, "SELECT * FROM causes_of_crimes");
$number_of_victims = mysqli_query($connect, "SELECT * FROM number_of_victims");


?>