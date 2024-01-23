<?php require_once("../controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Hasil Seleksi";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_smak_wartabakti"]["name_page"] ?></h1>
    <?php if ($id_role <= 2) { ?>
      <div class="col-lg-6 text-right">
        <a href="export-hasil-seleksi" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" target="_blank"><i class="bi bi-download"></i> Export</a>
      </div>
    <?php } ?>
  </div>

  <div class="card shadow mb-4 border-0">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="text-center">Status</th>
              <th class="text-center">Nama Lengkap</th>
              <?php if ($id_role == 1) { ?>
                <th class="text-center">Nilai Ujian</th>
                <th class="text-center">Nilai Rapor</th>
                <th class="text-center">Nilai Total</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Tgl Seleksi</th>
                <th class="text-center">Tgl Hasil</th>
                <th class="text-center">Aksi</th>
              <?php } else if ($id_role == 2) { ?>
                <th class="text-center">Nilai Ujian</th>
                <th class="text-center">Nilai Rapor</th>
                <th class="text-center">Nilai Total</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Tgl Seleksi</th>
                <th class="text-center">Tgl Hasil</th>
              <?php } else if ($id_role == 3) { ?>
                <th class="text-center">Jenis Kelamin</th>
                <th class="text-center">Tgl Lahir</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Email</th>
                <th class="text-center">No. Telp</th>
                <th class="text-center">Asal Sekolah</th>
              <?php } ?>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th class="text-center">Status</th>
              <th class="text-center">Nama Lengkap</th>
              <?php if ($id_role == 1) { ?>
                <th class="text-center">Nilai Ujian</th>
                <th class="text-center">Nilai Rapor</th>
                <th class="text-center">Nilai Total</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Tgl Seleksi</th>
                <th class="text-center">Tgl Hasil</th>
                <th class="text-center">Aksi</th>
              <?php } else if ($id_role == 2) { ?>
                <th class="text-center">Nilai Ujian</th>
                <th class="text-center">Nilai Rapor</th>
                <th class="text-center">Nilai Total</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Tgl Seleksi</th>
                <th class="text-center">Tgl Hasil</th>
              <?php } else if ($id_role == 3) { ?>
                <th class="text-center">Jenis Kelamin</th>
                <th class="text-center">Tgl Lahir</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Email</th>
                <th class="text-center">No. Telp</th>
                <th class="text-center">Asal Sekolah</th>
              <?php } ?>
            </tr>
          </tfoot>
          <tbody>
            <?php foreach ($views_hasil_seleksiAdmin as $data) { ?>
              <tr>
                <td><?= $data['status_lulus'] ?></td>
                <td><?= $data['nama_lengkap'] ?></td>
                <?php if ($id_role == 1) { ?>
                  <td><?= $data['nilai_ujian'] ?></td>
                  <td><?= $data['nilai_rapor'] ?></td>
                  <td><?= $data['nilai_total'] ?></td>
                  <td>
                    <p><?= $data['keterangan'] ?></p>
                  </td>
                  <td><?php $tanggal_seleksi = date_create($data["tanggal_seleksi"]);
                      echo date_format($tanggal_seleksi, "d M Y"); ?></td>
                  <td><?php if ($data["tanggal_hasil"] !== NULL) {
                        $tanggal_hasil = date_create($data["tanggal_hasil"]);
                        echo date_format($tanggal_hasil, "d M Y");
                      } ?></td>
                  <td class="text-center">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formulir<?= $data['id_pendaftaran'] ?>">
                      <i class="bi bi-eye"></i> Berkas
                    </button>
                    <div class="modal fade" id="formulir<?= $data['id_pendaftaran'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header border-bottom-0 shadow">
                            <h5 class="modal-title" id="exampleModalLabel">Formulir <?= $data['nama_lengkap'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <embed src="<?= $baseURL ?>assets/files/pendaftaran/<?= $data['formulir'] ?>" type="application/pdf" width="100%" height="600px">
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php if (empty($data['nilai_ujian'])) { ?>
                      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#ubah<?= $data['id_pendaftaran'] ?>">
                        <i class="bi bi-check-all"></i> Seleksi
                      </button>
                    <?php } ?>
                    <div class="modal fade" id="ubah<?= $data['id_pendaftaran'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header border-bottom-0 shadow">
                            <h5 class="modal-title" id="exampleModalLabel"><?= $data['nama_lengkap'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="" method="post">
                            <input type="hidden" name="id_hasil_seleksi" value="<?= $data['id_hasil_seleksi'] ?>">
                            <input type="hidden" name="nama_lengkap" value="<?= $data['nama_lengkap'] ?>">
                            <input type="hidden" name="email" value="<?= $data['email'] ?>">
                            <input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">
                            <div class="modal-body">
                              <div class="form-group">
                                <label for="nilai_ujian">Nilai Ujian</label>
                                <input type="number" name="nilai_ujian" value="<?= $data['nilai_ujian'] ?>" class="form-control" id="nilai_ujian" max="100" required>
                              </div>
                              <div class="form-group">
                                <label for="nilai_rapor">Nilai Rapor</label>
                                <input type="number" name="nilai_rapor" value="<?= $data['nilai_rapor'] ?>" class="form-control" id="nilai_rapor" max="100" required>
                              </div>
                              <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" class="form-control" id="keterangan" rows="3"><?= $data['keterangan'] ?></textarea>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-center border-top-0">
                              <button type="submit" name="hasil_seleksi" class="btn btn-primary btn-sm">Seleksi</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </td>
                <?php } else if ($id_role == 2) { ?>
                  <td><?= $data['nilai_ujian'] ?></td>
                  <td><?= $data['nilai_rapor'] ?></td>
                  <td><?= $data['nilai_total'] ?></td>
                  <td>
                    <p><?= $data['keterangan'] ?></p>
                  </td>
                  <td><?php $tanggal_seleksi = date_create($data["tanggal_seleksi"]);
                      echo date_format($tanggal_seleksi, "d M Y"); ?></td>
                <?php } else if ($id_role == 3) { ?>
                  <td><?= $data['jenis_kelamin'] ?></td>
                  <td><?= $data['tanggal_lahir'] ?></td>
                  <td><?= $data['alamat'] ?></td>
                  <td><?= $data['email'] ?></td>
                  <td><?= $data['nomor_telepon'] ?></td>
                  <td><?= $data['asal_sekolah'] ?></td>
                <?php } ?>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>