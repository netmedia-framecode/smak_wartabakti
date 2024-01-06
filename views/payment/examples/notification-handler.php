<?php
// This is just for very basic implementation reference, in production, you should validate the incoming requests and implement your backend more securely.
// Please refer to this docs for sample HTTP notifications:
// https://docs.midtrans.com/en/after-payment/http-notification?id=sample-of-different-payment-channels

namespace Midtrans;

require_once dirname(__FILE__) . '/../Midtrans.php';
Config::$isProduction = false;
Config::$serverKey = 'SB-Mid-server-ZYGeFl_4dueZejnTldp3KNRY';

require_once("../../../controller/script.php");

// non-relevant function only used for demo/example purpose
printExampleWarningMessage();

try {
    $notif = new Notification();
} catch (\Exception $e) {
    exit($e->getMessage());
}

$notif = $notif->getResponse();
$transaction = $notif->transaction_status;
$type = $notif->payment_type;
$order_id = $notif->order_id;
$email = $notif->email;
$first_name = $notif->first_name;
$fraud = $notif->fraud_status;

if ($transaction == 'settlement') {
    require_once("../../../controller/mail.php");
    $to       = $email;
    $subject  = "Pembayaran Masuk SMAK Wartabakti";
    $message  = "<!doctype html>
    <html>
      <head>
          <meta name='viewport' content='width=device-width'>
          <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
          <title>Pembayaran Masuk SMAK Wartabakti</title>
          <style>
              @media only screen and (max-width: 620px) {
                  table[class='body'] h1 {
                      font-size: 28px !important;
                      margin-bottom: 10px !important;}
                  table[class='body'] p,
                  table[class='body'] ul,
                  table[class='body'] ol,
                  table[class='body'] td,
                  table[class='body'] span,
                  table[class='body'] a {
                      font-size: 16px !important;}
                  table[class='body'] .wrapper,
                  table[class='body'] .article {
                      padding: 10px !important;}
                  table[class='body'] .content {
                      padding: 0 !important;}
                  table[class='body'] .container {
                      padding: 0 !important;
                      width: 100% !important;}
                  table[class='body'] .main {
                      border-left-width: 0 !important;
                      border-radius: 0 !important;
                      border-right-width: 0 !important;}
                  table[class='body'] .btn table {
                      width: 100% !important;}
                  table[class='body'] .btn a {
                      width: 100% !important;}
                  table[class='body'] .img-responsive {
                      height: auto !important;
                      max-width: 100% !important;
                      width: auto !important;}}
              @media all {
                  .ExternalClass {
                      width: 100%;}
                  .ExternalClass,
                  .ExternalClass p,
                  .ExternalClass span,
                  .ExternalClass font,
                  .ExternalClass td,
                  .ExternalClass div {
                      line-height: 100%;}
                  .apple-link a {
                      color: inherit !important;
                      font-family: inherit !important;
                      font-size: inherit !important;
                      font-weight: inherit !important;
                      line-height: inherit !important;
                      text-decoration: none !important;
                  .btn-primary table td:hover {
                      background-color: #d5075d !important;}
                  .btn-primary a:hover {
                      background-color: #000 !important;
                      border-color: #000 !important;
                      color: #fff !important;}}
          </style>
      </head>
      <body class style='background-color: #e1e3e5; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
          <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background-color: #e1e3e5; width: 100%;' width='100%' bgcolor='#e1e3e5'>
          <tr>
              <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
              <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;' width='580' valign='top'>
              <div class='content' style='box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;'>
      
                  <!-- START CENTERED WHITE CONTAINER -->
                  <table role='presentation' class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background: #ffffff; border-radius: 3px; width: 100%;' width='100%'>
      
                  <!-- START MAIN CONTENT AREA -->
                  <tr>
                      <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;' valign='top'>
                      <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                          <tr>
                          <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>
                              <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Hi " . $first_name . ",</p>
                              <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Selamat pembayaran kamu berhasil. Silakan mengecek pada pengumuman untuk tanggal masuk sekolah dan OSPEK yang akan dilakukan. Atau bisa klik link berikut : <a href='http://127.0.0.1:1010/apps/tugas/smak_wartabakti/pengumuman'>http://127.0.0.1:1010/apps/tugas/smak_wartabakti/pengumuman</a></p>
                              <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Terima kasih<br>SMAK Wartabakti.</p>
                              <small>Peringatan! Ini adalah pesan otomatis sehingga Anda tidak dapat membalas pesan ini.</small>
                          </td>
                          </tr>
                      </table>
                      </td>
                  </tr>
      
                  <!-- END MAIN CONTENT AREA -->
                  </table>
                  
                  <!-- START FOOTER -->
                  <div class='footer' style='clear: both; margin-top: 10px; text-align: center; width: 100%;'>
                  <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                      <tr>
                      <td class='content-block' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                          <span class='apple-link' style='color: #9a9ea6; font-size: 12px; text-align: center;'>Workarea Jln. S. K. Lerik, Kota Baru, Kupang, NTT, Indonesia. (0380) 8438423</span>
                      </td>
                      </tr>
                      <tr>
                      <td class='content-block powered-by' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                          Powered by <a href='https://www.netmedia-framecode.com' style='color: #9a9ea6; font-size: 12px; text-align: center; text-decoration: none;'>Netmedia Framecode</a>.
                      </td>
                      </tr>
                  </table>
                  </div>
                  <!-- END FOOTER -->
      
              <!-- END CENTERED WHITE CONTAINER -->
              </div>
              </td>
              <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
          </tr>
          </table>
      </body>
    </html>";
    smtp_mail($to, $subject, $message, "", "", 0, 0, true);
    // TODO set payment status in merchant's database to 'Settlement'
    // echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
    $sql = "UPDATE pembayaran SET status_pembayaran='Lunas', tanggal_pembayaran=current_timestamp WHERE order_id='$order_id'";
    mysqli_query($conn, $sql);
} else if ($transaction == 'pending') {
    // TODO set payment status in merchant's database to 'Pending'
    // echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
    $sql = "UPDATE pembayaran SET status_pembayaran='Pending', tanggal_pembayaran=current_timestamp WHERE order_id='$order_id'";
    mysqli_query($conn, $sql);
} else if ($transaction == 'deny') {
    // TODO set payment status in merchant's database to 'Denied'
    // echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
    $sql = "UPDATE pembayaran SET status_pembayaran='Denied', tanggal_pembayaran=current_timestamp WHERE order_id='$order_id'";
    mysqli_query($conn, $sql);
} else if ($transaction == 'expire') {
    // TODO set payment status in merchant's database to 'expire'
    // echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
    $sql = "UPDATE pembayaran SET status_pembayaran='Expired', tanggal_pembayaran=current_timestamp WHERE order_id='$order_id'";
    mysqli_query($conn, $sql);
} else if ($transaction == 'cancel') {
    // TODO set payment status in merchant's database to 'Denied'
    // echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
    $sql = "UPDATE pembayaran SET status_pembayaran='Cancel', tanggal_pembayaran=current_timestamp WHERE order_id='$order_id'";
    mysqli_query($conn, $sql);
}

function printExampleWarningMessage()
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo 'Notification-handler are not meant to be opened via browser / GET HTTP method. It is used to handle Midtrans HTTP POST notification / webhook.';
    }
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
