<?php

include("app3/functions.php");

include("app3/options.php");

?>
<!DOCTYPE html>
<html>
<head>
	
	<title>Het Wilde NL</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link href="https://fonts.googleapis.com/css?family=Nunito:300,700" rel="stylesheet">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.1.0/dist/leaflet.css" integrity="sha512-wcw6ts8Anuw10Mzh9Ytw4pylW8+NAD4ch3lqm9lzAsTxg0GFeJgoAtxuCLREZSC5lUXdVyo/7yfsqFjQ4S+aKw==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.1.0/dist/leaflet.js" integrity="sha512-mNqn2Wg7tSToJhvHcqfzLMU6J4mkOImSPTxVZAdo+lcPlk+GhZmYgACEe0x35K7YzW1zJ7XyJV/TT1MrdXvMcA==" crossorigin=""></script>

     <link rel="stylesheet" href="styles.css" />

	
	
</head>
<body>


<div id="hellothere" class="container">

	<h1>Erfgoedcollecties en de natuurlijke wereld</h1>



	<div class="row">
		<div class="col-md-12">
			
			<p>

			</p>

		</div>
	</div>

	<div class="row">
		<div class="col-md-4">

			<h2>Tegennatuur</h2>

			<img src="tegennatuur.jpg" />
			<p>Historische cartografie laat veranderingen in het landschap zien. Hoe zit dat met de omgeving van Natura2000 gebieden?</p>

			<h3>Gebruikte datasets</h3>
			
			<ul>
				<li>Topotijdreis kaarten</li>
				<li>Polygonen van Naturalis API</li>
			</ul>

		</div>
		<div class="col-md-4">

			<h2>Collectieflora & fauna</h2>

			<img src="florafauna.jpg" />
			<p>Buiten de gemeente Utrecht zijn 9.782 vermeldingen gevonden van 1.303 verschillende straten.</p>

			<h3>Gebruikte datasets</h3>
			
			<ul>
				<li>Botanische prenten UvA UB</li>
				<li>Nederlandsche vogelen van Nozeman en Sepp (via Commons)</li>
				<li>Waarnemingen via GBIF API</li>
			</ul>

		</div>
		<div class="col-md-4">

			<h2>"We are all individuals"</h2>

			<img src="individuals.jpg" />

			<p>Erfgoedinstellingen zijn doorgaans nogal antropocentrisch beschreven. Wordt het geen tijd de cartesiaanse scheiding tussen mens en natuur af te breken?</p>

			<a href="app3/individu.php?individu=Q115004786">Tanja</a> | 
			<a href="app3/individu.php?individu=Q115003515">Herman jr.</a> | 
			<a href="app3/individu.php?individu=Q107120526">Wonderboom Elswout</a> | 
			<a href="app3/individu.php?individu=Q15943299">Duizendjarige Den</a>

			<form action="app3/taxon.php" method="get">

			<select name="taxonid" onchange="this.form.submit()">
				<?= $options ?>
			</select>

			</form>

			<h3>Gebruikte datasets</h3>

			<ul>
				<li>Individuele dieren van Wikidata</li>
				<li>Afbeeldingen van Commons</li>
				<li>Quotes uit Delpher</li>
			</ul>

		</div>
	</div>

	<div class="row">
		<div class="col-md-6">

			

			
		</div>
		<div class="col-md-6">

			

		</div>
	</div>


</div>

	



</body>
</html>
