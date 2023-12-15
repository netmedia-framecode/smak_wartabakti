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
}
catch (\Exception $e) {
    exit($e->getMessage());
}

$notif = $notif->getResponse();
$transaction = $notif->transaction_status;
$type = $notif->payment_type;
$order_id = $notif->order_id;
$fraud = $notif->fraud_status;

if ($transaction == 'settlement') {
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

function printExampleWarningMessage() {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo 'Notification-handler are not meant to be opened via browser / GET HTTP method. It is used to handle Midtrans HTTP POST notification / webhook.';
    }
    if (strpos(Config::$serverKey, 'your ') != false ) {
        echo "<code>";
        echo "<h4>Please set your server key from sandbox</h4>";
        echo "In file: " . __FILE__;
        echo "<br>";
        echo "<br>";
        echo htmlspecialchars('Config::$serverKey = \'<your server key>\';');
        die();
    }   
}
