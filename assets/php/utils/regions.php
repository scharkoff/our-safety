<?php

// -- All regions
$regions = array();

// -- Create variable for regions
$query = mysqli_query($connect, "SELECT * FROM number_of_victims");
while ($row = mysqli_fetch_assoc($query)) {
    array_push($regions, $row["subject"]);
}

$regions = array_unique($regions);

?>