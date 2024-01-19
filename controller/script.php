<?php if (!isset($_SESSION[""])) {
  session_start();
}
error_reporting(~E_NOTICE & ~E_DEPRECATED);
require_once("db_connect.php");
require_once(__DIR__ . "/../models/sql.php");
require_once("functions.php");

$messageTypes = ["success", "info", "warning", "danger", "dark"];

$baseURL = "http://$_SERVER[HTTP_HOST]/apps/tugas/smak_wartabakti/";
$name_website = "SMAK Wartabakti";

$select_auth = "SELECT * FROM auth";
$views_auth = mysqli_query($conn, $select_auth);
$select_header = "SELECT * FROM header ORDER BY id DESC";
$views_header = mysqli_query($conn, $select_header);
$select_carousel = "SELECT * FROM carousel";
$views_carousel = mysqli_query($conn, $select_carousel);
$select_kategori_berita = "SELECT * FROM kategori_berita";
$views_kategori_berita = mysqli_query($conn, $select_kategori_berita);
$select_berita = "SELECT * FROM berita ORDER BY id_berita DESC LIMIT 4";
$views_berita = mysqli_query($conn, $select_berita);
$select_faq = "SELECT * FROM faq ORDER BY id_faq DESC";
$views_faq = mysqli_query($conn, $select_faq);
$select_profil = "SELECT * FROM profil";
$views_profil = mysqli_query($conn, $select_profil);
$select_visi_misi = "SELECT * FROM visi_misi";
$views_visi_misi = mysqli_query($conn, $select_visi_misi);
$select_berita_page = "SELECT * FROM berita";
$views_berita_page = mysqli_query($conn, $select_berita_page);
$current_datetime = date('Y-m-d H:i:s');
$select_iklan = "SELECT * FROM iklan WHERE tanggal_mulai <= '$current_datetime' AND tanggal_selesai >= '$current_datetime'";
$views_iklan = mysqli_query($conn, $select_iklan);
$select_pengumuman = "SELECT * FROM pengumuman ORDER BY id_pengumuman DESC";
$views_pengumuman = mysqli_query($conn, $select_pengumuman);
$select_galeri = "SELECT * FROM galeri ORDER BY id_galeri DESC";
$views_galeri = mysqli_query($conn, $select_galeri);
$select_formulir = "SELECT * FROM formulir";
$views_formulir = mysqli_query($conn, $select_formulir);
$select_hasil_seleksi = "SELECT * FROM hasil_seleksi JOIN pendaftaran ON hasil_seleksi.id_pendaftaran=pendaftaran.id_pendaftaran ORDER BY hasil_seleksi.id_hasil_seleksi ASC";
$views_hasil_seleksi = mysqli_query($conn, $select_hasil_seleksi);
$select_guru_visit = "SELECT * FROM guru";
$views_guru_visit = mysqli_query($conn, $select_guru_visit);
$select_ekstrakulikuler_visit = "SELECT * FROM ekstrakulikuler";
$views_ekstrakulikuler_visit = mysqli_query($conn, $select_ekstrakulikuler_visit);
$select_sejarah = "SELECT * FROM sejarah";
$views_sejarah = mysqli_query($conn, $select_sejarah);
$select_panduan = "SELECT * FROM panduan";
$views_panduan = mysqli_query($conn, $select_panduan);

