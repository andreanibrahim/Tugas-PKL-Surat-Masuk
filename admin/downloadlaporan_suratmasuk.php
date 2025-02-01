<?php
include '../koneksi/koneksi.php';
session_start();
include "login/ceksession.php";

// Mengambil data dari tabel
$bulan = $_POST['bulan'];
$tahun = $_POST['tahun'];
$sql1 = "SELECT * FROM tb_suratmasuk WHERE MONTH(tanggalmasuk_suratmasuk)='$bulan' AND YEAR(tanggalmasuk_suratmasuk) = '$tahun'";
$query1 = mysqli_query($db, $sql1);
$data = mysqli_fetch_assoc($query1);

// Cek jika data kosong
if (empty($data)) {
  // Kembali ke halaman dengan mengirimkan session alert
  session_start();
  $_SESSION['alert'] = "Belum Ada Data Surat Masuk";
  header("Location: datasuratmasuk.php");
  exit();
}

// Konversi bulan ke format teks
$bulanArray = [
    '01' => 'JANUARI', '02' => 'FEBRUARI', '03' => 'MARET', '04' => 'APRIL',
    '05' => 'MEI', '06' => 'JUNI', '07' => 'JULI', '08' => 'AGUSTUS',
    '09' => 'SEPTEMBER', '10' => 'OKTOBER', '11' => 'NOVEMBER', '12' => 'DESEMBER'
];
$bulanText = $bulanArray[$bulan];

$nama_file = "Surat_Masuk-{$bulanText}-{$tahun}.xls";

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$nama_file");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr>
        <th>No</th>
        <th>No Surat</th>
        <th>Tanggal Masuk</th>
        <th>Pengirim</th>
        <th>Perihal</th>
        <th>Kepada</th>
    </tr>";

$no = 1;
while ($data = mysqli_fetch_assoc($query1)) {
    echo "<tr>
            <td>" . $no++ . "</td>
            <td>" . $data['nomor_suratmasuk'] . "</td>
            <td>" . $data['tanggalmasuk_suratmasuk'] . "</td>
            <td>" . $data['pengirim'] . "</td>
            <td>" . $data['perihal_suratmasuk'] . "</td>
            <td>" . $data['kepada_suratmasuk'] . "</td>
        </tr>";
}

echo "</table>";
?>
