<div id="Penghargaan" class="text-left paddsection">

      <div class="container">
        <div class="section-title text-center">
          <h1>Film</h1>
        </div>
      </div>

      <div class="container">
        <div class="journal-block">
        <div class="row" style="color: white">
        <div class="col-lg-12">
      <?php
        // OGP untuk film

        \EasyRdf\RdfNamespace::setDefault('og');

        $award_url = '';
        foreach ($doc->all('owl:sameAs') as $akun) {
            $ogp_url = $akun->get('foaf:homepage');

            $ogp = \EasyRdf\Graph::newAndLoad($ogp_url);
            $ogp_image = $ogp->image;

            ?>
          <div class="row"> 
          <div class="col-lg-4 ">
            <img width="250" src="<?= $ogp_image ?>" alt="">
          </div>
          <div class="col-lg-4 ">
            <p><?= $ogp->description; ?></p>
            <p>Sumber: <a href="<?= $ogp->url ?>" target="_blank"><?= $ogp->site_name ?></a></p>
            <?php } ?>
          </div>
          </div>

        </div>
      </div>

        </div>
      </div>