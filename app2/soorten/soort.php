<html>
<body>
<?php

include("../../app3/functions.php");

include("uva.php");
include("commons.php");
include("dijkshoorn.php");

include("../../app3/individuals_query.php");

$taxonId = $_GET["taxonId"];

print("<!-- results from Nozeman -->\n");
foreach (commonsImages($taxonId, true) as $row) {
    print("<!-- Nozeman ${row['entity']} -->");
    print("<img src='${row['image']}' height='300'/>");
}
print("<!-- results from uva -->\n");
foreach (uvaImages($taxonId) as $row) {
    print("<!-- uva -->");
    print("<img src='${row['image']}' height='300'/>");
}
print("<!-- results from dijkshoorn -->\n");
foreach (dijkshoornImages($taxonId) as $row) {
    print("<!-- dijkshoorn -->");
    print("<img src='${row['image']}' height='300'/>");
}
print("<!-- other results from other commons -->\n");
foreach (commonsImages($taxonId) as $row) {
    print("<!-- Commons ${row['entity']} -->");
    print("<img src='${row['image']}' height='300'/>");
}
if (!empty(queryIndividuals($taxonId))) {
    print("<a href='../../app3/taxon.php?taxonid=$taxonId'>We Are All Individuals!!</a>");
}
?>
</body>
</html>
