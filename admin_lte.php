<?php
// Konfigurasi untuk Koneksikan ke Database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db5d";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// menambahkan database atau data nilai mhsw
if (isset($_POST['simpan_data'])) {
    $nim          = mysqli_real_escape_string($conn, $_POST['nim']);
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $nilai_akhir  = floatval($_POST['nilai_akhir']);

    if ($nilai_akhir >= 85) {
        $nilai_huruf = 'A';
        $predikat    = 'Sangat Memuaskan';
    } else if ($nilai_akhir >= 75) {
        $nilai_huruf = 'B';
        $predikat    = 'Memuaskan';
    } else if ($nilai_akhir >= 60) {
        $nilai_huruf = 'C';
        $predikat    = 'Cukup';
    } else {
        $nilai_huruf = 'D';
        $predikat    = 'Kurang';
    }

    $reg_date = date('Y-m-d H:i:s');

    $query = "REPLACE INTO nilaimhsw (nim, nama_lengkap, nilai_akhir, nilai_huruf, predikat, reg_date) 
              VALUES ('$nim', '$nama_lengkap', '$nilai_akhir', '$nilai_huruf', '$predikat', '$reg_date')";
    mysqli_query($conn, $query);
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// tombol edit db 
if (isset($_POST['edit_data'])) {
    $nim_lama     = mysqli_real_escape_string($conn, $_POST['edit_nim_lama']);
    $nim_baru     = mysqli_real_escape_string($conn, $_POST['edit_nim']);
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['edit_nama_lengkap']);
    $nilai_akhir  = floatval($_POST['edit_nilai_akhir']);

    if ($nilai_akhir >= 85) {
        $nilai_huruf = 'A';$predikat    = 'Sangat Memuaskan';
    } else if ($nilai_akhir >= 75) {
        $nilai_huruf = 'B';$predikat    = 'Memuaskan';
    } else if ($nilai_akhir >= 60) {
        $nilai_huruf = 'C';$predikat    = 'Cukup';
    } else {
        $nilai_huruf = 'D';$predikat    = 'Kurang';
    }

    $query_update = "UPDATE nilaimhsw SET nim='$nim_baru', nama_lengkap='$nama_lengkap', nilai_akhir='$nilai_akhir', nilai_huruf='$nilai_huruf', predikat='$predikat' WHERE nim='$nim_lama'";
    mysqli_query($conn,$query_update);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// tombol konfirmasi hapus
if (isset($_POST['hapus_data'])) {
    $nim = mysqli_real_escape_string($conn, $_POST['hapus_nim']);$query_delete = "DELETE FROM nilaimhsw WHERE nim='$nim'";
    mysqli_query($conn,$query_delete);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE 4 | Transkrip Nilai Mahasiswa</title>

    <!--begin::Theme Init (prevents flash of incorrect theme on load, #6043)-->
    <script>
      (() => {
        'use strict';
        const root = document.documentElement;

        if (root.getAttribute('data-lte-color-mode') === 'off') {
          return;
        }

        const STORAGE_KEY = 'lte-theme';
        let stored = null;
        try {
          stored = localStorage.getItem(STORAGE_KEY);
        } catch {
          // localStorage may be unavailable (private mode, sandboxed iframe).
        }
        const authored = root.getAttribute('data-bs-theme');
        let resolved = 'light';
        if (stored === 'dark' || stored === 'light') {
          resolved = stored;
        } else if (authored === 'dark' || authored === 'light') {
          resolved = authored;
        } else if (globalThis.matchMedia('(prefers-color-scheme: dark)').matches) {
          resolved = 'dark';
        }
        root.setAttribute('data-bs-theme', resolved);
        root.style.colorScheme = resolved;
        if (resolved !== authored) {
          root.setAttribute('data-lte-theme-resolved', '');
        }
      })();
    </script>
    <!--end::Theme Init-->

    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->

    <!--begin::Primary Meta Tags-->
    <meta name="title" content="AdminLTE 4 | Transkrip Nilai Mahasiswa" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a free Bootstrap 5 admin dashboard template with almost 50 example pages, built with vanilla JS and designed with accessibility in mind."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel"
    />
    <!--end::Primary Meta Tags-->

    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="./css/adminlte.css" as="style" />
    <!--end::Accessibility Features-->

    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
      media="print"
      onload="this.media = 'all'"
    />
    <!--end::Fonts-->

    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->

    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->

    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="./css/adminlte.css" />
    <!--end::Required Plugin(AdminLTE)-->
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Beranda</a></li>
          </ul>
          <!--end::Start Navbar Links-->
          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            <!--begin::Navbar Search-->
            <li class="nav-item">
              <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="bi bi-search"></i>
              </a>
            </li>
            <!--end::Navbar Search-->
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img
                  src="./image/user1-128x128.jpg"
                  class="user-image rounded-circle shadow"
                  alt="User Image"
                />
                <span class="d-none d-md-inline">Alexander Pierce</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <!--begin::User Image-->
                <li class="user-header text-bg-primary">
                  <img
                    src="./image/user1-128x128.jpg"
                    class="rounded-circle shadow"
                    alt="User Image"
                  />
                  <p>
                    Alexander Pierce - Web Developer
                    <small>Member since Mar. 2025</small>
                  </p>
                </li>
                <!--end::User Image-->
                <!--begin::Menu Footer-->
                <li class="user-footer">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                  <a href="#" class="btn btn-default btn-flat float-end">Sign out</a>
                </li>
                <!--end::Menu Footer-->
              </ul>
            </li>
            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>
      <!--end::Header-->

      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="#" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="./image/AdminLTELogo.png"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">AdminLTE 4</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="menu"
              data-accordion="false"
            >
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>Beranda</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="nav-icon bi bi-journal-text"></i>
                  <p>Nilai</p>
                </a>
              </li>
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->

      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6">
                <h1 class="mb-0 fs-3">Rekap Nilai Mahasiswa</h1>
              </div>
              <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nilai</li>
                  </ol>
                </nav>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-12">
                <!--begin::Card-->
                <div class="card mb-4">
                  <!--begin::Card Header-->
                  <div class="card-header">
                    <div class="row g-2 align-items-center">
                      <div class="col-12 col-md-3">
                        <h3 class="card-title">Direktori Nilai</h3>
                      </div>
                      <div class="col-12 col-md-9">
                        <div class="d-flex flex-wrap justify-content-md-end gap-2">
                          <div class="input-group input-group-sm w-auto">
                            <span class="input-group-text">
                              <i class="bi bi-search" aria-hidden="true"></i>
                            </span>
                            <input
                              type="search"
                              id="user-search"
                              class="form-control"
                              placeholder="Cari Berdasarkan Nama / NIM"
                              aria-label="Cari Berdasarkan Nama / NIM"
                              style="width: 200px"
                              value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>"
                            />
                          </div>
                          <?php 
                          $selected_predikat = isset($_GET['predikat']) ? $_GET['predikat'] : 'all';
                          $selected_sort     = isset($_GET['sort']) ? $_GET['sort'] : 'all';
                          ?>
                          <!-- Dropdown Filter Predikat -->
                          <select
                            id="user-role-filter"
                            class="form-select form-select-sm w-auto"
                            aria-label="Filter Predikat"
                          >
                            <option value="all" <?php echo ($selected_predikat == 'all') ? 'selected' : ''; ?>>Semua Predikat</option>
                            <option value="Sangat Memuaskan" <?php echo ($selected_predikat == 'Sangat Memuaskan') ? 'selected' : ''; ?>>Sangat Memuaskan</option>
                            <option value="Memuaskan" <?php echo ($selected_predikat == 'Memuaskan') ? 'selected' : ''; ?>>Memuaskan</option>
                            <option value="Cukup" <?php echo ($selected_predikat == 'Cukup') ? 'selected' : ''; ?>>Cukup</option>
                            <option value="Kurang" <?php echo ($selected_predikat == 'Kurang') ? 'selected' : ''; ?>>Kurang</option>
                          </select>

                          <!-- Dropdown Sorting Nilai Akhir Berdasarkan Angka -->
                          <select
                            id="nilai-sort-filter"
                            class="form-select form-select-sm w-auto"
                            aria-label="Urutkan Nilai"
                          >
                            <option value="all" <?php echo ($selected_sort == 'all') ? 'selected' : ''; ?>>Urutan Nilai (Default)</option>
                            <option value="asc" <?php echo ($selected_sort == 'asc') ? 'selected' : ''; ?>>70 - 34</option>
                            <option value="desc" <?php echo ($selected_sort == 'desc') ? 'selected' : ''; ?>>100 - 75</option>
                          </select>

                          <button
                            type="button"
                            class="btn btn-sm btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-add-user"
                          >
                            <i class="bi bi-person-plus-fill me-1" aria-hidden="true"> </i>
                            Tambah Data Nilai
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--end::Card Header-->
                  <!--begin::Card Body-->
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover align-middle m-0" id="tabel-nilai">
                        <thead>
                          <tr>
                            <th>NIM</th>
                            <th>Nama Lengkap</th>
                            <th>Nilai Akhir</th>
                            <th>Nilai Huruf</th>
                            <th>Predikat</th>
                            <th>Tgl Dibuat</th>
                            <th>Tgl Diubah</th>
                            <th class="text-end">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          // Konfigurasi Paging dimulai dari halaman 5
                          $limit = 5;
                          $start_page = 5;
                          $page = isset($_GET['page']) ? (int)$_GET['page'] : $start_page;
                          if ($page < $start_page) $page = $start_page;

                          $keyword  = isset($_GET['cari']) ? mysqli_real_escape_string($conn, $_GET['cari']) : '';
                          $predikat = isset($_GET['predikat']) ? mysqli_real_escape_string($conn, $_GET['predikat']) : '';
                          $sort     = isset($_GET['sort']) ? mysqli_real_escape_string($conn, $_GET['sort']) : '';

                          $where = [];
                          if ($keyword != '') {
                              $where[] = "(nama_lengkap LIKE '%$keyword%' OR nim LIKE '%$keyword%')";
                          }
                          if ($predikat != '' && $predikat != 'all') {
                              $where[] = "predikat = '$predikat'";
                          }

                          $where_sql = "";
                          if (count($where) > 0) {
                              $where_sql = " WHERE " . implode(' AND ', $where);
                          }

                          // 1. Hitung total data keseluruhan
                          $sql_count = "SELECT COUNT(*) as total FROM nilaimhsw" . $where_sql;
                          $result_count = mysqli_query($conn, $sql_count);
                          $row_count = mysqli_fetch_assoc($result_count);
                          $total_data = $row_count['total'];
                          
                          $jumlah_blok = ceil($total_data / $limit);
                          if ($jumlah_blok < 1) $jumlah_blok = 1;
                          $end_page = $start_page + $jumlah_blok - 1;

                          if ($page > $end_page) $page = $start_page;

                          // Offset disesuaikan dengan halaman awal 5
                          $offset = ($page - $start_page) * $limit;

                          // 2. Ambil data dengan LIMIT dan OFFSET 
                          $sql = "SELECT * FROM nilaimhsw" . $where_sql;
                          if ($sort == 'asc') {
                              $sql .= " ORDER BY nilai_akhir ASC";
                          } elseif ($sort == 'desc') {
                              $sql .= " ORDER BY nilai_akhir DESC";
                          }
                          $sql .= " LIMIT " . intval($limit) . " OFFSET " . intval($offset);

                          $result = mysqli_query($conn, $sql);
                          $current_count = mysqli_num_rows($result);

                          $start_num = ($total_data > 0) ? (($page - $start_page) * $limit) + 5 : 0;
                          $end_num = $start_num + $current_count - 1;
                          if ($total_data > 0 && $start_num < 5) {
                              $start_num = 5;
                          }
                          
                          // Penataan foto agar tidak berubah saat data dihapus atau difilter
                          $mapping_avatar = [
                              '3202416557' => './image/avatar9.jpg',
                              '3202418890' => './image/avatar8.jpg',
                              '3202516088' => './image/avatar14.jpg',
                              '3202478966' => './image/avatar11.jpg',
                              '3202316704' => './image/avatar6.jpg',
                              '3202617890' => './image/avatar11.jpg',
                              '3202617560' => './image/avatar16.jpg',
                              '3202611780' => './image/avatar17.jpg',
                              '3202789056' => './image/avatar15.jpg',
                              '3202316044' => './image/avatar12.jpg',
                              '3202316047' => './image/avatar7.jpg',
                              '3202517789' => './image/avatar13.jpg',
                              '320278993' => './image/avatar21.jpg',
                              '3202679200' => './image/avatar22.jpg',
                              '3202567098' => './image/avatar20.jpg'
                          ];

                          if ($total_data > 0) {
                              while ($row = mysqli_fetch_assoc($result)) {
                                  $nim_mhs = $row['nim'];
                                  $avatar = isset($mapping_avatar[$nim_mhs]) ? $mapping_avatar[$nim_mhs] : './image/avatar6.jpg';

                                  $badgeClass = 'text-bg-secondary';
                                  if ($row['nilai_huruf'] == 'A') $badgeClass = 'text-bg-success';
                                  elseif ($row['nilai_huruf'] == 'B') $badgeClass = 'text-bg-primary';
                                  elseif ($row['nilai_huruf'] == 'C') $badgeClass = 'text-bg-warning';
                                  elseif ($row['nilai_huruf'] == 'D') $badgeClass = 'text-bg-danger';
                          ?>
                          <tr>
                            <td class="fw-medium"><?php echo htmlspecialchars($row['nim']); ?></td>
                            <td>
                              <div class="d-flex align-items-center">
                                <img
                                  src="<?php echo $avatar; ?>"
                                  alt="<?php echo htmlspecialchars($row['nama_lengkap']); ?>"
                                  class="img-size-32 rounded-circle me-2"
                                />
                                <span><?php echo htmlspecialchars($row['nama_lengkap']); ?></span>
                              </div>
                            </td>
                            <td><?php echo number_format($row['nilai_akhir'], 2); ?></td>
                            <td><span class="badge <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($row['nilai_huruf']); ?></span></td>
                            <td><?php echo htmlspecialchars($row['predikat']); ?></td>
                            <td><?php echo htmlspecialchars($row['reg_date']); ?></td>
                            <td>2026-10-15</td>
                            <td class="text-end">
                              <div class="btn-group btn-group-sm">
                                <button
                                  type="button"
                                  class="btn btn-outline-secondary btn-edit"
                                  data-bs-toggle="modal"
                                  data-bs-target="#modal-edit-user"
                                  data-nim="<?php echo $row['nim']; ?>"
                                  data-nama="<?php echo htmlspecialchars($row['nama_lengkap']); ?>"
                                  data-nilai="<?php echo $row['nilai_akhir']; ?>"
                                  aria-label="Edit"
                                >
                                  <i class="bi bi-pencil" aria-hidden="true"> </i>
                                </button>
                                <button
                                  type="button"
                                  class="btn btn-outline-danger btn-delete"
                                  data-bs-toggle="modal"
                                  data-bs-target="#modal-delete-user"
                                  data-nim="<?php echo $row['nim']; ?>"
                                  data-nama="<?php echo htmlspecialchars($row['nama_lengkap']); ?>"
                                  aria-label="Delete"
                                >
                                  <i class="bi bi-trash" aria-hidden="true"> </i>
                                </button>
                              </div>
                            </td>
                          </tr>
                          <?php 
                              }
                          } else {
                              echo '<tr><td colspan="8" class="text-center py-3">Data tidak ditemukan.</td></tr>';
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                    <!-- /.table-responsive -->
                  </div>
                  <!--end::Card Body-->
                  <!--begin::Card Footer-->
                  <div class="card-footer clearfix">
                    <div class="float-start pt-1 fs-7 text-body-secondary" id="table-info">
                      Menampilkan <?php echo $start_num; ?> sampai <?php echo $end_num; ?> dari <?php echo $total_data; ?> data nilai
                    </div>
                    <ul class="pagination pagination-sm m-0 float-end">
                      <!-- Tombol Previous -->
                      <?php if ($page > $start_page): ?>
                        <?php 
                        $prev_params = $_GET;
                        $prev_params['page'] = $page - 1;
                        $prev_url = '?' . http_build_query($prev_params);
                        ?>
                        <li class="page-item">
                          <a class="page-link" href="<?php echo $prev_url; ?>" aria-label="Previous"> &laquo; </a>
                        </li>
                      <?php else: ?>
                        <li class="page-item disabled">
                          <a class="page-link" href="#" aria-label="Previous"> &laquo; </a>
                        </li>
                      <?php endif; ?>

                      <!-- Tombol Nomor Halaman Dinamis (Dimulai dari 5, 6, 7) -->
                      <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                        <?php 
                        $page_params = $_GET;
                        $page_params['page'] = $i;
                        $page_url = '?' . http_build_query($page_params);
                        ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                          <a class="page-link" href="<?php echo $page_url; ?>"><?php echo $i; ?></a>
                        </li>
                      <?php endfor; ?>

                      <!-- Tombol Next -->
                      <?php if ($page < $end_page): ?>
                        <?php 
                        $next_params = $_GET;
                        $next_params['page'] = $page + 1;
                        $next_url = '?' . http_build_query($next_params);
                        ?>
                        <li class="page-item">
                          <a class="page-link" href="<?php echo $next_url; ?>" aria-label="Next"> &raquo; </a>
                        </li>
                      <?php else: ?>
                        <li class="page-item disabled">
                          <a class="page-link" href="#" aria-label="Next"> &raquo; </a>
                        </li>
                      <?php endif; ?>
                    </ul>
                  </div>
                  <!--end::Card Footer-->
                </div>
                <!--end::Card-->
              </div>
              <!-- /.col -->
            </div>
            <!--end::Row-->

            <!--begin::Add User Modal-->
            <div
              class="modal fade"
              id="modal-add-user"
              tabindex="-1"
              aria-labelledby="modal-add-user-label"
              aria-hidden="true"
            >
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="POST" action="" id="form-tambah-nilai">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modal-add-user-label">Tambah Data Nilai Baru</h5>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                      ></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label for="new-nim" class="form-label"> NIM </label>
                        <input
                          type="text"
                          class="form-control"
                          id="new-nim"
                          name="nim"
                          placeholder="Masukkan NIM"
                          required
                        />
                      </div>
                      <div class="mb-3">
                        <label for="new-name" class="form-label"> Nama Lengkap </label>
                        <input
                          type="text"
                          class="form-control"
                          id="new-name"
                          name="nama_lengkap"
                          placeholder="Masukkan Nama Lengkap"
                          required
                        />
                      </div>
                      <div class="mb-3">
                        <label for="new-score" class="form-label"> Nilai Akhir </label>
                        <input
                          type="number"
                          step="0.01"
                          class="form-control"
                          id="new-score"
                          name="nilai_akhir"
                          placeholder="00.00"
                          required
                        />
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                      </button>
                      <button type="submit" name="simpan_data" class="btn btn-primary" id="btn-simpan-nilai">Simpan Data</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!--end::Add User Modal-->

            <!--begin::Edit User Modal-->
            <div
              class="modal fade"
              id="modal-edit-user"
              tabindex="-1"
              aria-labelledby="modal-edit-user-label"
              aria-hidden="true"
            >
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="POST" action="" id="form-edit-nilai">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modal-edit-user-label">Edit Data Nilai Mahasiswa</h5>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                      ></button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="edit_nim_lama" id="edit-nim-lama">
                      <div class="mb-3">
                        <label for="edit-nim" class="form-label"> NIM </label>
                        <input
                          type="text"
                          class="form-control"
                          id="edit-nim"
                          name="edit_nim"
                          required
                        />
                      </div>
                      <div class="mb-3">
                        <label for="edit-name" class="form-label"> Nama Lengkap </label>
                        <input
                          type="text"
                          class="form-control"
                          id="edit-name"
                          name="edit_nama_lengkap"
                          placeholder="Masukkan Nama Lengkap"
                          required
                        />
                      </div>
                      <div class="mb-3">
                        <label for="edit-score" class="form-label"> Nilai Akhir </label>
                        <input
                          type="number"
                          step="0.01"
                          class="form-control"
                          id="edit-score"
                          name="edit_nilai_akhir"
                          placeholder="00.00"
                          required
                        />
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                      </button>
                      <button type="submit" name="edit_data" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!--end::Edit User Modal-->

            <!--begin::Delete User Modal-->
            <div
              class="modal fade"
              id="modal-delete-user"
              tabindex="-1"
              aria-labelledby="modal-delete-user-label"
              aria-hidden="true"
            >
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="POST" action="">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modal-delete-user-label">Hapus Data Nilai</h5>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                      ></button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="hapus_nim" id="delete-nim">
                      <p class="mb-0" id="delete-message">
                        Apakah Anda yakin ingin menghapus data nilai mahasiswa ini? Tindakan ini tidak dapat dibatalkan.
                      </p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                      </button>
                      <button type="submit" name="hapus_data" class="btn btn-danger">
                        Hapus
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!--end::Delete User Modal-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->

      <!--begin::Footer-->
      <footer class="app-footer">
        <!--begin::To the end-->
        <div class="float-end d-none d-sm-inline">Anything you want</div>
        <!--end::To the end-->
        <!--begin::Copyright-->
        <strong>
          Copyright &copy; 2014-2026&nbsp;
          <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->

    <!--begin::Script-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      crossorigin="anonymous"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="./js/adminlte.js"></script>

    <!-- Script untuk Pencarian, Filter Predikat, Sorting Berdasarkan Angka, Paging, Edit, dan Delete -->
    <script>
      function applyFilterAndSearch() {
        const keyword = document.getElementById('user-search').value;
        const predikat = document.getElementById('user-role-filter').value;
        const sort = document.getElementById('nilai-sort-filter').value;
        
        let baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
        let params = new URLSearchParams();
        
        if (keyword) {
          params.set('cari', keyword);
        }
        if (predikat && predikat !== 'all') {
          params.set('predikat', predikat);
        }
        if (sort && sort !== 'all') {
          params.set('sort', sort);
        }
        params.set('page', '5'); // Tetap di halaman awal 5

        window.location.href = baseUrl + '?' + params.toString();
      }

      const searchInput = document.getElementById('user-search');
      searchInput.addEventListener('keyup', function (e) {
        if (e.key === 'Enter' || searchInput.value === '') {
          applyFilterAndSearch();
        }
      });

      document.getElementById('user-role-filter').addEventListener('change', function () {
        applyFilterAndSearch();
      });

      document.getElementById('nilai-sort-filter').addEventListener('change', function () {
        applyFilterAndSearch();
      });

      // Script untuk Edit
      const editButtons = document.querySelectorAll('.btn-edit');
      editButtons.forEach(button => {
        button.addEventListener('click', function () {
          const nim = this.getAttribute('data-nim');
          const nama = this.getAttribute('data-nama');
          const nilai = this.getAttribute('data-nilai');

          document.getElementById('edit-nim-lama').value = nim;
          document.getElementById('edit-nim').value = nim;
          document.getElementById('edit-name').value = nama;
          document.getElementById('edit-score').value = nilai;
        });
      });

      // Script untuk Delete
      const deleteButtons = document.querySelectorAll('.btn-delete');
      deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
          const nim = this.getAttribute('data-nim');
          const nama = this.getAttribute('data-nama');

          document.getElementById('delete-nim').value = nim;
          document.getElementById('delete-message').innerHTML = `Apakah Anda yakin ingin menghapus data nilai mahasiswa <b>${nama}</b> (NIM: ${nim})? Tindakan ini tidak dapat dibatalkan.`;
        });
      });
    </script>
    <!--end::Script-->
  </body>
</html>