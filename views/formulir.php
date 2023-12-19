<?php require_once("../controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Formulir";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_smak_wartabakti"]["name_page"] ?></h1>
  </div>

  <?php if ($id_role == 1) { ?>
    <div class="card shadow mb-4 border-0">
      <div class="card-body">
        <?php foreach ($views_formulir as $data) : ?>
          <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="formulirOld" value="<?= $data['formulir'] ?>">
            <div class="form-group">
              <label for="formulir">Unggah Formulir</label>
              <div class="custom-file">
                <input type="file" name="formulir" class="custom-file-input" id="formulir" accept=".pdf" required>
                <label class="custom-file-label" for="formulir">Unggah Formulir</label>
                <small class="form-text text-muted">Hanya file PDF yang diperbolehkan.</small>
              </div>
            </div>
            <button type="submit" name="edit_formulir" class="btn btn-primary">Unggah</button>
          </form>
        <?php endforeach; ?>
      </div>
    </div>
  <?php } ?>

  <div class="card shadow mb-4 border-0">
    <div class="card-body">
      <?php foreach ($views_formulir as $data) : ?>
        <embed src="<?= $baseURL ?>assets/files/formulir/<?= $data['formulir'] ?>" type="application/pdf" width="100%" height="600px">
      <?php endforeach; ?>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>