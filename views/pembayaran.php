<?php require_once("../controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Pembayaran";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_smak_wartabakti"]["name_page"] ?></h1>
  </div>

  <div class="card shadow mb-4 border-0">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="text-center">Nama Peserta</th>
              <th class="text-center">Jumlah Bayar</th>
              <th class="text-center">Tgl Bayar</th>
              <th class="text-center">Status Bayar</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th class="text-center">Nama Peserta</th>
              <th class="text-center">Jumlah Bayar</th>
              <th class="text-center">Tgl Bayar</th>
              <th class="text-center">Status Bayar</th>
              <th class="text-center">Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php foreach ($views_pembayaran as $data) { ?>
              <tr>
                <td><?= $data['nama_lengkap'] ?></td>
                <td>Rp. <?= number_format($data['jumlah_pembayaran']) ?></td>
                <td><?= $data['tanggal_pembayaran'] ?></td>
                <td><?= $data['status_pembayaran'] ?></td>
                <td class="text-center">
                  <?php if ($id_role == 3) { ?>
                    <form action="" method="post">
                      <input type="hidden" name="id_pembayaran" value="<?= $data['id_pembayaran'] ?>">
                      <input type="hidden" name="order_id" value="<?= $data['order_id'] ?>">
                      <button type="submit" name="add_pembayaran" class="btn btn-primary btn-sm">
                        <i class="bi bi-receipt-cutoff"></i> Bayar
                      </button>
                    </form>
                  <?php } else ?>
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