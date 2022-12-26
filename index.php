<?php
require 'vendor/autoload.php';
require_once __DIR__."/html_tag_helpers.php";

//Name Space RDF
use EasyRdf\RdfNamespace;
    \EasyRdf\RdfNamespace::set('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
    \EasyRdf\RdfNamespace::set('rdfs', 'http://www.w3.org/2000/01/rdf-schema#');
    \EasyRdf\RdfNamespace::set('owl', 'http://www.w3.org/2002/07/owl#');
    \EasyRdf\RdfNamespace::set('dbo', 'http://dbpedia.org/ontology/');
    \EasyRdf\RdfNamespace::set('dbp', 'http://dbpedia.org/property/');
    \EasyRdf\RdfNamespace::set('xsd', 'http://www.w3.org/2001/XMLSchema#');
    \EasyRdf\RdfNamespace::set('geo', 'http://www.w3.org/2003/01/geo/wgs84_pos#');
    \EasyRdf\RdfNamespace::set('wealth', 'http://example.org/schema/wealth/');
    \EasyRdf\RdfNamespace::set('person', 'http://example.org/schema/person/');
    \EasyRdf\RdfNamespace::set('foaf', 'http://xmlns.com/foaf/0.1/');
    \EasyRdf\RdfNamespace::setDefault('og');

    //Connection to Jena Fuseki
    $link = new \EasyRdf\Sparql\Client('http://localhost:3030/tubesWs/query');

    //Connection to DBpedia
    $dbpedia_endpoint = 'https://dbpedia.org/sparql';
    $dbpedia_conn = new \EasyRdf\Sparql\Client($dbpedia_endpoint);

    //Query
    $elon_query = '
    Select * WHERE {
      ?s rdfs:label "Elon Musk"@en.
      ?s dbo:abstract ?abstract.
      ?s foaf:name ?name.
      ?s dbo:thumbnail ?picture.
      ?s dbo:birthName ?birthName.
      ?s dbo:birthDate ?birthDate.
      ?s dbo:birthYear ?birthYear.
      ?s dbp:birthPlace ?birthPlace.
      ?s dbp:family ?family.
      ?s dbp:father ?father.
      ?s dbp:mother ?mother.
      ?s dbp:education ?education.
      ?s dbo:birthPlace ?place.
      ?s foaf:isPrimaryTopicOf ?image.
      FILTER( LANG (?abstract) = "en")
       }
       LIMIT 1
    ';

    //Query Result
    $result = $dbpedia_conn->query($elon_query);
    $data = [];

    //Tampung Result
    foreach($result as $item) {
      $data = [
        'abstract' => $item->abstract,
        'picture' => $item->picture,
        'name' => $item->name,
        'birthName' => $item->birthName,
        'birthDate' => $item->birthDate,
        'birthYear' => $item->birthYear,
        'birthPlace' => $item->birthPlace,
        'family' => $item->family,
        'father' => $item->father,
        'mother' => $item->mother,
        'education' => $item->education,
        'place' => $item->place,
        'image' => $item->image

      ];
    }

    //ogp gambar dari wikipedia
    $image = \EasyRdf\Graph::newAndLoad($data['image']);
    $image_url = $image->image;

    //Fungsi untuk mengambil nama berdasarkan URI
    function getName($uri) {
      $query = "
      Select  * WHERE {
        <".$uri."> rdfs:label ?label;
        dbo:birthName ?name.
      FILTER (LANG(?label) = 'en')
         }
      ";

      $dbpedia_endpoint = 'https://dbpedia.org/sparql';
      $dbpedia_conn = new \EasyRdf\Sparql\Client($dbpedia_endpoint);

      $data = [];
      foreach ($dbpedia_conn->query($query) as $item) {
        $data = [
          "name" => $item->name
        ];
      }

      return $data["name"];
    }

    //Connection To Local RDF
    $local_endpoint = 'http://localhost/tubesWS/ElonMusk.rdf';
    $local_conn = \EasyRdf\Graph::newAndLoad($local_endpoint);
    $doc = $local_conn->primaryTopic();

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

    <!-- ======= Chart ======= -->
    <?php include 'chart-section.php' ?>
    <!-- End Chart Section -->

    <!-- ======= Award Section ======= -->
    <?php include 'film-section.php' ?>
    <!-- ======= End Award Section ======= -->

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

</body>

</html>