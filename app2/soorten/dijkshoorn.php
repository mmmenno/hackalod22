<?php

function dijkshoornImages($taxonId) {
    function taxon_match($var) {
        return $var == $taxonId;
    }

    $sparql = "
        PREFIX owl: <http://www.w3.org/2002/07/owl#>
        PREFIX oa: <http://www.w3.org/ns/oa#>
        SELECT DISTINCT ?taxon ?image
        WHERE {
          #?cho oa:hasBody/owl:sameAs <http://www.wikidata.org/entity/$taxonId> .
          ?cho oa:hasBody/owl:sameAs ?taxon .
          ?cho oa:hasTarget/oa:hasSource ?image .
          FILTER(regex(?image, 'ggpht.com', 'i'))
        }
    ";
    $endpoint = "https://api.data.netwerkdigitaalerfgoed.nl/datasets/ivo/rma-dijkshoorn/services/rma-dijkshoorn/sparql";
    $json = getSparqlResults($endpoint,$sparql);
    #print($json);
    $filtered = array_filter(
        json_decode($json,true)['results']['bindings'],
        function($t) use ($taxonId) {
            return $t['taxon']['value'] == "http://www.wikidata.org/entity/$taxonId";
        }
    );
    #print($filtered);
    return $filtered;
}
