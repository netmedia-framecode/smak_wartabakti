<?php require_once("controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Pengumuman";
require_once("templates/top.php"); ?>

<section class="heading-page header-text" id="top">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h6>SMAS K Warta Bakti</h6>
        <h2>Pengumuman</h2>
      </div>
    </div>
  </div>
</section>

<section class="meetings-page" id="meetings">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 mb-3">
        <div class="meeting-single-item mb-3">
          <div class="down-content rounded-0">
            <h4>PPDB <?= date("Y") ?></h4>
            <ul>
              <li class="mb-2">
                <a href="panduan" class="text-dark"><i class="bi bi-arrow-return-right"></i> Panduan</a>
              </li>
              <?php foreach ($views_formulir as $data) { ?>
                <li class="mb-2">
                  <a href="<?= $baseURL ?>assets/files/formulir/<?= $data['formulir'] ?>" class="text-dark" download="<?= $data['formulir'] ?>"><i class="bi bi-arrow-return-right"></i> Download Formulir</a>
                </li>
              <?php } ?>
              <li class="mb-2">
                <a href="pendaftaran" class="text-dark"><i class="bi bi-arrow-return-right"></i> Pendaftaran</a>
              </li>
              <li class="mb-2">
                <a href="hasil-seleksi" class="text-dark"><i class="bi bi-arrow-return-right"></i> Hasil Seleksi</a>
              </li>
              <li class="mb-2">
                <a href="pengumuman" class="text-dark"><i class="bi bi-arrow-return-right"></i> Pengumuman</a>
              </li>
            </ul>
          </div>
        </div>
        <?php foreach ($views_galeri as $data) : ?>
          <div class="meeting-single-item mb-3">
            <img src="<?= $baseURL ?>assets/img/<?= $data['image'] ?>" style="width: 100%;height: 250px; object-fit: cover;" alt="">
          </div>
        <?php endforeach; ?>
      </div>
      <div class="col-lg-8 mb-4">
        <?php foreach ($views_pengumuman as $data) { ?>
          <div class="meeting-single-item mb-3">
            <div class="down-content rounded-0">
              <h2><?= $data['judul'] ?></h2>
              <p class="mb-3"><?php $tanggal  = date_create($data['tanggal']);
                              echo date_format($tanggal, 'l d M Y h:i'); ?></p>
              <?= $data['isi_pengumuman'] ?>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

  <?php require_once("templates/bottom.php"); ?>