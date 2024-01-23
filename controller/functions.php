<?php
function valid($conn, $value)
{
  $valid = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $value))));
  return $valid;
}

function separateAlphaNumeric($string)
{
  $alpha = "";
  $numeric = "";
  // Mengiterasi setiap karakter dalam string
  for ($i = 0; $i < strlen($string); $i++) {
    // Memeriksa apakah karakter adalah huruf
    if (ctype_alpha($string[$i])) {
      $alpha .= $string[$i];
    }
    // Memeriksa apakah karakter adalah angka
    if (ctype_digit($string[$i])) {
      $numeric .= $string[$i];
    }
  }
  // Mengembalikan array yang berisi huruf dan angka terpisah
  return array(
    "alpha" => $alpha,
    "numeric" => $numeric
  );
}

function generateToken()
{
  // Generate a random 6-digit number
  $token = mt_rand(100000, 999999);
  return $token;
}

function compressImage($source, $destination, $quality)
{
  // mendapatkan info image
  $imgInfo = getimagesize($source);
  $mime = $imgInfo['mime'];
  // membuat image baru
  switch ($mime) {
      // proses kode memilih tipe tipe image 
    case 'image/jpeg':
      $image = imagecreatefromjpeg($source);
      break;
    case 'image/png':
      $image = imagecreatefrompng($source);
      break;
    default:
      $image = imagecreatefromjpeg($source);
  }

  // Menyimpan image dengan ukuran yang baru
  imagejpeg($image, $destination, $quality);

  // Return image
  return $destination;
}

function compressFile($source, $destination, $quality = 75)
{
  $extension = pathinfo($source, PATHINFO_EXTENSION);

  // Check if it's an image
  $imageExtensions = ['jpeg', 'jpg', 'png', 'gif'];
  if (in_array(strtolower($extension), $imageExtensions)) {
    compressImage($source, $destination, $quality);
  } elseif (strtolower($extension) === 'pdf') {
    compressPdf($source, $destination);
  } elseif (in_array(strtolower($extension), ['doc', 'docx'])) {
    compressDoc($source, $destination);
  } else {
    // If it's neither an image, PDF, nor DOC, simply copy the file
    copy($source, $destination);
  }

  return $destination;
}

function compressPdf($source, $destination)
{
  // Implement PDF compression logic here
  // You may use external libraries like Ghostscript or other tools
  // Example: shell_exec("gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dNOPAUSE -dQUIET -dBATCH -sOutputFile=$destination $source");
  copy($source, $destination);
}

function compressDoc($source, $destination)
{
  // Implement DOC compression logic here
  // You may use external libraries or tools
  // Example: shell_exec("SomeCommandToCompressDoc $source $destination");
  copy($source, $destination);
}

function generateRandomPassword($length = 8)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $password = '';

  for ($i = 0; $i < $length; $i++) {
    $index = rand(0, strlen($characters) - 1);
    $password .= $characters[$index];
  }

  return $password;
}

function generateOrderId()
{
  // Format ID dengan timestamp
  $orderId = date("YmdHis");

  // Menambahkan digit acak (misalnya, 4 digit)
  $randomDigits = mt_rand(1000, 9999);
  $orderId .= $randomDigits;

  return $orderId;
}

function kontak($conn, $data, $action)
{
  if ($action == "insert") {
    $sql = "INSERT INTO kontak(nama,email,subject,pesan) VALUES('$data[nama]','$data[email]','$data[subject]','$data[pesan]')";
  }

  mysqli_query($conn, $sql);
  return mysqli_affected_rows($conn);
}

function komentar($conn, $data, $action)
{
  if ($action == "insert") {
    $sql = "INSERT INTO komentar(nama_komentar,email_komentar,isi_komentar,id_berita) VALUES('$data[nama_komentar]','$data[email_komentar]','$data[isi_komentar]','$data[id_berita]')";
  }

  mysqli_query($conn, $sql);
  return mysqli_affected_rows($conn);
}

function klasifikasiJadwalPendaftaran($tglBuka, $tglTutup, $gelombang)
{
  $sekarang = date('Y-m-d');

  if ($sekarang < $tglBuka) {
    return false;
  } elseif ($sekarang >= $tglBuka && $sekarang <= $tglTutup) {
    return true;
  } elseif ($sekarang > $tglTutup) {
    return "Pendaftaran untuk gelombang $gelombang telah ditutup.";
  }
}

