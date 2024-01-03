<?php require_once("controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Pendaftaran";
require_once("templates/top.php"); ?>

<section class="heading-page header-text" id="top">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h6>SMAS K Warta Bakti</h6>
        <h2>Hasil Seleksi</h2>
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
                <a href="formulir-ppdb" class="text-dark"><i class="bi bi-arrow-return-right"></i> Formulir PPDB</a>
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
        <div class="meeting-single-item">
          <div class="down-content rounded-0">
            <div class="table-responsive">
              <table class="table table-striped" id="dataTable">
                <thead>
                  <tr>
                    <th class="text-center">Status</th>
                    <th class="text-center">Nama Lengkap</th>
                    <th class="text-center">Jenis Kelamin</th>
                    <th class="text-center">Tgl Lahir</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">No. Telp</th>
                    <th class="text-center">Asal Sekolah</th>
                    <th class="text-center">Tgl Seleksi</th>
                    <th class="text-center">Tgl Hasil</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th class="text-center">Status</th>
                    <th class="text-center">Nama Lengkap</th>
                    <th class="text-center">Jenis Kelamin</th>
                    <th class="text-center">Tgl Lahir</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">No. Telp</th>
                    <th class="text-center">Asal Sekolah</th>
                    <th class="text-center">Tgl Seleksi</th>
                    <th class="text-center">Tgl Hasil</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($views_hasil_seleksi as $data) { ?>
                    <tr>
                      <td><?= $data['status_lulus'] ?></td>
                      <td><?= $data['nama_lengkap'] ?></td>
                      <td><?= $data['jenis_kelamin'] ?></td>
                      <td><?= $data['tanggal_lahir'] ?></td>
                      <td><?= $data['alamat'] ?></td>
                      <td><?= $data['email'] ?></td>
                      <td><?= $data['nomor_telepon'] ?></td>
                      <td><?= $data['asal_sekolah'] ?></td>
                      <td><?php $tanggal_seleksi = date_create($data["tanggal_seleksi"]);
                          echo date_format($tanggal_seleksi, "d M Y"); ?></td>
                      <td><?php if ($data["tanggal_hasil"] !== NULL) {
                            $tanggal_hasil = date_create($data["tanggal_hasil"]);
                            echo date_format($tanggal_hasil, "d M Y");
                          } ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require_once("templates/bottom.php"); ?>