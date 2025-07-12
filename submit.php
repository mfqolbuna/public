<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'owner';
$username = 'root';
$password = '';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data dari form
$panjang_lahan = mysqli_real_escape_string($conn, $_POST['panjang_lahan']);
$nominal_panjang_lahan = mysqli_real_escape_string($conn, $_POST['nominal_panjang_lahan']);
$lebar_lahan = mysqli_real_escape_string($conn, $_POST['lebar_lahan']);
$nominal_lebar_lahan = mysqli_real_escape_string($conn, $_POST['nominal_lebar_lahan']);
$jumlah_kamar_mandi = mysqli_real_escape_string($conn, $_POST['jumlah_kamar_mandi']);
$nominal_kamar_mandi = mysqli_real_escape_string($conn, $_POST['nominal_kamar_mandi']);
$jumlah_kamar_tidur = mysqli_real_escape_string($conn, $_POST['jumlah_kamar_tidur']);
$nominal_kamar_tidur = mysqli_real_escape_string($conn, $_POST['nominal_kamar_tidur']);
$jumlah_ruang_dapur = mysqli_real_escape_string($conn, $_POST['jumlah_ruang_dapur']);
$nominal_ruang_dapur = mysqli_real_escape_string($conn, $_POST['nominal_ruang_dapur']);
$jumlah_ruang_makan = mysqli_real_escape_string($conn, $_POST['jumlah_ruang_makan']);
$nominal_ruang_makan = mysqli_real_escape_string($conn, $_POST['nominal_ruang_makan']);
$jumlah_ruang_tamu = mysqli_real_escape_string($conn, $_POST['jumlah_ruang_tamu']);
$nominal_ruang_tamu = mysqli_real_escape_string($conn, $_POST['nominal_ruang_tamu']);
$jumlah_ruang_keluarga = mysqli_real_escape_string($conn, $_POST['jumlah_ruang_keluarga']);
$nominal_ruang_keluarga = mysqli_real_escape_string($conn, $_POST['nominal_ruang_keluarga']);
$jumlah_ruang_taman = mysqli_real_escape_string($conn, $_POST['jumlah_ruang_taman']);
$nominal_ruang_taman = mysqli_real_escape_string($conn, $_POST['nominal_ruang_taman']);
$jumlah_ruang_garasi = mysqli_real_escape_string($conn, $_POST['jumlah_ruang_garasi']);
$nominal_ruang_garasi = mysqli_real_escape_string($conn, $_POST['nominal_ruang_garasi']);
$jumlah_lantai = mysqli_real_escape_string($conn, $_POST['jumlah_lantai']);
$nominal_jumlah_lantai = mysqli_real_escape_string($conn, $_POST['nominal_jumlah_lantai']);
$total_harga = mysqli_real_escape_string($conn, $_POST['total_harga']);
$nama_bank = mysqli_real_escape_string($conn, $_POST['nama_bank']);
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$nomor_telepon = mysqli_real_escape_string($conn, $_POST['nomor_telepon']);

// Query insert data
$sql = "INSERT INTO pengguna (
    panjang_lahan, nominal_panjang_lahan, lebar_lahan, nominal_lebar_lahan,
    jumlah_kamar_mandi, nominal_kamar_mandi, jumlah_kamar_tidur, nominal_kamar_tidur,
    jumlah_ruang_dapur, nominal_ruang_dapur, jumlah_ruang_makan, nominal_ruang_makan,
    jumlah_ruang_tamu, nominal_ruang_tamu, jumlah_ruang_keluarga, nominal_ruang_keluarga,
    jumlah_ruang_taman, nominal_ruang_taman, jumlah_ruang_garasi, nominal_ruang_garasi,
    jumlah_lantai, nominal_jumlah_lantai, total_harga, nama_bank, nama, nomor_telepon
) VALUES (
    '$panjang_lahan', '$nominal_panjang_lahan', '$lebar_lahan', '$nominal_lebar_lahan',
    '$jumlah_kamar_mandi', '$nominal_kamar_mandi', '$jumlah_kamar_tidur', '$nominal_kamar_tidur',
    '$jumlah_ruang_dapur', '$nominal_ruang_dapur', '$jumlah_ruang_makan', '$nominal_ruang_makan',
    '$jumlah_ruang_tamu', '$nominal_ruang_tamu', '$jumlah_ruang_keluarga', '$nominal_ruang_keluarga',
    '$jumlah_ruang_taman', '$nominal_ruang_taman', '$jumlah_ruang_garasi', '$nominal_ruang_garasi',
    '$jumlah_lantai', '$nominal_jumlah_lantai', '$total_harga', '$nama_bank', '$nama', '$nomor_telepon'
)";

if (mysqli_query($conn, $sql)) {
    header("Location: dashboard.php?status=success");
} else {
    header("Location: dashboard.php?status=error&message=" . urlencode(mysqli_error($conn)));
}

mysqli_close($conn);
?>