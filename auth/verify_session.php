<?php
require_once("../controller/script.php");
if (isset($_SESSION["project_smak_wartabakti"])) {
  header("Location: ../views/");
  exit;
} else {
  if (!isset($_SESSION["data_auth"]["en_user"])) {
    $_SESSION["project_smak_wartabakti"] = [
      "message-warning" => "Maaf, sepertinya ada kesalahan saat mendaftar.",
      "time-message" => time()
    ];
    header("Location: register");
    exit;
  } else {
    $message = "Waktu verifikasi telah habis!";
    $response = ["message" => $message];
    echo json_encode($response);
  }
}

