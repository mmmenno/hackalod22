<?php

function commonsImages($taxonId, $fromNozeman = false) {
    $endpoint = 'https://commons-query.wikimedia.org/sparql';
    $nozemanQuery = '';
    if ($fromNozeman === true) {
        $nozemanQuery = '?file wdt:P6243 wd:Q19361289 . ';
    }

    $query = <<<EOD
        SELECT DISTINCT ?file ?depicted ?taxonName ?image ?depictedLabel ?depictedLabelNL ?taxon WHERE {
            $nozemanQuery
            ?file wdt:P180 wd:$taxonId.
            ?file wdt:P180 ?depicted .
            ?file schema:url ?image .
            ?file rdf:type schema:ImageObject . # don't produce sounds ;)
            #  ?depicted wdt:P105 wd:Q7432 .
            VALUES ?taxon { wd:Q7432 wd:Q34740 }
            SERVICE <https://query.wikidata.org/sparql> {
                SERVICE wikibase:label {
                    bd:serviceParam wikibase:language "[AUTO_LANGUAGE],en" .
                    ?depicted rdfs:label ?depictedLabel .
                }
                ?depicted wdt:P225 ?taxonName .
                ?depicted wdt:P105 ?taxon . # geen eieren, alleen vogels en planten
            }
        }
        #ORDER BY ?image
        LIMIT 10
    EOD;
    
    $ch = curl_init();
    curl_setopt_array( $ch, [
        CURLOPT_URL => $endpoint,
        CURLOPT_USERAGENT => 'HackalodBot/0.1',
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query( [
            'query' => $query,
        ] ),
        CURLOPT_HTTPHEADER => [
            'accept: application/json',
        ],
        CURLOPT_COOKIE => 'wcqsOauth=' . getenv( 'WCQS_AUTH_TOKEN' ),
        CURLOPT_COOKIEJAR => __DIR__ . '/cookie.txt',
        CURLOPT_COOKIEFILE => __DIR__ . '/cookie.txt',
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_VERBOSE => true,
    ]);
    
    $response = curl_exec( $ch );
    if(str_contains(curl_getinfo($ch)["url"], "UserLogin")) {
        throw new Exception("provide WCQS_AUTH_TOKEN as documented at https://commons.wikimedia.org/wiki/Commons:SPARQL_query_service/API_endpoint");
    }
    
    #print("Results\n");
    #print($response);
    return json_decode( $response, true )['results']['bindings'];
}


?>
