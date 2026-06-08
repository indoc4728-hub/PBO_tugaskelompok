<?php
require_once 'Pasien.php';

class PasienAsuransiSwasta extends Pasien {
    private $namaProvider;
    private $nomorPolis;
    private $limitCover;

    public function __construct($id_pasien, $nama, $usia, $lamaRawat, $biayaKamarPerHari, $namaProvider, $nomorPolis, $limitCover) {
        parent::__construct($id_pasien, $nama, $usia, $lamaRawat, $biayaKamarPerHari);
        $this->namaProvider = $namaProvider;
        $this->nomorPolis = $nomorPolis;
        $this->limitCover = $limitCover;
    }

    // Rumus Asuransi: Jika total > limit, bayar sisanya. Jika tidak, bayar 0.
    public function hitungTotalBiaya() {
        $tarifDasar = $this->lamaRawat * $this->biayaKamarPerHari;
        if ($tarifDasar > $this->limitCover) {
            return $tarifDasar - $this->limitCover;
        }
        return 0;
    }

    public function cetakKlaimLayanan() {
        return "Asuransi Swasta: " . $this->namaProvider . " [No Polis: " . $this->nomorPolis . ", Limit: Rp " . number_format($this->limitCover, 0, ',', '.') . "]";
    }
}