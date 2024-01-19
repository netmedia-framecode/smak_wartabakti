<?php
require_once("../controller/script.php");
require_once('../assets/vendor/autoload.php');

$hasil_seleksi = mysqli_query($conn, "SELECT * FROM hasil_seleksi JOIN pendaftaran ON hasil_seleksi.id_pendaftaran=pendaftaran.id_pendaftaran ORDER BY pendaftaran.nama_lengkap ASC");

$mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML('<h2 style="text-align: center;">Lulus Seleksi Pendaftaran Peserta Didik Baru <br>SMA Katholik Wartabakti</h2>');

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
      <th style="border: 1px solid #000;">Nilai Ujian</th>
      <th style="border: 1px solid #000;">Nilai Rapor</th>
      <th style="border: 1px solid #000;">Nilai Total</th>
      <th style="border: 1px solid #000;">Keterangan</th>
      <th style="border: 1px solid #000;">Tgl Seleksi</th>
      <th style="border: 1px solid #000;">Tgl Hasil</th>
    </tr>
  </thead>
  <tbody id="search-page">');

if (mysqli_num_rows($hasil_seleksi) == 0) {
  $mpdf->WriteHTML('<tr style="border: 1px solid #000;">
      <th colspan="8" style="border: 1px solid #000;">Belum ada data.</th>
    </tr>');
}

$no = 1;

if (mysqli_num_rows($hasil_seleksi) > 0) {
  while ($data = mysqli_fetch_assoc($hasil_seleksi)) {
    $tanggal_seleksi = date_create($data["tanggal_seleksi"]);
    $tanggal_seleksi = date_format($tanggal_seleksi, "d M Y");
    if ($data["tanggal_hasil"] !== NULL) {
      $tanggal_hasil = date_create($data["tanggal_hasil"]);
      $tanggal_hasil = date_format($tanggal_hasil, "d M Y");
    } else {
      $tanggal_hasil = "";
    }
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
      <td style="border: 1px solid #000;">' . $data['nilai_ujian'] . '</td>
      <td style="border: 1px solid #000;">' . $data['nilai_rapor'] . '</td>
      <td style="border: 1px solid #000;">' . $data['nilai_total'] . '</td>
      <td style="border: 1px solid #000;"><p>' . $data['keterangan'] . '</p></td>
      <td style="border: 1px solid #000;">' . $tanggal_seleksi . '</td>
      <td style="border: 1px solid #000;">' . $tanggal_hasil . '</td>
    </tr>');
    $no++;
  }
}

$mpdf->WriteHTML('</tbody>
</table>');

$mpdf->Output('Lulus_Seleksi_Pendaftaran_Peserta_Didik_Baru.pdf', 'D');
exit;