function pendaftaran($conn, $data, $action)
{
  $sekarang = date('Y-m-d');
  $query = "SELECT * FROM jadwal_daftar WHERE '$sekarang' BETWEEN tgl_buka AND tgl_tutup";
  $result = mysqli_query($conn, $query);
  if ($result) {
    $jadwal = mysqli_fetch_assoc($result);
    $id_jd = $jadwal['id_jd'];
    $kuota = $jadwal['kuota'];
    $check_peserta = "SELECT * FROM pendaftaran WHERE id_jd='$id_jd'";
    $check_pesertas = mysqli_query($conn, $check_peserta);
    $data_peserta = mysqli_num_rows($check_pesertas);
    if ($data_peserta > $kuota) {
      $message = "Maaf, saat ini kuota pendaftaran peserta didik baru telah penuh.";
      $message_type = "danger";
      alert($message, $message_type);
      return false;
    }
    $statusPendaftaran = klasifikasiJadwalPendaftaran($jadwal['tgl_buka'], $jadwal['tgl_tutup'], $jadwal['gelombang']);
    if ($statusPendaftaran == false) {
      $message = "Maaf, pendaftaran belum dibuka.";
      $message_type = "danger";
      alert($message, $message_type);
      return false;
    } elseif ($statusPendaftaran == true) {
    } elseif ($statusPendaftaran == false) {
      $message = "Maaf, pendaftaran untuk gelombang " . $jadwal['gelombang'] . " telah ditutup.";
      $message_type = "danger";
      alert($message, $message_type);
      return false;
    }
  }

  if ($action == "insert") {
    $select_pendaftaran = "SELECT * FROM pendaftaran WHERE email='$data[email]'";
    $take_pendaftaran = mysqli_query($conn, $select_pendaftaran);
    if (mysqli_num_rows($take_pendaftaran) > 0) {
      $message = "Maaf, email yang anda masukan sudah terdaftar.";
      $messageType = "danger";
      alert($message, $messageType);
      return false;
    }
    $select_users = "SELECT * FROM users ORDER BY id_user DESC LIMIT 1";
    $take_users = mysqli_query($conn, $select_users);
    if (mysqli_num_rows($take_users) > 0) {
      $row = mysqli_fetch_assoc($take_users);
      $id_user = $row['id_user'] + 1;
    } else {
      $id_user = 1;
    }
    $path = "assets/files/pendaftaran/";
    $fileName = basename($_FILES["formulir"]["name"]);
    $fileName = str_replace(" ", "-", $fileName);
    $fileNameEncrypt = crc32($fileName);
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $imageUploadPath = $path . $fileNameEncrypt . "." . $fileExtension;
    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
    $allowedTypes = array('pdf');

    if (in_array($fileType, $allowedTypes)) {
      compressFile($_FILES["formulir"]["tmp_name"], $imageUploadPath);
      $formulir = $fileNameEncrypt . "." . $fileExtension;
    } else {
      $message = "Maaf, hanya file PDF yang diizinkan.";
      $messageType = "danger";
      alert($message, $messageType);
      return false;
    }

    require_once("controller/mail.php");
    $to       = $data['email'];
    $subject  = "Pendaftaran Peserta Didik Baru " . date("Y") . " - SMAK Wartabakti";
    $message  = "<!doctype html>
    <html>
      <head>
          <meta name='viewport' content='width=device-width'>
          <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
          <title>Pendaftaran Peserta Didik Baru " . date("Y") . "</title>
          <style>
              @media only screen and (max-width: 620px) {
                  table[class='body'] h1 {
                      font-size: 28px !important;
                      margin-bottom: 10px !important;}
                  table[class='body'] p,
                  table[class='body'] ul,
                  table[class='body'] ol,
                  table[class='body'] td,
                  table[class='body'] span,
                  table[class='body'] a {
                      font-size: 16px !important;}
                  table[class='body'] .wrapper,
                  table[class='body'] .article {
                      padding: 10px !important;}
                  table[class='body'] .content {
                      padding: 0 !important;}
                  table[class='body'] .container {
                      padding: 0 !important;
                      width: 100% !important;}
                  table[class='body'] .main {
                      border-left-width: 0 !important;
                      border-radius: 0 !important;
                      border-right-width: 0 !important;}
                  table[class='body'] .btn table {
                      width: 100% !important;}
                  table[class='body'] .btn a {
                      width: 100% !important;}
                  table[class='body'] .img-responsive {
                      height: auto !important;
                      max-width: 100% !important;
                      width: auto !important;}}
              @media all {
                  .ExternalClass {
                      width: 100%;}
                  .ExternalClass,
                  .ExternalClass p,
                  .ExternalClass span,
                  .ExternalClass font,
                  .ExternalClass td,
                  .ExternalClass div {
                      line-height: 100%;}
                  .apple-link a {
                      color: inherit !important;
                      font-family: inherit !important;
                      font-size: inherit !important;
                      font-weight: inherit !important;
                      line-height: inherit !important;
                      text-decoration: none !important;
                  .btn-primary table td:hover {
                      background-color: #d5075d !important;}
                  .btn-primary a:hover {
                      background-color: #000 !important;
                      border-color: #000 !important;
                      color: #fff !important;}}
          </style>
      </head>
      <body class style='background-color: #e1e3e5; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
          <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background-color: #e1e3e5; width: 100%;' width='100%' bgcolor='#e1e3e5'>
          <tr>
              <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
              <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;' width='580' valign='top'>
              <div class='content' style='box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;'>
      
                  <!-- START CENTERED WHITE CONTAINER -->
                  <table role='presentation' class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background: #ffffff; border-radius: 3px; width: 100%;' width='100%'>
      
                  <!-- START MAIN CONTENT AREA -->
                  <tr>
                      <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;' valign='top'>
                      <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                          <tr>
                          <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>
                              <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Hi " . $data['nama_lengkap'] . ",</p>
                              <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Selamat kamu sudah terdaftar sebagai calon peserta didik baru tahun " . date("Y") . ". Saat ini kami sedang mengecek kelengkapan berkas dan apabila diterima kami akan mengirimkan pesan kepada Calon PPDB " . date("Y") . " untuk melanjutkan ke tahap seleksi.</p>
                              <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Terima kasih telah mendaftar di SMAK Wartabakti.</p>
                              <small>Peringatan! Ini adalah pesan otomatis sehingga Anda tidak dapat membalas pesan ini.</small>
                          </td>
                          </tr>
                      </table>
                      </td>
                  </tr>
      
                  <!-- END MAIN CONTENT AREA -->
                  </table>
                  
                  <!-- START FOOTER -->
                  <div class='footer' style='clear: both; margin-top: 10px; text-align: center; width: 100%;'>
                  <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                      <tr>
                      <td class='content-block' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                          <span class='apple-link' style='color: #9a9ea6; font-size: 12px; text-align: center;'>Workarea Jln. S. K. Lerik, Kota Baru, Kupang, NTT, Indonesia. (0380) 8438423</span>
                      </td>
                      </tr>
                      <tr>
                      <td class='content-block powered-by' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                          Powered by <a href='https://www.netmedia-framecode.com' style='color: #9a9ea6; font-size: 12px; text-align: center; text-decoration: none;'>Netmedia Framecode</a>.
                      </td>
                      </tr>
                  </table>
                  </div>
                  <!-- END FOOTER -->
      
              <!-- END CENTERED WHITE CONTAINER -->
              </div>
              </td>
              <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
          </tr>
          </table>
      </body>
    </html>";
    smtp_mail($to, $subject, $message, "", "", 0, 0, true);
    $sql = "INSERT INTO users(id_user,id_active,name,email) VALUES('$id_user','1','$data[nama_lengkap]','$data[email]');";
    $sql .= "INSERT INTO pendaftaran(id_jd, id_user, nama_lengkap, jenis_kelamin, tanggal_lahir, alamat, email, nomor_telepon, asal_sekolah, formulir) VALUES ('$id_jd', '$id_user', '$data[nama_lengkap]', '$data[jenis_kelamin]', '$data[tanggal_lahir]', '$data[alamat]', '$data[email]', '$data[nomor_telepon]', '$data[asal_sekolah]', '$formulir');";
  }

  mysqli_multi_query($conn, $sql);
  return mysqli_affected_rows($conn);
}

if (!isset($_SESSION["project_smak_wartabakti"]["users"])) {
  function register($conn, $data, $action)
  {
    if ($action == "insert") {
      $checkEmail = "SELECT * FROM users WHERE email='$data[email]'";
      $checkEmail = mysqli_query($conn, $checkEmail);
      if (mysqli_num_rows($checkEmail) > 0) {
        $message = "Maaf, email yang anda masukan sudah terdaftar.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      } else {
        if ($data['password'] !== $data['re_password']) {
          $message = "Maaf, konfirmasi password yang anda masukan belum sama.";
          $message_type = "danger";
          alert($message, $message_type);
          return false;
        } else {
          $password = password_hash($data['password'], PASSWORD_DEFAULT);
          $token = generateToken();
          $en_user = password_hash($token, PASSWORD_DEFAULT);
          $en_user = str_replace("$", "", $en_user);
          $en_user = str_replace("/", "", $en_user);
          $en_user = str_replace(".", "", $en_user);
          require_once("mail.php");
          $to       = $data['email'];
          $subject  = "Account Verification - SMAK Wartabakti";
          $message  = "<!doctype html>
          <html>
            <head>
                <meta name='viewport' content='width=device-width'>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
                <title>Account Verification</title>
                <style>
                    @media only screen and (max-width: 620px) {
                        table[class='body'] h1 {
                            font-size: 28px !important;
                            margin-bottom: 10px !important;}
                        table[class='body'] p,
                        table[class='body'] ul,
                        table[class='body'] ol,
                        table[class='body'] td,
                        table[class='body'] span,
                        table[class='body'] a {
                            font-size: 16px !important;}
                        table[class='body'] .wrapper,
                        table[class='body'] .article {
                            padding: 10px !important;}
                        table[class='body'] .content {
                            padding: 0 !important;}
                        table[class='body'] .container {
                            padding: 0 !important;
                            width: 100% !important;}
                        table[class='body'] .main {
                            border-left-width: 0 !important;
                            border-radius: 0 !important;
                            border-right-width: 0 !important;}
                        table[class='body'] .btn table {
                            width: 100% !important;}
                        table[class='body'] .btn a {
                            width: 100% !important;}
                        table[class='body'] .img-responsive {
                            height: auto !important;
                            max-width: 100% !important;
                            width: auto !important;}}
                    @media all {
                        .ExternalClass {
                            width: 100%;}
                        .ExternalClass,
                        .ExternalClass p,
                        .ExternalClass span,
                        .ExternalClass font,
                        .ExternalClass td,
                        .ExternalClass div {
                            line-height: 100%;}
                        .apple-link a {
                            color: inherit !important;
                            font-family: inherit !important;
                            font-size: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                            text-decoration: none !important;
                        .btn-primary table td:hover {
                            background-color: #d5075d !important;}
                        .btn-primary a:hover {
                            background-color: #000 !important;
                            border-color: #000 !important;
                            color: #fff !important;}}
                </style>
            </head>
            <body class style='background-color: #e1e3e5; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background-color: #e1e3e5; width: 100%;' width='100%' bgcolor='#e1e3e5'>
                <tr>
                    <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                    <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;' width='580' valign='top'>
                    <div class='content' style='box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;'>
            
                        <!-- START CENTERED WHITE CONTAINER -->
                        <table role='presentation' class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background: #ffffff; border-radius: 3px; width: 100%;' width='100%'>
            
                        <!-- START MAIN CONTENT AREA -->
                        <tr>
                            <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;' valign='top'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                                <tr>
                                <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Hi " . $data['name'] . ",</p>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Selamat akun kamu sudah terdaftar, tinggal satu langkah lagi kamu sudah bisa menggunakan akun. Silakan salin kode token dibawah ini untuk memverifikasi akun kamu.</p>
                                    <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='btn btn-primary' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; box-sizing: border-box; min-width: 100%; width: 100%;' width='100%'>
                                    <tbody>
                                        <tr>
                                        <td align='left' style='font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;' valign='top'>
                                            <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: auto; width: auto;'>
                                            <tbody>
                                                <tr>
                                                <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: center; font-weight: bold;' valign='top' bgcolor='#ffffff' align='center'>" . $token . "</td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Terima kasih telah mendaftar di SMAK Wartabakti.</p>
                                    <small>Peringatan! Ini adalah pesan otomatis sehingga Anda tidak dapat membalas pesan ini.</small>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
            
                        <!-- END MAIN CONTENT AREA -->
                        </table>
                        
                        <!-- START FOOTER -->
                        <div class='footer' style='clear: both; margin-top: 10px; text-align: center; width: 100%;'>
                        <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                            <tr>
                            <td class='content-block' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                                <span class='apple-link' style='color: #9a9ea6; font-size: 12px; text-align: center;'>Workarea Jln. S. K. Lerik, Kota Baru, Kupang, NTT, Indonesia. (0380) 8438423</span>
                            </td>
                            </tr>
                            <tr>
                            <td class='content-block powered-by' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                                Powered by <a href='https://www.netmedia-framecode.com' style='color: #9a9ea6; font-size: 12px; text-align: center; text-decoration: none;'>Netmedia Framecode</a>.
                            </td>
                            </tr>
                        </table>
                        </div>
                        <!-- END FOOTER -->
            
                    <!-- END CENTERED WHITE CONTAINER -->
                    </div>
                    </td>
                    <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                </tr>
                </table>
            </body>
          </html>";
          smtp_mail($to, $subject, $message, "", "", 0, 0, true);
          $_SESSION['data_auth'] = ['en_user' => $en_user];
          $sql = "INSERT INTO users(en_user,token,name,email,password) VALUES('$en_user','$token','$data[name]','$data[email]','$password')";
        }
      }
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function re_verifikasi($conn, $data, $action)
  {
    if ($action == "update") {
      $checkEN = "SELECT * FROM users WHERE en_user='$data[en_user]'";
      $checkEN = mysqli_query($conn, $checkEN);
      if (mysqli_num_rows($checkEN) == 0) {
        $message = "Maaf, sepertinya ada kesalahan saat mendaftar.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      } else if (mysqli_num_rows($checkEN) > 0) {
        $row = mysqli_fetch_assoc($checkEN);
        $name = $row['name'];
        $email = $row['email'];
        $token = generateToken();
        $reen_user = password_hash($token, PASSWORD_DEFAULT);
        $reen_user = str_replace("$", "", $reen_user);
        $reen_user = str_replace("/", "", $reen_user);
        $reen_user = str_replace(".", "", $reen_user);
        require_once("mail.php");
        $to       = $email;
        $subject  = "Account Verification - SMAK Wartabakti";
        $message  = "<!doctype html>
        <html>
          <head>
              <meta name='viewport' content='width=device-width'>
              <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
              <title>Account Verification</title>
              <style>
                  @media only screen and (max-width: 620px) {
                      table[class='body'] h1 {
                          font-size: 28px !important;
                          margin-bottom: 10px !important;}
                      table[class='body'] p,
                      table[class='body'] ul,
                      table[class='body'] ol,
                      table[class='body'] td,
                      table[class='body'] span,
                      table[class='body'] a {
                          font-size: 16px !important;}
                      table[class='body'] .wrapper,
                      table[class='body'] .article {
                          padding: 10px !important;}
                      table[class='body'] .content {
                          padding: 0 !important;}
                      table[class='body'] .container {
                          padding: 0 !important;
                          width: 100% !important;}
                      table[class='body'] .main {
                          border-left-width: 0 !important;
                          border-radius: 0 !important;
                          border-right-width: 0 !important;}
                      table[class='body'] .btn table {
                          width: 100% !important;}
                      table[class='body'] .btn a {
                          width: 100% !important;}
                      table[class='body'] .img-responsive {
                          height: auto !important;
                          max-width: 100% !important;
                          width: auto !important;}}
                  @media all {
                      .ExternalClass {
                          width: 100%;}
                      .ExternalClass,
                      .ExternalClass p,
                      .ExternalClass span,
                      .ExternalClass font,
                      .ExternalClass td,
                      .ExternalClass div {
                          line-height: 100%;}
                      .apple-link a {
                          color: inherit !important;
                          font-family: inherit !important;
                          font-size: inherit !important;
                          font-weight: inherit !important;
                          line-height: inherit !important;
                          text-decoration: none !important;
                      .btn-primary table td:hover {
                          background-color: #d5075d !important;}
                      .btn-primary a:hover {
                          background-color: #000 !important;
                          border-color: #000 !important;
                          color: #fff !important;}}
              </style>
          </head>
          <body class style='background-color: #e1e3e5; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
              <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background-color: #e1e3e5; width: 100%;' width='100%' bgcolor='#e1e3e5'>
              <tr>
                  <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                  <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;' width='580' valign='top'>
                  <div class='content' style='box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;'>
          
                      <!-- START CENTERED WHITE CONTAINER -->
                      <table role='presentation' class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background: #ffffff; border-radius: 3px; width: 100%;' width='100%'>
          
                      <!-- START MAIN CONTENT AREA -->
                      <tr>
                          <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;' valign='top'>
                          <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                              <tr>
                              <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>
                                  <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Hi " . $name . ",</p>
                                  <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Selamat akun kamu sudah terdaftar, tinggal satu langkah lagi kamu sudah bisa menggunakan akun. Silakan salin kode token dibawah ini untuk memverifikasi akun kamu.</p>
                                  <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='btn btn-primary' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; box-sizing: border-box; min-width: 100%; width: 100%;' width='100%'>
                                  <tbody>
                                      <tr>
                                      <td align='left' style='font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;' valign='top'>
                                          <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: auto; width: auto;'>
                                          <tbody>
                                              <tr>
                                              <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: center; font-weight: bold;' valign='top' bgcolor='#ffffff' align='center'>" . $token . "</td>
                                              </tr>
                                          </tbody>
                                          </table>
                                      </td>
                                      </tr>
                                  </tbody>
                                  </table>
                                  <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Terima kasih telah mendaftar di SMAK Wartabakti.</p>
                                  <small>Peringatan! Ini adalah pesan otomatis sehingga Anda tidak dapat membalas pesan ini.</small>
                              </td>
                              </tr>
                          </table>
                          </td>
                      </tr>
          
                      <!-- END MAIN CONTENT AREA -->
                      </table>
                      
                      <!-- START FOOTER -->
                      <div class='footer' style='clear: both; margin-top: 10px; text-align: center; width: 100%;'>
                      <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                          <tr>
                          <td class='content-block' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                              <span class='apple-link' style='color: #9a9ea6; font-size: 12px; text-align: center;'>Workarea Jln. S. K. Lerik, Kota Baru, Kupang, NTT, Indonesia. (0380) 8438423</span>
                          </td>
                          </tr>
                          <tr>
                          <td class='content-block powered-by' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                              Powered by <a href='https://www.netmedia-framecode.com' style='color: #9a9ea6; font-size: 12px; text-align: center; text-decoration: none;'>Netmedia Framecode</a>.
                          </td>
                          </tr>
                      </table>
                      </div>
                      <!-- END FOOTER -->
          
                  <!-- END CENTERED WHITE CONTAINER -->
                  </div>
                  </td>
                  <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
              </tr>
              </table>
          </body>
        </html>";
        smtp_mail($to, $subject, $message, "", "", 0, 0, true);
        $_SESSION['data_auth'] = ['en_user' => $reen_user];
        $sql = "UPDATE users SET en_user='$reen_user', token='$token', updated_at=current_timestamp WHERE en_user='$data[en_user]'";
      }
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function verifikasi($conn, $data, $action)
  {
    if ($action == "update") {
      $checkEN = "SELECT * FROM users WHERE en_user='$data[en_user]'";
      $checkEN = mysqli_query($conn, $checkEN);
      if (mysqli_num_rows($checkEN) == 0) {
        $message = "Maaf, sepertinya ada kesalahan saat mendaftar.";
        $message_type = "warning";
        alert($message, $message_type);
        return false;
      } else if (mysqli_num_rows($checkEN) > 0) {
        $row = mysqli_fetch_assoc($checkEN);
        $token_primary = $row['token'];
        $updated_at = strtotime($row['updated_at']);
        $current_time = time();
        if (($current_time - $updated_at) > (5 * 60)) {
          $message = "Maaf, waktu untuk verifikasi telah habis.";
          $message_type = "warning";
          alert($message, $message_type);
          $_SESSION["project_smak_wartabakti"] = [
            "message-warning" => "Maaf, waktu untuk verifikasi telah habis.",
            "time-message" => time()
          ];
          return false;
        }
        if ($data['token'] !== $token_primary) {
          $message = "Maaf, kode token yang anda masukan masih salah.";
          $message_type = "warning";
          alert($message, $message_type);
          return false;
        }
        $sql = "UPDATE users SET id_active='1', updated_at=current_timestamp WHERE en_user='$data[en_user]'";
      }
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function forgot_password($conn, $data, $action, $baseURL)
  {
    if ($action == "update") {
      $checkEmail = "SELECT * FROM users WHERE email='$data[email]'";
      $checkEmail = mysqli_query($conn, $checkEmail);
      if (mysqli_num_rows($checkEmail) === 0) {
        $message = "Maaf, email yang anda masukan belum terdaftar.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      } else {
        $row = mysqli_fetch_assoc($checkEmail);
        $name = valid($conn, $row['name']);
        $token = generateToken();
        $en_user = password_hash($token, PASSWORD_DEFAULT);
        $en_user = str_replace("$", "", $en_user);
        $en_user = str_replace("/", "", $en_user);
        $en_user = str_replace(".", "", $en_user);
        require_once("mail.php");
        $to       = $data['email'];
        $subject  = "Reset password - SMAK Wartabakti";
        $message  = "<!doctype html>
        <html>
          <head>
              <meta name='viewport' content='width=device-width'>
              <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
              <title>Reset password</title>
              <style>
                  @media only screen and (max-width: 620px) {
                      table[class='body'] h1 {
                          font-size: 28px !important;
                          margin-bottom: 10px !important;}
                      table[class='body'] p,
                      table[class='body'] ul,
                      table[class='body'] ol,
                      table[class='body'] td,
                      table[class='body'] span,
                      table[class='body'] a {
                          font-size: 16px !important;}
                      table[class='body'] .wrapper,
                      table[class='body'] .article {
                          padding: 10px !important;}
                      table[class='body'] .content {
                          padding: 0 !important;}
                      table[class='body'] .container {
                          padding: 0 !important;
                          width: 100% !important;}
                      table[class='body'] .main {
                          border-left-width: 0 !important;
                          border-radius: 0 !important;
                          border-right-width: 0 !important;}
                      table[class='body'] .btn table {
                          width: 100% !important;}
                      table[class='body'] .btn a {
                          width: 100% !important;}
                      table[class='body'] .img-responsive {
                          height: auto !important;
                          max-width: 100% !important;
                          width: auto !important;}}
                  @media all {
                      .ExternalClass {
                          width: 100%;}
                      .ExternalClass,
                      .ExternalClass p,
                      .ExternalClass span,
                      .ExternalClass font,
                      .ExternalClass td,
                      .ExternalClass div {
                          line-height: 100%;}
                      .apple-link a {
                          color: inherit !important;
                          font-family: inherit !important;
                          font-size: inherit !important;
                          font-weight: inherit !important;
                          line-height: inherit !important;
                          text-decoration: none !important;
                      .btn-primary table td:hover {
                          background-color: #d5075d !important;}
                      .btn-primary a:hover {
                          background-color: #000 !important;
                          border-color: #000 !important;
                          color: #fff !important;}}
              </style>
          </head>
          <body class style='background-color: #e1e3e5; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
              <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background-color: #e1e3e5; width: 100%;' width='100%' bgcolor='#e1e3e5'>
              <tr>
                  <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                  <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;' width='580' valign='top'>
                  <div class='content' style='box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;'>
          
                      <!-- START CENTERED WHITE CONTAINER -->
                      <table role='presentation' class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background: #ffffff; border-radius: 3px; width: 100%;' width='100%'>
          
                      <!-- START MAIN CONTENT AREA -->
                      <tr>
                          <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;' valign='top'>
                          <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                              <tr>
                              <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>
                                  <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Hi " . $name . ",</p>
                                  <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Pesan ini secara otomatis dikirimkan kepada anda karena anda meminta untuk mereset kata sandi. Jika anda tidak sama sekali ingin mereset atau bukan anda yang ingin mereset abaikan saja. Klik tombol reset berikut untuk melanjutkan:</p>
                                  <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='btn btn-primary' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; box-sizing: border-box; min-width: 100%; width: 100%;' width='100%'>
                                  <tbody>
                                      <tr>
                                      <td align='left' style='font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;' valign='top'>
                                          <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: auto; width: auto;'>
                                          <tbody>
                                              <tr>
                                                <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: center;' valign='top' bgcolor='#ffffff' align='center'>
                                                  <a href='" . $baseURL . "auth/new-password?en=" . $en_user . "' target='_blank' style='background-color: #ffffff; border: solid 1px #000; border-radius: 5px; box-sizing: border-box; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-decoration: none; text-transform: capitalize; border-color: #000; color: #000;'>Atur Ulang Kata Sandi</a> 
                                                </td>
                                              </tr>
                                          </tbody>
                                          </table>
                                      </td>
                                      </tr>
                                  </tbody>
                                  </table>
                                  <small>Peringatan! Ini adalah pesan otomatis sehingga Anda tidak dapat membalas pesan ini.</small>
                              </td>
                              </tr>
                          </table>
                          </td>
                      </tr>
          
                      <!-- END MAIN CONTENT AREA -->
                      </table>
                      
                      <!-- START FOOTER -->
                      <div class='footer' style='clear: both; margin-top: 10px; text-align: center; width: 100%;'>
                      <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                          <tr>
                          <td class='content-block' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                              <span class='apple-link' style='color: #9a9ea6; font-size: 12px; text-align: center;'>Workarea Jln. S. K. Lerik, Kota Baru, Kupang, NTT, Indonesia. (0380) 8438423</span>
                          </td>
                          </tr>
                          <tr>
                          <td class='content-block powered-by' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                              Powered by <a href='https://www.netmedia-framecode.com' style='color: #9a9ea6; font-size: 12px; text-align: center; text-decoration: none;'>Netmedia Framecode</a>.
                          </td>
                          </tr>
                      </table>
                      </div>
                      <!-- END FOOTER -->
          
                  <!-- END CENTERED WHITE CONTAINER -->
                  </div>
                  </td>
                  <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
              </tr>
              </table>
          </body>
        </html>";
        smtp_mail($to, $subject, $message, "", "", 0, 0, true);
        $sql = "UPDATE users SET en_user='$en_user', token='$token', updated_at=current_timestamp WHERE email='$data[email]'";
      }
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function new_password($conn, $data, $action)
  {
    if ($action == "update") {
      $lenght = strlen($data['password']);
      if ($lenght < 8) {
        $message = "Maaf, password yang anda masukan harus 8 digit atau lebih.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      } else if ($data['password'] !== $data['re_password']) {
        $message = "Maaf, konfirmasi password yang anda masukan belum sama.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      } else {
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password='$password' WHERE email='$data[email]'";
      }
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function login($conn, $data)
  {
    // check account
    $checkAccount = mysqli_query($conn, "SELECT * FROM users JOIN user_role ON users.id_role=user_role.id_role WHERE users.email='$data[email]'");
    if (mysqli_num_rows($checkAccount) == 0) {
      $message = "Maaf, akun yang anda masukan belum terdaftar.";
      $message_type = "danger";
      alert($message, $message_type);
      return false;
    } else if (mysqli_num_rows($checkAccount) > 0) {
      $row = mysqli_fetch_assoc($checkAccount);
      if (password_verify($data['password'], $row["password"])) {
        $_SESSION["project_smak_wartabakti"]["users"] = [
          "id" => $row["id_user"],
          "id_role" => $row["id_role"],
          "role" => $row["role"],
          "email" => $row["email"],
          "name" => $row["name"],
          "image" => $row["image"]
        ];
        return mysqli_affected_rows($conn);
      } else {
        $message = "Maaf, kata sandi yang anda masukan salah.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      }
    }
  }
}

if (isset($_SESSION["project_smak_wartabakti"]["users"])) {

  function profil($conn, $data, $action, $id_user)
  {
    if ($action == "update") {
      $path = "../assets/img/profil/";
      if (!empty($_FILES['image']["name"])) {
        $fileName = basename($_FILES["image"]["name"]);
        $fileName = str_replace(" ", "-", $fileName);
        $fileName_encrypt = crc32($fileName);
        $ekstensiGambar = explode('.', $fileName);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        $imageUploadPath = $path . $fileName_encrypt . "." . $ekstensiGambar;
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
          $imageTemp = $_FILES["image"]["tmp_name"];
          compressImage($imageTemp, $imageUploadPath, 75);
          $image = $fileName_encrypt . "." . $ekstensiGambar;
        } else {
          $message = "Maaf, hanya file gambar JPG, JPEG, dan PNG yang diizinkan.";
          $message_type = "danger";
          alert($message, $message_type);
          return false;
        }
      }
      if (!empty($_FILES['image']["name"])) {
        $unwanted_characters = "../assets/img/profil/";
        $remove_image = str_replace($unwanted_characters, "", $data['imageOld']);
        if ($remove_image != "default.svg") {
          unlink($path . $remove_image);
        }
      } else if (empty($_FILE['image']["name"])) {
        $image = $data['imageOld'];
      }
      if (!empty($data['password'])) {
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE users SET name='$data[name]', image='$image', password='$password' WHERE id_user='$id_user'";
      } else {
        $sql = "UPDATE users SET name='$data[name]', image='$image' WHERE id_user='$id_user'";
      }
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function setting($conn, $data, $action)
  {

    if ($action == "update") {
      $path = "../assets/img/auth/";
      if (!empty($_FILES['image']["name"])) {
        $fileName = basename($_FILES["image"]["name"]);
        $fileName = str_replace(" ", "-", $fileName);
        $fileName_encrypt = crc32($fileName);
        $ekstensiGambar = explode('.', $fileName);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        $imageUploadPath = $path . $fileName_encrypt . "." . $ekstensiGambar;
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
          $imageTemp = $_FILES["image"]["tmp_name"];
          compressImage($imageTemp, $imageUploadPath, 75);
          $image = $fileName_encrypt . "." . $ekstensiGambar;
        } else {
          $message = "Maaf, hanya file gambar JPG, JPEG, dan PNG yang diizinkan.";
          $message_type = "danger";
          alert($message, $message_type);
          return false;
        }
      }
      if (!empty($_FILES['image']["name"])) {
        $unwanted_characters = "../assets/img/auth/";
        $remove_image = str_replace($unwanted_characters, "", $data['imageOld']);
        unlink($path . $remove_image);
      } else if (empty($_FILE['image']["name"])) {
        $image = $data['imageOld'];
      }
      $sql = "UPDATE auth SET image='$image', bg='$data[bg]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function users($conn, $data, $action)
  {

    if ($action == "update") {
      $sql = "UPDATE users SET id_role='$data[id_role]', id_active='$data[id_active]' WHERE id_user='$data[id_user]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function role($conn, $data, $action)
  {
    if ($action == "insert") {
      $checkRole = "SELECT * FROM user_role WHERE role LIKE '%$data[role]%'";
      $checkRole = mysqli_query($conn, $checkRole);
      if (mysqli_num_rows($checkRole) > 0) {
        $message = "Maaf, role yang anda masukan sudah ada.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      } else {
        $sql = "INSERT INTO user_role(role) VALUES('$data[role]')";
      }
    }

    if ($action == "update") {
      if ($data['role'] !== $data['roleOld']) {
        $checkRole = "SELECT * FROM user_role WHERE role LIKE '%$data[role]%'";
        $checkRole = mysqli_query($conn, $checkRole);
        if (mysqli_num_rows($checkRole) > 0) {
          $message = "Maaf, role yang anda masukan sudah ada.";
          $message_type = "danger";
          alert($message, $message_type);
          return false;
        }
      }
      $sql = "UPDATE user_role SET role='$data[role]' WHERE id_role='$data[id_role]'";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM user_role WHERE id_role='$data[id_role]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function menu($conn, $data, $action)
  {
    if ($action == "insert") {
      $checkMenu = "SELECT * FROM user_menu WHERE menu='$data[menu]'";
      $checkMenu = mysqli_query($conn, $checkMenu);
      if (mysqli_num_rows($checkMenu) > 0) {
        $message = "Maaf, menu yang anda masukan sudah ada.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      } else {
        $sql = "INSERT INTO user_menu(menu) VALUES('$data[menu]')";
      }
    }

    if ($action == "update") {
      if ($data['menu'] !== $data['menuOld']) {
        $checkMenu = "SELECT * FROM user_menu WHERE menu='$data[menu]'";
        $checkMenu = mysqli_query($conn, $checkMenu);
        if (mysqli_num_rows($checkMenu) > 0) {
          $message = "Maaf, menu yang anda masukan sudah ada.";
          $message_type = "danger";
          alert($message, $message_type);
          return false;
        }
      }
      $sql = "UPDATE user_menu SET menu='$data[menu]' WHERE id_menu='$data[id_menu]'";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM user_menu WHERE id_menu='$data[id_menu]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function sub_menu($conn, $data, $action, $baseURL)
  {
    $url = strtolower(str_replace(" ", "-", $data['title']));

    if ($action == "insert") {
      $checkSubMenu = "SELECT * FROM user_sub_menu WHERE title='$data[title]'";
      $checkSubMenu = mysqli_query($conn, $checkSubMenu);
      if (mysqli_num_rows($checkSubMenu) > 0) {
        $message = "Maaf, nama sub menu yang anda masukan sudah ada.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      } else {
        $file = fopen("../views/" . $url . ".php", "w");
        fwrite($file, '<?php require_once("../controller/script.php");
        $_SESSION["project_smak_wartabakti"]["name_page"] = "' . $data['title'] . '";
        require_once("../templates/views_top.php"); ?>
        
        <!-- Begin Page Content -->
        <div class="container-fluid">
        
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_smak_wartabakti"]["name_page"] ?></h1>
          </div>
        
          <!-- Mulai buatlah lembar kerja anda disini! -->
        
        </div>
        <!-- /.container-fluid -->
        
        <?php require_once("../templates/views_bottom.php") ?>
        ');
        fclose($file);
        $sql = "INSERT INTO user_sub_menu(id_menu,id_active,title,url,icon) VALUES('$data[id_menu]','$data[id_active]','$data[title]','$url','$data[icon]')";
      }
    }

    if ($action == "update") {
      if ($data['title'] !== $data['titleOld']) {
        $checkSubMenu = "SELECT * FROM user_sub_menu WHERE title='$data[title]'";
        $checkSubMenu = mysqli_query($conn, $checkSubMenu);
        if (mysqli_num_rows($checkSubMenu) > 0) {
          $message = "Maaf, nama sub menu yang anda masukan sudah ada.";
          $message_type = "danger";
          alert($message, $message_type);
          return false;
        }
      }
      $sql = "UPDATE user_sub_menu SET id_menu='$data[id_menu]', id_active='$data[id_active]', title='$data[title]', url='$url', icon='$data[icon]' WHERE id_sub_menu='$data[id_sub_menu]'";
    }

    if ($action == "delete") {
      unlink("../views/" . $url . ".php");
      $sql = "DELETE FROM user_sub_menu WHERE id_sub_menu='$data[id_sub_menu]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function menu_access($conn, $data, $action)
  {
    if ($action == "insert") {
      $sql = "INSERT INTO user_access_menu(id_role,id_menu) VALUES('$data[id_role]','$data[id_menu]')";
    }

    if ($action == "update") {
      $sql = "UPDATE user_access_menu SET id_role='$data[id_role]', id_menu='$data[id_menu]' WHERE id_access_menu='$data[id_access_menu]'";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM user_access_menu WHERE id_access_menu='$data[id_access_menu]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function sub_menu_access($conn, $data, $action)
  {
    if ($action == "insert") {
      $sql = "INSERT INTO user_access_sub_menu(id_role,id_sub_menu) VALUES('$data[id_role]','$data[id_sub_menu]')";
    }

    if ($action == "update") {
      $sql = "UPDATE user_access_sub_menu SET id_role='$data[id_role]', id_sub_menu='$data[id_sub_menu]' WHERE id_access_sub_menu='$data[id_access_sub_menu]'";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM user_access_sub_menu WHERE id_access_sub_menu='$data[id_access_sub_menu]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function section_header($conn, $data, $action)
  {
    if ($action == "update") {
      $sql = "UPDATE header SET nama='$data[nama]', deskripsi='$data[deskripsi]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function section_carousel($conn, $data, $action)
  {
    $path = "../assets/img/";
    if ($action == "insert") {
      $fileName = basename($_FILES["icon"]["name"]);
      $fileName = str_replace(" ", "-", $fileName);
      $fileName_encrypt = crc32($fileName);
      $ekstensiGambar = explode('.', $fileName);
      $ekstensiGambar = strtolower(end($ekstensiGambar));
      $imageUploadPath = $path . "icon_" . $fileName_encrypt . "." . $ekstensiGambar;
      $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
      $allowTypes = array('png');
      if (in_array($fileType, $allowTypes)) {
        $imageTemp = $_FILES["icon"]["tmp_name"];
        compressImage($imageTemp, $imageUploadPath, 75);
        $icon = "icon_" . $fileName_encrypt . "." . $ekstensiGambar;
      } else {
        $message = "Maaf, hanya file gambar PNG yang diizinkan.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      }
      $sql = "INSERT INTO carousel(nama,deskripsi,icon) VALUES('$data[nama]','$data[deskripsi]','$icon')";
    }

    if ($action == "update") {
      if (!empty($_FILES['icon']["name"])) {
        $fileName = basename($_FILES["icon"]["name"]);
        $fileName = str_replace(" ", "-", $fileName);
        $fileName_encrypt = crc32($fileName);
        $ekstensiGambar = explode('.', $fileName);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        $imageUploadPath = $path . $fileName_encrypt . "." . $ekstensiGambar;
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
          $imageTemp = $_FILES["icon"]["tmp_name"];
          compressImage($imageTemp, $imageUploadPath, 75);
          $icon = $fileName_encrypt . "." . $ekstensiGambar;
          unlink($path . $data['iconOld']);
        } else {
          $message = "Maaf, hanya file gambar JPG, JPEG, dan PNG yang diizinkan.";
          $message_type = "danger";
          alert($message, $message_type);
          return false;
        }
      } else if (empty($_FILE['icon']["name"])) {
        $icon = $data['iconOld'];
      }
      $sql = "UPDATE carousel SET nama='$data[nama]', deskripsi='$data[deskripsi]', icon='$icon' WHERE id_carousel='$data[id_carousel]'";
    }

    if ($action == "delete") {
      unlink($path . $data['icon']);
      $sql = "DELETE FROM carousel WHERE id_carousel='$data[id_carousel]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function section_faq($conn, $data, $action)
  {
    if ($action == "insert") {
      $sql = "INSERT INTO faq(pertanyaan,jawaban) VALUES('$data[pertanyaan]','$data[jawaban]')";
    }

    if ($action == "update") {
      $sql = "UPDATE faq SET pertanyaan='$data[pertanyaan]', jawaban='$data[jawaban]' WHERE id_faq='$data[id_faq]'";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM faq WHERE id_faq='$data[id_faq]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function section_kontak($conn, $data, $action)
  {
    if ($action == "delete") {
      $sql = "DELETE FROM kontak WHERE id_kontak='$data[id_kontak]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function menu_profil($conn, $data, $action)
  {
    if ($action == "update") {
      $sql = "UPDATE profil SET deskripsi='$data[deskripsi]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function menu_visi_misi($conn, $data, $action)
  {
    if ($action == "update") {
      $sql = "UPDATE visi_misi SET deskripsi='$data[deskripsi]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function kategori($conn, $data, $action)
  {
    if ($action == "insert") {
      $sql = "INSERT INTO kategori_berita(nama_kategori) VALUES('$data[nama_kategori]')";
    }

    if ($action == "update") {
      $sql = "UPDATE kategori_berita SET nama_kategori='$data[nama_kategori]' WHERE id_kategori='$data[id_kategori]'";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM kategori_berita WHERE id_kategori='$data[id_kategori]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function berita($conn, $data, $action, $isi_berita, $id_user, $baseURL)
  {
    $path = "../assets/img/berita/";
    $slug = strtolower(str_replace(" ", "_", $data['judul_berita']));

    if ($action == "insert") {
      $fileName = basename($_FILES["img_berita"]["name"]);
      $fileName = str_replace(" ", "-", $fileName);
      $fileName_encrypt = crc32($fileName);
      $ekstensiGambar = explode('.', $fileName);
      $ekstensiGambar = strtolower(end($ekstensiGambar));
      $imageUploadPath = $path . $fileName_encrypt . "." . $ekstensiGambar;
      $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
      $allowTypes = array('jpg', 'jpeg', 'png');
      if (in_array($fileType, $allowTypes)) {
        $imageTemp = $_FILES["img_berita"]["tmp_name"];
        compressImage($imageTemp, $imageUploadPath, 75);
        $img_berita = $fileName_encrypt . "." . $ekstensiGambar;
      } else {
        $message = "Maaf, hanya file format gambar JPG, JPEG dan PNG yang diizinkan.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      }
      $sql = "INSERT INTO berita(img_berita,judul_berita,isi_berita,slug,id_kategori,id_user) VALUES('$img_berita','$data[judul_berita]','$isi_berita','$slug','$data[id_kategori]','$id_user')";
    }

    if ($action == "update") {
      if (!empty($_FILES['img_berita']["name"])) {
        $fileName = basename($_FILES["img_berita"]["name"]);
        $fileName = str_replace(" ", "-", $fileName);
        $fileName_encrypt = crc32($fileName);
        $ekstensiGambar = explode('.', $fileName);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        $imageUploadPath = $path . $fileName_encrypt . "." . $ekstensiGambar;
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
          $imageTemp = $_FILES["img_berita"]["tmp_name"];
          compressImage($imageTemp, $imageUploadPath, 75);
          $img_berita = $fileName_encrypt . "." . $ekstensiGambar;
          unlink($path . $data['img_beritaOld']);
        } else {
          $message = "Maaf, hanya file gambar JPG, JPEG, dan PNG yang diizinkan.";
          $message_type = "danger";
          alert($message, $message_type);
          return false;
        }
      } else if (empty($_FILE['img_berita']["name"])) {
        $img_berita = $data['img_beritaOld'];
      }
      $sql = "UPDATE berita SET img_berita='$img_berita', judul_berita='$data[judul_berita]', isi_berita='$isi_berita', slug='$slug', id_kategori='$data[id_kategori]' WHERE id_berita='$data[id_berita]'";
    }

    if ($action == "delete") {
      unlink($path . $data['img_berita']);
      $sql = "DELETE FROM berita WHERE id_berita='$data[id_berita]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function pengumuman($conn, $data, $action, $isi_pengumuman)
  {
    if ($action == "insert") {
      $sql = "INSERT INTO pengumuman(judul,isi_pengumuman) VALUES('$data[judul]','$isi_pengumuman')";
    }

    if ($action == "update") {
      $sql = "UPDATE pengumuman SET judul='$data[judul]', isi_pengumuman='$isi_pengumuman' WHERE id_pengumuman='$data[id_pengumuman]'";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM pengumuman WHERE id_pengumuman='$data[id_pengumuman]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function menu_galeri($conn, $data, $action)
  {
    $path = "../assets/img/";

    if ($action == "insert") {
      $fileName = basename($_FILES["image"]["name"]);
      $fileName = str_replace(" ", "-", $fileName);
      $fileName_encrypt = crc32($fileName);
      $ekstensiGambar = explode('.', $fileName);
      $ekstensiGambar = strtolower(end($ekstensiGambar));
      $imageUploadPath = $path . "galeri_" . $fileName_encrypt . "." . $ekstensiGambar;
      $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
      $allowTypes = array('jpg', 'png', 'jpeg');
      if (in_array($fileType, $allowTypes)) {
        $imageTemp = $_FILES["image"]["tmp_name"];
        compressImage($imageTemp, $imageUploadPath, 75);
        $image = "galeri_" . $fileName_encrypt . "." . $ekstensiGambar;
      } else {
        $message = "Maaf, hanya file gambar JPG, JPEG, dan PNG yang diizinkan.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      }
      $sql = "INSERT INTO galeri(image,ket) VALUES('$image','$data[ket]')";
    }

    if ($action == "update") {
      if (!empty($_FILES['image']["name"])) {
        $fileName = basename($_FILES["image"]["name"]);
        $fileName = str_replace(" ", "-", $fileName);
        $fileName_encrypt = crc32($fileName);
        $ekstensiGambar = explode('.', $fileName);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        $imageUploadPath = $path . $fileName_encrypt . "." . $ekstensiGambar;
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
          $imageTemp = $_FILES["image"]["tmp_name"];
          compressImage($imageTemp, $imageUploadPath, 75);
          $image = $fileName_encrypt . "." . $ekstensiGambar;
          unlink($path . $data['imageOld']);
        } else {
          $message = "Maaf, hanya file gambar JPG, JPEG, dan PNG yang diizinkan.";
          $message_type = "danger";
          alert($message, $message_type);
          return false;
        }
      } else if (empty($_FILE['image']["name"])) {
        $image = $data['imageOld'];
      }
      $sql = "UPDATE galeri SET image='$image', ket='$data[ket]' WHERE id_galeri='$data[id_galeri]'";
    }

    if ($action == "delete") {
      unlink($path . $data['image']);
      $sql = "DELETE FROM galeri WHERE id_galeri='$data[id_galeri]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function formulir($conn, $data, $action)
  {
    if ($action == "update") {
      $path = "../assets/files/formulir/";
      $fileName = basename($_FILES["formulir"]["name"]);
      $fileName = str_replace(" ", "-", $fileName);
      $fileNameEncrypt = crc32($fileName);
      $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
      $imageUploadPath = $path . "PPDB_" . date("Y") . "_" . $fileNameEncrypt . "." . $fileExtension;
      $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
      $allowedTypes = array('pdf');

      if (in_array($fileType, $allowedTypes)) {
        compressFile($_FILES["formulir"]["tmp_name"], $imageUploadPath);
        $formulir = "PPDB_" . date("Y") . "_" . $fileNameEncrypt . "." . $fileExtension;
      } else {
        $message = "Maaf, hanya file PDF yang diizinkan.";
        $messageType = "danger";
        alert($message, $messageType);
        return false;
      }
      unlink($path . $data['formulirOld']);
      $sql = "UPDATE formulir SET formulir='$formulir'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function pendaftaran_verifikasi($conn, $data, $action)
  {
    if ($action == "insert") {
      $password = generateRandomPassword(8);
      $password_hash = password_hash($password, PASSWORD_DEFAULT);
      require_once("../controller/mail.php");
      $to       = $data['email'];
      $subject  = "Hasil Pendaftaran Peserta Didik Baru " . date("Y") . " - SMAK Wartabakti";
      $message  = "<!doctype html>
      <html>
        <head>
            <meta name='viewport' content='width=device-width'>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
            <title>Hasil Pendaftaran Peserta Didik Baru " . date("Y") . "</title>
            <style>
                @media only screen and (max-width: 620px) {
                    table[class='body'] h1 {
                        font-size: 28px !important;
                        margin-bottom: 10px !important;}
                    table[class='body'] p,
                    table[class='body'] ul,
                    table[class='body'] ol,
                    table[class='body'] td,
                    table[class='body'] span,
                    table[class='body'] a {
                        font-size: 16px !important;}
                    table[class='body'] .wrapper,
                    table[class='body'] .article {
                        padding: 10px !important;}
                    table[class='body'] .content {
                        padding: 0 !important;}
                    table[class='body'] .container {
                        padding: 0 !important;
                        width: 100% !important;}
                    table[class='body'] .main {
                        border-left-width: 0 !important;
                        border-radius: 0 !important;
                        border-right-width: 0 !important;}
                    table[class='body'] .btn table {
                        width: 100% !important;}
                    table[class='body'] .btn a {
                        width: 100% !important;}
                    table[class='body'] .img-responsive {
                        height: auto !important;
                        max-width: 100% !important;
                        width: auto !important;}}
                @media all {
                    .ExternalClass {
                        width: 100%;}
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                        line-height: 100%;}
                    .apple-link a {
                        color: inherit !important;
                        font-family: inherit !important;
                        font-size: inherit !important;
                        font-weight: inherit !important;
                        line-height: inherit !important;
                        text-decoration: none !important;
                    .btn-primary table td:hover {
                        background-color: #d5075d !important;}
                    .btn-primary a:hover {
                        background-color: #000 !important;
                        border-color: #000 !important;
                        color: #fff !important;}}
            </style>
        </head>
        <body class style='background-color: #e1e3e5; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
            <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background-color: #e1e3e5; width: 100%;' width='100%' bgcolor='#e1e3e5'>
            <tr>
                <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;' width='580' valign='top'>
                <div class='content' style='box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;'>
        
                    <!-- START CENTERED WHITE CONTAINER -->
                    <table role='presentation' class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background: #ffffff; border-radius: 3px; width: 100%;' width='100%'>
        
                    <!-- START MAIN CONTENT AREA -->
                    <tr>
                        <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;' valign='top'>
                        <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                            <tr>
                            <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>
                                <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Hi " . $data['nama_lengkap'] . ",</p>
                                <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 20px;'>Maaf kamu belum terverifikasi sebagai peserta didik baru tahun " . date("Y") . ". Silakan lakukan pembaharuan berkas formulir kamu dengan data login akun kamu sebagai berikut:</p>
                                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='btn btn-primary' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; box-sizing: border-box; min-width: 100%; width: 100%;' width='100%'>
                                <tbody>
                                    <tr>
                                    <td align='left' style='font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;' valign='top'>
                                        <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: auto; width: auto;'>
                                        <tbody>
                                            <tr>
                                            <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: left; font-weight: bold;' valign='top' bgcolor='#ffffff' align='left'>Email: " . $data['email'] . "</td>
                                            </tr>
                                            <tr>
                                            <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: left; font-weight: bold;' valign='top' bgcolor='#ffffff' align='left'>Password: " . $password . "</td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </td>
                                    </tr>
                                </tbody>
                                </table>
                                <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 30px;'>Terima kasih</p>
                                <small>Peringatan! Ini adalah pesan otomatis sehingga Anda tidak dapat membalas pesan ini.</small>
                            </td>
                            </tr>
                        </table>
                        </td>
                    </tr>
        
                    <!-- END MAIN CONTENT AREA -->
                    </table>
                    
                    <!-- START FOOTER -->
                    <div class='footer' style='clear: both; margin-top: 10px; text-align: center; width: 100%;'>
                    <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                        <tr>
                        <td class='content-block' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                            <span class='apple-link' style='color: #9a9ea6; font-size: 12px; text-align: center;'>Workarea Jln. S. K. Lerik, Kota Baru, Kupang, NTT, Indonesia. (0380) 8438423</span>
                        </td>
                        </tr>
                        <tr>
                        <td class='content-block powered-by' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                            Powered by <a href='https://www.netmedia-framecode.com' style='color: #9a9ea6; font-size: 12px; text-align: center; text-decoration: none;'>Netmedia Framecode</a>.
                        </td>
                        </tr>
                    </table>
                    </div>
                    <!-- END FOOTER -->
        
                <!-- END CENTERED WHITE CONTAINER -->
                </div>
                </td>
                <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
            </tr>
            </table>
        </body>
      </html>";
      smtp_mail($to, $subject, $message, "", "", 0, 0, true);
      $sql = "UPDATE pendaftaran SET status_pendaftaran='Belum Terverifikasi' WHERE id_pendaftaran='$data[id_pendaftaran]';";
      $sql .= "UPDATE users SET password='$password_hash' WHERE email='$data[email]';";
    }

    if ($action == "update") {
      $password = generateRandomPassword(8);
      $password_hash = password_hash($password, PASSWORD_DEFAULT);
      require_once("../controller/mail.php");
      $to       = $data['email'];
      $subject  = "Hasil Pendaftaran Peserta Didik Baru " . date("Y") . " - SMAK Wartabakti";
      $message  = "<!doctype html>
      <html>
        <head>
            <meta name='viewport' content='width=device-width'>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
            <title>Hasil Pendaftaran Peserta Didik Baru " . date("Y") . "</title>
            <style>
                @media only screen and (max-width: 620px) {
                    table[class='body'] h1 {
                        font-size: 28px !important;
                        margin-bottom: 10px !important;}
                    table[class='body'] p,
                    table[class='body'] ul,
                    table[class='body'] ol,
                    table[class='body'] td,
                    table[class='body'] span,
                    table[class='body'] a {
                        font-size: 16px !important;}
                    table[class='body'] .wrapper,
                    table[class='body'] .article {
                        padding: 10px !important;}
                    table[class='body'] .content {
                        padding: 0 !important;}
                    table[class='body'] .container {
                        padding: 0 !important;
                        width: 100% !important;}
                    table[class='body'] .main {
                        border-left-width: 0 !important;
                        border-radius: 0 !important;
                        border-right-width: 0 !important;}
                    table[class='body'] .btn table {
                        width: 100% !important;}
                    table[class='body'] .btn a {
                        width: 100% !important;}
                    table[class='body'] .img-responsive {
                        height: auto !important;
                        max-width: 100% !important;
                        width: auto !important;}}
                @media all {
                    .ExternalClass {
                        width: 100%;}
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                        line-height: 100%;}
                    .apple-link a {
                        color: inherit !important;
                        font-family: inherit !important;
                        font-size: inherit !important;
                        font-weight: inherit !important;
                        line-height: inherit !important;
                        text-decoration: none !important;
                    .btn-primary table td:hover {
                        background-color: #d5075d !important;}
                    .btn-primary a:hover {
                        background-color: #000 !important;
                        border-color: #000 !important;
                        color: #fff !important;}}
            </style>
        </head>
        <body class style='background-color: #e1e3e5; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
            <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background-color: #e1e3e5; width: 100%;' width='100%' bgcolor='#e1e3e5'>
            <tr>
                <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;' width='580' valign='top'>
                <div class='content' style='box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;'>
        
                    <!-- START CENTERED WHITE CONTAINER -->
                    <table role='presentation' class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background: #ffffff; border-radius: 3px; width: 100%;' width='100%'>
        
                    <!-- START MAIN CONTENT AREA -->
                    <tr>
                        <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;' valign='top'>
                        <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                            <tr>
                            <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>
                                <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Hi " . $data['nama_lengkap'] . ",</p>
                                <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 20px;'>Selamat kamu sudah terverifikasi sebagai peserta didik baru tahun " . date("Y") . ". Selanjutnya kamu akan mengikuti tahap ujian seleksi masuk dengan jadwal sebagai berikut:</p>
                                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='btn btn-primary' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; box-sizing: border-box; min-width: 100%; width: 100%;' width='100%'>
                                <tbody>
                                    <tr>
                                    <td align='left' style='font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;' valign='top'>
                                        <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: auto; width: auto;'>
                                        <tbody>
                                          <tr>
                                            <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: left; font-weight: bold;width: 100px;' valign='top' bgcolor='#ffffff' align='left'>Lokasi Ujian</td>
                                            <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: left; font-weight: bold;' valign='top' bgcolor='#ffffff' align='left'> : </td>
                                            <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: left; font-weight: bold;' valign='top' bgcolor='#ffffff' align='left'><strong>SMA Swasta Katholik Warta Bakti, JL. ACHMAD YANI KEFAMENANU, Kel. Kefamenanu Selatan, Kec. Kota Kefamenanu, Kab. Timor Tengah Utara, Prov. Nusa Tenggara Timur</strong></td>
                                          </tr>
                                          <tr>
                                            <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: left; font-weight: bold;width: 100px;' valign='top' bgcolor='#ffffff' align='left'>Tanggal :</td>
                                            <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: left; font-weight: bold;' valign='top' bgcolor='#ffffff' align='left'> : </td>
                                            <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: left; font-weight: bold;' valign='top' bgcolor='#ffffff' align='left'><strong>" . $data['tanggal_seleksi'] . "</strong></td>
                                          </tr>
                                          <tr>
                                            <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: left; font-weight: bold;width: 100px;' valign='top' bgcolor='#ffffff' align='left'>Jam : </td>
                                            <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: left; font-weight: bold;' valign='top' bgcolor='#ffffff' align='left'> : </td>
                                            <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: left; font-weight: bold;' valign='top' bgcolor='#ffffff' align='left'><strong>07:30 WITA</strong></td>
                                          </tr>
                                        </tbody>
                                        </table>
                                    </td>
                                    </tr>
                                </tbody>
                                </table>";
      if (empty($data['password'])) {
        $message .= "<p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 20px;'>Untuk melihat data pendaftaran dan hasil seleksi kamu bisa login pada akun yang telah kami buat menggunakan email yang kamu daftarkan, berikut akunnya:</p>
                                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='btn btn-primary' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; box-sizing: border-box; min-width: 100%; width: 100%;' width='100%'>
                                <tbody>
                                    <tr>
                                    <td align='left' style='font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;' valign='top'>
                                        <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: auto; width: auto;'>
                                        <tbody>
                                            <tr>
                                            <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: left; font-weight: bold;' valign='top' bgcolor='#ffffff' align='left'>Email: " . $data['email'] . "</td>
                                            </tr>
                                            <tr>
                                            <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: left; font-weight: bold;' valign='top' bgcolor='#ffffff' align='left'>Password: " . $password . "</td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </td>
                                    </tr>
                                </tbody>
                                </table>";
      } else {
        $message .= "<p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 30px;'>Untuk melihat data pendaftaran dan hasil seleksi kamu bisa login pada akun yang telah kami buat menggunakan email yang kamu daftarkan.</p>";
      }
      $message .= "<p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 30px;'>Harap untuk menyiapkan diri sebaik mungkin agar dapat mengikuti ujian seleksi masuk.</p>
                                <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 30px;'>Terima kasih</p>
                                <small>Peringatan! Ini adalah pesan otomatis sehingga Anda tidak dapat membalas pesan ini.</small>
                            </td>
                            </tr>
                        </table>
                        </td>
                    </tr>
        
                    <!-- END MAIN CONTENT AREA -->
                    </table>
                    
                    <!-- START FOOTER -->
                    <div class='footer' style='clear: both; margin-top: 10px; text-align: center; width: 100%;'>
                    <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                        <tr>
                        <td class='content-block' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                            <span class='apple-link' style='color: #9a9ea6; font-size: 12px; text-align: center;'>Workarea Jln. S. K. Lerik, Kota Baru, Kupang, NTT, Indonesia. (0380) 8438423</span>
                        </td>
                        </tr>
                        <tr>
                        <td class='content-block powered-by' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                            Powered by <a href='https://www.netmedia-framecode.com' style='color: #9a9ea6; font-size: 12px; text-align: center; text-decoration: none;'>Netmedia Framecode</a>.
                        </td>
                        </tr>
                    </table>
                    </div>
                    <!-- END FOOTER -->
        
                <!-- END CENTERED WHITE CONTAINER -->
                </div>
                </td>
                <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
            </tr>
            </table>
        </body>
      </html>";
      smtp_mail($to, $subject, $message, "", "", 0, 0, true);
      $sql = "UPDATE pendaftaran SET status_pendaftaran='Diverifikasi' WHERE id_pendaftaran='$data[id_pendaftaran]';";
      $sql .= "INSERT INTO hasil_seleksi(id_pendaftaran,tanggal_seleksi) VALUES('$data[id_pendaftaran]','$data[tanggal_seleksi]');";
      if (empty($data['password'])) {
        $sql .= "UPDATE users SET password='$password_hash' WHERE email='$data[email]';";
      }
    }

    if ($action == "update_peserta") {
      $path = "../assets/files/pendaftaran/";
      $fileName = basename($_FILES["formulir"]["name"]);
      $fileName = str_replace(" ", "-", $fileName);
      $fileNameEncrypt = crc32($fileName);
      $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
      $imageUploadPath = $path . $fileNameEncrypt . "." . $fileExtension;
      $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
      $allowedTypes = array('pdf');

      if (in_array($fileType, $allowedTypes)) {
        unlink($path . $data['formulirOld']);
        compressFile($_FILES["formulir"]["tmp_name"], $imageUploadPath);
        $formulir = $fileNameEncrypt . "." . $fileExtension;
      } else {
        $message = "Maaf, hanya file PDF yang diizinkan.";
        $messageType = "danger";
        alert($message, $messageType);
        return false;
      }

      $sql = "UPDATE pendaftaran SET formulir='$formulir', status_pendaftaran='Belum Diverifikasi' WHERE id_pendaftaran='$data[id_pendaftaran]';";
    }

    mysqli_multi_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function hasil_seleksi($conn, $data, $action)
  {
    if ($action == "update") {
      $select_biaya_pembayaran = "SELECT * FROM biaya_pembayaran";
      $take_biaya_pembayaran = mysqli_query($conn, $select_biaya_pembayaran);
      $total_biaya = 0;
      $order_id = generateOrderId();
      $bobotUjian = 60;
      $bobotRapor = 40;
      $nilaiTotal = ($data['nilai_ujian'] * $bobotUjian / 100) + ($data['nilai_rapor'] * $bobotRapor / 100);
      if ($nilaiTotal < 75) {
        $status_lulus = "Belum Lulus";
        require_once("../controller/mail.php");
        $to       = $data['email'];
        $subject  = "Hasil Seleksi Peserta Didik Baru " . date("Y") . " - SMAK Wartabakti";
        $message  = "<!doctype html>
        <html>
          <head>
              <meta name='viewport' content='width=device-width'>
              <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
              <title>Hasil Seleksi Peserta Didik Baru " . date("Y") . "</title>
              <style>
                  @media only screen and (max-width: 620px) {
                      table[class='body'] h1 {
                          font-size: 28px !important;
                          margin-bottom: 10px !important;}
                      table[class='body'] p,
                      table[class='body'] ul,
                      table[class='body'] ol,
                      table[class='body'] td,
                      table[class='body'] span,
                      table[class='body'] a {
                          font-size: 16px !important;}
                      table[class='body'] .wrapper,
                      table[class='body'] .article {
                          padding: 10px !important;}
                      table[class='body'] .content {
                          padding: 0 !important;}
                      table[class='body'] .container {
                          padding: 0 !important;
                          width: 100% !important;}
                      table[class='body'] .main {
                          border-left-width: 0 !important;
                          border-radius: 0 !important;
                          border-right-width: 0 !important;}
                      table[class='body'] .btn table {
                          width: 100% !important;}
                      table[class='body'] .btn a {
                          width: 100% !important;}
                      table[class='body'] .img-responsive {
                          height: auto !important;
                          max-width: 100% !important;
                          width: auto !important;}}
                  @media all {
                      .ExternalClass {
                          width: 100%;}
                      .ExternalClass,
                      .ExternalClass p,
                      .ExternalClass span,
                      .ExternalClass font,
                      .ExternalClass td,
                      .ExternalClass div {
                          line-height: 100%;}
                      .apple-link a {
                          color: inherit !important;
                          font-family: inherit !important;
                          font-size: inherit !important;
                          font-weight: inherit !important;
                          line-height: inherit !important;
                          text-decoration: none !important;
                      .btn-primary table td:hover {
                          background-color: #d5075d !important;}
                      .btn-primary a:hover {
                          background-color: #000 !important;
                          border-color: #000 !important;
                          color: #fff !important;}}
              </style>
          </head>
          <body class style='background-color: #e1e3e5; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
              <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background-color: #e1e3e5; width: 100%;' width='100%' bgcolor='#e1e3e5'>
              <tr>
                  <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                  <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;' width='580' valign='top'>
                  <div class='content' style='box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;'>
          
                      <!-- START CENTERED WHITE CONTAINER -->
                      <table role='presentation' class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background: #ffffff; border-radius: 3px; width: 100%;' width='100%'>
          
                      <!-- START MAIN CONTENT AREA -->
                      <tr>
                          <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;' valign='top'>
                          <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                              <tr>
                              <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>
                                  <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Hi " . $data['nama_lengkap'] . ",</p>
                                  <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 20px;'>Selamat kamu berhasil menyelesaikan ujian seleksi dengan baik namum kamu belum berhasil dan dinyatakan <strong>TIDAK LULUS</strong> sebagai peserta didik baru tahun " . date("Y") . ". Terima kasih sudah bersedia mengikuti seleksi masuk di SMA Swasta Katholik Warta Bakti Kefamenanu.</p>
                                  <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 30px;'>Terima kasih</p>
                                  <small>Peringatan! Ini adalah pesan otomatis sehingga Anda tidak dapat membalas pesan ini.</small>
                              </td>
                              </tr>
                          </table>
                          </td>
                      </tr>
          
                      <!-- END MAIN CONTENT AREA -->
                      </table>
                      
                      <!-- START FOOTER -->
                      <div class='footer' style='clear: both; margin-top: 10px; text-align: center; width: 100%;'>
                      <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                          <tr>
                          <td class='content-block' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                              <span class='apple-link' style='color: #9a9ea6; font-size: 12px; text-align: center;'>Workarea Jln. S. K. Lerik, Kota Baru, Kupang, NTT, Indonesia. (0380) 8438423</span>
                          </td>
                          </tr>
                          <tr>
                          <td class='content-block powered-by' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                              Powered by <a href='https://www.netmedia-framecode.com' style='color: #9a9ea6; font-size: 12px; text-align: center; text-decoration: none;'>Netmedia Framecode</a>.
                          </td>
                          </tr>
                      </table>
                      </div>
                      <!-- END FOOTER -->
          
                  <!-- END CENTERED WHITE CONTAINER -->
                  </div>
                  </td>
                  <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
              </tr>
              </table>
          </body>
        </html>";
        smtp_mail($to, $subject, $message, "", "", 0, 0, true);
        $sql = "UPDATE hasil_seleksi SET nilai_ujian='$data[nilai_ujian]', nilai_rapor='$data[nilai_rapor]', nilai_total='$nilaiTotal', keterangan='$data[keterangan]', tanggal_hasil=current_timestamp, status_lulus='$status_lulus' WHERE id_hasil_seleksi='$data[id_hasil_seleksi]';";
      } else if ($nilaiTotal >= 75) {
        $status_lulus = "Lulus";
        $waktuSaatIni = time();
        $waktuBatas = $waktuSaatIni + (24 * 60 * 60);
        $formatWaktu = date("Y-m-d H:i:s", $waktuBatas);
        require_once("../controller/mail.php");
        $to       = $data['email'];
        $subject  = "Hasil Seleksi Peserta Didik Baru " . date("Y") . " - SMAK Wartabakti";
        $message  = "<!doctype html>
        <html>
          <head>
              <meta name='viewport' content='width=device-width'>
              <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
              <title>Hasil Seleksi Peserta Didik Baru " . date("Y") . "</title>
              <style>
                  @media only screen and (max-width: 620px) {
                      table[class='body'] h1 {
                          font-size: 28px !important;
                          margin-bottom: 10px !important;}
                      table[class='body'] p,
                      table[class='body'] ul,
                      table[class='body'] ol,
                      table[class='body'] td,
                      table[class='body'] span,
                      table[class='body'] a {
                          font-size: 16px !important;}
                      table[class='body'] .wrapper,
                      table[class='body'] .article {
                          padding: 10px !important;}
                      table[class='body'] .content {
                          padding: 0 !important;}
                      table[class='body'] .container {
                          padding: 0 !important;
                          width: 100% !important;}
                      table[class='body'] .main {
                          border-left-width: 0 !important;
                          border-radius: 0 !important;
                          border-right-width: 0 !important;}
                      table[class='body'] .btn table {
                          width: 100% !important;}
                      table[class='body'] .btn a {
                          width: 100% !important;}
                      table[class='body'] .img-responsive {
                          height: auto !important;
                          max-width: 100% !important;
                          width: auto !important;}}
                  @media all {
                      .ExternalClass {
                          width: 100%;}
                      .ExternalClass,
                      .ExternalClass p,
                      .ExternalClass span,
                      .ExternalClass font,
                      .ExternalClass td,
                      .ExternalClass div {
                          line-height: 100%;}
                      .apple-link a {
                          color: inherit !important;
                          font-family: inherit !important;
                          font-size: inherit !important;
                          font-weight: inherit !important;
                          line-height: inherit !important;
                          text-decoration: none !important;
                      .btn-primary table td:hover {
                          background-color: #d5075d !important;}
                      .btn-primary a:hover {
                          background-color: #000 !important;
                          border-color: #000 !important;
                          color: #fff !important;}}
              </style>
          </head>
          <body class style='background-color: #e1e3e5; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
              <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background-color: #e1e3e5; width: 100%;' width='100%' bgcolor='#e1e3e5'>
              <tr>
                  <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                  <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;' width='580' valign='top'>
                  <div class='content' style='box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;'>
          
                      <!-- START CENTERED WHITE CONTAINER -->
                      <table role='presentation' class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background: #ffffff; border-radius: 3px; width: 100%;' width='100%'>
          
                      <!-- START MAIN CONTENT AREA -->
                      <tr>
                          <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;' valign='top'>
                          <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                              <tr>
                              <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>
                                  <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Hi " . $data['nama_lengkap'] . ",</p>
                                  <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 20px;'>Selamat kamu sudah dinyakatan <strong>LULUS</strong> sebagai peserta didik baru tahun " . date("Y") . ". Selanjutnya kamu akan diminta untuk melakukan pembayaran uang masuk sekolah. Berikut biaya yang akan dibebankan kepada kamu:</p>
                                  <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='btn btn-primary' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; box-sizing: border-box; min-width: 100%; width: 100%;' width='100%'>
                                  <tbody>
                                      <tr>
                                      <td align='left' style='font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;' valign='top'>
                                          <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: auto; width: auto;'>
                                          <tbody>";
        foreach ($take_biaya_pembayaran as $data_biaya) :
          $jumlah_biaya = number_format($data_biaya['jumlah_biaya']);
          $message .= "<tr>
                                              <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: left; font-weight: bold;' valign='top' bgcolor='#ffffff' align='left'>" . $data_biaya['nama_biaya'] . ": Rp. " . $jumlah_biaya . "</td>
                                              </tr>";
          $total_biaya += $data_biaya['jumlah_biaya'];
        endforeach;
        $total_biaya_fix = number_format($total_biaya);
        $message .= "<tr>
                                              <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: left; font-weight: bold;' valign='top' bgcolor='#ffffff' align='left'>Total Biaya Uang Masuk Sekolah: Rp. " . $total_biaya_fix . "</td>
                                            </tr>
                                          </tbody>
                                          </table>
                                      </td>
                                      </tr>
                                  </tbody>
                                  </table>
                                  <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 20px;'>Untuk melakukan pembayaran kamu bisa login pada akun yang telah kami buat sebelumnya. Batas waktu pembayaran kamu sampai dengan <strong>" . $formatWaktu . "</strong>, apabila pembayaran belum dinyatan Lunas maka akan dianggap hangus dan anda perlu melapor kembali ke bagian administrasi sekolah.</p>
                                  <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 30px;'>Terima kasih</p>
                                  <small>Peringatan! Ini adalah pesan otomatis sehingga Anda tidak dapat membalas pesan ini.</small>
                              </td>
                              </tr>
                          </table>
                          </td>
                      </tr>
          
                      <!-- END MAIN CONTENT AREA -->
                      </table>
                      
                      <!-- START FOOTER -->
                      <div class='footer' style='clear: both; margin-top: 10px; text-align: center; width: 100%;'>
                      <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                          <tr>
                          <td class='content-block' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                              <span class='apple-link' style='color: #9a9ea6; font-size: 12px; text-align: center;'>Workarea Jln. S. K. Lerik, Kota Baru, Kupang, NTT, Indonesia. (0380) 8438423</span>
                          </td>
                          </tr>
                          <tr>
                          <td class='content-block powered-by' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                              Powered by <a href='https://www.netmedia-framecode.com' style='color: #9a9ea6; font-size: 12px; text-align: center; text-decoration: none;'>Netmedia Framecode</a>.
                          </td>
                          </tr>
                      </table>
                      </div>
                      <!-- END FOOTER -->
          
                  <!-- END CENTERED WHITE CONTAINER -->
                  </div>
                  </td>
                  <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
              </tr>
              </table>
          </body>
        </html>";
        smtp_mail($to, $subject, $message, "", "", 0, 0, true);
        $sql = "UPDATE hasil_seleksi SET nilai_ujian='$data[nilai_ujian]', nilai_rapor='$data[nilai_rapor]', nilai_total='$nilaiTotal', keterangan='$data[keterangan]', tanggal_hasil=current_timestamp, status_lulus='$status_lulus' WHERE id_hasil_seleksi='$data[id_hasil_seleksi]';";
        $sql .= "INSERT INTO pembayaran(id_hasil_seleksi,order_id,jumlah_pembayaran,batas_pembayaran) VALUES('$data[id_hasil_seleksi]','$order_id','$total_biaya','$formatWaktu');";
      }
    }

    mysqli_multi_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function biaya_pembayaran($conn, $data, $action)
  {
    if ($action == "insert") {
      $sql = "INSERT INTO biaya_pembayaran(nama_biaya,jumlah_biaya) VALUES('$data[nama_biaya]','$data[jumlah_biaya]')";
    }

    if ($action == "update") {
      $sql = "UPDATE biaya_pembayaran SET nama_biaya='$data[nama_biaya]', jumlah_biaya='$data[jumlah_biaya]' WHERE id_biaya='$data[id_biaya]'";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM biaya_pembayaran WHERE id_biaya='$data[id_biaya]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function guru($conn, $data, $action)
  {
    $path = "../assets/img/guru/";

    if ($action == "insert") {
      $fileName = basename($_FILES["img"]["name"]);
      $fileName = str_replace(" ", "-", $fileName);
      $fileName_encrypt = crc32($fileName);
      $ekstensiGambar = explode('.', $fileName);
      $ekstensiGambar = strtolower(end($ekstensiGambar));
      $imageUploadPath = $path . $fileName_encrypt . "." . $ekstensiGambar;
      $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
      $allowTypes = array('jpg', 'png', 'jpeg');
      if (in_array($fileType, $allowTypes)) {
        $imageTemp = $_FILES["img"]["tmp_name"];
        compressImage($imageTemp, $imageUploadPath, 75);
        $img = $fileName_encrypt . "." . $ekstensiGambar;
      } else {
        $message = "Maaf, hanya file gambar JPG, JPEG, dan PNG yang diizinkan.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      }
      $sql = "INSERT INTO guru(img_guru,nama_lengkap,nik,jk,tempat_lahir,tgl_lahir) VALUES('$img','$data[nama_lengkap]','$data[nik]','$data[jk]','$data[tempat_lahir]','$data[tgl_lahir]')";
    }

    if ($action == "update") {
      if (!empty($_FILES['img']["name"])) {
        $fileName = basename($_FILES["img"]["name"]);
        $fileName = str_replace(" ", "-", $fileName);
        $fileName_encrypt = crc32($fileName);
        $ekstensiGambar = explode('.', $fileName);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        $imageUploadPath = $path . $fileName_encrypt . "." . $ekstensiGambar;
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
          $imageTemp = $_FILES["img"]["tmp_name"];
          compressImage($imageTemp, $imageUploadPath, 75);
          $img = $fileName_encrypt . "." . $ekstensiGambar;
          if ($data['img_guruOld'] !== "default.png") {
            unlink($path . $data['img_guruOld']);
          }
        } else {
          $message = "Maaf, hanya file gambar JPG, JPEG, dan PNG yang diizinkan.";
          $message_type = "danger";
          alert($message, $message_type);
          return false;
        }
      } else if (empty($_FILE['img']["name"])) {
        $img = $data['img_guruOld'];
      }
      $sql = "UPDATE guru SET img_guru='$img', nama_lengkap='$data[nama_lengkap]', nik='$data[nik]', jk='$data[jk]', tempat_lahir='$data[tempat_lahir]', tgl_lahir='$data[tgl_lahir]' WHERE id_guru='$data[id_guru]'";
    }

    if ($action == "delete") {
      if ($data['img_guru'] !== "default.png") {
        unlink($path . $data['img_guru']);
      }
      $sql = "DELETE FROM guru WHERE id_guru='$data[id_guru]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function ekstrakulikuler($conn, $data, $action)
  {
    $path = "../assets/img/ekstrakulikuler/";

    if ($action == "insert") {
      $fileName = basename($_FILES["img"]["name"]);
      $fileName = str_replace(" ", "-", $fileName);
      $fileName_encrypt = crc32($fileName);
      $ekstensiGambar = explode('.', $fileName);
      $ekstensiGambar = strtolower(end($ekstensiGambar));
      $imageUploadPath = $path . $fileName_encrypt . "." . $ekstensiGambar;
      $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
      $allowTypes = array('jpg', 'png', 'jpeg');
      if (in_array($fileType, $allowTypes)) {
        $imageTemp = $_FILES["img"]["tmp_name"];
        compressImage($imageTemp, $imageUploadPath, 75);
        $img = $fileName_encrypt . "." . $ekstensiGambar;
      } else {
        $message = "Maaf, hanya file gambar JPG, JPEG, dan PNG yang diizinkan.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      }
      mysqli_query($conn, "INSERT INTO ekstrakulikuler(img,deskripsi,kategori) VALUES('$img','$data[deskripsii]','$data[kategori]')");
    }

    if ($action == "delete") {
      unlink($path . $data['img']);
      $sql = "DELETE FROM ekstrakulikuler WHERE id='$data[id]'";
      mysqli_query($conn, $sql);
    }

    return mysqli_affected_rows($conn);
  }

  function sejarah($conn, $data, $action)
  {
    if ($action == "update") {
      $sql = "UPDATE sejarah SET deskripsi='$data[deskripsi]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function panduan($conn, $data, $action)
  {
    if ($action == "update") {
      $sql = "UPDATE panduan SET deskripsi='$data[deskripsi]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function prestasi($conn, $data, $action, $deskripsi)
  {
    $path = "../assets/img/prestasi/";

    if ($action == "insert") {
      $fileName = basename($_FILES["img"]["name"]);
      $fileName = str_replace(" ", "-", $fileName);
      $fileName_encrypt = crc32($fileName);
      $ekstensiGambar = explode('.', $fileName);
      $ekstensiGambar = strtolower(end($ekstensiGambar));
      $imageUploadPath = $path . $fileName_encrypt . "." . $ekstensiGambar;
      $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
      $allowTypes = array('jpg', 'png', 'jpeg');
      if (in_array($fileType, $allowTypes)) {
        $imageTemp = $_FILES["img"]["tmp_name"];
        compressImage($imageTemp, $imageUploadPath, 75);
        $img = $fileName_encrypt . "." . $ekstensiGambar;
      } else {
        $message = "Maaf, hanya file gambar JPG, JPEG, dan PNG yang diizinkan.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      }
      $sql = "INSERT INTO prestasi(image,judul,deskripsi,kategori) VALUES('$img','$data[judul]','$deskripsi','$data[kategori]')";
    }

    if ($action == "update") {
      if (!empty($_FILES['img']["name"])) {
        $fileName = basename($_FILES["img"]["name"]);
        $fileName = str_replace(" ", "-", $fileName);
        $fileName_encrypt = crc32($fileName);
        $ekstensiGambar = explode('.', $fileName);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        $imageUploadPath = $path . $fileName_encrypt . "." . $ekstensiGambar;
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
          $imageTemp = $_FILES["img"]["tmp_name"];
          compressImage($imageTemp, $imageUploadPath, 75);
          $img = $fileName_encrypt . "." . $ekstensiGambar;
          unlink($path . $data['imageOld']);
        } else {
          $message = "Maaf, hanya file gambar JPG, JPEG, dan PNG yang diizinkan.";
          $message_type = "danger";
          alert($message, $message_type);
          return false;
        }
      } else if (empty($_FILE['img']["name"])) {
        $img = $data['imageOld'];
      }
      $sql = "UPDATE prestasi SET image='$img', judul='$data[judul]', deskripsi='$deskripsi', kategori='$data[kategori]' WHERE id_prestasi='$data[id_prestasi]'";
    }

    if ($action == "delete") {
      unlink($path . $data['image']);
      $sql = "DELETE FROM prestasi WHERE id_prestasi='$data[id_prestasi]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function jadwal_daftar($conn, $data, $action)
  {
    if ($action == "insert") {
      $sql = "INSERT INTO jadwal_daftar(tgl_buka,tgl_tutup,gelombang,kuota) VALUES('$data[tgl_buka]','$data[tgl_tutup]','$data[gelombang]','$data[kuota]')";
    }

    if ($action == "update") {
      $sql = "UPDATE jadwal_daftar SET tgl_buka='$data[tgl_buka]', tgl_tutup='$data[tgl_tutup]', gelombang='$data[gelombang]', kuota='$data[kuota]' WHERE id_jd='$data[id_jd]'";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM jadwal_daftar WHERE id_jd='$data[id_jd]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function __name($conn, $data, $action)
  {
    if ($action == "insert") {
    }

    if ($action == "update") {
    }

    if ($action == "delete") {
    }

    // mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
}
