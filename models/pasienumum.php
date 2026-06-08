<?php
require_once 'Pasien.php';

class PasienUmum extends Pasien {
    private $nik;
    private $metodePembayaran;

    public function __construct($id_pasien, $nama, $usia, $lamaRawat, $biayaKamarPerHari, $nik, $metodePembayaran) {
        parent::__construct($id_pasien, $nama, $usia, $lamaRawat, $biayaKamarPerHari);
        $this->nik = $nik;
        $this->metodePembayaran = $metodePembayaran;
    }

    // Rumus Umum: (Lama Rawat * Biaya Kamar) + Rp 150.000
    public function hitungTotalBiaya() {
        return ($this->lamaRawat * $this->biayaKamarPerHari) + 150000;
    }

    public function cetakKlaimLayanan() {
        return "Pasien Umum (Mandiri) - NIK: " . $this->nik . " [Metode: " . $this->metodePembayaran . "]";
    }
}