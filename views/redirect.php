<?php
if (!isset($_SESSION["project_smak_wartabakti"]["users"])) {
  header("Location: ../auth/");
  exit;
}
