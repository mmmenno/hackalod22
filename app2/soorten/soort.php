
<?php

include("../../app3/functions.php");

include("uva.php");
include("commons.php");
include("dijkshoorn.php");

$taxonId = $_GET["taxonId"];
foreach (commonsImages($taxonId, true) as $row) {
    $file_entity_url = $row['file']['value'];
    $full_image_url = $row['image']['value'];
    print("<!-- Nozeman $file_entity_url -->");
    print("<img src='$full_image_url?width=300' height='300'/>");
}
foreach (uvaImages($taxonId) as $row) {
    $full_url = $row['imageURL']['value'];
    $small_url = str_replace("full/full", "full/300,", $full_url);
    print("<img src='$small_url' height='300'/>");
}
foreach (dijkshoornImages($taxonId) as $row) {
    $full_image_url = $row['img']['value'];
    print("<img src='$full_image_url' height='300'/>");
}
foreach (commonsImages($taxonId) as $row) {
    $file_entity_url = $row['file']['value'];
    $full_image_url = $row['image']['value'];
    print("<!-- $file_entity_url -->");
    print("<img src='$full_image_url?width=300' height='300'/>");
}
