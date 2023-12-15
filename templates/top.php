<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once("sections/head.php") ?>
</head>

<body>
  <?php foreach ($messageTypes as $type) {
    if (isset($_SESSION["project_smak_wartabakti"]["message_$type"])) {
      echo "<div class='message-$type' data-message-$type='{$_SESSION["project_smak_wartabakti"]["message_$type"]}'></div>";
    }
  } ?>

  <?php require_once("sections/nav.php") ?>