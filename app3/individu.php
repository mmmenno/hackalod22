<?php

error_reporting(E_ALL ^ E_NOTICE);  

include("functions.php");


include("options.php");



// Wikidata info van dit individu ophalen

$sparql = "
SELECT ?item ?itemLabel ?itemDescription ?taxon ?taxonLabel ?dob ?dod ?img ?work ?imbdId ?col ?wpen ?wpnl WHERE {
  VALUES ?item { wd:" . $_GET['individu'] . " }
  ?item wdt:P10241 ?taxon .
  OPTIONAL {
    ?item wdt:P569 ?dob .
  }
  OPTIONAL {
    ?item wdt:P570 ?dod .
  }
  OPTIONAL {
    ?item wdt:P18 ?img .
  }
  optional {
    ?item wdt:P1441 ?workLabel .
  }
  optional {
    ?item wdt:P345 ?imbdId .
  }
  optional {
    ?item wdt:P195 ?colLabel .
  }
  optional{
    ?wpen schema:about ?item .
    ?wpen schema:isPartOf <https://en.wikipedia.org/> .
  }
  optional{
    ?wpnl schema:about ?item .
    ?wpnl schema:isPartOf <https://nl.wikipedia.org/> .
  }
  SERVICE wikibase:label { bd:serviceParam wikibase:language \"nl,en\". }
}
";
$endpoint = 'https://query.wikidata.org/sparql';

$json = getSparqlResults($endpoint,$sparql);
$data = json_decode($json,true);

$individu = $data['results']['bindings'][0];
//print_r($data);

$indimgs = array();

if(isset($individu['img']['value'])){
	$indimgs[] = array(
		"image" => $individu['img']['value']
	);

}

// any imgs from commons?

$json = file_get_contents("../data/imgs-individuals.json");
$data = json_decode($json,true);


foreach ($data as $k => $v) {
	if($v['item'] == "http://www.wikidata.org/entity/" . $_GET['individu']){
		if(isset($individu['img']['value']) && $v['image']==$individu['img']['value']){
			continue;
		}
		$indimgs[] = $v;
	}
}
//print_r($indimgs);




?>
<html>
<head>
<link rel="stylesheet" href="styles.css" />


</head>
<body id="individu">


<div class="contentcircle">
<h1><?= $individu['itemLabel']['value'] ?></h1>

<p><?= $individu['itemDescription']['value'] ?></p>
	
<!--<?php if(isset($individu['colLabel']['value'])) ?>-->
	
<!--<?php if(isset($individu['workLabel']['value'])) ?>-->
<!--hier moet de workLavels herhaalt worden als het individu in meerdere werken voorkomt-->
	
<?php if(isset($individu['wpnl']['value'])){ ?>
	<a href="<?= $individu['wpnl']['value'] ?>">🇳🇱</a>
<?php } ?>

<?php if(isset($individu['wpen']['value'])){ ?>
	<a href="<?= $individu['wpen']['value'] ?>">🇬🇧</a>
<?php } ?>

<div class="dobd">
	<?php if(isset($individu['dob']['value'])){ ?>
		<br /><?= substr($individu['dob']['value'],0,4) ?>
	<?php } ?>

	<?php if(isset($individu['dod']['value'])){ ?>
		- <?= substr($individu['dod']['value'],0,4) ?>
	<?php } ?>
</div>

</div>


<?php 
	$positions = array(
		"left: 55%; top: 40%",
		"left: 35%; top: 5%",
		"left: 65%; top: -10%",
		"left: 20%; top: 45%",
		"left: -3%; top: 60%",
		"left: 75%; top: 70%",
		"left: 35%; top: 70%",
		"left: 80%; top: 20%",
		"left: 55%; top: 90%",
		"left: 15%; top: 95%"
	);
	$i = 0;
	foreach ($indimgs as $img) { 

		$pos = $positions[$i];
		$i++;

		if($i>8){
			break;
		}

	?>
	<div class="imgcircleholder" style="<?= $pos ?>">
		<div class="circle" style="background-image: url(<?= $img['image'] ?>?width=500);"></div>
	</div>
<?php } ?>



<form action="taxon.php" method="get">

<select name="taxonid">
	<?= $options ?>
</select>

<button type="submit">GO</button>

</form>


</body>
</html>
