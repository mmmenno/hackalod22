<?php

# Alle natuurgebieden, kies gebied, etc
if(!isset($_GET['gebied'])){
  $gebied = "Q2800398";
}else{
  $gebied = $_GET['gebied'];
}

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
