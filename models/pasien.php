<?php
// models/Pasien.php

abstract class Pasien {
    // Encapsulation: Menggunakan protected agar aman tapi bisa diwariskan
    protected $id_pasien;
    protected $nama;
    protected $usia;
    protected $lamaRawat;
    protected $biayaKamarPerHari;

    public function __construct($id_pasien, $nama, $usia, $lamaRawat, $biayaKamarPerHari) {
        $this->id_pasien = $id_pasien;
        $this->nama = $nama;
        $this->usia = $usia;
        $this->lamaRawat = $lamaRawat;
        $this->biayaKamarPerHari = $biayaKamarPerHari;
    }

    // Abstract methods yang wajib di-override oleh kelas anak
    abstract public function hitungTotalBiaya();
    abstract public function cetakKlaimLayanan();

    // Getter untuk mengambil data dari luar kelas
    public function getIdPasien() { return $this->id_pasien; }
    public function getNama() { return $this->nama; }
}