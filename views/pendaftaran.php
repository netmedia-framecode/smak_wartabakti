<?php require_once("../controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Pendaftaran";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_smak_wartabakti"]["name_page"] ?></h1>
  </div>

  <div class="card shadow mb-4 border-0">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
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
              <th class="text-center">Aksi</th>
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
              <th class="text-center">Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php foreach ($views_pendaftaran as $data) { ?>
              <tr>
                <td><?= $data['status_pendaftaran'] ?></td>
                <td><?= $data['nama_lengkap'] ?></td>
                <td><?= $data['jenis_kelamin'] ?></td>
                <td><?= $data['tanggal_lahir'] ?></td>
                <td><?= $data['alamat'] ?></td>
                <td><?= $data['email'] ?></td>
                <td><?= $data['nomor_telepon'] ?></td>
                <td><?= $data['asal_sekolah'] ?></td>
                <td class="text-center">
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formulir<?= $data['id_pendaftaran'] ?>">
                    <i class="bi bi-eye"></i> Berkas
                  </button>
                  <?php if ($id_role == 1) {
                    if ($data['status_pendaftaran'] == "Belum Diverifikasi" || $data['status_pendaftaran'] == "Belum Terverifikasi") { ?>
                      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#ubah<?= $data['id_pendaftaran'] ?>">
                        <i class="bi bi-check-all"></i> Verifikasi
                      </button>
                    <?php }
                    if ($data['status_pendaftaran'] == "Belum Diverifikasi") { ?>
                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#tambah<?= $data['id_pendaftaran'] ?>">
                        <i class="bi bi-x-lg"></i> Verifikasi
                      </button>
                  <?php }
                  } ?>

                  <div class="modal fade" id="formulir<?= $data['id_pendaftaran'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Formulir <?= $data['nama_lengkap'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="id_pendaftaran" value="<?= $data['id_pendaftaran'] ?>">
                          <input type="hidden" name="formulirOld" value="<?= $data['formulir'] ?>">
                          <div class="modal-body">
                            <embed src="<?= $baseURL ?>assets/files/pendaftaran/<?= $data['formulir'] ?>" type="application/pdf" width="100%" height="600px">
                            <?php if ($id_role == 3) { ?>
                              <div class="form-group mt-3">
                                <label for="formulir" class="form-label">Unggah Data Formulir</label>
                                <input type="file" class="form-control" name="formulir" accept=".pdf" id="formulir" required>
                                <small class="form-text text-muted">
                                  Hanya file PDF yang diperbolehkan. Berkas yang dapat diunggah meliputi formulir, transkrip nilai, ijasah SMP, dan akte kelahiran.
                                </small>
                              </div>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="submit" name="edit_pendaftaran" class="btn btn-primary btn-sm">Upload</button>
                          <?php } ?>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

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
                          <input type="hidden" name="id_pendaftaran" value="<?= $data['id_pendaftaran'] ?>">
                          <input type="hidden" name="nama_lengkap" value="<?= $data['nama_lengkap'] ?>">
                          <input type="hidden" name="email" value="<?= $data['email'] ?>">
                          <input type="hidden" name="password" value="<?= $data['password'] ?>">
                          <div class="modal-body">
                            <p>Jika data calon peserta didik baru telah sesuai silakan klik <strong>Verifikasi</strong> untuk masuk ke tahap seleksi.</p>
                            <div class="form-group">
                              <label for="tanggal_seleksi">Tanggal Seleksi</label>
                              <input type="date" name="tanggal_seleksi" class="form-control" id="tanggal_seleksi" required>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="submit" name="pendaftaran_verifikasi" class="btn btn-primary btn-sm">Verifikasi</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <div class="modal fade" id="tambah<?= $data['id_pendaftaran'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel"><?= $data['nama_lengkap'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_pendaftaran" value="<?= $data['id_pendaftaran'] ?>">
                          <input type="hidden" name="nama_lengkap" value="<?= $data['nama_lengkap'] ?>">
                          <input type="hidden" name="email" value="<?= $data['email'] ?>">
                          <div class="modal-body">
                            <p>Jika data calon peserta didik baru tidak sesuai silakan klik <strong>Belum Terverifikasi</strong>.</p>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="submit" name="pendaftaran_belum_verifikasi" class="btn btn-danger btn-sm">Belum Terverifikasi</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                </td>
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