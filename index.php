<?php
require 'vendor/autoload.php';

use EasyRdf\RdfNamespace;
\EasyRdf\RdfNamespace::set('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
    \EasyRdf\RdfNamespace::set('rdfs', 'http://www.w3.org/2000/01/rdf-schema#');
    \EasyRdf\RdfNamespace::set('owl', 'http://www.w3.org/2002/07/owl#');
    \EasyRdf\RdfNamespace::set('dc', 'http://purl.org/dc/elements/1.1/');
    \EasyRdf\RdfNamespace::set('dbo', 'https://dbpedia.org/page#');
    \EasyRdf\RdfNamespace::set('dbp', 'http://dbpedia.org/property#');
    \EasyRdf\RdfNamespace::set('dbr', 'http://dbpedia.org/resource#');
    \EasyRdf\RdfNamespace::set('xsd', 'http://www.w3.org/2001/XMLSchema#');
    \EasyRdf\RdfNamespace::set('skos', 'http://www.w3.org/2004/02/skos/core#');
    \EasyRdf\RdfNamespace::set('geo', 'http://www.w3.org/2003/01/geo/wgs84_pos#');
    \EasyRdf\RdfNamespace::setDefault('og');

    $link = new \EasyRdf\Sparql\Client('http://localhost:3030/tubesWs/query');

    $elon_URI = 'https://dbpedia.org/page/Elon_Musk';

    $about_query = '
      SELECT ?birthOn ?birthDate ?education ?father ?mother ?picture WHERE {
       <'. $elon_URI .'> dbo:birthPlace ?birthOn.
        ?s dbo:birthDate ?birthDate.
        ?s dbo:education ?education.
        ?s dbp:father ?father.
        ?s dbp:mother ?mother.
        ?s dbo:thumbnail ?picture.
      }
      ';

    $hero_query = '
      SELECT ?birthName ?name WHERE {
        ?s foaf:name ?name.
        ?s dbo:birthName ?birthName.
      }
      ';

    $map_query = '
      SELECT ?latitude ?longitude WHERE {
        ?s <http://www.w3.org/2003/01/geo/wgs84_pos#long> ?longitude.
        ?s <http://www.w3.org/2003/01/geo/wgs84_pos#lat> ?latitude.
      }
    ';

    $abstract_query = '
      SELECT ?abstract WHERE {
        ?s dbo:abstract ?abstract.
      }
    ';

    $result_map = $link->query($map_query);
    $result_abstract = $link->query($abstract_query);
    $result_hero = $link->query($hero_query);
    $result_about = $link->query($about_query);

    $birthOn;
    $birthDate;
    $education;
    $mother;
    $father;
    $birthName;
    $longitude;
    $latitude; 
    $abstract;
    $name;
    $picture;
    
    foreach ($result_map as $item) {
      $longitude = $item->longitude;
      $latitude =  $item->latitude;
    }

    foreach ($result_abstract as $item) {
      $abstract = $item->abstract;
    }

    foreach ($result_hero as $item){
      $name = $item ->name;
      $birthName = $item->birthName;
    }

    foreach ($result_about as $item){
      $birthOn = $item->birthOn;
      $birthDate = $item->birthDate;
      $education = $item->education;
      $mother = $item->mother;
      $father = $item->father;
      $picture = $item->picture; 
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Elon Musk</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,500i,600,600i,700,700i|Playfair+Display:400,400i,500,500i,600,600i,700,700i,900,900i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- LeafletJs -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
    integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
  <!-- Make sure you put this AFTER Leaflet's CSS -->
  <!-- Make sure you put this AFTER Leaflet's CSS -->
  <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
    integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

  <style>
    #map {
      height: 200px;
    }
  </style>
</head>

<body>
  <!-- ======= Hero Section ======= -->
  <?php include 'hero-section.php' ?>
  <!-- End Hero -->

  <main id="main">

    <!-- ======= Abstract Section ======= -->
    <?php include 'abstract-section.php' ?>
    <!-- ======= End Abstract Section ======= -->

    <!-- End About Section -->
    <?php include 'about-section.php' ?>
    <!-- End About Section -->

    <!-- Map -->
    <?php include 'map-section.php' ?>
    <!-- Map End -->

    <!-- ======= Award ======= -->
    <?php include 'award-section.php' ?>
    <!-- End Award Section -->

    <!-- ======= Relative Section ======= -->
    <?php include 'relative-section.php' ?>
    <!-- ======= End Relative Section ======= -->

  </main>
  <!-- End #main -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/typed.js/typed.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
    var map = L.map('map').setView([<?=$latitude?>, <?=$longitude?>], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    var marker = L.marker([<?=$latitude?>, <?=$longitude?>]).addTo(map);
    marker.bindPopup("Elon Birth Here").openPopup();
  </script>

</body>

</html>