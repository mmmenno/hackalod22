<?php

include("uva.php");

$taxonId = $_GET["taxonId"];

foreach (uvaImages($taxonId) as $row) {
    $full_url = $row['imageURL']['value'];
    $small_url = str_replace("full/full", "full/300,", $full_url);
    print("<img src='$small_url' height='300'/>");
}
?>
