<?php

include("../../app3/functions.php");

# Alle natuurgebieden, kies gebied, etc
if(!isset($_GET['gebied'])){
    $gebied = "Q2800398";
}else{
    $gebieden_data = "../../data/natura2000-met-wikidata.csv";
    if (($handle = fopen($gebieden_data, "r")) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
              if ($row[0] == $_GET['gebied']){
                $locality = $row[2];
                $gebieds_naam = $row[1];
              }
        }
        fclose($handle);
    }
    $gebiedid = $_GET['gebied'];
}

echo $locality;


// STAP 1: BOUNDS BEREKENEN
$apiurl = "https://api.biodiversitydata.nl/v2/geo/getGeoJsonForLocality/" . $locality;
$json = file_get_contents($apiurl);
$data = json_decode($json,true);

$n = null;
$e = null;
$s = null;
$w = null;

foreach($data['coordinates'] as $polygon){
    foreach($polygon[0] as $outercoord){
        if($outercoord[0] < $w || $w == null){
            $w = $outercoord[0];
        }
        if($outercoord[0] > $e || $e == null){
            $e = $outercoord[0];
        }
        if($outercoord[1] > $s || $s == null){
            $s = $outercoord[1];
        }
        if($outercoord[1] < $n || $n == null){
            $n = $outercoord[1];
        }
    }
}

$square = array(
    array($w,$s),
    array($e,$s),
    array($e,$n),
    array($w,$n),
    array($w,$s)
);

// nu wkt maken
$coords = array();
foreach($square as $coord){
    $coords[] = $coord[0] . " " . $coord[1];
}
$wkt = "POLYGON((";
$wkt .= implode(",", $coords);
$wkt .= "))";



// STAP 2: MET BOUNDS POLYGOON OCCURENCES UIT GBIF HALEN

// als je ook foto's wilt: &media_type=StillImage toevoegen
$gbifurl = "https://api.gbif.org/v1/occurrence/search?has_coordinate=true&limit=100&";
$gbifurl .= "has_geospatial_issue=false&geometry=" . str_replace(" ","%20",$wkt);

//echo $gbifurl;
$json = file_get_contents($gbifurl);
$data = json_decode($json,true);

// alle afzonderlijke GBIF soort ids in array
$speciesids = array();
$occurrences = array();

foreach ($data['results'] as $rec) {
    $occurrences[] = array(
        "lat" => $rec['decimalLatitude'],
        "lon" => $rec['decimalLongitude'],
        "speciesKey" => $rec['speciesKey']
    );
    if(!in_array($rec['speciesKey'],$speciesids)){
        $speciesids[] = $rec['speciesKey'];
    }
}

//print_r($occurrences);
//die;


// STAP 3: aan wikidata vragen wat de wikidata ids zijn bij deze gbif ids:

$sparql = "
SELECT ?item ?itemLabel ?gbif WHERE {
  VALUES ?gbif { \"";
$sparql .= implode("\" \"", $speciesids);
$sparql .= "\" }
  ?item wdt:P846 ?gbif .
    SERVICE wikibase:label { bd:serviceParam wikibase:language \"nl,en\".}
}";

//echo $sparql;
$endpoint = 'https://query.wikidata.org/sparql';

$json = getSparqlResults($endpoint,$sparql);
$data = json_decode($json,true);

//print_r($data);
//die;

foreach ($occurrences as $ockey => $ocvalue) {
    foreach ($data['results']['bindings'] as $wdkey => $wdvalue) {
        if($ocvalue['speciesKey'] == $wdvalue['gbif']['value']){
            $occurrences[$ockey]['wikidata'] = str_replace("http://www.wikidata.org/entity/","",$wdvalue['item']['value']);
            $occurrences[$ockey]['label'] = $wdvalue['itemLabel']['value'];
        }
    }
}

print_r($occurrences);
die;


?>
<html>
<head>
    <title>HetWildeNL - Collectie flora en fauna</title>
    <link href="/style.css" rel="stylesheet">
</head>
<body>
<h1>Collectie flora en fauna</h1>
<h2>Natuurgebied <?= $gebied ?></h2>
</body>
</html>
