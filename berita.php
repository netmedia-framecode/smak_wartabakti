<?php require_once("controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Berita";
require_once("templates/top.php"); ?>

<section class="heading-page header-text" id="top">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h6>SMAS K Warta Bakti</h6>
        <h2>Berita</h2>
      </div>
    </div>
  </div>
</section>

<?php if (mysqli_num_rows($views_berita_page) > 0) { ?>
  <section class="upcoming-meetings" id="meetings" style="margin-bottom: -300px;">
    <style>
      /* Gaya awal untuk resolusi laptop */
      .berita-top {
        margin-top: -100px;
      }

      /* Media query untuk resolusi HP */
      @media screen and (max-width: 1200px) {
        .berita-top {
          margin-top: -100px;
        }
      }

      @media screen and (max-width: 991px) {
        .berita-top {
          margin-top: -200px;
        }
      }

      @media screen and (max-width: 767px) {
        .berita-top {
          margin-top: -300px;
        }
      }
    </style>
    <div class="container berita-top">
      <div class="row flex-row-reverse">
        <div class="col-lg-8">
          <div class="row">
            <?php if (!isset($_GET['judul'])) {
              if (!isset($_GET['kategori'])) {
                while ($data = mysqli_fetch_assoc($views_berita_page)) { ?>
                  <div class="col-lg-6">
                    <div class="meeting-item">
                      <div class="thumb">
                        <a href="berita?judul=<?= $data['slug'] ?>"><img class="rounded-0" src="<?= $baseURL ?>assets/img/berita/<?= $data['img_berita'] ?>" alt="<?= $data['judul_berita'] ?>"></a>
                      </div>
                      <div class="down-content rounded-0">
                        <div class="row">
                          <div class="col-lg-2">
                            <div class="date">
                              <h6><?php $tanggal_publikasi  = date_create($data['tanggal_publikasi']);
                                  echo date_format($tanggal_publikasi, 'M') . "<span>" . date_format($tanggal_publikasi, 'd') . "</span>"; ?></h6>
                            </div>
                          </div>
                          <div class="col-lg-10">
                            <a href="berita?judul=<?= $data['slug'] ?>">
                              <h4><?= $data['judul_berita'] ?></h4>
                            </a>
                          </div>
                        </div>
                        <p><?php $num_char = 75;
                            $text = trim($data['isi_berita']);
                            $text = preg_replace('#</?strong.*?>#is', '', $text);
                            $lentext = strlen($text);
                            if ($lentext > $num_char) {
                              echo substr($text, 0, $num_char) . '...';
                            } else if ($lentext <= $num_char) {
                              echo substr($text, 0, $num_char);
                            } ?></p>
                      </div>
                    </div>
                  </div>
                  <?php }
              } else {
                if (empty($_GET['kategori'])) {
                  while ($data = mysqli_fetch_assoc($views_berita_page)) { ?>
                    <div class="col-lg-6">
                      <div class="meeting-item">
                        <div class="thumb">
                          <a href="berita?judul=<?= $data['slug'] ?>"><img class="rounded-0" src="<?= $baseURL ?>assets/img/berita/<?= $data['img_berita'] ?>" alt="<?= $data['judul_berita'] ?>"></a>
                        </div>
                        <div class="down-content rounded-0">
                          <div class="row">
                            <div class="col-lg-2">
                              <div class="date">
                                <h6><?php $tanggal_publikasi  = date_create($data['tanggal_publikasi']);
                                    echo date_format($tanggal_publikasi, 'M') . "<span>" . date_format($tanggal_publikasi, 'd') . "</span>"; ?></h6>
                              </div>
                            </div>
                            <div class="col-lg-10">
                              <a href="berita?judul=<?= $data['slug'] ?>">
                                <h4><?= $data['judul_berita'] ?></h4>
                              </a>
                            </div>
                          </div>
                          <p><?php $num_char = 75;
                              $text = trim($data['isi_berita']);
                              $text = preg_replace('#</?strong.*?>#is', '', $text);
                              $lentext = strlen($text);
                              if ($lentext > $num_char) {
                                echo substr($text, 0, $num_char) . '...';
                              } else if ($lentext <= $num_char) {
                                echo substr($text, 0, $num_char);
                              } ?></p>
                        </div>
                      </div>
                    </div>
                  <?php }
                } else {
                  $slug = valid($conn, $_GET['kategori']);
                  $select_kategori_berita_detail = "SELECT berita.*, kategori_berita.nama_kategori FROM berita JOIN kategori_berita ON berita.id_kategori=kategori_berita.id_kategori WHERE kategori_berita.slug='$slug'";
                  $views_kategori_berita_detail = mysqli_query($conn, $select_kategori_berita_detail); ?>
                  <h4 class="text-white">Kategori: <?= $data['nama_kategori'] ?></h4>
                  <hr>
                  <?php foreach ($views_kategori_berita_detail as $data) { ?>
                    <div class="col-lg-6">
                      <div class="meeting-item">
                        <div class="thumb">
                          <a href="berita?judul=<?= $data['slug'] ?>"><img class="rounded-0" src="<?= $baseURL ?>assets/img/berita/<?= $data['img_berita'] ?>" alt="<?= $data['judul_berita'] ?>"></a>
                        </div>
                        <div class="down-content rounded-0">
                          <div class="row">
                            <div class="col-lg-2">
                              <div class="date">
                                <h6><?php $tanggal_publikasi  = date_create($data['tanggal_publikasi']);
                                    echo date_format($tanggal_publikasi, 'M') . "<span>" . date_format($tanggal_publikasi, 'd') . "</span>"; ?></h6>
                              </div>
                            </div>
                            <div class="col-lg-10">
                              <a href="berita?judul=<?= $data['slug'] ?>">
                                <h4><?= $data['judul_berita'] ?></h4>
                              </a>
                            </div>
                          </div>
                          <p><?php $num_char = 75;
                              $text = trim($data['isi_berita']);
                              $text = preg_replace('#</?strong.*?>#is', '', $text);
                              $lentext = strlen($text);
                              if ($lentext > $num_char) {
                                echo substr($text, 0, $num_char) . '...';
                              } else if ($lentext <= $num_char) {
                                echo substr($text, 0, $num_char);
                              } ?></p>
                        </div>
                      </div>
                    </div>
                  <?php }
                }
              }
            } else {
              if (empty($_GET['judul'])) {
                while ($data = mysqli_fetch_assoc($views_berita_page)) { ?>
                  <div class="col-lg-6">
                    <div class="meeting-item">
                      <div class="thumb">
                        <a href="berita?judul=<?= $data['slug'] ?>"><img class="rounded-0" src="<?= $baseURL ?>assets/img/berita/<?= $data['img_berita'] ?>" alt="<?= $data['judul_berita'] ?>"></a>
                      </div>
                      <div class="down-content rounded-0">
                        <div class="row">
                          <div class="col-lg-2">
                            <div class="date">
                              <h6><?php $tanggal_publikasi  = date_create($data['tanggal_publikasi']);
                                  echo date_format($tanggal_publikasi, 'M') . "<span>" . date_format($tanggal_publikasi, 'd') . "</span>"; ?></h6>
                            </div>
                          </div>
                          <div class="col-lg-10">
                            <a href="berita?judul=<?= $data['slug'] ?>">
                              <h4><?= $data['judul_berita'] ?></h4>
                            </a>
                          </div>
                        </div>
                        <p><?php $num_char = 75;
                            $text = trim($data['isi_berita']);
                            $text = preg_replace('#</?strong.*?>#is', '', $text);
                            $lentext = strlen($text);
                            if ($lentext > $num_char) {
                              echo substr($text, 0, $num_char) . '...';
                            } else if ($lentext <= $num_char) {
                              echo substr($text, 0, $num_char);
                            } ?></p>
                      </div>
                    </div>
                  </div>
                <?php }
              } else {
                $slug = valid($conn, $_GET['judul']);
                $select_berita_detail = "SELECT * FROM berita JOIN kategori_berita ON berita.id_kategori=kategori_berita.id_kategori JOIN users ON berita.id_user=users.id_user WHERE berita.slug='$slug'";
                $views_berita_detail = mysqli_query($conn, $select_berita_detail);
                foreach ($views_berita_detail as $data) { ?>
                  <div class="col-lg-12">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="meeting-single-item ">
                          <div class="thumb">
                            <div class="price">
                              <span><?= $data['nama_kategori'] ?></span>
                            </div>
                            <div class="date">
                              <h6><?php $tanggal_publikasi  = date_create($data['tanggal_publikasi']);
                                  echo date_format($tanggal_publikasi, 'M') . "<span>" . date_format($tanggal_publikasi, 'd') . "</span>"; ?></h6>
                            </div>
                            <a href="berita?judul=<?= $data['slug'] ?>"><img class="rounded-0" src="<?= $baseURL ?>assets/img/berita/<?= $data['img_berita'] ?>" alt="<?= $data['judul_berita'] ?>"></a>
                          </div>
                          <div class="down-content rounded-0">
                            <a href="berita?judul=<?= $data['slug'] ?>">
                              <h4><?= $data['judul_berita'] ?></h4>
                            </a>
                            <p class="mb-4"><?php $tanggal_publikasi  = date_create($data['tanggal_publikasi']);
                                            echo date_format($tanggal_publikasi, 'l d M Y h:i') . " | author " . $data['name']; ?></p>
                            <?= $data['isi_berita'] ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
            <?php }
              }
            } ?>
          </div>
          <section class="contact-us" id="contact" style="margin-top: -100px;">
            <?php if (isset($_GET['judul'])) {
              if (!empty($_GET['judul'])) { ?>
                <div class="container p-0">
                  <div class="row">
                    <div class="col-lg-12 align-self-center">
                      <form id="contact" class="rounded-0" action="" method="post">
                        <?php $slug = valid($conn, $_GET['judul']);
                        $select_komentar_input = "SELECT * FROM berita WHERE berita.slug='$slug'";
                        $views_komentar_input = mysqli_query($conn, $select_komentar_input);
                        foreach ($views_komentar_input as $data) { ?>
                          <input type="hidden" name="id_berita" value="<?= $data['id_berita']; ?>">
                          <input type="hidden" name="slug" value="<?= $data['slug']; ?>">
                        <?php } ?>
                        <div class="row">
                          <div class="col-lg-12">
                            <h2>Komentar</h2>
                          </div>
                          <div class="col-lg-6">
                            <fieldset>
                              <input name="nama_komentar" type="text" id="nama_komentar" placeholder="Nama" required>
                            </fieldset>
                          </div>
                          <div class="col-lg-6">
                            <fieldset>
                              <input name="email_komentar" type="email" id="email_komentar" placeholder="Email" required>
                            </fieldset>
                          </div>
                          <div class="col-lg-12">
                            <fieldset>
                              <textarea name="isi_komentar" type="text" class="form-control" id="isi_komentar" placeholder="Komentar kamu" required></textarea>
                            </fieldset>
                          </div>
                          <div class="col-lg-12">
                            <fieldset>
                              <button type="submit" name="komentar" class="button">Kirim</button>
                            </fieldset>
                          </div>
                        </div>
                        <hr>
                        <div class="isi-komentar mt-5">
                          <?php $slug = valid($conn, $_GET['judul']);
                          $select_komentar = "SELECT * FROM komentar JOIN berita ON komentar.id_berita=berita.id_berita WHERE berita.slug='$slug'";
                          $views_komentar = mysqli_query($conn, $select_komentar);
                          foreach ($views_komentar as $data) { ?>
                            <div class="row">
                              <div class="col-lg-2">
                                <img src="<?= $baseURL ?>assets/img/profil/default.svg" style="width: 75px;" alt="">
                              </div>
                              <div class="col-lg-10">
                                <h5><?= $data['nama_komentar'] ?></h5>
                                <small><?= $data['email_komentar'] ?></small>
                                <p class="mt-3"><?= $data['isi_komentar'] ?></p>
                                <footer class="blockquote-footer mt-3"><?php $tanggal_komentar  = date_create($data['tanggal_komentar']);
                                                                        echo date_format($tanggal_komentar, 'l d M Y h:i'); ?></footer>
                              </div>
                            </div>
                          <?php } ?>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
            <?php }
            } ?>
          </section>
        </div>
        <div class="col-lg-4">
          <div class="categories rounded-0">
            <h4>Kategori</h4>
            <ul>
              <?php foreach ($views_kategori_berita as $data) : ?>
                <li><a href="berita?kategori=<?= $data['slug'] ?>"><?= $data['nama_kategori'] ?></a></li><br>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php foreach ($views_iklan as $data) : ?>
            <div class="categories mt-3 mb-3 p-0">
              <a href="<?= $data['tautan'] ?>" target="_blank"><img src="<?= $baseURL ?>assets/img/iklan/<?= $data['image'] ?>" alt="<?= $data['judul_iklan'] ?>" style="width: 100%;height: 100%; object-fit: cover;"></a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>
<?php } ?>

<section class="contact-us" id="contact">

  <?php require_once("templates/bottom.php"); ?>