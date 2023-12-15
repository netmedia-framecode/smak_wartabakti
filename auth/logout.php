<?php if (!isset($_SESSION)) {
  session_start();
}
require_once("../controller/script.php");
if (isset($_SESSION["project_smak_wartabakti"])) {
  unset($_SESSION["project_smak_wartabakti"]);
  header("Location: ./");
  exit();
}
