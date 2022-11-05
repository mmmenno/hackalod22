<html>
<body>
<?php

include("../../app3/functions.php");

include("uva.php");
include("commons.php");
include("dijkshoorn.php");

include("../../app3/individuals_query.php");

$taxonId = $_GET["taxonId"];

$images = array_merge(
    commonsImages($taxonId, true),
    uvaImages($taxonId),
    dijkshoornImages($taxonId),
    commonsImages($taxonId)
);

foreach ($images as $row) {
    print("<img src='${row['image']}' height='300'/>");
}
if (!empty(queryIndividuals($taxonId))) {
    print("<a href='../../app3/taxon.php?taxonid=$taxonId'>We Are All Individuals!!</a>");
}
?>
</body>
</html>
