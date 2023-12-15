<?php
// This is just for very basic implementation reference, in production, you should validate the incoming requests and implement your backend more securely.
// Please refer to this docs for snap popup:
// https://docs.midtrans.com/en/snap/integration-guide?id=integration-steps-overview

namespace Midtrans;

require_once("../../../../controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Checkout";

require_once dirname(__FILE__) . '/../../Midtrans.php';
// Set Your server key
// can find in Merchant Portal -> Settings -> Access keys
Config::$serverKey = 'SB-Mid-server-ZYGeFl_4dueZejnTldp3KNRY';
Config::$clientKey = 'SB-Mid-client-GiTG0dW6tP1d6Ygd';

// non-relevant function only used for demo/example purpose
printExampleWarningMessage();

// Uncomment for production environment
// Config::$isProduction = true;
Config::$isSanitized = Config::$is3ds = true;
$order_id = $_GET['order_id'];
$select_pembayaran = "SELECT * 
                FROM pembayaran 
                JOIN hasil_seleksi ON pembayaran.id_hasil_seleksi=hasil_seleksi.id_hasil_seleksi
                JOIN pendaftaran ON hasil_seleksi.id_pendaftaran=pendaftaran.id_pendaftaran
                JOIN users ON pembayaran.id_user=users.id_user
                WHERE pembayaran.order_id='$order_id'
                ORDER BY pembayaran.id_pembayaran DESC
              ";
$take_pembayaran = mysqli_query($conn, $select_pembayaran);
$data = mysqli_fetch_assoc($take_pembayaran);

if ($data['status_pembayaran'] == "Lunas") {
  header("Location: ../../../pembayaran");
  exit();
}

// Required
$transaction_details = array(
  'order_id' => $data['order_id'],
  'gross_amount' => $data['jumlah_pembayaran'], // no decimal allowed for creditcard
);
// Optional
$item_details = array(
  array(
    'id' => $data['id_pembayaran'],
    'price' => $data['jumlah_pembayaran'],
    'quantity' => 1,
    'name' => "Biaya Masuk Sekolah"
  ),
);
// Optional
$customer_details = array(
  'first_name'    => $data['nama_lengkap'],
  'email'         => $data['email'],
  'phone'         => $data['nomor_telepon'],
);
// Fill transaction details
$transaction = array(
  'transaction_details' => $transaction_details,
  'customer_details' => $customer_details,
  'item_details' => $item_details,
);

$snap_token = '';
try {
  $snap_token = Snap::getSnapToken($transaction);
} catch (\Exception $e) {
  echo $e->getMessage();
}

function printExampleWarningMessage()
{
  if (strpos(Config::$serverKey, 'your ') != false) {
    echo "<code>";
    echo "<h4>Please set your server key from sandbox</h4>";
    echo "In file: " . __FILE__;
    echo "<br>";
    echo "<br>";
    echo htmlspecialchars('Config::$serverKey = \'<your server key>\';');
    die();
  }
}

require_once("../../../../templates/views_top.php");
?>
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_smak_wartabakti"]["name_page"] ?></h1>
  </div>

  <div class="card shadow mb-4 border-0">
    <div class="card-body text-dark">
      <div class="table-responsive">
        <table class="table table-bordered text-dark" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="text-center">Nama Peserta</th>
              <th class="text-center">Jenis Kelamin</th>
              <th class="text-center">Tgl Lahir</th>
              <th class="text-center">Alamat</th>
              <th class="text-center">Email</th>
              <th class="text-center">No. Telp</th>
              <th class="text-center">Asal Sekolah</th>
              <th class="text-center">Jumlah Bayar</th>
              <th class="text-center">Tgl Bayar</th>
              <th class="text-center">Status Bayar</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($take_pembayaran as $data) { ?>
              <tr>
                <td><?= $data['nama_lengkap'] ?></td>
                <td><?= $data['jenis_kelamin'] ?></td>
                <td><?= $data['tanggal_lahir'] ?></td>
                <td><?= $data['alamat'] ?></td>
                <td><?= $data['email'] ?></td>
                <td><?= $data['nomor_telepon'] ?></td>
                <td><?= $data['asal_sekolah'] ?></td>
                <td>Rp. <?= number_format($data['jumlah_pembayaran']) ?></td>
                <td><?= $data['tanggal_pembayaran'] ?></td>
                <td><?= $data['status_pembayaran'] ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <?php $total_biaya = 0;
      foreach ($views_biaya_pembayaran as $data_bp) : ?>
        <p><b><?= $data_bp['nama_biaya'] ?></b> : Rp. <?= number_format($data_bp['jumlah_biaya']) ?></p>
      <?php $total_biaya += $data_bp['jumlah_biaya'];
      endforeach; ?>
      <p><b>Total Biaya Uang Masuk Sekolah</b> : Rp. <?= number_format($total_biaya) ?></p>
      <small><?= "Token = " . $snap_token; ?></small><br>
      <button class="btn btn-primary mt-3" id="pay-button"><i class="bi bi-receipt-cutoff"></i> Bayar Sekarang</button>
      <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
      <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo Config::$clientKey; ?>"></script>
      <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
          // SnapToken acquired from previous step
          snap.pay('<?php echo $snap_token ?>');
        };
      </script>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php require_once("../../../../templates/views_bottom.php") ?>