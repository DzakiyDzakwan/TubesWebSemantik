<?php 

    $birthPlace_query = "
    Select ?birthPlace WHERE {
        ?s rdfs:label 'Elon Musk'@en.
        ?s dbo:birthPlace ?birthPlace
         }
    LIMIT 1
    ";

    $result_place = $dbpedia_conn->query($birthPlace_query);

    $birthPlace = [];
    foreach($result_place as $item) {
        $birthPlace = [
            "uri" => $item->birthPlace
        ];
    } 

    $uri = $birthPlace["uri"];
    
    $location_query = "
    Select ?long, ?lat WHERE {
        <".$uri."> rdfs:label ?label;
        geo:long ?long;
        geo:lat ?lat.
        FILTER (LANG(?label) = 'en')
    }
    ";

    $result_location = $dbpedia_conn->query($location_query);
    $location = [];
    foreach($result_location as $item) {
        $location = [
            "lat" => $item->lat,
            "long" => $item->long
        ];
    }

?>

<div class="paddsection">
    <div class="container">
            <h1 class="text-center my-5">Birth Place</h1>
            <div id="map"></div>
    </div>
</div>

<script>
    var map = L.map('map').setView([<?=$location["lat"]?>, <?=$location["long"]?>], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    var marker = L.marker([<?=$location["lat"]?>, <?=$location["long"]?>]).addTo(map);
    marker.bindPopup("<?=$data["birthPlace"]?>").openPopup();
  </script>