<?php
    require 'config.php';
    session_start();
    if (empty($_SESSION['user_id']) ||  empty($_SESSION['logged_in'])) {
        echo "<script>
        alert('please log in to continue:');
        window.location.href='login.php';
        </script>";
    }
    if ($_SESSION['role'] != 1) {
      header('Location: login.php');
    }
    if (!empty($_POST['search'])) {
      setcookie('search',$_POST['search'], time() + (86400 * 30), "/");
    }else{
      if (empty($_GET['pageno'])) {
        unset($_COOKIE['search']); 
        setcookie('search', null, -1, '/'); 
      }
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin panal</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php

  if (!empty($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
  }
  else {
    $pageno = 1;
  }
    $frames = 3;
    $offset = ($pageno - 1) * $frames;



    if (empty($_POST['search']) && !isset($_COOKIE['search'])) {
    	$pdostatement = $pdo->prepare("SELECT * FROM users ORDER BY id DESC");
      $pdostatement->execute();
      $rawResult = $pdostatement->fetchAll();
      $totalpages = ceil(count($rawResult)/$frames);

      $pdostatement = $pdo->prepare("SELECT * FROM users ORDER BY id DESC LIMIT $offset,$frames");
      $pdostatement->execute();
      $result = $pdostatement->fetchAll();
      
    }
    else {
    	$searchKey = $_POST['search'] ? $_POST['search'] : $_COOKIE['search'];
      $pdostatement = $pdo->prepare("SELECT * FROM users WHERE name LIKE '%$searchKey%' ORDER BY id DESC");
      $pdostatement->execute();
      $rawResult = $pdostatement->fetchAll();
      $totalpages = ceil(count($rawResult)/$frames);

      $pdostatement = $pdo->prepare("SELECT * FROM users WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$frames");
      $pdostatement->execute();
      $result = $pdostatement->fetchAll();
      
    }
    


  ?>
  <div class="content-wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form action="" class="form-inline" method="post">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" name="search" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>
      </ul>
    </nav>
    <div class="card-body">
          <table class="table table-bordered">
            <h1>User mangement</h1>
              <div>
                  <a class="btn btn-primary"  href="user_add.php">Create new</a>
                  <a style="float:right;" class="btn btn-warning" href="logout.php">Log out</a></br>
              </div></br>
              <thead>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Action</th>
              </thead>
              <tbody>
                 <?php
                 $i=1;
                  if ($result) {
                      foreach ($result as $value) {
                  ?>
                  <tr>
                      <td><?php echo $value['name']?></td>
                      <td><?php echo $value['email']?></td>
                      <td><?php if ($value['role']==1){echo 'admin';}else{echo 'user';} ?></td>
                      <td>
                          <a href="user_edit.php?id=<?php echo $value['id']?>" type="button" class="btn btn-warning">Edit</a>
                          <a href="user_delete.php?id=<?php echo $value['id']?>" onclick="return confirm('Are you sure you want to delete this item?');"
                            class="btn btn-danger">Delete</a>
					</td>
                  </tr>


                  <?php
                  $i++;
                      }
                  }
                 ?>
              </tbody>
          </table>
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item"><a class="page-link" href="?pageno=1">Fir</a></li>
          <li class="page-item <?php if($pageno <= 1){echo 'disabled';}?>">
            <a class="page-link" href="<?php if ($pageno <=1) {echo '#';}else {echo "?pageno=".($pageno-1);}?>">Previous</a>
          </li>
          <li class="page-item"><a class="page-link" href="#"><?php echo $pageno;?></a></li>
          <li class="page-item <?php if($pageno >= $totalpages){echo 'disabled';}?>">
            <a class="page-link" href="<?php if($pageno>=$totalpages){echo '#';}else{echo "?pageno=".($pageno+1);}?>">Next</a>
          </li>
          <li class="page-item"><a class="page-link" href="?pageno=<?php echo $totalpages?>">Last</a></li>
        </ul>
      </nav>
    </div>
  </div>

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->

  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Blog</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>



      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Blogs
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="user_listenings.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Users
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

  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="#">Min thant kyaw</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard.js"></script>
</body>
</html>

