<div class="sub-header">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-sm-6">
        <div class="left-content">
        </div>
      </div>
      <div class="col-lg-6 col-sm-6">
        <div class="right-icons">
          <ul>
            <li><a href="tel:+6285333736693"><i class="fa fa-phone"></i> +62 853-3373-6693</a></li>
            <li><a href="mailto:info@smaskwartabakti.sch.id"><i class="fa fa-envelope"></i> info@smaskwartabakti.sch.id</a></li>
            <li class="text-white">|</li>
            <li><a href="auth/"><i class="fa fa-sign-in"></i> Login</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <nav class="main-nav">
          <!-- ***** Logo Start ***** -->
          <style>
            /* Gaya awal untuk resolusi laptop */
            .logo-img {
              width: 350px;
            }

            /* Media query untuk resolusi HP */
            @media screen and (max-width: 1200px) {
              .logo-img {
                width: 300px;
              }
            }

            @media screen and (max-width: 991px) {
              .logo-img {
                width: 50px;
              }
            }

            @media screen and (max-width: 767px) {
              .logo-img {
                width: 200px;
                margin-top: 20px;
              }
            }
          </style>

          <a href="./" class="logo">
            <img src="<?= $baseURL ?>assets/img/logo.png" class="logo-img" alt="">
          </a>
          <!-- ***** Logo End ***** -->

          <!-- ***** Menu Start ***** -->
          <ul class="nav">
            <li><a href="./">Beranda</a></li>
            <li><a href="profil">Profil</a></li>
            <li><a href="visi-misi">Visi Misi</a></li>
            <li class="has-sub">
              <a href="javascript:void(0)">Berita</a>
              <ul class="sub-menu">
                <li><a href="berita">Semua Berita</a></li>
                <?php foreach ($views_kategori_berita as $data) : ?>
                  <li><a href="berita?kategori=<?= $data['slug'] ?>"><?= $data['nama_kategori'] ?></a></li>
                <?php endforeach; ?>
              </ul>
            </li>
            <li class="has-sub">
              <a href="javascript:void(0)">PPDB <?= date("Y") ?></a>
              <ul class="sub-menu">
                <li><a href="formulir-ppdb">Formulir PPDB</a></li>
                <?php foreach ($views_formulir as $data) { ?>
                  <li><a href="<?= $baseURL ?>assets/files/formulir/<?= $data['formulir'] ?>" download="<?= $data['formulir'] ?>">Download Formulir</a></li>
                <?php } ?>
                <li><a href="pendaftaran">Pendaftaran</a></li>
                <li><a href="hasil-seleksi">Hasil Seleksi</a></li>
                <li><a href="pengumuman">Pengumuman</a></li>
              </ul>
            </li>
            <li><a href="galeri">Galeri</a></li>
            <li><a href="index#contact">Kontak</a></li>
          </ul>
          <a class='menu-trigger'>
            <span>Menu</span>
          </a>
          <!-- ***** Menu End ***** -->
        </nav>
      </div>
    </div>
  </div>
</header>