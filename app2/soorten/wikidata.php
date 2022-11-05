<?php
function wikidataImages($taxonId) {
    $endpoint = 'https://query.wikidata.org/sparql';
    $sparql = <<<EOD
        SELECT ?image ?itemLabel 
        WHERE 
        {
          wd:Q27236 wdt:P18 ?image . # Must be of a cat
          SERVICE wikibase:label { bd:serviceParam wikibase:language "[AUTO_LANGUAGE],en". } # Helps get the label in your language, if not, then en language
        }
    EOD;
    $json = getSparqlResults($endpoint,$sparql);
    return array_map(
        function($row) {
            return array(
                "image" => $row['image']['value'],
                "uri" => $row['image']['value'],
            );
        },
        json_decode($json,true)['results']['bindings']
    );

}
?>
