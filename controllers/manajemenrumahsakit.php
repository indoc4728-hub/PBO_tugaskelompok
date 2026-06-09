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
            echo "<tr><td colspan='4' style='color:red; font-weight:bold; text-align:center;'>Gagal memuat data: Koneksi ke database belum terbentuk.</td></tr>";
            return;
        }

        // Mencegah duplikasi data jika fungsi dipanggil lebih dari sekali dalam satu runtime
        $this->daftarPasien = [];

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

    // Fungsi cetak gabungan seluruh data pasien tanpa filter (Menu Laporan Semua Pasien)
    public function tampilkanLaporanHTML() {
        if (empty($this->daftarPasien)) {
            echo "<tr><td colspan='4' style='text-align:center; color:orange;'>Tidak ada data pasien yang termuat dari basis data.</td></tr>";
            return;
        }

        foreach ($this->daftarPasien as $p) {
            echo "<tr>";
            echo "<td><span style='background:#f1f3f5; padding:4px 8px; border-radius:4px; font-family:monospace; font-weight:600;'>" . $p->getIdPasien() . "</span></td>";
            echo "<td><b>" . $p->getNama() . "</b></td>";
            echo "<td>" . $p->cetakKlaimLayanan() . "</td>"; // Dynamic Binding
            echo "<td style='color: #e74c3c; font-weight: bold;'>Rp " . number_format($p->hitungTotalBiaya(), 0, ',', '.') . "</td>"; // Dynamic Binding
            echo "</tr>";
        }
    }

    // Fungsi untuk memfilter tampilan data pasien spesifik per jenis tabel/klaster 
    public function tampilkanLaporanHTMLPerTabel($filter) {
        if (empty($this->daftarPasien)) {
            echo "<tr><td colspan='4' style='text-align:center; color:orange;'>Tidak ada data pasien yang termuat dari basis data.</td></tr>";
            return;
        }

        $dataDitemukan = false;

        foreach ($this->daftarPasien as $p) {
            // Logika pengecekan class objek untuk menyaring tampilan sesuai filter menu 
            if (($filter == 'bpjs' && get_class($p) == 'PasienBPJS') ||
                ($filter == 'asuransi' && get_class($p) == 'PasienAsuransiSwasta') ||
                ($filter == 'umum' && get_class($p) == 'PasienUmum')) {
                
                $dataDitemukan = true;
                
                echo "<tr>";
                echo "<td><span style='background:#f1f3f5; padding:4px 8px; border-radius:4px; font-family:monospace; font-weight:600;'>" . $p->getIdPasien() . "</span></td>";
                echo "<td><b>" . $p->getNama() . "</b></td>";
                echo "<td>" . $p->cetakKlaimLayanan() . "</td>"; // Dynamic Binding 
                echo "<td style='color: #e74c3c; font-weight: bold;'>Rp " . number_format($p->hitungTotalBiaya(), 0, ',', '.') . "</td>"; // Dynamic Binding
                echo "</tr>";
            }
        }

        if (!$dataDitemukan) {
            echo "<tr><td colspan='4' style='text-align:center; color:red;'>Data pasien untuk kategori ini tidak ditemukan di database.</td></tr>";
        }
    }
}