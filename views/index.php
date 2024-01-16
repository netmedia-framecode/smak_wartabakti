<?php require_once("../controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  </div>

  <!-- Content Row -->
  <?php if ($id_role <= 2) { ?>
    <div class="row">

      <div class="col-xl-3 col-md-6 mb-4">
        <a href="users" class="text-decoration-none">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Pengguna</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $counts_users ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <a href="pendaftaran" class="text-decoration-none">
          <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Pendaftaran</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $counts_pendaftaran ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-list-ul fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <a href="hasil-seleksi" class="text-decoration-none">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Seleksi
                  </div>
                  <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $counts_hasil_seleksi ?></div>
                    </div>
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-list-ul fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <a href="pembayaran" class="text-decoration-none">
          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Pembayaran</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $counts_pembayaran ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-user-md fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
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
              $sql = "SELECT 'Users' as category, MONTH(created_at) as month, COUNT(*) as total FROM users WHERE YEAR(created_at) = $currentYear AND MONTH(created_at) BETWEEN 1 AND 12 GROUP BY month
                      UNION
                      SELECT 'Pendaftaran' as category, MONTH(tanggal_pendaftaran) as month, COUNT(*) as total FROM pendaftaran WHERE status_pendaftaran='Belum Diverifikasi' AND YEAR(tanggal_pendaftaran) = $currentYear AND MONTH(tanggal_pendaftaran) BETWEEN 1 AND 12 GROUP BY month
                      UNION
                      SELECT 'Seleksi' as category, MONTH(tanggal_seleksi) as month, COUNT(*) as total FROM hasil_seleksi WHERE YEAR(tanggal_seleksi) = $currentYear AND MONTH(tanggal_seleksi) BETWEEN 1 AND 12 GROUP BY month
                      UNION
                      SELECT 'Pembayaran' as category, MONTH(tanggal_pembayaran) as month, COUNT(*) as total FROM pembayaran WHERE YEAR(tanggal_pembayaran) = $currentYear AND MONTH(tanggal_pembayaran) BETWEEN 1 AND 12 GROUP BY month";

              $result = $conn->query($sql);
              $dataGrafik = [];

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $dataGrafik[] = [
                    'category' => $row['category'],
                    'total' => $row['total'],
                  ];
                }
              }
              ?>
              <canvas id="chart-dashboard"></canvas>
              <script>
                var dataGrafik = <?php echo json_encode($dataGrafik); ?>;
              </script>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>