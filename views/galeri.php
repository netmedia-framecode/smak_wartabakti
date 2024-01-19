<?php require_once("../controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Galeri";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_smak_wartabakti"]["name_page"] ?></h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambah"><i class="bi bi-plus-lg"></i> Tambah</a>
  </div>

  <div class="card shadow mb-4 border-0">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="text-center">Gambar</th>
              <th class="text-center">Keterangan</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th class="text-center">Gambar</th>
              <th class="text-center">Keterangan</th>
              <th class="text-center">Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php foreach ($views_galeri as $data) : ?>
              <tr>
                <td><img src="<?= $baseURL ?>assets/img/<?= $data['image'] ?>" class="img-thumbnail" style="width: 100%; height: 200px; object-fit: cover;" alt=""></td>
                <td><?= $data['ket'] ?></td>
                <td class="text-center">
                  <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubah<?= $data['id_galeri'] ?>">
                    <i class="bi bi-pencil-square"></i> Ubah
                  </button>
                  <div class="modal fade" id="ubah<?= $data['id_galeri'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Ubah</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="id_galeri" value="<?= $data['id_galeri'] ?>">
                          <input type="hidden" name="imageOld" value="<?= $data['image'] ?>">
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="image">Menu</label>
                              <input type="file" name="image" class="form-control" id="image">
                            </div>
                            <div class="form-group">
                              <label for="ket">Keterangan</label>
                              <textarea name="ket" id="ket" class="form-control" cols="30" rows="10"><?= $data['ket'] ?></textarea>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="edit_menu_galeri" class="btn btn-warning btn-sm">Ubah</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus<?= $data['id_galeri'] ?>">
                    <i class="bi bi-trash3"></i> Hapus
                  </button>
                  <div class="modal fade" id="hapus<?= $data['id_galeri'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Hapus</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_galeri" value="<?= $data['id_galeri'] ?>">
                          <input type="hidden" name="image" value="<?= $data['image'] ?>">
                          <div class="modal-body">
                            <p>Jika anda yakin ingin menghapus data ini, klik Hapus!</p>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="delete_menu_galeri" class="btn btn-danger btn-sm">hapus</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header border-bottom-0 shadow">
          <h5 class="modal-title" id="tambahLabel">Tambah Galeri</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label for="image">Menu</label>
              <input type="file" name="image" class="form-control" id="image" required>
            </div>
            <div class="form-group">
              <label for="ket">Keterangan</label>
              <textarea name="ket" id="ket" class="form-control" cols="30" rows="10"></textarea>
            </div>
          </div>
          <div class="modal-footer justify-content-center border-top-0">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
            <button type="submit" name="add_menu_galeri" class="btn btn-primary btn-sm">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- <div class="card shadow mb-4 border-0">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <form action="" method="post" enctype="multipart/form-data">
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
          </form>
        </div>
        <?php ?>
        <div class="col-lg-4"></div>
        <?php ?>
      </div>
    </div>
  </div> -->

  <!-- <div class="card shadow mb-4 border-0">
    <div class="card-body">
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
    </div>
  </div> -->

</div>
<!-- /.container-fluid -->

<!-- <script>
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
</script> -->
<?php require_once("../templates/views_bottom.php") ?>