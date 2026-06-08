<?php
require_once 'Pasien.php';

class PasienBPJS extends Pasien {
    private $nomorPBI;
    private $faskesAsal;
    private $kelasKamar;

    public function __construct($id_pasien, $nama, $usia, $lamaRawat, $biayaKamarPerHari, $nomorPBI, $faskesAsal, $kelasKamar) {
        parent::__construct($id_pasien, $nama, $usia, $lamaRawat, $biayaKamarPerHari);
        $this->nomorPBI = $nomorPBI;
        $this->faskesAsal = $faskesAsal;
        $this->kelasKamar = $kelasKamar;
    }

    // Rumus BPJS: (Lama Rawat * Biaya Kamar) * 10%
    public function hitungTotalBiaya() {
        return ($this->lamaRawat * $this->biayaKamarPerHari) * 0.10;
    }

    public function cetakKlaimLayanan() {
        return "BPJS (" . $this->kelasKamar . ") - Faskes Asal: " . $this->faskesAsal . " [No PBI: " . $this->nomorPBI . "]";
    }
}