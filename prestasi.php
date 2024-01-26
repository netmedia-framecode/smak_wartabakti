<?php require_once("controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Prestasi";
require_once("templates/top.php"); ?>

<section class="heading-page header-text" id="top">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h6>SMAS K Warta Bakti</h6>
        <h2>Prestasi</h2>
      </div>
    </div>
  </div>
</section>

<section class="meetings-page" id="meetings">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-8">
            <div class="d-flex justify-content-between">
              <div class="col-lg-6 d-flex">
                <form action="" method="post">
                  <input type="hidden" name="kategori" value="Akademi">
                  <button type="submit" name="kategori_prestasi" class="btn btn-link">
                    <span class="badge bg-<?php if (!isset($_POST['kategori'])) {
                                            echo "primary";
                                          } else {
                                            if ($_POST['kategori'] == "Akademi") {
                                              echo "success";
                                            } else {
                                              echo "primary";
                                            }
                                          } ?>">Akademi</span>
                  </button>
                </form>
                <form action="" method="post">
                  <input type="hidden" name="kategori" value="Non Akademi">
                  <button type="submit" name="kategori_prestasi" class="btn btn-link">
                    <span class="badge bg-<?php if (!isset($_POST['kategori'])) {
                                            echo "primary";
                                          } else {
                                            if ($_POST['kategori'] == "Non Akademi") {
                                              echo "success";
                                            } else {
                                              echo "primary";
                                            }
                                          } ?>">Non Akademi</span>
                  </button>
                </form>
              </div>
              <div class="col-lg-6">
                <form action="" method="post">
                  <div class="input-group mb-3">
                    <input type="text" name="keyword" class="form-control" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="submit" name="search_prestasi" id="button-addon2">Cari</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <?php if (isset($_SESSION['project_smak_wartabakti']['search_prestasi'])) {
              foreach ($views_prestasi_search as $data) : ?>
                <div class="meeting-single-item mb-3">
                  <div class="down-content rounded-0">
                    <h2><?= $data['judul'] ?></h2>
                    <img src="<?= $baseURL ?>assets/img/prestasi/<?= $data['image'] ?>" style="width: 80%;" alt="">
                    <p>Kategori: <?= $data['kategori'] ?></p>
                    <?= $data['deskripsi'] ?>
                  </div>
                </div>
              <?php endforeach;
            } else {
              foreach ($views_prestasi as $data) : ?>
                <div class="meeting-single-item mb-3">
                  <div class="down-content rounded-0">
                    <h2><?= $data['judul'] ?></h2>
                    <img src="<?= $baseURL ?>assets/img/prestasi/<?= $data['image'] ?>" style="width: 80%;" alt="">
                    <p>Kategori: <?= $data['kategori'] ?></p>
                    <?= $data['deskripsi'] ?>
                  </div>
                </div>
            <?php endforeach;
            } ?>
          </div>
          <div class="col-lg-4">
            <div class="meeting-single-item">
              <img src="<?= $baseURL ?>assets/img/romo.jpeg" alt="">
              <div class="down-content rounded-0">
                <div class="text-center">
                  <h6>RM. DJANUARIUS W. MAU KURA,PR</h6>
                  <p>- Kepala Sekolah -</p>
                </div>
                <p class="mt-3">Salam Sejahtera,</p>
                <p class="mt-3" style="text-align: justify;">Puji syukur kepada Tuhan Yang Maha Esa yang telah memberikan rahmat dan anugerahNya sehingga website SMAS Katolik Warta Bakti ini dapat terbit. Salah satu tujuan dari website ini adalah untuk menjawab akan setiap kebutuhan informasi dengan memanfaatkan sarana teknologi informasi yang ada. Kami sadar sepenuhnya dalam rangka memajukan pendidikan di era berkembangnya Teknologi Informasi yang begitu pesat, sangat diperlukan berbagai sarana prasarana yang kondusif, kebutuhan berbagai informasi siswa, guru, orangtua maupun masyarakat, sehingga kami berusaha mewujudkan hal tersebut semaksimal mungkin. Semoga dengan adanya website ini dapat membantu dan bermanfaat, terutama informasi yang berhubungan dengan pendidikan, ilmu pengetahuan dan informasi seputar SMAS Katolik Warta Bakti kefamenanu.</p>
                <p class="mt-3" style="text-align: justify;">Besar harapan kami, sarana ini dapat memberi manfaat bagi semua pihak yang ada dilingkup pendidikan dan pemerhati pendidikan secara khusus bagi SMAS Katolik Warta Bakti.</p>
                <p class="mt-3" style="text-align: justify;">Akhirnya kami mengharapkan masukan dari berbagai pihak untuk website ini agar kami terus belajar dan meng-update diri, sehingga tampilan, isi dan mutu website akan terus berkembang dan lebih baik nantinya. Terima kasih atas kerjasamanya, maju terus untuk mencapai SMAS Katolik Warta Bakti yang lebih baik lagi.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require_once("templates/bottom.php"); ?>