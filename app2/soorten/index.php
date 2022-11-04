<?php

# Pagina voor alle soorten (vogels - bomen )

$vogelen = json_decode(file_get_contents('../../data/voogelen.json'),true);

?>
<html>
<head>
    <title>HetWildeNL - Collectie flora en fauna</title>
    <link href="/style.css" rel="stylesheet">
</head>
<body>
<h1>Collectie flora en fauna</h1>
<h2>Soorten</h2>
<a href="soort.php?taxonId=Q14683">Huismus</a>
<a href="soort.php?taxonId=Q133128">Grove den</a>

<ul>
    <?php
        foreach($vogelen as $vogel):
        $label = $vogel['depictedLabelNL'];
        $wikiID = trim($vogel['depicted'], 'http://www.wikidata.org/entity/');
        ?>
    <li><a href="soort.php?taxonId=<?= $wikiID?>"><?= $label?></a></li>
    <?php endforeach;?>
</ul>
</body>
</html>
