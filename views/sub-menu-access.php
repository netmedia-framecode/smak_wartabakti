<?php require_once("../controller/script.php");
$_SESSION["project_smak_wartabakti"]["name_page"] = "Sub Menu Access";
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
              <th class="text-center">Role</th>
              <th class="text-center">Sub Menu</th>
              <th class="text-center" style="width: 200px;">Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th class="text-center">Role</th>
              <th class="text-center">Sub Menu</th>
              <th class="text-center">Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php foreach ($views_user_access_sub_menu as $data) { ?>
              <tr>
                <td><?= $data['role'] ?></td>
                <td><?= $data['title'] ?></td>
                <td class="text-center">
                  <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubah<?= $data['id_access_sub_menu'] ?>">
                    <i class="bi bi-pencil-square"></i> Ubah
                  </button>
                  <div class="modal fade" id="ubah<?= $data['id_access_sub_menu'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $data['title'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_access_sub_menu" value="<?= $data['id_access_sub_menu'] ?>">
                          <input type="hidden" name="title" value="<?= $data['title'] ?>">
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="id_role">Role</label>
                              <select name="id_role" class="form-control" id="id_role" required>
                                <option value="" selected>Pilih Role</option>
                                <?php $id_role = $data['id_role'];
                                foreach ($views_user_role as $data_select_role) {
                                  $selected = ($data_select_role['id_role'] == $id_role) ? 'selected' : ''; ?>
                                  <option value="<?= $data_select_role['id_role'] ?>" <?= $selected ?>><?= $data_select_role['role'] ?></option>
                                <?php } ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="id_sub_menu">Sub Menu</label>
                              <select name="id_sub_menu" class="form-control" id="id_sub_menu" required>
                                <option value="" selected>Pilih Sub Menu</option>
                                <?php $id_sub_menu = $data['id_sub_menu'];
                                foreach ($views_sub_menu_check as $data_select_menu) {
                                  $selected = ($data_select_menu['id_sub_menu'] == $id_sub_menu) ? 'selected' : ''; ?>
                                  <option value="<?= $data_select_menu['id_sub_menu'] ?>" <?= $selected ?>><?= $data_select_menu['title'] ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="edit_sub_menu_access" class="btn btn-warning btn-sm">Ubah</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus<?= $data['id_access_sub_menu'] ?>">
                    <i class="bi bi-trash3"></i> Hapus
                  </button>
                  <div class="modal fade" id="hapus<?= $data['id_access_sub_menu'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $data['title'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_access_sub_menu" value="<?= $data['id_access_sub_menu'] ?>">
                          <input type="hidden" name="title" value="<?= $data['title'] ?>">
                          <div class="modal-body">
                            <p>Jika anda yakin ingin menghapus <?= $data['title'] ?> klik Hapus!</p>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="delete_sub_menu_access" class="btn btn-danger btn-sm">hapus</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header border-bottom-0 shadow">
          <h5 class="modal-title" id="tambahLabel">Tambah Akses Sub Menu</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label for="id_role">Role</label>
              <select name="id_role" class="form-control" id="id_role" required>
                <option value="" selected>Pilih Role</option>
                <?php foreach ($views_user_role as $data_select_role) { ?>
                  <option value="<?= $data_select_role['id_role'] ?>"><?= $data_select_role['role'] ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="id_sub_menu">Sub Menu</label>
              <select name="id_sub_menu" class="form-control" id="id_sub_menu" required>
                <option value="" selected>Pilih Sub Menu</option>
                <?php foreach ($views_sub_menu_check as $data_select_menu) { ?>
                  <option value="<?= $data_select_menu['id_sub_menu'] ?>"><?= $data_select_menu['title'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-center border-top-0">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
            <button type="submit" name="add_sub_menu_access" class="btn btn-primary btn-sm">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>
