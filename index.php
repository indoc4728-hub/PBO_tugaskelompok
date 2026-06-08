<?php
// index.php
require_once 'controllers/ManajemenRumahSakit.php';

$app = new manajemenrumahsakit();
$app->loadDataDariDatabase();
$app->tampilkanLaporanHTML(); // Memanggil fungsi HTML yang ada di controller