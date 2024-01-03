<?php require_once("controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Pendaftaran";
require_once("templates/top.php"); ?>

<section class="heading-page header-text" id="top">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h6>SMAS K Warta Bakti</h6>
        <h2>Pendaftaran</h2>
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
            <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="<?php if (isset($_POST['nama_lengkap'])) {
                                                                echo $_POST['nama_lengkap'];
                                                              } ?>" class="form-control" id="nama_lengkap" required>
              </div>
              <div class="form-group mt-3">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <div class="row">
                  <div class="col-lg-2">
                    <div class="form-check">
                      <input name="jenis_kelamin" value="Laki Laki" type="radio" class="form-check-input" id="laki_laki" <?php if (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] === "Laki Laki") echo "checked"; ?>>
                      <label class="form-check-label" for="laki_laki">Laki Laki</label>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-check">
                      <input name="jenis_kelamin" value="Perempuan" type="radio" class="form-check-input" id="perempuan" <?php if (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] === "Perempuan") echo "checked"; ?>>
                      <label class="form-check-label" for="perempuan">Perempuan</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group mt-3">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="<?php if (isset($_POST['tanggal_lahir'])) {
                                                                  echo $_POST['tanggal_lahir'];
                                                                } ?>" class="form-control" id="tanggal_lahir" required>
              </div>
              <div class="form-group mt-3">
                <label for="alamat">Alamat</label>
                <input type="text" name="alamat" value="<?php if (isset($_POST['alamat'])) {
                                                          echo $_POST['alamat'];
                                                        } ?>" class="form-control" id="alamat" required>
              </div>
              <div class="form-group mt-3">
                <label for="email">Email</label>
                <input type="email" name="email" value="<?php if (isset($_POST['email'])) {
                                                          echo $_POST['email'];
                                                        } ?>" class="form-control" id="email" required>
              </div>
              <div class="form-group mt-3">
                <label for="nomor_telepon">Nomor Telepon</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">+62</span>
                  </div>
                  <input type="text" name="nomor_telepon" value="<?php if (isset($_POST['nomor_telepon'])) {
                                                                    $nomor_telepon = $_POST['nomor_telepon'];
                                                                    // Hapus awalan "0" jika ada
                                                                    $nomor_telepon = ltrim($nomor_telepon, '0');
                                                                    echo $nomor_telepon;
                                                                  } ?>" class="form-control" id="nomor_telepon" pattern="[0-9]+" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <label for="asal_sekolah">Asal Sekolah</label>
                <input type="text" name="asal_sekolah" value="<?php echo isset($_POST['asal_sekolah']) ? htmlspecialchars($_POST['asal_sekolah']) : ''; ?>" class="form-control" id="asal_sekolah" required>
              </div>
              <div class="form-group mt-3">
                <label for="formulir" class="form-label">Unggah Data Formulir</label>
                <input type="file" class="form-control" name="formulir" accept=".pdf" id="formulir" required>
                <small class="form-text text-muted">
                  Hanya file PDF yang diperbolehkan. Berkas yang dapat diunggah meliputi formulir, transkrip nilai, ijasah SMP, dan akte kelahiran.
                </small>
              </div>
              <button type="submit" name="pendaftaran" class="btn btn-primary mt-3">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require_once("templates/bottom.php"); ?>