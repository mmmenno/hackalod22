<?php

include("uva.php");
include("commons.php");

$taxonId = $_GET["taxonId"];

foreach (uvaImages($taxonId) as $row) {
    $full_url = $row['imageURL']['value'];
    $small_url = str_replace("full/full", "full/300,", $full_url);
    print("<img src='$small_url' height='300'/>");
}
foreach (commonsImages($taxonId) as $row) {
    $full_url = $row['image']['value'];
    print("<img src='$full_url?width=300' height='300'/>");
}
?>
