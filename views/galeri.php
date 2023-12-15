<?php require_once("../controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Galeri";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_smak_wartabakti"]["name_page"] ?></h1>
  </div>

  <div class="card shadow mb-4 border-0">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <form action="" method="post" enctype="multipart/form-data">
            <!--begin::Action-->
            <div class="text-center" id="drop-area">
              <div class="form-group">
                <label for="images">Drag and Drop here:</label>
                <input type="file" class="form-control-file d-none" id="images" name="images[]" multiple>
              </div>
              <div class="form-group shadow mb-3" style="height: 200px;">
                <div id="fileList"></div>
              </div>
              <button type="submit" name="add_menu_galeri" class="btn btn-primary">Upload</button>
            </div>
            <!--end::Action-->
          </form>
        </div>
        <?php ?>
        <div class="col-lg-4"></div>
        <?php ?>
      </div>
    </div>
  </div>

  <div class="card shadow mb-4 border-0">
    <div class="card-body">
      <!--begin::Images content-->
      <div class="d-flex flex-wrap justify-content-between">
        <?php foreach ($views_galeri as $data) : ?>
          <form action="" method="post">
            <img src="<?= $baseURL ?>assets/img/<?= $data['image'] ?>" class="img-thumbnail" style="width: 100%; height: 200px; object-fit: cover;" alt="">
            <input type="hidden" name="id_galeri" value="<?= $data['id_galeri'] ?>">
            <input type="hidden" name="image" value="<?= $data['image'] ?>">
            <button type="submit" name="delete_menu_galeri" class="btn btn-danger btn-sm" style="margin-top: -200px;margin-left: 0px;border-top-left-radius: 0px;border-bottom-left-radius: 0px;"><i class="bi bi-trash3"></i></button>
          </form>
        <?php endforeach; ?>
      </div>
      <!--end::Images content-->
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<script>
  const dropArea = document.querySelector("#drop-area");
  const input = document.querySelector("#images");

  dropArea.addEventListener("dragover", function(e) {
    e.preventDefault();
  });

  dropArea.addEventListener("drop", function(e) {
    e.preventDefault();
    input.files = e.dataTransfer.files;

    var files = input.files,
      filesLength = files.length;
    for (var i = 0; i < filesLength; i++) {
      var file = files[i];
      var fileName = file.name;
      var list = document.createElement("li");
      list.innerHTML = fileName;
      document.querySelector("#fileList").appendChild(list);
    }
  });

  input.addEventListener("change", function(e) {
    var files = e.target.files,
      filesLength = files.length;
    for (var i = 0; i < filesLength; i++) {
      var file = files[i];
      var fileName = file.name;
      var list = document.createElement("li");
      list.innerHTML = fileName;
      document.querySelector("#fileList").appendChild(list);
    }
  });
</script>
<?php require_once("../templates/views_bottom.php") ?>