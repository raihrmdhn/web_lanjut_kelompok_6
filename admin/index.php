<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>App TI | Muhammad Raihan</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">

  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"> -->

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php?p=home" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="../dist/img/LOGOTI.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">App TI</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../dist/img/anakjuragan.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Muhammad Raihan</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <?php
        $p = isset($_GET['p']) ? $_GET['p'] : 'home';
        ?>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">Menu</li>
          <li class="nav-item">
            <a href="index.php?p=home" class="nav-link <?= ($p == 'home') ? 'active' : '' ?>" >
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Home
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?p=mhs" class="nav-link <?= ($p == 'mhs') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-users"></i>
              <p>
                Mahasiswa
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?p=prodi" class="nav-link <?= ($p == 'prodi') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-building"></i>
              <p>
                Prodi
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?p=dosen" class="nav-link <?= ($p == 'dosen') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Dosen
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?p=matakuliah" class="nav-link <?= ($p == 'matakuliah') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Mata Kuliah
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?p=kategori" class="nav-link <?= ($p == 'kategori') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Kategori
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?p=berita" class="nav-link <?= ($p == 'berita') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>
                Berita
              </p>
            </a>
          </li>
          <li class = "nav-header">Admin</li>
          <li class="nav-item">
            <a href="index.php?p=user" class="nav-link <?= ($p == 'user') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                User
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?p=level" class="nav-link <?= ($p == 'level') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Level
              </p>
            </a>
          </li>
          <li class="nav-item mt-4 border-top">
            <a href="../index.php" class="nav-link mt-4 active bg-danger">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Log Out
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->

  </aside>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"></h1>
            
          </div><!-- /.col -->
          
        </div><!-- /.row -->

        
      </div><!-- /.container-fluid -->
      <main class="ms-sm-auto px-md-4">
        

        <?php
              $page=isset($_GET['p']) ? $_GET['p'] : 'home';
              if($page=='home') include 'home.php';
              if($page=='mhs') include 'mahasiswa.php';
              if($page=='prodi') include 'prodi.php';
              if($page=='dosen') include 'dosen.php';
              if($page=='matakuliah') include 'matakuliah.php';
              if($page=='kategori') include 'kategori.php';
              if($page=='berita') include 'berita.php';
              if($page=='user') include 'user.php';
              if($page=='level') include 'level.php';
            
          ?>
        
      </main>
    </div>
    <!-- /.content-header -->

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Design By Muhammad Raihan
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->

<script>
        new DataTable('#example');
    </script>

</body>
</html>
