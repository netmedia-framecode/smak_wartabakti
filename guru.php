<?php require_once("controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Data Guru";
require_once("templates/top.php"); ?>

<section class="heading-page header-text" id="top">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h6>SMAS K Warta Bakti</h6>
        <h2>Data Guru</h2>
      </div>
    </div>
  </div>
</section>

<section class="meetings-page" id="meetings">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <?php foreach ($views_guru_visit as $data) : ?>
          <div class="meeting-single-item mb-4">
            <div class="down-content rounded-0">
              <div class="row">
                <div class="col-lg-4">
                  <img src="<?= $baseURL ?>assets/img/no-image.png" alt="">
                </div>
                <div class="col-lg-8">
                  <table class="table table-sm">
                    <tbody>
                      <tr>
                        <th scope="row" style="width: 200px;">Nama Lengkap</th>
                        <td>:</td>
                        <td><?= $data['nama_lengkap'] ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Nik</th>
                        <td>:</td>
                        <td><?= $data['nik'] ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Jenis Kelamin</th>
                        <td>:</td>
                        <td><?= $data['jk'] ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Tempat Lahir</th>
                        <td>:</td>
                        <td><?= $data['tempat_lahir'] ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Tanggal Lahir</th>
                        <td>:</td>
                        <td><?= $data['tgl_lahir'] ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
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

  <?php require_once("templates/bottom.php"); ?>