<?php
require_once("../controller/script.php");
require_once('../assets/vendor/autoload.php');

$pembayaran = mysqli_query($conn, "SELECT * 
FROM pembayaran 
JOIN hasil_seleksi ON pembayaran.id_hasil_seleksi=hasil_seleksi.id_hasil_seleksi
JOIN pendaftaran ON hasil_seleksi.id_pendaftaran=pendaftaran.id_pendaftaran
JOIN users ON pendaftaran.id_user=users.id_user");

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
$mpdf->WriteHTML('<h3 style="text-align: center;">Pembayaran Pendaftaran Peserta Didik Baru <br>SMA Katholik Wartabakti <br>Tahun Ajaran ' . $tahunAjaranSaatIni . '/' . $tahunAjaranBerikutnya . '</h3>');

$mpdf->WriteHTML('<table style="border-collapse: collapse; width: 100%; margin: auto;">
  <thead>
    <tr style="border: 1px solid #000;">
      <th style="border: 1px solid #000;">#</th>
      <th style="border: 1px solid #000;">Nama Peserta</th>
      <th style="border: 1px solid #000;">Jumlah Bayar</th>
      <th style="border: 1px solid #000;">Batas Bayar</th>
      <th style="border: 1px solid #000;">Tgl Bayar</th>
      <th style="border: 1px solid #000;">Status Bayar</th>
    </tr>
  </thead>
  <tbody id="search-page">');

if (mysqli_num_rows($pembayaran) == 0) {
  $mpdf->WriteHTML('<tr style="border: 1px solid #000;">
      <th colspan="8" style="border: 1px solid #000;">Belum ada data.</th>
    </tr>');
}

$no = 1;

if (mysqli_num_rows($pembayaran) > 0) {
  while ($data = mysqli_fetch_assoc($pembayaran)) {
    $mpdf->WriteHTML('
    <tr style="border: 1px solid #000;">
      <th style="border: 1px solid #000;">' . $no . '</th>
      <td style="border: 1px solid #000;">' . $data['nama_lengkap'] . '</td>
      <td style="border: 1px solid #000;">Rp. ' . number_format($data['jumlah_pembayaran']) . '</td>
      <td style="border: 1px solid #000;">' . $data['batas_pembayaran'] . '</td>
      <td style="border: 1px solid #000;">' . $data['tanggal_pembayaran'] . '</td>
      <td style="border: 1px solid #000;">' . $data['status_pembayaran'] . '</td>
    </tr>');
    $no++;
  }
}

$mpdf->WriteHTML('</tbody>
</table>');

// $mpdf->Output();
$mpdf->OutputHttpDownload('Pembayaran_PPDB.pdf');
header("Location: pembayaran");
exit;
