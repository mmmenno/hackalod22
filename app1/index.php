<?php

include("functions.php");

$zoomlevel = 10;
$lat = 52;
$lon = 5;
$radius = 10;
$qid = "Q13742779";
$year = 1950;

?>

<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.1.0/dist/leaflet.css" integrity="sha512-wcw6ts8Anuw10Mzh9Ytw4pylW8+NAD4ch3lqm9lzAsTxg0GFeJgoAtxuCLREZSC5lUXdVyo/7yfsqFjQ4S+aKw==" crossorigin=""/>

  <script src="https://unpkg.com/leaflet@1.1.0/dist/leaflet.js" integrity="sha512-mNqn2Wg7tSToJhvHcqfzLMU6J4mkOImSPTxVZAdo+lcPlk+GhZmYgACEe0x35K7YzW1zJ7XyJV/TT1MrdXvMcA==" crossorigin=""></script>


  <!-- Esri Leaflet -->
  <script src="https://unpkg.com/esri-leaflet@2.2.4/dist/esri-leaflet.js"></script>

  <!-- Proj4 and Proj4Leaflet -->
  <script src="https://unpkg.com/proj4@2.5.0/dist/proj4-src.js"></script>
  <script src="https://unpkg.com/proj4leaflet@1.0.1"></script>


  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" href="assets/css/styles.css" />
  
    </script>
    

<div id="map" style="height: 400px; margin-bottom: 24px; width: 98%;"></div>

<div id="maptt" style="height: 400px; margin-bottom: 24px; width: 98%;"></div>

<script>
  $(document).ready(function() {
    createMap();
    createTopoTijdReisMap();
//    refreshMap();
  });

  function createMap(){
    center = [<?= $lat ?>, <?= $lon ?>];
    zoomlevel = <?= $zoomlevel ?>;

    map = L.map('map', {
          center: center,
          zoom: zoomlevel,
          minZoom: 1,
          maxZoom: 20,
          scrollWheelZoom: true,
          zoomControl: false
      });

    L.control.zoom({
        position: 'bottomright'
    }).addTo(map);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
  }

  function createTopoTijdReisMap(){
    center = [<?= $lat ?>, <?= $lon ?>];
//    zoomlevel = <?= $zoomlevel ?>;

    var RD = new L.Proj.CRS(
        'EPSG:28992',
        '+proj=sterea +lat_0=52.15616055555555 +lon_0=5.38763888888889 +k=0.9999079 +x_0=155000 +y_0=463000 +ellps=bessel +units=m +towgs84=565.2369,50.0087,465.658,-0.406857330322398,0.350732676542563,-1.8703473836068,4.0812 +no_defs', {
        origin: [-3.05155E7,3.1112399999999993E7],
        resolutions: [3251.206502413005,1625.6032512065026,812.8016256032513,406.40081280162565,203.20040640081282,101.60020320040641, 50.800101600203206,25.400050800101603,12.700025400050801,6.350012700025401,3.1750063500127004,1.5875031750063502,0.7937515875031751,0.39687579375158755,0.19843789687579377,0.09921894843789689,0.04960947421894844]
    });


//    var topotijdreislayer = L.esri.tiledMapLayer({
//        url: 'https://tiles1.arcgis.com/tiles/nSZVuSZjHpEZZbRo/arcgis/rest/services/Historische_tijdreis_1950/flet wmts amersfoort coordinatenMapServer',
//        maxZoom: 11,
//        minZoom: 0,
//    });
//
//    var maptt = L.map('maptt', {
//        crs: RD,
//        layers: [topotijdreislayer]
//    });


    var topotijdreislayer = L.tileLayer('https://tiles.arcgis.com/tiles/nSZVuSZjHpEZZbRo/arcgis/rest/services/Historische_tijdreis_<?= $year ?>/MapServer/WMTS/tile/1.0.0/Historische_tijdreis_<?= $year ?>/default/default028mm/{z}/{y}/{x}',
    { WMTS: false, attribution: 'Kadaster (TopoTijdReis <?= $year ?>)' });

    maptt = L.map('maptt', {
        crs: RD,
        scrollWheelZoom: true,
        zoomControl: false,
        minZoom: 1,
        maxZoom: 11,
        layers: [topotijdreislayer]
    });
    L.control.zoom({
        position: 'bottomright'
    }).addTo(maptt);

    //map view still gets set with Latitude/Longitude,
    //BUT the zoomlevel is now different (it uses the resolutions defined in our projection tileset above)
    maptt.setView(center, 11);
    // OR use RD coordinates (28992), and reproject it to LatLon (4326)
    //maptt.setView(RD.projection.unproject(center), 10);
  }

  function refreshMap(){
    $.ajax({
      type: 'GET',
      url: 'geojson.php',
      data: { lat: <?= $lat ?>, lon: <?= $lon ?>, radius: <?= $radius ?>, qid: "<?= $qid ?>" },
      dataType: 'json',
      success: function(jsonData) {
        if (typeof sightings !== 'undefined') {
          map.removeLayer(sightings);
        }

        sightings = L.geoJson(null, {
          pointToLayer: function (feature, latlng) {                    
              return new L.CircleMarker(latlng, {
                  color: "#FC2211",
                  radius:8,
                  weight: 2,
                  opacity: 0.8,
                  fillOpacity: 0.3
              });
          },
          style: function(feature) {
            return {
                color: getColor(feature.properties),
                clickable: true
            };
          },
          onEachFeature: function(feature, layer) {
            showImages(feature);
            layer.on({
                click: whenClicked
              });
            }
        }).addTo(map);

        sightings.addData(jsonData).bringToFront();

        if(sightings.getLayers().length == 0){
          $('#fotobeschrijving').css("margin-bottom","0");
        }
      
        //map.fitBounds(sightings.getBounds());
      },
      error: function() {
          console.log('Error loading data');
      }

    });

    
  }

  function getColor(props) {

    if (typeof props['bend'] == 'undefined' || props['bend'] == null) {
      return '#950305';
    }
    return '#738AB7';
  }

  function whenClicked() {

    console.log('clicked');
  }

  function showImages(feature){
    //console.log(feature);
    var props = feature['properties'];
    var src = props['foto'];
    var photoid = props['obsid'];
    //console.log(src);
    var photo = $('<img>',{id: photoid, src: src});
    photo.click(function(){
      $('#foto').html('');
      var src = $(this).attr('src');
      src = src.replace('square','medium');
      var bigphoto = $('<img>',{src: src});
      $('#foto').append(bigphoto);

      var phototxt = '';
      if(props['taxonwp']!=null){
        phototxt = '<a href="' + props['taxonwp'] + '">' + props['taxonname'] + '</a> - ';
      }
      phototxt += props['fotoattr'];
      console.log(phototxt)
      $('#fotobeschrijving').html(phototxt);
    });
    $('#fotos').append(photo);
  }



</script>

