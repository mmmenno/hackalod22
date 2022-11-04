<?php

include("../../app3/functions.php");

function uvaImages($taxonId) {
    $sparql = "
        PREFIX foaf: <http://xmlns.com/foaf/0.1/>
        PREFIX mrel: <http://id.loc.gov/vocabulary/relators/>
        PREFIX dct: <http://purl.org/dc/terms/>
        PREFIX dc: <http://purl.org/dc/elements/1.1/>
        PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
        PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
        PREFIX wdt: <http://www.wikidata.org/prop/direct/>
        PREFIX wd: <http://www.wikidata.org/entity/>
        
        SELECT ?depictsURI ?botanic ?taxonName ?imageURL
        WHERE {
          SERVICE <https://query.wikidata.org/sparql> {
                ?depictsURI wdt:P31 wd:Q16521 ;    # instance of taxon
                    wdt:P171* wd:$taxonId;  # parent taxon or subclasses of gall wasp
                    wdt:P225 ?taxonName .    # taxon name
          }
        
          ?botanic dc:subject ?subject ;
                 dc:title ?title ;
                 mrel:dpc ?depictsURI ;
                 foaf:depiction ?imageURL .
        
          FILTER ( REGEX(?subject,'^botanie') ) .  # botanic images only
    }";
    $endpoint = 'https://api.lod.uba.uva.nl/datasets/UB-UVA/Beeldbank/services/virtuoso/sparql';
    $json = getSparqlResults($endpoint,$sparql);
    return json_decode($json,true)['results']['bindings'];
}

?>
