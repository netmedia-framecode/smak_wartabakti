<?php require_once("controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "";
require_once("templates/top.php"); ?>

<section class="section main-banner" id="top" data-section="section1">
  <video autoplay muted loop id="bg-video">
    <source src="assets/img/course-video.mp4" type="video/mp4" />
  </video>

  <div class="video-overlay header-text">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="caption">
            <?php foreach ($views_header as $data) : ?>
              <h2><?= $data['nama'] ?></h2>
              <p><?= $data['deskripsi'] ?></p>
            <?php endforeach; ?>
            <div class="main-button-red">
              <div class="scroll-to-section"><a href="pendaftaran">Daftar Sekarang!</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="services">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="owl-service-item owl-carousel">

          <?php foreach ($views_carousel as $data) :
            $url = strtolower(str_replace(" ", "-", $data['nama'])); ?>
            <a href="<?= $url ?>">
              <div class="item rounded-0">
                <div class="icon">
                  <img src="<?= $baseURL ?>assets/img/<?= $data['icon'] ?>" alt="">
                </div>
                <div class="down-content">
                  <h4><?= $data['nama'] ?></h4>
                  <p><?= $data['deskripsi'] ?></p>
                </div>
              </div>
            </a>
          <?php endforeach; ?>

        </div>
      </div>
    </div>
  </div>
</section>

<?php if (mysqli_num_rows($views_berita) > 0) { ?>
  <section class="upcoming-meetings" id="meetings">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading">
            <h2>Berita</h2>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="categories rounded-0">
            <h4>Kategori</h4>
            <ul>
              <?php foreach ($views_kategori_berita as $data) :  ?>
                <li><a href="berita?kategori=<?= $data['slug'] ?>"><?= $data['nama_kategori'] ?></a></li><br>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="row">
            <?php while ($data = mysqli_fetch_assoc($views_berita)) { ?>
              <div class="col-lg-6">
                <div class="meeting-item">
                  <div class="thumb">
                    <a href="berita?judul=<?= $data['slug'] ?>"><img class="rounded-0" src="<?= $baseURL ?>assets/img/berita/<?= $data['img_berita'] ?>" alt="New Lecturer Meeting"></a>
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
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php } ?>

<section class="apply-now" id="apply">
  <div class="container">
    <div class="row mt-5">
      <div class="col-lg-6 align-self-center">
        <div class="row">
          <div class="col-lg-12">
            <div class="item">
              <h3>Pendaftaran</h3>
              <p>Bagi peserta didik baru yang ingin mendaftar di SMA Swasta Katolik Warta Bakti Kefamenanu bisa langsung mendaftarkan diri dengan mengklik tombol daftar berikut</p>
              <div class="main-button-red">
                <div><a href="pendaftaran">Daftar</a></div>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="item">
              <h3>Pengumuman</h3>
              <p>Informasi mengenai hasil seleksi peserta didik baru bisa kamu lihat disini</p>
              <div class="main-button-yellow">
                <div><a href="pengumuman">Lihat</a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="accordions is-first-expanded rounded-0">
          <h2>Frequently Asked Questions</h2>
          <?php foreach ($views_faq as $data) : ?>
            <article class="accordion">
              <div class="accordion-head">
                <span><?= $data['pertanyaan'] ?></span>
                <span class="icon">
                  <i class="icon fa fa-chevron-right"></i>
                </span>
              </div>
              <div class="accordion-body">
                <div class="content">
                  <p><?= $data['jawaban'] ?></p>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="contact-us" id="contact">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 align-self-center ">
        <div class="row">
          <div class="col-lg-12">
            <form id="contact" class="rounded-0" action="" method="post">
              <div class="row">
                <div class="col-lg-12">
                  <h2>Kontak</h2>
                </div>
                <div class="col-lg-4">
                  <fieldset>
                    <input name="nama" type="text" id="nama" placeholder="Nama" required>
                  </fieldset>
                </div>
                <div class="col-lg-4">
                  <fieldset>
                    <input name="email" type="email" id="email" placeholder="Email" required>
                  </fieldset>
                </div>
                <div class="col-lg-4">
                  <fieldset>
                    <input name="subject" type="text" id="subject" placeholder="Subject" required>
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <textarea name="pesan" type="text" class="form-control" id="pesan" placeholder="Pesan kamu" required></textarea>
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <button type="submit" name="kontak" class="button">Kirim</button>
                  </fieldset>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="right-info rounded-0">
          <ul>
            <li>
              <h6>Phone Number</h6>
              <span>+62 853-3373-6693</span>
            </li>
            <li>
              <h6>Email Address</h6>
              <span>info@smaskwartabakti.sch.id</span>
            </li>
            <li>
              <h6>Street Address</h6>
              <span>Jl. A.Yani. Kodepos, 85613., Kefamenanu Selatan, Kota Kefamenanu, Timor Tengah Utara</span>
            </li>
            <li>
              <h6>Website URL</h6>
              <span>smaskwartabakti.sch.id</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <?php require_once("templates/bottom.php"); ?>