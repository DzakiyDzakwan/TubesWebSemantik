<?php 
  $date = strtotime($data["birthDate"]);
  $birthDate = date('d M Y', $date);

  /* 
  var_dump($data["picture"]);
  echo "<br><br>";
  \EasyRdf\RdfNamespace::setDefault('og');
  $ogp = \EasyRdf\Graph::newAndLoad($data["picture"]);
  var_dump($ogp); */

    /* \EasyRdf\RdfNamespace::setDefault('og');
    $wiki_conn = \EasyRdf\Graph::newAndLoad($data["picture"]);
    $image = $wiki_conn->image; */
  
  $relative_query = "
  Select ?relative WHERE {
    ?s rdfs:label 'Elon Musk'@en.
    ?s dbp:relatives ?relative
     }
  ";

  $relatives = [];
  $relative_result = $dbpedia_conn->query($relative_query);
  foreach ($relative_result as $item) {
    $relatives[] = $item->relative;
  }

  $spouse_query = "
  Select ?spouse WHERE {
    ?s rdfs:label 'Elon Musk'@en.
    ?s dbo:spouse ?spouse
     }
  ";

  $spouses = [];
  $spouse_result = $dbpedia_conn->query($spouse_query);
  foreach ($spouse_result as $item) {
    $spouses[] = $item->spouse;
  }

?>

<div id="about" class="paddsection">
      <div class="container">
        <div class="row justify-content-between">

          <div class="col-lg-4 ">
            <div class="div-img-bg">
              <div class="about-img">
                <img src= "<?=$image_url?>"
                  class="img-responsive" alt="me">
              </div>
            </div>
          </div>

          <div class="col-lg-7">
            <div class="about-descr">
              <h2><?=$data["name"]?></h2>
              <ul>
                <li>Birth Name : <?=$data["birthName"]?></li>
                <li>Birt Date : <?=$birthDate?></li>
                <li>Birth Place : <?=$data["birthPlace"]?></li>
                <li>Education : <?=$data["education"]?></li>
                <li>
                  Relative :
                  <ul>
                  <?php foreach($relatives  as $item) : ?>
                    <?php if($item != "") :?>
                      <li><?= $item?></li>
                    <?php endif ; ?>
                  <?php endforeach ; ?>
                  </ul>
                </li>
                <li>
                  Spouse :
                  <ul>
                  <?php foreach($spouses  as $item) : ?>
                    <li><a href="<?= $item?>"><?php echo getName($item) ?></a></li>
                  <?php endforeach ; ?>
                  </ul>
                </li>
                <li>
                  Family :
                  <ul>
                    <li>Father : <a href="<?=$data["father"]?>">Erol Musk</a></li>
                    <li>Mother : <a href="<?=$data["mother"]?>"><?php echo getName($data["mother"]) ?></a></li>
                  </ul>
                </li>
              </ul>
            </div>

          </div>
        </div>
      </div>
    </div>