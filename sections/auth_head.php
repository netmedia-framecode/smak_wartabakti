<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title>
  <?= $name_website ?> <?php if (isset($_SESSION['project_smak_wartabakti']['name_page'])) {
                          echo " - " . $_SESSION['project_smak_wartabakti']['name_page'];
                        } ?>
</title>

<!-- Custom fonts for this template-->
<link href="<?= $baseURL ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<!-- Custom styles for this template-->
<link href="<?= $baseURL ?>assets/css/sb-admin-2.css" rel="stylesheet">
<script src="<?= $baseURL ?>assets/sweetalert/dist/sweetalert2.all.min.js"></script>
