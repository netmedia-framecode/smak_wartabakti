<?php require_once("controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Profil";
require_once("templates/top.php"); ?>

<section class="heading-page header-text" id="top">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h6>SMAS K Warta Bakti</h6>
        <h2>Profil</h2>
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
                <h2>Profil SMA Swasta Katolik Warta Bakti</h2>
                <hr>
                <?php foreach ($views_profil as $data) {
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