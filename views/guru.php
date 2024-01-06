<?php require_once("../controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Guru";
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
              <th class="text-center">Nama Lengkap</th>
              <th class="text-center">NIK</th>
              <th class="text-center">Jenis Kelamin</th>
              <th class="text-center">Tempat Lahir</th>
              <th class="text-center">Tanggal Lahir</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th class="text-center">Nama Lengkap</th>
              <th class="text-center">NIK</th>
              <th class="text-center">Jenis Kelamin</th>
              <th class="text-center">Tempat Lahir</th>
              <th class="text-center">Tanggal Lahir</th>
              <th class="text-center">Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php foreach ($views_guru as $data) { ?>
              <tr>
                <td><?= $data['nama_lengkap'] ?></td>
                <td><?= $data['nik'] ?></td>
                <td><?= $data['jk'] ?></td>
                <td><?= $data['tempat_lahir'] ?></td>
                <td><?= $data['tgl_lahir'] ?></td>
                <td class="text-center">
                  <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubah<?= $data['id_guru'] ?>">
                    <i class="bi bi-pencil-square"></i> Ubah
                  </button>
                  <div class="modal fade" id="ubah<?= $data['id_guru'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $data['nama_lengkap'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_guru" value="<?= $data['id_guru'] ?>">
                          <input type="hidden" name="img_guruOld" value="<?= $data['img_guru'] ?>">
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="img">Unggah Gambar</label>
                              <input type="file" name="img" class="form-control" id="img">
                            </div>
                            <div class="form-group">
                              <label for="nama_lengkap">Nama Lengkap</label>
                              <input type="text" name="nama_lengkap" value="<?= $data['nama_lengkap'] ?>" class="form-control" id="nama_lengkap" required>
                            </div>
                            <div class="form-group">
                              <label for="nik">NIK</label>
                              <input type="number" name="nik" value="<?= $data['nik'] ?>" class="form-control" id="nik" required>
                            </div>
                            <div class="form-group">
                              <label for="jk">Jenis Kelamin</label>
                              <select name="jk" class="form-control" aria-label="Default select example">
                                <option value="" selected>Pilih Jenis Kelamin</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="tempat_lahir">Tempat Lahir</label>
                              <input type="text" name="tempat_lahir" value="<?= $data['tempat_lahir'] ?>" class="form-control" id="tempat_lahir" required>
                            </div>
                            <div class="form-group">
                              <label for="tgl_lahir">Tgl Lahir</label>
                              <input type="date" name="tgl_lahir" value="<?= $data['tgl_lahir'] ?>" class="form-control" id="tgl_lahir" required>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="edit_guru" class="btn btn-warning btn-sm">Ubah</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus<?= $data['id_guru'] ?>">
                    <i class="bi bi-trash3"></i> Hapus
                  </button>
                  <div class="modal fade" id="hapus<?= $data['id_guru'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $data['nama_lengkap'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_guru" value="<?= $data['id_guru'] ?>">
                          <input type="hidden" name="img_guru" value="<?= $data['img_guru'] ?>">
                          <div class="modal-body">
                            <p>Jika anda yakin ingin menghapus data ini klik Hapus!</p>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="delete_guru" class="btn btn-danger btn-sm">hapus</button>
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
          <h5 class="modal-title" id="tambahLabel">Tambah Guru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label for="img">Unggah Gambar</label>
              <input type="file" name="img" class="form-control" id="img" required>
            </div>
            <div class="form-group">
              <label for="nama_lengkap">Nama Lengkap</label>
              <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" required>
            </div>
            <div class="form-group">
              <label for="nik">NIK</label>
              <input type="number" name="nik" class="form-control" id="nik" required>
            </div>
            <div class="form-group">
              <label for="jk">Jenis Kelamin</label>
              <select name="jk" class="form-control" aria-label="Default select example">
                <option value="" selected>Pilih Jenis Kelamin</option>
                <option value="Laki-Laki">Laki-Laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>
            <div class="form-group">
              <label for="tempat_lahir">Tempat Lahir</label>
              <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir" required>
            </div>
            <div class="form-group">
              <label for="tgl_lahir">Tgl Lahir</label>
              <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir" required>
            </div>
          </div>
          <div class="modal-footer justify-content-center border-top-0">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
            <button type="submit" name="add_guru" class="btn btn-primary btn-sm">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>