<?php

$vogelQuery = '
SELECT DISTINCT ?file ?image ?depicted ?depictedLabel ?depictedLabelNL ?taxon ?taxonName WHERE {
  ?file wdt:P6243 wd:Q19361289 . 
#  ?file wdt:P180 wd:Q160488 .
   ?file wdt:P180 ?depicted .
  ?file schema:url ?image .
#  ?depicted wdt:P105 wd:Q7432 .
  VALUES ?taxon { wd:Q7432 wd:Q34740 }
  SERVICE <https://query.wikidata.org/sparql> {
    SERVICE wikibase:label {
        bd:serviceParam wikibase:language "[AUTO_LANGUAGE],en" .
        ?depicted rdfs:label ?depictedLabel .
    }
    SERVICE wikibase:label {
        bd:serviceParam wikibase:language "nl," .
        ?depicted rdfs:label ?depictedLabelNL .
    }
    ?depicted wdt:P225 ?taxonName .
    ?depicted wdt:P105 ?taxon . # geen eieren, alleen vogels en planten
  }
}
ORDER BY ?image
LIMIT 500
';