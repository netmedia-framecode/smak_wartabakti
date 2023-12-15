<?php require_once("../controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "List Berita";
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
              <th class="text-center">Author</th>
              <th class="text-center">Judul</th>
              <th class="text-center">Kategori</th>
              <th class="text-center">Isi Berita</th>
              <th class="text-center">Tgl Publikasi</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th class="text-center">Author</th>
              <th class="text-center">Judul</th>
              <th class="text-center">Kategori</th>
              <th class="text-center">Isi Berita</th>
              <th class="text-center">Tgl Publikasi</th>
              <th class="text-center">Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php foreach ($views_berita_primary as $data) { ?>
              <tr>
                <td><?= $data['name'] ?></td>
                <td class="text-center">
                  <img src="<?= $baseURL ?>assets/img/berita/<?= $data['img_berita'] ?>" class="rounded-circle" style="cursor: pointer; width: 100px; height: 100px; object-fit: cover;" alt="" data-toggle="modal" data-target="#img_berita<?= $data['id_berita'] ?>">
                  <div class="modal fade" id="img_berita<?= $data['id_berita'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel"><?= $data['judul_berita'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <img src="<?= $baseURL ?>assets/img/berita/<?= $data['img_berita'] ?>" style="width: 100%; height: 500px; object-fit: cover;" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                  <?= $data['judul_berita'] ?>
                </td>
                <td><?= $data['nama_kategori'] ?></td>
                <td>
                  <p><?= $data['isi_berita'] ?></p>
                </td>
                <td><?php $tanggal_publikasi = date_create($data["tanggal_publikasi"]);
                    echo date_format($tanggal_publikasi, "d M Y"); ?></td>
                <td class="text-center">
                  <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubah<?= $data['id_berita'] ?>">
                    <i class="bi bi-pencil-square"></i> Ubah
                  </button>
                  <div class="modal fade" id="ubah<?= $data['id_berita'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $data['judul_berita'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="id_berita" value="<?= $data['id_berita'] ?>">
                          <input type="hidden" name="img_beritaOld" value="<?= $data['img_berita'] ?>">
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="img_berita">Unggah Gambar</label>
                              <div class="custom-file">
                                <input type="file" name="img_berita" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Unggah Gambar</label>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="judul_berita">Judul Berita</label>
                              <input type="text" name="judul_berita" value="<?= $data['judul_berita'] ?>" class="form-control" id="judul_berita" minlength="3" required>
                            </div>
                            <div class="form-group">
                              <label for="isi_berita">Judul Berita</label>
                              <textarea name="isi_berita" class="form-control" id="deskripsi<?= $data['id_berita'] ?>" rows="3" required><?= $data['isi_berita'] ?></textarea>
                              <script>
                                CKEDITOR.replace('deskripsi<?= $data['id_berita'] ?>');
                              </script>
                            </div>
                            <div class="form-group">
                              <label for="id_kategori">Kategori Berita</label>
                              <select name="id_kategori" class="form-control" id="id_kategori" required>
                                <option value="" selected>Pilih Kategori</option>
                                <?php $id_kategori = $data['id_kategori'];
                                foreach ($views_kategori_berita as $data_kategori) {
                                  $selected = ($data_kategori['id_kategori'] == $id_kategori) ? 'selected' : ''; ?>
                                  <option value="<?= $data_kategori['id_kategori'] ?>" <?= $selected ?>><?= $data_kategori['nama_kategori'] ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="edit_berita" class="btn btn-warning btn-sm">Ubah</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus<?= $data['id_berita'] ?>">
                    <i class="bi bi-trash3"></i> Hapus
                  </button>
                  <div class="modal fade" id="hapus<?= $data['id_berita'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $data['judul_berita'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_berita" value="<?= $data['id_berita'] ?>">
                          <input type="hidden" name="img_berita" value="<?= $data['img_berita'] ?>">
                          <div class="modal-body">
                            <p>Jika anda yakin ingin menghapus <?= $data['judul_berita'] ?>, klik Hapus!</p>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="delete_berita" class="btn btn-danger btn-sm">hapus</button>
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
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header border-bottom-0 shadow">
          <h5 class="modal-title" id="tambahLabel">Tambah Berita</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label for="img_berita">Unggah Gambar</label>
              <div class="custom-file">
                <input type="file" name="img_berita" class="custom-file-input" id="customFile">
                <label class="custom-file-label" for="customFile">Unggah Gambar</label>
              </div>
            </div>
            <div class="form-group">
              <label for="judul_berita">Judul Berita</label>
              <input type="text" name="judul_berita" class="form-control" id="judul_berita" minlength="3" required>
            </div>
            <div class="form-group">
              <label for="isi_berita">Judul Berita</label>
              <textarea name="isi_berita" class="form-control" id="deskripsi" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="id_kategori">Kategori Berita</label>
              <select name="id_kategori" class="form-control" id="id_kategori" required>
                <option value="" selected>Pilih Kategori</option>
                <?php foreach ($views_kategori_berita as $data) : ?>
                  <option value="<?= $data['id_kategori'] ?>"><?= $data['nama_kategori'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-center border-top-0">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
            <button type="submit" name="add_berita" class="btn btn-primary btn-sm">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>