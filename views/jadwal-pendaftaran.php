<?php require_once("../controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Jadwal Pendaftaran";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_smak_wartabakti"]["name_page"] ?></h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambah"><i class="bi bi-plus-lg"></i> Tambah</a>
  </div>

  <div class="card shadow mb-4 border-0">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="text-center">Tgl buka</th>
              <th class="text-center">Tgl tutup</th>
              <th class="text-center">Gelombang</th>
              <th class="text-center">Kuota</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th class="text-center">Tgl buka</th>
              <th class="text-center">Tgl tutup</th>
              <th class="text-center">Gelombang</th>
              <th class="text-center">Kuota</th>
              <th class="text-center">Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php foreach ($views_jadwal_daftar as $data) { ?>
              <tr>
                <td><?= $data['tgl_buka'] ?></td>
                <td><?= $data['tgl_tutup'] ?></td>
                <td><?= $data['gelombang'] ?></td>
                <td><?= $data['kuota'] ?></td>
                <td class="text-center">
                  <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubah<?= $data['id_jd'] ?>">
                    <i class="bi bi-pencil-square"></i> Ubah
                  </button>
                  <div class="modal fade" id="ubah<?= $data['id_jd'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Ubah</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_jd" value="<?= $data['id_jd'] ?>">
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="tgl_buka">Tgl Buka</label>
                              <input type="date" name="tgl_buka" value="<?= $data['tgl_buka'] ?>" class="form-control" id="tgl_buka" required>
                            </div>
                            <div class="form-group">
                              <label for="tgl_tutup">Tgl Tutup</label>
                              <input type="date" name="tgl_tutup" value="<?= $data['tgl_tutup'] ?>" class="form-control" id="tgl_tutup" required>
                            </div>
                            <div class="form-group">
                              <label for="gelombang">Gelombang</label>
                              <input type="number" name="gelombang" value="<?= $data['gelombang'] ?>" min="1" value="1" class="form-control" id="gelombang" required>
                            </div>
                            <div class="form-group">
                              <label for="kuota">Kuota</label>
                              <input type="number" name="kuota" min="1" value="<?= $data['kuota'] ?>" class="form-control" id="kuota" required>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="edit_jadwal_daftar" class="btn btn-warning btn-sm">Ubah</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus<?= $data['id_jd'] ?>">
                    <i class="bi bi-trash3"></i> Hapus
                  </button>
                  <div class="modal fade" id="hapus<?= $data['id_jd'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Hapus</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_jd" value="<?= $data['id_jd'] ?>">
                          <div class="modal-body">
                            <p>Jika anda yakin ingin menghapus data ini, klik Hapus!</p>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="delete_jadwal_daftar" class="btn btn-danger btn-sm">hapus</button>
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

  <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header border-bottom-0 shadow">
          <h5 class="modal-title" id="tambahLabel">Tambah Jadwal Pendaftaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label for="tgl_buka">Tgl Buka</label>
              <input type="date" name="tgl_buka" class="form-control" id="tgl_buka" required>
            </div>
            <div class="form-group">
              <label for="tgl_tutup">Tgl Tutup</label>
              <input type="date" name="tgl_tutup" class="form-control" id="tgl_tutup" required>
            </div>
            <div class="form-group">
              <label for="gelombang">Gelombang</label>
              <input type="number" name="gelombang" min="1" value="1" class="form-control" id="gelombang" required>
            </div>
            <div class="form-group">
              <label for="kuota">Kuota</label>
              <input type="number" name="kuota" min="1" value="1" class="form-control" id="kuota" required>
            </div>
          </div>
          <div class="modal-footer justify-content-center border-top-0">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
            <button type="submit" name="add_jadwal_daftar" class="btn btn-primary btn-sm">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>