<?php require_once("../controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Pembayaran";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_smak_wartabakti"]["name_page"] ?></h1>
    <?php if ($id_role <= 2) { ?>
      <div class="col-lg-6 text-right">
        <a href="export-pembayaran" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" target="_blank"><i class="bi bi-download"></i> Export</a>
      </div>
    <?php } ?>
  </div>

  <div class="card shadow mb-4 border-0">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="text-center">Nama Peserta</th>
              <th class="text-center">Jumlah Bayar</th>
              <th class="text-center">Batas Bayar</th>
              <th class="text-center">Tgl Bayar</th>
              <th class="text-center">Status Bayar</th>
              <?php if ($id_role == 3) { ?>
                <th class="text-center">Aksi</th>
              <?php } ?>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th class="text-center">Nama Peserta</th>
              <th class="text-center">Jumlah Bayar</th>
              <th class="text-center">Batas Bayar</th>
              <th class="text-center">Tgl Bayar</th>
              <th class="text-center">Status Bayar</th>
              <?php if ($id_role == 3) { ?>
                <th class="text-center">Aksi</th>
              <?php } ?>
            </tr>
          </tfoot>
          <tbody>
            <?php foreach ($views_pembayaran as $data) { ?>
              <tr>
                <td><?= $data['nama_lengkap'] ?></td>
                <td>Rp. <?= number_format($data['jumlah_pembayaran']) ?></td>
                <td><?= $data['batas_pembayaran'] ?></td>
                <td><?= $data['tanggal_pembayaran'] ?></td>
                <td><?= $data['status_pembayaran'] ?></td>
                <?php if ($id_role == 3) { ?>
                  <td class="text-center">
                    <form action="" method="post">
                      <input type="hidden" name="id_pembayaran" value="<?= $data['id_pembayaran'] ?>">
                      <input type="hidden" name="order_id" value="<?= $data['order_id'] ?>">
                      <input type="hidden" name="batas_pembayaran" value="<?= $data['batas_pembayaran'] ?>">
                      <button type="submit" name="add_pembayaran" class="btn btn-primary btn-sm">
                        <i class="bi bi-receipt-cutoff"></i> Bayar
                      </button>
                    </form>
                  </td>
                <?php } ?>
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