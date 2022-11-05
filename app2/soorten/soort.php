<html>
<head>
<link rel="stylesheet" href="styles.css" />
</head>
<body>
<?php

include("../../app3/functions.php");
include("uva.php");
include("commons.php");
include("dijkshoorn.php");
include("nozeman.php");

include("../../app3/individuals_query.php");

$taxonId = $_GET["taxonId"];

$images = array_merge(
    //commonsImages($taxonId, true),
    uvaImages($taxonId),
    nozemanImages($taxonId),
    dijkshoornImages($taxonId),
    //commonsImages($taxonId)
);

#foreach ($images as $row) {
#    print("<img src='${row['image']}' height='300'/>");
#}
$positions = array(
	"left: 5%; top: 70%",
	"left: 25%; top: 8%",
	"left: 45%; top: 40%",
	"left: 70%; top: 65%",
	"left: 53%; top: 10%",
	"left: 85%; top: 00%",
	"left: 05%; top: 00%",
	"left: 30%; top: 70%",
	"left: 85%; top: 60%",
	"left: 55%; top: 45%"
);
$i = 0;
foreach ($images as $img) { 

	$pos = $positions[$i];
	$i++;

	if($i>8){
		break;
	}

    ?>
	<div class="imgcircleholder" style="<?= $pos ?>">
		<div class="circle" style="background-image: url(<?= $img['image'] ?>?width=500);"></div>
	</div>
<?php }

if (!empty(queryIndividuals($taxonId))) {
    print("<a href='../../app3/taxon.php?taxonid=$taxonId'><div class='imgcircleholder' style='left: -0%; top: 23%'><div class='circle' style='background-image: url(./individuals.png)'></div></div></a>");
}
?>
</body>
</html>
