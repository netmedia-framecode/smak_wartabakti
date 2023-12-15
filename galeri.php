<?php require_once("controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Galeri";
require_once("templates/top.php"); ?>

<section class="heading-page header-text" id="top">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h6>SMAS K Warta Bakti</h6>
        <h2>Galeri</h2>
      </div>
    </div>
  </div>
</section>

<section class="meetings-page" id="meetings">
  <div class="container">
    <div class="row">
      <?php foreach ($views_galeri as $index => $data) : ?>
        <div class="col-lg-4 mb-3">
          <img src="<?= $baseURL ?>assets/img/<?= $data['image'] ?>" class="img-thumbnail" style="cursor: pointer;" alt="<?= $data['image'] ?>" data-toggle="modal" data-target="#exampleModal<?= $index ?>">
        </div>
        <div class="modal fade" id="exampleModal<?= $index ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header border-bottom-0 shadow">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <img src="<?= $baseURL ?>assets/img/<?= $data['image'] ?>" class="img-thumbnail" alt="<?= $data['image'] ?>">
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    </div>
  </div>

  <?php require_once("templates/bottom.php"); ?>