if (isset($_POST["kontak"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (kontak($conn, $validated_post, $action = 'insert') > 0) {
    $message = "Pesan yang kamu kirim berhasil kami terima dengan baik.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: ./");
    exit();
  }
}
if (isset($_POST["komentar"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (komentar($conn, $validated_post, $action = 'insert') > 0) {
    $message = "Komentar yang kamu buat berhasil dikirim.";
    $message_type = "success";
    alert($message, $message_type);
    $slug = valid($conn, $_POST['slug']);
    header("Location: berita?judul=$slug");
    exit();
  }
}
if (isset($_POST["pendaftaran"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (pendaftaran($conn, $validated_post, $action = 'insert') > 0) {
    $message = "Selamat, kamu berhasil mendaftarkan diri sebagai calon peserta didik baru. Berkas yang kamu kirim berhasil kami terima dengan baik, berikutnya akan kami cek dan jika berkas kamu diterima maka kamu akan mendapatkan pesan dari kami melalui email yang kami kirimkan.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: pendaftaran");
    exit();
  }
}

if (!isset($_SESSION["project_smak_wartabakti"]["users"])) {
  if (isset($_SESSION["project_smak_wartabakti"]["time_message"]) && (time() - $_SESSION["project_smak_wartabakti"]["time_message"]) > 2) {
    foreach ($messageTypes as $type) {
      if (isset($_SESSION["project_smak_wartabakti"]["message_$type"])) {
        unset($_SESSION["project_smak_wartabakti"]["message_$type"]);
      }
    }
    unset($_SESSION["project_smak_wartabakti"]["time_message"]);
  }
  if (isset($_POST["register"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (register($conn, $validated_post, $action = 'insert') > 0) {
      header("Location: verification?en=" . $_SESSION['data_auth']['en_user']);
      exit();
    }
  }
  if (isset($_POST["re_verifikasi"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (re_verifikasi($conn, $validated_post, $action = 'update') > 0) {
      $message = "Kode token yang baru telah dikirim ke email anda.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: verification?en=" . $_SESSION['data_auth']['en_user']);
      exit();
    }
  }
  if (isset($_POST["verifikasi"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (verifikasi($conn, $validated_post, $action = 'update') > 0) {
      $message = "Akun anda berhasil di verifikasi.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: ./");
      exit();
    }
  }
  if (isset($_POST["forgot_password"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (forgot_password($conn, $validated_post, $action = 'update', $baseURL) > 0) {
      $message = "Kami telah mengirim link ke email anda untuk melakukan reset kata sandi.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: ./");
      exit();
    }
  }
  if (isset($_POST["new_password"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (new_password($conn, $validated_post, $action = 'update') > 0) {
      $message = "Kata sandi anda telah berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: ./");
      exit();
    }
  }
  if (isset($_POST["login"])) {
    if (login($conn, $_POST) > 0) {
      header("Location: ../views/");
      exit();
    }
  }
}

if (isset($_SESSION["project_smak_wartabakti"]["users"])) {
  $id_user = valid($conn, $_SESSION["project_smak_wartabakti"]["users"]["id"]);
  $id_role = valid($conn, $_SESSION["project_smak_wartabakti"]["users"]["id_role"]);
  $role = valid($conn, $_SESSION["project_smak_wartabakti"]["users"]["role"]);
  $email = valid($conn, $_SESSION["project_smak_wartabakti"]["users"]["email"]);
  $name = valid($conn, $_SESSION["project_smak_wartabakti"]["users"]["name"]);
  if (isset($_SESSION["project_smak_wartabakti"]["users"]["time_message"]) && (time() - $_SESSION["project_smak_wartabakti"]["users"]["time_message"]) > 2) {
    foreach ($messageTypes as $type) {
      if (isset($_SESSION["project_smak_wartabakti"]["users"]["message_$type"])) {
        unset($_SESSION["project_smak_wartabakti"]["users"]["message_$type"]);
      }
    }
    unset($_SESSION["project_smak_wartabakti"]["users"]["time_message"]);
  }

  $select_count_users = "SELECT * FROM users";
  $count_users = mysqli_query($conn, $select_count_users);
  $counts_users = mysqli_num_rows($count_users);
  $select_count_pendaftaran = "SELECT * FROM pendaftaran WHERE status_pendaftaran='Belum Diverifikasi'";
  $count_pendaftaran = mysqli_query($conn, $select_count_pendaftaran);
  $counts_pendaftaran = mysqli_num_rows($count_pendaftaran);
  $select_count_hasil_seleksi = "SELECT * FROM hasil_seleksi";
  $count_hasil_seleksi = mysqli_query($conn, $select_count_hasil_seleksi);
  $counts_hasil_seleksi = mysqli_num_rows($count_hasil_seleksi);
  $select_count_pembayaran = "SELECT * FROM pembayaran";
  $count_pembayaran = mysqli_query($conn, $select_count_pembayaran);
  $counts_pembayaran = mysqli_num_rows($count_pembayaran);


  $select_profile = "SELECT users.*, user_role.role, user_status.status 
                      FROM users
                      JOIN user_role ON users.id_role=user_role.id_role 
                      JOIN user_status ON users.id_active=user_status.id_status 
                      WHERE users.id_user='$id_user'
                    ";
  $view_profile = mysqli_query($conn, $select_profile);
  if (isset($_POST["edit_profil"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (profil($conn, $validated_post, $action = 'update', $id_user) > 0) {
      $message = "Profil Anda berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: profil");
      exit();
    }
  }
  if (isset($_POST["setting"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (setting($conn, $validated_post, $action = 'update') > 0) {
      $message = "Setting pada system login berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: setting");
      exit();
    }
  }

  $select_users = "SELECT users.*, user_role.role, user_status.status 
                    FROM users
                    JOIN user_role ON users.id_role=user_role.id_role 
                    JOIN user_status ON users.id_active=user_status.id_status
                    WHERE users.id_user!='$id_user'
                  ";
  $views_users = mysqli_query($conn, $select_users);
  $select_user_role = "SELECT * FROM user_role";
  $views_user_role = mysqli_query($conn, $select_user_role);
  if (isset($_POST["edit_users"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (users($conn, $validated_post, $action = 'update') > 0) {
      $message = "data users berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: users");
      exit();
    }
  }
  if (isset($_POST["add_role"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (role($conn, $validated_post, $action = 'insert') > 0) {
      $message = "Role baru berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: role");
      exit();
    }
  }
  if (isset($_POST["edit_role"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (role($conn, $validated_post, $action = 'update') > 0) {
      $message = "Role " . $_POST['roleOld'] . " berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: role");
      exit();
    }
  }
  if (isset($_POST["delete_role"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (role($conn, $validated_post, $action = 'delete') > 0) {
      $message = "Role " . $_POST['role'] . " berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: role");
      exit();
    }
  }

  $select_menu = "SELECT * 
                    FROM user_menu 
                    ORDER BY menu ASC
                  ";
  $views_menu = mysqli_query($conn, $select_menu);
  if (isset($_POST["add_menu"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (menu($conn, $validated_post, $action = 'insert') > 0) {
      $message = "Menu baru berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: menu");
      exit();
    }
  }
  if (isset($_POST["edit_menu"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (menu($conn, $validated_post, $action = 'update') > 0) {
      $message = "Menu " . $_POST['menuOld'] . " berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: menu");
      exit();
    }
  }
  if (isset($_POST["delete_menu"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (menu($conn, $validated_post, $action = 'delete') > 0) {
      $message = "Menu " . $_POST['menu'] . " berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: menu");
      exit();
    }
  }

  $select_sub_menu = "SELECT user_sub_menu.*, user_menu.menu, user_status.status 
                        FROM user_sub_menu 
                        JOIN user_menu ON user_sub_menu.id_menu=user_menu.id_menu 
                        JOIN user_status ON user_sub_menu.id_active=user_status.id_status 
                        ORDER BY user_sub_menu.title ASC
                      ";
  $views_sub_menu = mysqli_query($conn, $select_sub_menu);
  $select_user_status = "SELECT * 
                          FROM user_status
                        ";
  $views_user_status = mysqli_query($conn, $select_user_status);
  if (isset($_POST["add_sub_menu"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (sub_menu($conn, $validated_post, $action = 'insert', $baseURL) > 0) {
      $message = "Sub Menu baru berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: sub-menu");
      exit();
    }
  }
  if (isset($_POST["edit_sub_menu"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (sub_menu($conn, $validated_post, $action = 'update', $baseURL) > 0) {
      $message = "Sub Menu " . $_POST['titleOld'] . " berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: sub-menu");
      exit();
    }
  }
  if (isset($_POST["delete_sub_menu"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (sub_menu($conn, $validated_post, $action = 'delete', $baseURL) > 0) {
      $message = "Sub Menu " . $_POST['title'] . " berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: sub-menu");
      exit();
    }
  }

  $select_user_access_menu = "SELECT user_access_menu.*, user_role.role, user_menu.menu
                                FROM user_access_menu 
                                JOIN user_role ON user_access_menu.id_role=.user_role.id_role 
                                JOIN user_menu ON user_access_menu.id_menu=user_menu.id_menu
                              ";
  $views_user_access_menu = mysqli_query($conn, $select_user_access_menu);
  $select_menu_check = "SELECT user_menu.* 
                    FROM user_menu 
                    ORDER BY user_menu.menu ASC
                  ";
  $views_menu_check = mysqli_query($conn, $select_menu_check);
  if (isset($_POST["add_menu_access"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (menu_access($conn, $validated_post, $action = 'insert') > 0) {
      $message = "Akses ke menu berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: menu-access");
      exit();
    }
  }
  if (isset($_POST["edit_menu_access"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (menu_access($conn, $validated_post, $action = 'update') > 0) {
      $message = "Akses menu " . $_POST['menu'] . " berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: menu-access");
      exit();
    }
  }
  if (isset($_POST["delete_menu_access"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (menu_access($conn, $validated_post, $action = 'delete') > 0) {
      $message = "Akses menu " . $_POST['menu'] . " berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: menu-access");
      exit();
    }
  }

  $select_user_access_sub_menu = "SELECT user_access_sub_menu.*, user_role.role, user_sub_menu.title
                                FROM user_access_sub_menu 
                                JOIN user_role ON user_access_sub_menu.id_role=.user_role.id_role 
                                JOIN user_sub_menu ON user_access_sub_menu.id_sub_menu=user_sub_menu.id_sub_menu
                              ";
  $views_user_access_sub_menu = mysqli_query($conn, $select_user_access_sub_menu);
  $select_sub_menu_check = "SELECT user_sub_menu.* 
                    FROM user_sub_menu 
                    ORDER BY user_sub_menu.title ASC
                  ";
  $views_sub_menu_check = mysqli_query($conn, $select_sub_menu_check);
  if (isset($_POST["add_sub_menu_access"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (sub_menu_access($conn, $validated_post, $action = 'insert') > 0) {
      $message = "Akses ke sub menu berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: sub-menu-access");
      exit();
    }
  }
  if (isset($_POST["edit_sub_menu_access"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (sub_menu_access($conn, $validated_post, $action = 'update') > 0) {
      $message = "Akses sub menu " . $_POST['title'] . " berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: sub-menu-access");
      exit();
    }
  }
  if (isset($_POST["delete_sub_menu_access"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (sub_menu_access($conn, $validated_post, $action = 'delete') > 0) {
      $message = "Akses sub menu " . $_POST['title'] . " berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: sub-menu-access");
      exit();
    }
  }

  if (isset($_POST["edit_section_header"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (section_header($conn, $validated_post, $action = 'update') > 0) {
      $message = "Section header berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: beranda");
      exit();
    }
  }
  if (isset($_POST["add_section_carousel"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (section_carousel($conn, $validated_post, $action = 'insert') > 0) {
      $message = "Data section carousel berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: beranda");
      exit();
    }
  }
  if (isset($_POST["edit_section_carousel"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (section_carousel($conn, $validated_post, $action = 'update') > 0) {
      $message = "Data section carousel berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: beranda");
      exit();
    }
  }
  if (isset($_POST["delete_section_carousel"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (section_carousel($conn, $validated_post, $action = 'delete') > 0) {
      $message = "Data section carousel berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: beranda");
      exit();
    }
  }
  if (isset($_POST["add_section_faq"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (section_faq($conn, $validated_post, $action = 'insert') > 0) {
      $message = "Data section FAQ berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: beranda");
      exit();
    }
  }
  if (isset($_POST["edit_section_faq"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (section_faq($conn, $validated_post, $action = 'update') > 0) {
      $message = "Data section FAQ berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: beranda");
      exit();
    }
  }
  if (isset($_POST["delete_section_faq"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (section_faq($conn, $validated_post, $action = 'delete') > 0) {
      $message = "Data section FAQ berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: beranda");
      exit();
    }
  }

  $select_kontak = "SELECT * FROM kontak ORDER BY id_kontak DESC";
  $views_kontak = mysqli_query($conn, $select_kontak);
  if (isset($_POST["delete_section_kontak"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (section_kontak($conn, $validated_post, $action = 'delete') > 0) {
      $message = "Data section kontak berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: beranda");
      exit();
    }
  }

  $select_profil = "SELECT * FROM profil";
  $views_profil = mysqli_query($conn, $select_profil);
  if (isset($_POST["edit_menu_profil"])) {
    if (menu_profil($conn, $_POST, $action = 'update') > 0) {
      $message = "Data profil berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: profil");
      exit();
    }
  }

  $select_visi_misi = "SELECT * FROM visi_misi";
  $views_visi_misi = mysqli_query($conn, $select_visi_misi);
  if (isset($_POST["edit_menu_visi_misi"])) {
    if (menu_visi_misi($conn, $_POST, $action = 'update') > 0) {
      $message = "Data visi misi berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: visi-misi");
      exit();
    }
  }

  if (isset($_POST["add_kategori"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (kategori($conn, $validated_post, $action = 'insert') > 0) {
      $message = "Nama kategori berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: kategori");
      exit();
    }
  }
  if (isset($_POST["edit_kategori"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (kategori($conn, $validated_post, $action = 'update') > 0) {
      $message = "Nama kategori berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: kategori");
      exit();
    }
  }
  if (isset($_POST["delete_kategori"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (kategori($conn, $validated_post, $action = 'delete') > 0) {
      $message = "Nama kategori berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: kategori");
      exit();
    }
  }

  if ($id_role === 1) {
    $select_berita_primary = "SELECT berita.*, kategori_berita.nama_kategori, users.name FROM berita JOIN kategori_berita ON berita.id_kategori=kategori_berita.id_kategori JOIN users ON berita.id_user=users.id_user ORDER BY berita.id_berita DESC";
  } else {
    $select_berita_primary = "SELECT berita.*, kategori_berita.nama_kategori, users.name FROM berita JOIN kategori_berita ON berita.id_kategori=kategori_berita.id_kategori JOIN users ON berita.id_user=users.id_user WHERE berita.id_user='$id_user' ORDER BY berita.id_berita DESC";
  }
  $views_berita_primary = mysqli_query($conn, $select_berita_primary);
  if (isset($_POST["add_berita"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (berita($conn, $validated_post, $action = 'insert', $isi_berita = $_POST['isi_berita'], $id_user, $baseURL) > 0) {
      $message = "Berita baru berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: list-berita");
      exit();
    }
  }
  if (isset($_POST["edit_berita"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (berita($conn, $validated_post, $action = 'update', $isi_berita = $_POST['isi_berita'], $id_user, $baseURL) > 0) {
      $message = "Berita berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: list-berita");
      exit();
    }
  }
  if (isset($_POST["delete_berita"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (berita($conn, $validated_post, $action = 'delete', $isi_berita = $_POST['isi_berita'], $id_user, $baseURL) > 0) {
      $message = "Berita berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: list-berita");
      exit();
    }
  }

  if (isset($_POST["add_pengumuman"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (pengumuman($conn, $validated_post, $action = 'insert', $isi_pengumuman = $_POST['isi_pengumuman']) > 0) {
      $message = "Pengumuman baru berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: list-pengumuman");
      exit();
    }
  }
  if (isset($_POST["edit_pengumuman"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (pengumuman($conn, $validated_post, $action = 'update', $isi_pengumuman = $_POST['isi_pengumuman']) > 0) {
      $message = "Pengumuman berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: list-pengumuman");
      exit();
    }
  }
  if (isset($_POST["delete_pengumuman"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (pengumuman($conn, $validated_post, $action = 'delete', $isi_pengumuman = $_POST['isi_pengumuman']) > 0) {
      $message = "Pengumuman berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: list-pengumuman");
      exit();
    }
  }

  if (isset($_POST["add_menu_galeri"])) {
    if (menu_galeri($conn, $_POST, $action = 'insert') > 0) {
      $message = "Gambar baru berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: galeri");
      exit();
    }
  }
  if (isset($_POST["edit_menu_galeri"])) {
    if (menu_galeri($conn, $_POST, $action = 'update') > 0) {
      $message = "Gambar berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: galeri");
      exit();
    }
  }
  if (isset($_POST["delete_menu_galeri"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (menu_galeri($conn, $validated_post, $action = 'delete') > 0) {
      $message = "Gambar berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: galeri");
      exit();
    }
  }

  if (isset($_POST["edit_formulir"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (formulir($conn, $validated_post, $action = 'update') > 0) {
      $message = "Formulir baru berhasil unggah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: formulir");
      exit();
    }
  }

  if ($id_role <= 2) {
    $select_pendaftaran = "SELECT pendaftaran.*, users.password FROM pendaftaran JOIN users ON pendaftaran.id_user=users.id_user WHERE pendaftaran.status_pendaftaran='Belum Diverifikasi' OR pendaftaran.status_pendaftaran='Belum Terverifikasi' ORDER BY pendaftaran.id_pendaftaran ASC";
  } else {
    $select_pendaftaran = "SELECT * FROM pendaftaran WHERE id_user='$id_user' ORDER BY id_pendaftaran ASC";
  }
  $views_pendaftaran = mysqli_query($conn, $select_pendaftaran);
  if (isset($_POST["pendaftaran_verifikasi"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (pendaftaran_verifikasi($conn, $validated_post, $action = 'update') > 0) {
      $message = "Data peserta didik baru telah berhasil di verifikasi.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: pendaftaran");
      exit();
    }
  }
  if (isset($_POST["pendaftaran_belum_verifikasi"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (pendaftaran_verifikasi($conn, $validated_post, $action = 'insert') > 0) {
      $message = "Status data peserta didik baru berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: pendaftaran");
      exit();
    }
  }
  if (isset($_POST["edit_pendaftaran"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (pendaftaran_verifikasi($conn, $validated_post, $action = 'update_peserta') > 0) {
      $message = "Data formulir kamu telah berhasil diupload.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: pendaftaran");
      exit();
    }
  }

  if ($id_role <= 2) {
    $select_hasil_seleksiAdmin = "SELECT * FROM hasil_seleksi JOIN pendaftaran ON hasil_seleksi.id_pendaftaran=pendaftaran.id_pendaftaran ORDER BY hasil_seleksi.id_hasil_seleksi ASC";
  } else if ($id_role == 3) {
    $select_hasil_seleksiAdmin = "SELECT * FROM hasil_seleksi JOIN pendaftaran ON hasil_seleksi.id_pendaftaran=pendaftaran.id_pendaftaran WHERE pendaftaran.id_user='$id_user' ORDER BY hasil_seleksi.id_hasil_seleksi ASC";
  }
  $views_hasil_seleksiAdmin = mysqli_query($conn, $select_hasil_seleksiAdmin);
  if (isset($_POST["hasil_seleksi"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (hasil_seleksi($conn, $validated_post, $action = 'update') > 0) {
      $message = "Data peserta didik baru telah berhasil di seleksi.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: hasil-seleksi");
      exit();
    }
  }

  $select_biaya_pembayaran = "SELECT * FROM biaya_pembayaran";
  $views_biaya_pembayaran = mysqli_query($conn, $select_biaya_pembayaran);
  if (isset($_POST["add_biaya_pembayaran"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (biaya_pembayaran($conn, $validated_post, $action = 'insert') > 0) {
      $message = "Biaya pembayaran baru berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: pembayaran");
      exit();
    }
  }
  if (isset($_POST["edit_biaya_pembayaran"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (biaya_pembayaran($conn, $validated_post, $action = 'update') > 0) {
      $message = "Biaya pembayaran berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: pembayaran");
      exit();
    }
  }
  if (isset($_POST["delete_biaya_pembayaran"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (biaya_pembayaran($conn, $validated_post, $action = 'delete') > 0) {
      $message = "Biaya pembayaran berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: pembayaran");
      exit();
    }
  }

  if ($id_role <= 2) {
    $select_pembayaran = "SELECT * 
                    FROM pembayaran 
                    JOIN hasil_seleksi ON pembayaran.id_hasil_seleksi=hasil_seleksi.id_hasil_seleksi
                    JOIN pendaftaran ON hasil_seleksi.id_pendaftaran=pendaftaran.id_pendaftaran
                    JOIN users ON pendaftaran.id_user=users.id_user
                    ORDER BY pembayaran.id_pembayaran DESC
                  ";
  } else {
    $select_pembayaran = "SELECT * 
                    FROM pembayaran 
                    JOIN hasil_seleksi ON pembayaran.id_hasil_seleksi=hasil_seleksi.id_hasil_seleksi
                    JOIN pendaftaran ON hasil_seleksi.id_pendaftaran=pendaftaran.id_pendaftaran
                    JOIN users ON pendaftaran.id_user=users.id_user
                    WHERE pendaftaran.id_user='$id_user'
                    ORDER BY pembayaran.id_pembayaran DESC
                  ";
  }
  $views_pembayaran = mysqli_query($conn, $select_pembayaran);
  if (isset($_POST["add_pembayaran"])) {
    $waktuBatasPembayaran = strtotime($_POST['batas_pembayaran']);
    $waktuSaatIni = time();
    if ($waktuSaatIni > $waktuBatasPembayaran) {
      $message = "Maaf, batas pembayaran telah lewat. Silakan hubungi bagian administrasi untuk bantuan lebih lanjut.";
      $message_type = "danger";
      alert($message, $message_type);
      return false;
    } else {
      $order_id = $_POST['order_id'];
      header("Location: " . $baseURL . "views/payment/examples/snap/checkout?order_id=$order_id");
      exit();
    }
  }

  $select_guru = "SELECT * FROM guru";
  $views_guru = mysqli_query($conn, $select_guru);
  if (isset($_POST["add_guru"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (guru($conn, $validated_post, $action = 'insert') > 0) {
      $message = "Data guru baru berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: guru");
      exit();
    }
  }
  if (isset($_POST["edit_guru"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (guru($conn, $validated_post, $action = 'update') > 0) {
      $message = "Data guru berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: guru");
      exit();
    }
  }
  if (isset($_POST["delete_guru"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (guru($conn, $validated_post, $action = 'delete') > 0) {
      $message = "Data guru berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: guru");
      exit();
    }
  }

  $select_ekstrakulikuler = "SELECT * FROM ekstrakulikuler";
  $views_ekstrakulikuler = mysqli_query($conn, $select_ekstrakulikuler);
  if (isset($_POST["add_ekstrakulikuler"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (ekstrakulikuler($conn, $validated_post, $action = 'insert') > 0) {
      $message = "Data ekstrakulikuler baru berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: ekstrakulikuler");
      exit();
    }
  }
  if (isset($_POST["delete_ekstrakulikuler"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (ekstrakulikuler($conn, $validated_post, $action = 'delete') > 0) {
      $message = "Data ekstrakulikuler berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: ekstrakulikuler");
      exit();
    }
  }

  if (isset($_POST["edit_sejarah"])) {
    if (sejarah($conn, $_POST, $action = 'update') > 0) {
      $message = "Data sejarah berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: sejarah");
      exit();
    }
  }

  if (isset($_POST["edit_panduan"])) {
    if (panduan($conn, $_POST, $action = 'update') > 0) {
      $message = "Panduan pendaftaran berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: panduan");
      exit();
    }
  }
}
