<?php require_once("../controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Pendaftaran";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_smak_wartabakti"]["name_page"] ?></h1>
    <?php if ($id_role <= 2) { ?>
      <a href="" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" data-toggle="modal" data-target="#export"><i class="bi bi-download"></i> Export</a>
      <div class="modal fade" id="export" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header border-bottom-0 shadow">
              <h5 class="modal-title" id="exampleModalLabel">Export Pendaftaran</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="export-pendaftaran" method="get">
              <div class="modal-body">
                <p>Pilih Gelombang berapa yang ingin di export atau bisa semuanya dengan mongkosongkan pilihan berikut:</p>
                <div class="form-group">
                  <label for="gelombang">Gelombang</label>
                  <select name="gelombang" class="form-control" id="gelombang">
                    <option value="" selected>Pilih Gelombang</option>
                    <?php foreach ($views_jadwal_daftar as $data_jd) { ?>
                      <option value="<?= $data_jd['id_jd'] ?>"><?= $data_jd['gelombang'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="modal-footer justify-content-center border-top-0">
                <button type="submit" class="btn btn-success btn-sm">Export</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Grafik</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="chart-area">
            <?php
            $currentYear = date("Y");
            $sql = "SELECT 'Pendaftaran' as category, MONTH(tanggal_pendaftaran) as month, jenis_kelamin, COUNT(*) as total FROM pendaftaran WHERE YEAR(tanggal_pendaftaran) = $currentYear AND MONTH(tanggal_pendaftaran) BETWEEN 1 AND 12 GROUP BY month, jenis_kelamin";

            $result = $conn->query($sql);
            $dataGrafik = [];

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $monthName = date("F", mktime(0, 0, 0, $row['month'], 1));
                $dataGrafik[] = [
                  'category' => $row['jenis_kelamin'], // Menggunakan jenis kelamin sebagai kategori
                  'month' => $monthName,
                  'total' => $row['total'],
                ];
              }
            }
            ?>
            <canvas id="chart-pendaftaran"></canvas>
            <script>
              var dataGrafik = <?php echo json_encode($dataGrafik); ?>;
            </script>
          </div>
        </div>
      </div>
    </div>
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