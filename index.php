<?php
// index.php
require_once 'controllers/ManajemenRumahSakit.php';

$app = new ManajemenRumahSakit();

// Mengambil parameter halaman dari URL, default ke 'dashboard'
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Medis PBO</title>
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { display: flex; min-height: 100vh; background-color: #f4f6f9; color: #333; }
        
        /* Sidebar Styling */
        .sidebar { width: 280px; background-color: #2c3e50; color: #fff; padding: 20px; flex-shrink: 0; }
        .sidebar h3 { text-align: center; margin-bottom: 30px; font-size: 20px; font-weight: 700; letter-spacing: 1px; color: #3498db; }
        .sidebar ul { list-style: none; }
        .sidebar ul li { margin-bottom: 8px; }
        .sidebar ul li.menu-title { color: #7f8c8d; font-size: 11px; text-transform: uppercase; font-weight: 700; padding: 10px 15px 5px 15px; letter-spacing: 1px; }
        .sidebar ul li a { display: block; padding: 12px 15px; color: #ecf0f1; text-decoration: none; border-radius: 5px; transition: 0.3s; font-weight: 500; font-size: 14px; }
        .sidebar ul li a:hover, .sidebar ul li a.active { background-color: #34495e; color: #3498db; border-left: 4px solid #3498db; }
        
        /* Main Content Styling */
        .main-content { flex-grow: 1; padding: 40px; overflow-y: auto; }
        .header-title { margin-bottom: 30px; font-size: 26px; color: #2c3e50; font-weight: 600; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        
        /* Dashboard Cards */
        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .card { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-top: 4px solid #3498db; text-decoration: none; color: inherit; display: block; transition: 0.3s; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 6px 12px rgba(0,0,0,0.1); }
        .card h4 { color: #7f8c8d; font-size: 13px; text-transform: uppercase; margin-bottom: 10px; font-weight: 600; }
        .card p { font-size: 28px; font-weight: 700; color: #2c3e50; }
        
        /* Welcome Banner */
        .welcome-banner { background: linear-gradient(135deg, #3498db, #2c3e50); color: white; padding: 40px; border-radius: 8px; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(52,152,219,0.3); }
        .welcome-banner h1 { font-size: 30px; margin-bottom: 10px; }
        .welcome-banner p { font-size: 15px; opacity: 0.9; }

        /* Style Tabel Modern */
        .table-container { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow-x: auto; margin-top: 20px; }
        .data-table { width: 100%; border-collapse: collapse; text-align: left; }
        .data-table th { background-color: #f8f9fa; color: #2c3e50; padding: 14px; font-weight: 600; border-bottom: 2px solid #dee2e6; font-size: 14px; }
        .data-table td { padding: 14px; border-bottom: 1px solid #dee2e6; font-size: 14px; color: #495057; vertical-align: middle; }
        .data-table tr:hover { background-color: #f8f9fa; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h3>MEDIS-PBO v1.0</h3>
        <ul>
            <li><a href="?page=dashboard" class="<?php echo $page == 'dashboard' ? 'active' : ''; ?>">🏠 Dashboard Utama</a></li>
            
            <li class="menu-title">Data Filter per Tabel</li>
            <li><a href="?page=bpjs" class="<?php echo $page == 'bpjs' ? 'active' : ''; ?>">🟢 Tabel Pasien BPJS</a></li>
            <li><a href="?page=asuransi" class="<?php echo $page == 'asuransi' ? 'active' : ''; ?>">🟣 Tabel Asuransi Swasta</a></li>
            <li><a href="?page=umum" class="<?php echo $page == 'umum' ? 'active' : ''; ?>">🟡 Tabel Pasien Umum</a></li>

            <li class="menu-title">Laporan Global</li>
            <li><a href="?page=semua_pasien" class="<?php echo $page == 'semua_pasien' ? 'active' : ''; ?>">📊 Laporan Semua Pasien</a></li>
        </ul>
    </div>

    <div class="main-content">
        <?php if ($page == 'dashboard'): ?>
            <div class="header-title">Dashboard Ringkasan Klinis</div>
            
            <div class="welcome-banner">
                <h1>Selamat Datang di Sistem Layanan Medis</h1>
                <p>Silakan klik menu di sebelah kiri atau kotak indikator di bawah untuk melihat daftar pasien spesifik per tabel basis data.</p>
            </div>

            <div class="dashboard-grid">
                <a href="?page=bpjs" class="card" style="border-top-color: #2ecc71;">
                    <h4>Klaster BPJS</h4>
                    <p>4 Pasien</p>
                    <span style="font-size: 12px; color: #2ecc71;">Lihat Tabel &rarr;</span>
                </a>
                <a href="?page=asuransi" class="card" style="border-top-color: #9b59b6;">
                    <h4>Asuransi Swasta</h4>
                    <p>3 Pasien</p>
                    <span style="font-size: 12px; color: #9b59b6;">Lihat Tabel &rarr;</span>
                </a>
                <a href="?page=umum" class="card" style="border-top-color: #f1c40f;">
                    <h4>Pasien Umum</h4>
                    <p>3 Pasien</p>
                    <span style="font-size: 12px; color: #f1c40f;">Lihat Tabel &rarr;</span>
                </a>
            </div>

        <?php else: ?>
            <div class="header-title">
                <?php 
                    if ($page == 'bpjs') echo "Tabel Polimorfik Objek Pasien BPJS";
                    elseif ($page == 'asuransi') echo "Tabel Polimorfik Objek Pasien Asuransi Swasta";
                    elseif ($page == 'umum') echo "Tabel Polimorfik Objek Pasien Umum";
                    elseif ($page == 'semua_pasien') echo "Laporan Gabungan Data Seluruh Pasien";
                ?>
            </div>
            
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 120px;">ID Pasien</th>
                            <th style="width: 220px;">Nama Pasien</th>
                            <th>Detail Informasi / Atribut Khusus Subclass</th>
                            <th style="width: 200px;">Beban Biaya Mandiri</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $app->loadDataDariDatabase();
                            
                            // Percabangan logika pemanggilan fungsi di Controller
                            if ($page == 'semua_pasien') {
                                $app->tampilkanLaporanHTML(); // Tanpa filter (Cetak Semua)
                            } else {
                                $app->tampilkanLaporanHTMLPerTabel($page); // Dengan filter per tabel
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>