<?php

include("functions.php");


$sparql = "
SELECT ?item ?itemLabel ?taxon ?taxonLabel ?afb ?dob ?dod ?wpen ?wpnl WHERE {
  VALUES ?taxon { wd:" . $_GET['taxonid'] . " }
  ?item wdt:P10241 ?taxon .
  optional{
    ?item wdt:P18 ?afb .
  }
  optional{
    ?item wdt:P569 ?dob .
  }
  optional{
    ?item wdt:P570 ?dod .
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
}";

//echo $sparql;
$endpoint = 'https://query.wikidata.org/sparql';

$json = getSparqlResults($endpoint,$sparql);
$data = json_decode($json,true);

//print_r($data);

$imgs = array();
foreach ($data['results']['bindings'] as $row) {
	if(isset($row['afb']['value'])){
		$imgs[] = array(
			"img" => $row['afb']['value'] . "?width=100",
			"qid" => str_replace("http://www.wikidata.org/entity/","",$row['item']['value']),
			"label" => $row['itemLabel']['value']
		);
	}
}


?>
<html>
<head>

	<style type="text/css">
		body{
			text-align: center;
			font-family: Arial, Helvetica, sans-serif;
		}
		h1{
			margin-top: 60px;
		}
		a{
			color: #dc73d6;
			text-decoration: none;
			font-family: "Arial Black", Helvetica, sans-serif;
		}
		.individual{
			position: relative;
			display: inline-block;
			margin: 20px 30px 0 30px;
			text-align: center;
			vertical-align: middle;
			width: 150px;
			height: 150px;
		}
		.circle{
			position: absolute;
			width: 100%;
			height: 100%;
			background-color:#ffc6ff;
			border-radius: 50%;
		  background-position: center; /* Center the image */
		  background-repeat: no-repeat; /* Do not repeat the image */
		  background-size: cover; /* Resize the background image to cover the entire container */
		}
		.content{
			position: absolute;
			width: 150px;
			overflow: visible;
			margin-top: 40px;
			margin-left: -10px;
			background-color:#fff;
			font-size: 14px;
			border: 5px solid #dc73d6;
			padding: 5px;
			color: #000;
			
		}
	</style>


</head>
<body>
<h1>"We are all individuals"</h1>

<h2>van het taxon <?= $data['results']['bindings'][0]['taxonLabel']['value'] ?></h2>


<br />

<?php foreach ($data['results']['bindings'] as $row) { ?>
	<div class="individual">
		<?php if(isset($row['afb']['value'])){ ?>
				<div class="circle" style="background-image: url(<?= $row['afb']['value'] ?>?width=150);"></div>
		<?php }else{ ?>
				<div class="circle"></div>
		<?php } ?>
		<div class="content">
			<a href="individu.php?individu=<?= str_replace("http://www.wikidata.org/entity/","",$row['item']['value']) ?>"><?= $row['itemLabel']['value'] ?></a><br />
			<?php if(isset($row['dob']['value']) && preg_match("/^[0-9]{4}/",$row['dob']['value'])){ ?>
				<?= substr($row['dob']['value'],0,4) ?>
			<?php }else{ ?>
				?
			<?php } ?>
			-
			<?php if(isset($row['dod']['value']) && preg_match("/^[0-9]{4}/",$row['dod']['value'])){ ?>
				<?= substr($row['dod']['value'],0,4) ?>
			<?php } ?>
			<?php if(isset($row['wpen']['value'])){ ?>
				<a href="<?= $row['wpen']['value'] ?>">en</a>
			<?php } ?>
			<?php if(isset($row['wpnl']['value'])){ ?>
				<a href="<?= $row['wpnl']['value'] ?>">nl</a>
			<?php } ?>
		</div>
	</div>
<?php } ?>
</body>

