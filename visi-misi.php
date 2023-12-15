<?php require_once("controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Visi Misi";
require_once("templates/top.php"); ?>

<section class="heading-page header-text" id="top">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h6>SMAS K Warta Bakti</h6>
        <h2>Visi dan Misi</h2>
      </div>
    </div>
  </div>
</section>

<section class="meetings-page" id="meetings">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="meeting-single-item">
              <div class="down-content">
                <h2>Visi dan Misi SMA Swasta Katolik Warta Bakti</h2>
                <hr>
                <?php foreach ($views_visi_misi as $data) {
                  echo $data['deskripsi'];
                } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require_once("templates/bottom.php"); ?>