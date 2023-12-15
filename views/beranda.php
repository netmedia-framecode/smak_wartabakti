<?php require_once("../controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Beranda";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_smak_wartabakti"]["name_page"] ?></h1>
  </div>

  <div class="accordion shadow" id="accordionExample">
    <div class="card">
      <div class="card-header shadow" id="headingOne">
        <h2 class="mb-0">
          <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#section_header" aria-expanded="true" aria-controls="section_header">
            Section Header
          </button>
        </h2>
      </div>

      <div id="section_header" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
        <div class="card-body text-dark">
          <form action="" method="post">
            <?php foreach ($views_header as $data) : ?>
              <h2><input type="text" name="nama" value="<?= $data['nama'] ?>" class="border-0 w-100" required></h2>
              <p><input type="text" name="deskripsi" value="<?= $data['deskripsi'] ?>" class="border-0 w-100" required></p>
            <?php endforeach; ?>
            <button type="submit" name="edit_section_header" class="btn btn-warning mt-3">Ubah</button>
          </form>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header shadow" id="headingTwo">
        <div class="d-flex justify-content-between">
          <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#section_carousel" aria-expanded="false" aria-controls="section_carousel">
              Section Carousel
            </button>
          </h2>
          <div>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambah_carousel"><i class="bi bi-plus-lg"></i> Tambah</a>
            <div class="modal fade" id="tambah_carousel" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header border-bottom-0 shadow">
                    <h5 class="modal-title" id="tambahLabel">Tambah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="form-control" id="nama" required>
                      </div>
                      <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" id="deskripsi" rows="3"></textarea>
                      </div>
                      <div class="form-group">
                        <label for="icon">Icon</label>
                        <div class="custom-file">
                          <input type="file" name="icon" class="custom-file-input" id="icon" required>
                          <label class="custom-file-label" for="icon">Unggah File Icon</label>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer justify-content-center border-top-0">
                      <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                      <button type="submit" name="add_section_carousel" class="btn btn-primary btn-sm">Tambah</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="section_carousel" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered text-dark" id="dataTable1" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th class="text-center">Nama</th>
                  <th class="text-center">Deskripsi</th>
                  <th class="text-center">Icon</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th class="text-center">Nama</th>
                  <th class="text-center">Deskripsi</th>
                  <th class="text-center">Icon</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </tfoot>
              <tbody>
                <?php foreach ($views_carousel as $data) : ?>
                  <tr>
                    <td><?= $data['nama'] ?></td>
                    <td>
                      <p><?= $data['deskripsi'] ?></p>
                    </td>
                    <td><?= $data['icon'] ?></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubah_carousel<?= $data['id_carousel'] ?>">
                        <i class="bi bi-pencil-square"></i> Ubah
                      </button>
                      <div class="modal fade" id="ubah_carousel<?= $data['id_carousel'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header border-bottom-0 shadow">
                              <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $data['nama'] ?></h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action="" method="post" enctype="multipart/form-data">
                              <input type="hidden" name="id_carousel" value="<?= $data['id_carousel'] ?>">
                              <input type="hidden" name="iconOld" value="<?= $data['icon'] ?>">
                              <div class="modal-body">
                                <div class="form-group">
                                  <label for="nama">Nama</label>
                                  <input type="text" name="nama" value="<?= $data['nama'] ?>" class="form-control" id="nama" required>
                                </div>
                                <div class="form-group">
                                  <label for="deskripsi">Deskripsi</label>
                                  <textarea name="deskripsi" class="form-control" id="deskripsi" rows="3"><?= $data['deskripsi'] ?></textarea>
                                </div>
                                <div class="form-group">
                                  <label for="icon">Icon</label>
                                  <div class="custom-file">
                                    <input type="file" name="icon" class="custom-file-input" id="icon">
                                    <label class="custom-file-label" for="icon">Unggah File Icon</label>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer justify-content-center border-top-0">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                <button type="submit" name="edit_section_carousel" class="btn btn-warning btn-sm">Ubah</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus_carousel<?= $data['id_carousel'] ?>">
                        <i class="bi bi-trash3"></i> Hapus
                      </button>
                      <div class="modal fade" id="hapus_carousel<?= $data['id_carousel'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header border-bottom-0 shadow">
                              <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $data['nama'] ?></h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action="" method="post">
                              <input type="hidden" name="id_carousel" value="<?= $data['id_carousel'] ?>">
                              <input type="hidden" name="icon" value="<?= $data['icon'] ?>">
                              <div class="modal-body">
                                <p>Jika anda yakin ingin menghapus data klik Hapus!</p>
                              </div>
                              <div class="modal-footer justify-content-center border-top-0">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                <button type="submit" name="delete_section_carousel" class="btn btn-danger btn-sm">hapus</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header shadow" id="headingThree">
        <div class="d-flex justify-content-between">
          <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#section_faq" aria-expanded="false" aria-controls="section_faq">
              Section FAQ
            </button>
          </h2>
          <div>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambah_faq"><i class="bi bi-plus-lg"></i> Tambah</a>
            <div class="modal fade" id="tambah_faq" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header border-bottom-0 shadow">
                    <h5 class="modal-title" id="tambahLabel">Tambah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="" method="post">
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="pertanyaan">Pertanyaan</label>
                        <input type="text" name="pertanyaan" class="form-control" id="pertanyaan" required>
                      </div>
                      <div class="form-group">
                        <label for="jawaban">Jawaban</label>
                        <textarea name="jawaban" class="form-control" id="jawaban" rows="3"></textarea>
                      </div>
                    </div>
                    <div class="modal-footer justify-content-center border-top-0">
                      <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                      <button type="submit" name="add_section_faq" class="btn btn-primary btn-sm">Tambah</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="section_faq" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered text-dark" id="dataTable2" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th class="text-center">Pertanyaan</th>
                  <th class="text-center">Jawaban</th>
                  <th class="text-center">Tgl Buat</th>
                  <th class="text-center">Tgl Ubah</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th class="text-center">Pertanyaan</th>
                  <th class="text-center">Jawaban</th>
                  <th class="text-center">Tgl Buat</th>
                  <th class="text-center">Tgl Ubah</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </tfoot>
              <tbody>
                <?php foreach ($views_faq as $data) : ?>
                  <tr>
                    <td><?= $data['pertanyaan'] ?></td>
                    <td>
                      <p><?= $data['jawaban'] ?></p>
                    </td>
                    <td><?php $tanggal_dibuat = date_create($data["tanggal_dibuat"]);
                        echo date_format($tanggal_dibuat, "l, d M Y"); ?></td>
                    <td><?php $terakhir_diperbarui = date_create($data["terakhir_diperbarui"]);
                        echo date_format($terakhir_diperbarui, "l, d M Y"); ?></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubah_faq<?= $data['id_faq'] ?>">
                        <i class="bi bi-pencil-square"></i> Ubah
                      </button>
                      <div class="modal fade" id="ubah_faq<?= $data['id_faq'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header border-bottom-0 shadow">
                              <h5 class="modal-title" id="exampleModalLabel">Ubah</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action="" method="post">
                              <input type="hidden" name="id_faq" value="<?= $data['id_faq'] ?>">
                              <div class="modal-body">
                                <div class="form-group">
                                  <label for="pertanyaan">Pertanyaan</label>
                                  <input type="text" name="pertanyaan" value="<?= $data['pertanyaan'] ?>" class="form-control" id="pertanyaan" required>
                                </div>
                                <div class="form-group">
                                  <label for="jawaban">Jawaban</label>
                                  <textarea name="jawaban" class="form-control" id="jawaban" rows="3"><?= $data['jawaban'] ?></textarea>
                                </div>
                              </div>
                              <div class="modal-footer justify-content-center border-top-0">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                <button type="submit" name="edit_section_faq" class="btn btn-warning btn-sm">Ubah</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus_faq<?= $data['id_faq'] ?>">
                        <i class="bi bi-trash3"></i> Hapus
                      </button>
                      <div class="modal fade" id="hapus_faq<?= $data['id_faq'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header border-bottom-0 shadow">
                              <h5 class="modal-title" id="exampleModalLabel">Hapus</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action="" method="post">
                              <input type="hidden" name="id_faq" value="<?= $data['id_faq'] ?>">
                              <div class="modal-body">
                                <p>Jika anda yakin ingin menghapus data <?= $data['pertanyaan'] ?>, klik Hapus!</p>
                              </div>
                              <div class="modal-footer justify-content-center border-top-0">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                <button type="submit" name="delete_section_faq" class="btn btn-danger btn-sm">hapus</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header shadow" id="headingThree">
        <h2 class="mb-0">
          <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#section_kontak" aria-expanded="false" aria-controls="section_kontak">
            Section Kontak
          </button>
        </h2>
      </div>
      <div id="section_kontak" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered text-dark" id="dataTable3" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th class="text-center">Tgl</th>
                  <th class="text-center">Nama</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Subject</th>
                  <th class="text-center">Pesan</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th class="text-center">Tgl</th>
                  <th class="text-center">Nama</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Subject</th>
                  <th class="text-center">Pesan</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </tfoot>
              <tbody>
                <?php foreach ($views_kontak as $data) : ?>
                  <tr>
                    <td class="text-center"><?php $tanggal = date_create($data["tanggal"]);
                                            echo date_format($tanggal, "d M Y"); ?></td>
                    <td><?= $data['nama'] ?></td>
                    <td><a href="mailto:<?= $data['email'] ?>" target="_blank"><?= $data['email'] ?></a></td>
                    <td><?= $data['subject'] ?></td>
                    <td>
                      <p><?= $data['pesan'] ?></p>
                    </td>
                    <td class="text-center">
                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus_kontak<?= $data['id_kontak'] ?>">
                        <i class="bi bi-trash3"></i> Hapus
                      </button>
                      <div class="modal fade" id="hapus_kontak<?= $data['id_kontak'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header border-bottom-0 shadow">
                              <h5 class="modal-title" id="exampleModalLabel">Hapus</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action="" method="post">
                              <input type="hidden" name="id_kontak" value="<?= $data['id_kontak'] ?>">
                              <div class="modal-body">
                                <p>Jika anda yakin ingin menghapus data kontak dari <?= $data['nama'] ?>, klik Hapus!</p>
                              </div>
                              <div class="modal-footer justify-content-center border-top-0">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                <button type="submit" name="delete_section_kontak" class="btn btn-danger btn-sm">hapus</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>