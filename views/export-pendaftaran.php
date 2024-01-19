<?php
require_once("../controller/script.php");
require_once('../assets/vendor/autoload.php');

$pendaftaran = mysqli_query($conn, "SELECT * FROM pendaftaran ORDER BY nama_lengkap ASC");

$mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML('<h2 style="text-align: center;">Pendaftaran Peserta Didik Baru <br>SMA Katholik Wartabakti</h2>');

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
    </tr>');
    $no++;
  }
}

$mpdf->WriteHTML('</tbody>
</table>');

$mpdf->Output('Pendaftaran_Peserta_Didik_Baru.pdf', 'D');
exit;
