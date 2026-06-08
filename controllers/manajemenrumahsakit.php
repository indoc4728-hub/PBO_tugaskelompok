<?php
// controllers/ManajemenRumahSakit.php
require_once 'config/database.php';
require_once 'models/PasienBPJS.php';
require_once 'models/PasienAsuransiSwasta.php';
require_once 'models/PasienUmum.php';

class ManajemenRumahSakit {
    private $daftarPasien = []; // Polymorphic Collection
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conn;
    }

    // Menarik data relasional dari 4 tabel di database (Job 1 & Job 4)
    public function loadDataDariDatabase() {
        if ($this->db === null) {
            echo "<p style='color:red; font-weight:bold;'>Gagal memuat data: Koneksi ke database belum terbentuk.</p>";
            return;
        }

        $query = "SELECT p.*, b.nomor_pbi, b.faskes_asal, b.kelas_kamar, 
                     a.nama_provider, a.nomor_polis, a.limit_cover, 
                     u.nik, u.metode_pembayaran 
              FROM pasien p
              LEFT JOIN pasien_bpjs b ON p.id_pasien = b.id_pasien
              LEFT JOIN pasien_asuransi_swasta a ON p.id_pasien = a.id_pasien
              LEFT JOIN pasien_umum u ON p.id_pasien = u.id_pasien";
              
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['jenis_pasien'] == 'BPJS') {
                $this->daftarPasien[] = new PasienBPJS(
                    $row['id_pasien'], $row['nama'], $row['usia'], $row['lama_rawat'], $row['biaya_kamar_per_hari'],
                    $row['nomor_pbi'], $row['faskes_asal'], $row['kelas_kamar']
                );
            } elseif ($row['jenis_pasien'] == 'Asuransi Swasta') {
                $this->daftarPasien[] = new PasienAsuransiSwasta(
                    $row['id_pasien'], $row['nama'], $row['usia'], $row['lama_rawat'], $row['biaya_kamar_per_hari'],
                    $row['nama_provider'], $row['nomor_polis'], $row['limit_cover']
                );
            } elseif ($row['jenis_pasien'] == 'Umum') {
                $this->daftarPasien[] = new PasienUmum(
                    $row['id_pasien'], $row['nama'], $row['usia'], $row['lama_rawat'], $row['biaya_kamar_per_hari'],
                    $row['nik'], $row['metode_pembayaran']
                );
            }
        }
    }

    // TARUH FUNGSI TAMPILAN HTML BARU DI SINI (Dynamic Binding)
    public function tampilkanLaporanHTML() {
        echo "<div style='font-family: Arial, sans-serif; max-width: 800px; margin: 30px auto; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);'>";
        echo "<h2 style='text-align: center; color: #2c3e50; margin-bottom: 0;'>LAPORAN BIAYA LAYANAN MEDIS RUMAH SAKIT</h2>";
        echo "<p style='text-align: center; color: #7f8c8d; margin-top: 5px;'>Sistem Backend Polimorfik Berbasis Web</p>";
        echo "<hr style='border: 0; border-top: 2px solid #34495e; margin-bottom: 20px;'>";
        
        foreach ($this->daftarPasien as $p) {
            echo "<div style='background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-left: 5px solid #3498db; border-radius: 4px;'>";
            echo "<table style='width: 100%; border-collapse: collapse;'>";
            echo "<tr><td style='width: 150px;'><b>ID Pasien</b></td><td>: " . $p->getIdPasien() . "</td></tr>";
            echo "<tr><td><b>Nama Pasien</b></td><td>: " . $p->getNama() . "</td></tr>";
echo "<tr><td><b>Klaster Penjamin</b></td><td>: " . $p->cetakKlaimLayanan() . "</td></tr>";
            echo "<tr><td><b>Total Biaya Mandiri</b></td><td style='color: #e74c3c; font-weight: bold;'>: Rp " . number_format($p->hitungTotalBiaya(), 0, ',', '.') . "</td></tr>"; // Dynamic Binding
            echo "</table>";
            echo "</div>";
        }
        echo "</div>";
    }
}