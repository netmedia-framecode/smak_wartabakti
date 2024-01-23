<?php
require_once("../controller/script.php");
require_once('../assets/vendor/autoload.php');


$mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML('<div style="border-bottom: 3px solid black;width: 100%;">
  <table border="0" style="width: 100%;">
    <tbody>
      <tr>
        <th style="text-align: center;">
          <img src="../assets/img/logo-kiri.png" alt="" style="width: 100px;height: 100px;">
        </th>
        <td style="text-align: center;">
          <h3>PEMERINTAH PROVINSI NUSA TENGGARA TIMUR<br>DINAS PENDIDIKAN DAN KEBUDAYAAN<br>YAYASAN PENDIDIKAN SNUNA KABUPATEN TIMOR TENGAH UTARA<br>SMKS KATOLIK KEFAMENANU</h3>
          <p style="font-size: 14px;">Jl. Yos Soedarso, Kelurahan Aplasi-Kefamenanu | Telp. 0388[31448]- email: smkkatolikkefa@gmail.com</p>
        </td>
        <th style="text-align: center;">
          <img src="../assets/img/logo-smarta.png" alt="" style="width: 100px;height: 100px;">
        </th>
      </tr>
    </tbody>
  </table>
</div>');

$tahunAjaranSaatIni = date('Y');
$tahunAjaranBerikutnya = $tahunAjaranSaatIni + 1;
if ($_GET['gelombang'] != "") {
  $id_jd = valid($conn, $_GET['gelombang']);
  $pendaftaran = mysqli_query($conn, "SELECT * FROM pendaftaran JOIN jadwal_daftar ON pendaftaran.id_jd=jadwal_daftar.id_jd WHERE pendaftaran.id_jd='$id_jd' ORDER BY nama_lengkap ASC");
  $mpdf->WriteHTML('<h3 style="text-align: center;">Pendaftaran Peserta Didik Baru <br>SMA Katholik Wartabakti <br>Gelombang ' . $_GET['gelombang'] . ' Tahun Ajaran ' . $tahunAjaranSaatIni . '/' . $tahunAjaranBerikutnya . '</h3>');
} else {
  $pendaftaran = mysqli_query($conn, "SELECT * FROM pendaftaran JOIN jadwal_daftar ON pendaftaran.id_jd=jadwal_daftar.id_jd ORDER BY nama_lengkap ASC");
  $mpdf->WriteHTML('<h3 style="text-align: center;">Pendaftaran Peserta Didik Baru <br>SMA Katholik Wartabakti <br>Tahun Ajaran ' . $tahunAjaranSaatIni . '/' . $tahunAjaranBerikutnya . '</h3>');
}

$mpdf->WriteHTML('<table style="border-collapse: collapse; width: 100%; margin: auto;">
  <thead>
    <tr style="border: 1px solid #000;">
      <th style="border: 1px solid #000;">#</th>
      <th style="border: 1px solid #000;">Status</th>
      <th style="border: 1px solid #000;">Nama Lengkap</th>
      <th style="border: 1px solid #000;">Jenis Kelamin</th>
      <th style="border: 1px solid #000;">Tgl Lahir</th>
      <th style="border: 1px solid #000;">Alamat</th>
      <th style="border: 1px solid #000;">Email</th>
      <th style="border: 1px solid #000;">No. Telp</th>
      <th style="border: 1px solid #000;">Asal Sekolah</th>
      <th style="border: 1px solid #000;">Gelombang</th>
    </tr>
  </thead>
  <tbody id="search-page">');

if (mysqli_num_rows($pendaftaran) == 0) {
  $mpdf->WriteHTML('<tr style="border: 1px solid #000;">
      <th colspan="8" style="border: 1px solid #000;">Belum ada data.</th>
    </tr>');
}

$no = 1;

if (mysqli_num_rows($pendaftaran) > 0) {
  while ($data = mysqli_fetch_assoc($pendaftaran)) {
    $mpdf->WriteHTML('
    <tr style="border: 1px solid #000;">
      <th style="border: 1px solid #000;">' . $no . '</th>
      <td style="border: 1px solid #000;">' . $data['status_pendaftaran'] . '</td>
      <td style="border: 1px solid #000;">' . $data['nama_lengkap'] . '</td>
      <td style="border: 1px solid #000;">' . $data['jenis_kelamin'] . '</td>
      <td style="border: 1px solid #000;">' . $data['tanggal_lahir'] . '</td>
      <td style="border: 1px solid #000;">' . $data['alamat'] . '</td>
      <td style="border: 1px solid #000;">' . $data['email'] . '</td>
      <td style="border: 1px solid #000;">' . $data['nomor_telepon'] . '</td>
      <td style="border: 1px solid #000;">' . $data['asal_sekolah'] . '</td>
      <td style="border: 1px solid #000;">' . $data['gelombang'] . '</td>
    </tr>');
    $no++;
  }
}

$mpdf->WriteHTML('</tbody>
</table>');

// $mpdf->Output();
$mpdf->OutputHttpDownload('Pendaftaran_Peserta_Didik_Baru.pdf');
header("Location: pendaftaran");
exit;
